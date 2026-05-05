<?php
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$sessionId = $_COOKIE['analytics_sid'] ?? substr(md5(uniqid()), 0, 32);
if (!isset($_COOKIE['analytics_sid'])) {
    setcookie('analytics_sid', $sessionId, time() + (86400 * 30), '/');
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ipHash = $ip ? substr(md5($ip), 0, 16) : null;

$state = $input['state'] ?? null;
if ($state && strlen($state) > 2) {
    $state = substr($state, 0, 2);
}

$data = [
    'session_id' => $sessionId,
    'page' => $input['page'] ?? $_SERVER['REQUEST_URI'] ?? '/',
    'state' => $state,
    'country' => $input['country'] ?? 'BR',
    'referrer' => $input['referrer'] ?? $_SERVER['HTTP_REFERER'] ?? null,
    'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 512),
    'ip_hash' => $ipHash
];

db_save_analytics($data);

echo json_encode(['success' => true]);