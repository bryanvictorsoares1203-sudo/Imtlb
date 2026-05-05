<?php
/**
 * Kwai Ads Bootstrap - Endpoint para ContentView no carregamento
 * Chamar via AJAX: fetch('/checkout/kwai-bootstrap.php')
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/kwai_config.php';
require_once __DIR__ . '/includes/kwai_helper.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $result = kwai_send_content_view_on_bootstrap($_SERVER['REQUEST_URI'], $_GET);
    // Nunca expor access_token / payload / response para o frontend.
    echo json_encode([
        'ok' => (bool)($result['ok'] ?? false),
        'http_code' => $result['http_code'] ?? null,
        'error' => $result['error'] ?? null,
        'event' => 'ContentView',
    ]);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
