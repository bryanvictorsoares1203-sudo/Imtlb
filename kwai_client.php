<?php
/**
 * Kwai Pixel Client Endpoint - Recebe chamadas do frontend
 * Compatible with PHP 7.2+
 */

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/kwai_helper.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
    exit;
}

$eventName = $input['event'] ?? '';
$value = isset($input['value']) ? (float) $input['value'] : null;
$clickId = isset($input['clickId']) ? (string) $input['clickId'] : null;
$config = $input['config'] ?? [];

if (empty($eventName)) {
    echo json_encode(['ok' => false, 'error' => 'Event name required']);
    exit;
}

try {
    $result = kwai_track_event($eventName, $value, $clickId, $config);
    // Nunca expor access_token / payload / response para o frontend.
    echo json_encode([
        'ok' => (bool)($result['ok'] ?? false),
        'http_code' => $result['http_code'] ?? null,
        'error' => $result['error'] ?? null,
        'event' => $eventName,
    ]);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
