<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/db.php';

define('PARADISE_API_URL', 'https://multi.paradisepags.com/api/v1/transaction.php');

$apiKey = db_get_setting('PARADISE_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Gateway não configurado']);
    exit;
}

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID da transação ausente']);
    exit;
}

$localTx = db_get_transaction($id);
if (!$localTx) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Transação não encontrada']);
    exit;
}

$url = PARADISE_API_URL . '?transaction_id=' . urlencode($id);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'X-API-Key: ' . $apiKey,
    ],
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$raw      = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    error_log('[Paradise Pags verificar] cURL error: ' . $curlErr);
    echo json_encode(['success' => false, 'message' => 'Erro de conexão']);
    exit;
}

$gw = json_decode($raw, true);
error_log('[Paradise Pags verificar] HTTP ' . $httpCode . ' id=' . $id . ' — ' . $raw);

if ($httpCode !== 200 || !is_array($gw)) {
    echo json_encode(['success' => false, 'message' => 'Resposta inválida do gateway']);
    exit;
}

$gwStatus = strtolower($gw['status'] ?? 'pending');
if ($gwStatus !== $localTx['status']) {
    db_update_transaction_status($id, $gwStatus);
    error_log('[Paradise Pags] Status atualizado localmente: ' . $gwStatus);
}

echo json_encode([
    'success' => true,
    'status'  => $gwStatus,
]);