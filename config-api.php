<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';

$config = [
    'click_id_param' => db_get_setting('CLICK_ID_PARAM') ?: ''
];

echo json_encode($config);