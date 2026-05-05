<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/kwai_config.php';
require_once __DIR__ . '/includes/kwai_helper.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Payload inválido']);
    exit;
}

$transaction_id = $input['transaction_id'] ?? '';
$status         = $input['status'] ?? '';

if (!$transaction_id || !$status) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
    exit;
}

$statusMap = [
    'approved' => 'approved',
    'paid'     => 'paid',
    'pending'  => 'pending',
    'rejected' => 'rejected',
    'cancelled'=> 'cancelled',
];

$normalizedStatus = $statusMap[strtolower($status)] ?? 'pending';

$updated = db_update_transaction_status($transaction_id, $normalizedStatus);

error_log('[Paradise Webhook] transaction_id=' . $transaction_id . ' status=' . $status . ' normalized=' . $normalizedStatus . ' updated=' . ($updated ? 'yes' : 'no'));

if ($normalizedStatus === 'approved' || $normalizedStatus === 'paid') {
    $tx = db_get_transaction($transaction_id);
    if ($tx) {
        error_log('[Paradise Webhook] Pagamento confirmado - reference: ' . $tx['reference'] . ' amount: ' . $tx['amount']);
        
        $valueInReais = $tx['amount'] / 100;
        
        // 🔥 KWAI SERVER-SIDE: Purchase
        $clickId = kwai_get_clickid_from_request();
        try {
            kwai_track_purchase($valueInReais, $clickId);
        } catch (Exception $e) {
            error_log('[Paradise Webhook] Kwai Purchase erro: ' . $e->getMessage());
        }
        error_log('[Paradise Webhook] Kwai Purchase Service | TxID: ' . $transaction_id . ' | ClickID: ' . ($clickId ?? 'none') . ' | Valor: R$' . $valueInReais);
        
        $upsellUrl = db_get_setting('UPSELL_URL');
        if ($upsellUrl) {
            $txId = urlencode($transaction_id);
            $ref = urlencode($tx['reference']);
            $redirectUrl = $upsellUrl . (strpos($upsellUrl, '?') !== false ? '&' : '?') . 'transaction_id=' . $txId . '&reference=' . $ref;
            error_log('[Paradise Webhook] Redirecionando para upsell: ' . $redirectUrl);
            header('Location: ' . $redirectUrl);
            exit;
        }
    }
}

http_response_code(200);
echo json_encode(['success' => true, 'message' => 'Status atualizado']);
