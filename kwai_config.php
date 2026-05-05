<?php
/**
 * Kwai Ads Config - Server-Side Integration (Compatível PHP 7.2+)
 */

// API Kwai oficial
define('KWAI_API_URL', 'https://www.adsnebula.com/log/common/api');
define('KWAI_PIXEL_SDK_VERSION', '9.9.9');

// Cookies (180 dias = ~6 meses)

define('KWAI_LOG_SUCCESS', __DIR__ . '/logs/kwai_success_events.log');
define('KWAI_LOG_FAILED', __DIR__ . '/logs/kwai_failed_events.log');

define('KWAI_COOKIE_NAME', 'kwai_clickid');
define('KWAI_COOKIE_DAYS', 180);
define('KWAI_COOKIE_PATH', '/');
define('KWAI_COOKIE_SAMESITE', 'Lax');

function kwai_config($key, $default = null) {
    static $configs = null;
    
    if ($configs === null) {
        global $db;
        if (isset($db) && $db) {
            $result = $db->query("SELECT `key`, value FROM settings WHERE LOWER(`key`) LIKE 'kwai_%'");
            $configs = [];
            while ($row = $result->fetch_assoc()) {
                $configs[$row['key']] = $row['value'];
                $configs[strtolower($row['key'])] = $row['value'];
            }
        } else {
            $configs = [];
        }
    }
    
    return $configs[$key] ?? $default;
}

function kwai_is_enabled() {
    return kwai_config('kwai_pixel_ativo', '0') === '1';
}

function kwai_get_pixel_id() {
    return kwai_config('kwai_pixel_id', '');
}

function kwai_get_access_token() {
    return kwai_config('kwai_access_token', '');
}

function kwai_get_mmpcode() {
    return kwai_config('kwai_mmpcode', 'PL');
}

function kwai_get_third_party() {
    return kwai_config('kwai_third_party', 'shopline');
}

function kwai_get_track_flag() {
    return kwai_config('kwai_track_flag', 'true') === 'true';
}

function kwai_get_test_flag() {
    $config = kwai_config('kwai_test_flag_default', 'false');
    return $config === 'true';
}

function kwai_get_sdk_version() {
    return kwai_config('kwai_pixel_sdk_version', KWAI_PIXEL_SDK_VERSION);
}
