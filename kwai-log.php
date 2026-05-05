<?php
$logFile = '/www/wwwroot/PROJETOSKWAI/checkout/kwai-log.txt';

if ($_GET['action'] === 'log') {
    $msg = $_GET['msg'] ?? '';
    $log = date('Y-m-d H:i:s') . ' - ' . $msg . "\n";
    @file_put_contents($logFile, $log, FILE_APPEND);
    echo 'OK';
    exit;
}

if ($_GET['action'] === 'read') {
    @file_put_contents($logFile, '');
    if (file_exists($logFile)) {
        echo file_get_contents($logFile);
    } else {
        echo '';
    }
    exit;
}

if ($_GET['action'] === 'clear') {
    @file_put_contents($logFile, '');
    echo 'Cleared';
    exit;
}

echo 'Use action=log, action=read or action=clear';