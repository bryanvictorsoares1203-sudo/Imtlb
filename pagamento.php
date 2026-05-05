<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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

define('PARADISE_API_URL', 'https://multi.paradisepags.com/api/v1/transaction.php');

$apiKey = db_get_setting('PARADISE_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    error_log('[Paradise Pags] API Key não configurada');
    echo json_encode(['success' => false, 'message' => 'Gateway não configurado']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Payload inválido']);
    exit;
}

$valor    = isset($input['valor'])    ? (int) $input['valor']    : 0;
$nome     = isset($input['nome'])     ? trim($input['nome'])     : '';
$email    = isset($input['email'])    ? trim($input['email'])    : '';
$cpf      = isset($input['cpf'])      ? preg_replace('/\D/', '', $input['cpf']) : '';
$telefone = isset($input['telefone']) ? preg_replace('/\D/', '', $input['telefone']) : '';

if ($valor <= 0 || !$nome || !$email || strlen($cpf) < 11) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Dados obrigatórios ausentes ou inválidos']);
    exit;
}

$reference = 'REF' . time() . rand(100, 999);

$body = [
    'amount'      => $valor,
    'description' => 'Pedido #' . $reference,
    'reference'   => $reference,
    'source'      => 'api_externa',
    'customer'    => [
        'name'     => $nome,
        'email'    => $email,
        'phone'    => $telefone,
        'document' => $cpf,
    ],
];

$ch = curl_init(PARADISE_API_URL);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($body),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'X-API-Key: ' . $apiKey,
    ],
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$raw      = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    error_log('[Paradise Pags] cURL error: ' . $curlErr);
    echo json_encode(['success' => false, 'message' => 'Erro de conexão com o gateway']);
    exit;
}

$gw = json_decode($raw, true);
error_log('[Paradise Pags] HTTP ' . $httpCode . ' — ' . $raw);

if ($httpCode !== 200 || empty($gw['transaction_id'])) {
    $msg = isset($gw['message']) ? $gw['message'] : ('Gateway retornou HTTP ' . $httpCode);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

db_save_transaction([
    'external_id'    => $gw['transaction_id'],
    'reference'      => $reference,
    'amount'         => $valor,
    'status'         => 'pending',
    'pix_code'       => $gw['qr_code'] ?? '',
    'qr_code_base64' => $gw['qr_code_base64'] ?? '',
]);

$qrBase64  = $gw['qr_code_base64'] ?? '';
$qrCodeUrl = $qrBase64 ? 'data:image/png;base64,' . $qrBase64 : '';

echo json_encode([
    'success'       => true,
    'token'         => $gw['transaction_id'],
    'pixCopiaECola' => $gw['qr_code']    ?? '',
    'qrCodeUrl'     => $qrCodeUrl,
    'expires_at'    => $gw['expires_at'] ?? '',
]);
