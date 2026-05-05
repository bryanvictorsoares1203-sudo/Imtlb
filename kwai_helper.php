<?php
/**
 * Kwai Ads Helper - Server-Side Integration
 * Compatible with PHP 7.2+
 * No framework, no Composer
 */

require_once __DIR__ . '/kwai_config.php';

/**
 * Normaliza o clickid removendo caracteres inválidos
 * @param string $raw
 * @return string
 */
function kwai_normalize_clickid($raw) {
    if (empty($raw)) {
        return '';
    }
    $raw = trim($raw);
    $raw = preg_replace('/[^a-zA-Z0-9\-_]/', '', $raw);
    return substr($raw, 0, 256);
}

/**
 * Obtém o clickid do cookie
 * @return string|null
 */
function kwai_get_clickid_from_cookie() {
    $cookie = $_COOKIE[KWAI_COOKIE_NAME] ?? null;
    return $cookie ? kwai_normalize_clickid($cookie) : null;
}

/**
 * Obtém o clickid da requisição (URL ou body)
 * @param array $body
 * @return string|null
 */
function kwai_get_clickid_from_request($body = []) {
    $customParam = null;
    global $db;
    if (isset($db) && $db) {
        $stmt = $db->prepare("SELECT value FROM settings WHERE `key` = 'CLICK_ID_PARAM'");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $customParam = $row['value'];
        }
        $stmt->close();
    }
    
    // Priority (strict): clickid > kwai_clickid > click_id
    $keys = ['clickid', 'kwai_clickid', 'click_id', 'sck', 'ttclid', 'ksclid'];
    if ($customParam && !in_array($customParam, $keys, true)) {
        $keys[] = $customParam;
    }
    
    foreach ($keys as $key) {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            return kwai_normalize_clickid($_GET[$key]);
        }
        if (isset($body[$key]) && !empty($body[$key])) {
            return kwai_normalize_clickid($body[$key]);
        }
    }
    
    return kwai_get_clickid_from_cookie();
}

/**
 * Captura e persiste o clickid da URL
 * @param int $days
 * @return string|null
 */
function kwai_persist_clickid_from_url($days = KWAI_COOKIE_DAYS) {
    $clickId = kwai_get_clickid_from_request();
    
    if ($clickId) {
        kwai_persist_clickid($clickId, $days);
    }
    
    return $clickId;
}

/**
 * Persiste o clickid em cookie
 * @param string $clickId
 * @param int $days
 * @return bool
 */
function kwai_persist_clickid($clickId, $days = KWAI_COOKIE_DAYS) {
    $clickId = kwai_normalize_clickid($clickId);
    if (empty($clickId)) {
        return false;
    }
    
    $expire = time() + ($days * 86400);
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

    // PHP 7.2 compatibility: setcookie() options-array exists only in 7.3+.
    if (PHP_VERSION_ID >= 70300) {
        return setcookie(KWAI_COOKIE_NAME, $clickId, [
            'expires' => $expire,
            'path' => KWAI_COOKIE_PATH,
            'secure' => $isHttps,
            'httponly' => false,
            'samesite' => KWAI_COOKIE_SAMESITE,
        ]);
    }

    // Legacy SameSite support for <= 7.2
    $path = rtrim(KWAI_COOKIE_PATH ?: '/', ';');
    $path .= '; samesite=' . KWAI_COOKIE_SAMESITE;
    return setcookie(KWAI_COOKIE_NAME, $clickId, $expire, $path, '', $isHttps, false);
}

/**
 * Obtém o IP do cliente
 * @return string
 */
function kwai_client_ip() {
    $keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
    
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    
    return '0.0.0.0';
}

/**
 * Normaliza o nome do evento para o formato do Kwai
 * @param string $name
 * @return string
 */
function kwai_normalize_event_name($name) {
    $name = trim((string) $name);
    if ($name === '') return 'EVENT_UNKNOWN';

    $key = strtolower($name);
    $key = preg_replace('/[^a-z0-9_]/', '', $key);

    $map = [
        'pageview' => 'EVENT_CONTENT_VIEW',
        'contentview' => 'EVENT_CONTENT_VIEW',

        'eventformsubmit' => 'EVENT_FORM_SUBMIT',
        'formsubmit' => 'EVENT_FORM_SUBMIT',

        'initiatecheckout' => 'EVENT_INITIATED_CHECKOUT',
        'initiatedcheckout' => 'EVENT_INITIATED_CHECKOUT',
        'checkout' => 'EVENT_INITIATED_CHECKOUT',

        'addpaymentinfo' => 'EVENT_ADD_PAYMENT_INFO',

        'addtocart' => 'EVENT_ADD_TO_CART',

        'purchase' => 'EVENT_PURCHASE',
        'payment' => 'EVENT_PURCHASE',
    ];

    if (isset($map[$key])) return $map[$key];
    return 'EVENT_' . strtoupper($key);
}

/**
 * Verifica se é uma requisição de teste
 * @param array $body
 * @return bool
 */
function kwai_is_test_request($body = []) {
    $testParams = ['ks_px_test', 'kwai_test', 'test_pixel', 'test_mode'];
    
    foreach ($testParams as $param) {
        if (isset($_GET[$param]) || isset($body[$param])) {
            return true;
        }
    }
    
    return kwai_get_test_flag();
}

/**
 * Verifica se a URI é elegível para ContentView
 * @param string $uri
 * @return bool
 */
function kwai_is_relevant_content_view_uri($uri) {
    if (empty($uri)) {
        return true;
    }
    
    $uri = parse_url($uri, PHP_URL_PATH);
    
    $ignorePatterns = [
        '#^/(api|webhook|admin|assets|static|css|js|img)/#',
        '#\.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)(\?.*)?$#',
    ];
    
    foreach ($ignorePatterns as $pattern) {
        if (preg_match($pattern, $uri)) {
            return false;
        }
    }
    
    return true;
}

/**
 * Log de sucesso
 * @param string $line
 */
function kwai_log_success($line) {
    $log = '[' . date('Y-m-d H:i:s') . '] ' . $line . "\n";
    @file_put_contents(KWAI_LOG_SUCCESS, $log, FILE_APPEND);
}

/**
 * Log de falha
 * @param string $line
 */
function kwai_log_fallback($line) {
    $log = '[' . date('Y-m-d H:i:s') . '] ' . $line . "\n";
    @file_put_contents(KWAI_LOG_FAILED, $log, FILE_APPEND);
}

function kwai_event_dedupe_file() {
    return sys_get_temp_dir() . '/kwai_event_dedupe.json';
}

function kwai_should_skip_duplicate_event(array $payload, $ttlSeconds = 15) {
    $eventName = kwai_normalize_event_name($payload['event_name'] ?? '');
    $clickId = kwai_normalize_clickid($payload['clickid'] ?? '');
    $pageName = isset($payload['page_name']) ? trim((string) $payload['page_name']) : '';
    $value = isset($payload['value']) ? (string) round((float) $payload['value'], 2) : '';
    $key = hash('sha256', implode('|', [$eventName, $clickId, $pageName, $value]));
    $file = kwai_event_dedupe_file();
    $now = time();

    $handle = @fopen($file, 'c+');
    if (!$handle) {
        return false;
    }

    try {
        if (!flock($handle, LOCK_EX)) {
            fclose($handle);
            return false;
        }

        $contents = stream_get_contents($handle);
        $cache = $contents ? json_decode($contents, true) : [];
        if (!is_array($cache)) {
            $cache = [];
        }

        foreach ($cache as $cacheKey => $timestamp) {
            if (!is_int($timestamp) || ($now - $timestamp) > ($ttlSeconds * 2)) {
                unset($cache[$cacheKey]);
            }
        }

        if (isset($cache[$key]) && ($now - (int) $cache[$key]) <= $ttlSeconds) {
            ftruncate($handle, 0);
            rewind($handle);
            fwrite($handle, json_encode($cache));
            fflush($handle);
            flock($handle, LOCK_UN);
            fclose($handle);
            return true;
        }

        $cache[$key] = $now;
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, json_encode($cache));
        fflush($handle);
        flock($handle, LOCK_UN);
        fclose($handle);
        return false;
    } catch (Exception $e) {
        flock($handle, LOCK_UN);
        fclose($handle);
        return false;
    }
}

function kwai_mask_secret($value) {
    $value = (string) $value;
    if ($value === '') return '';
    if (strlen($value) <= 8) return '***';
    return substr($value, 0, 4) . '***' . substr($value, -4);
}

/**
 * Classe principal para envio de eventos Kwai
 */
class KwaiPixel {
    
    private $pixelId;
    private $accessToken;
    private $mmpcode;
    private $thirdParty;
    private $trackFlag;
    private $testFlag;
    private $sdkVersion;
    
    public function __construct() {
        $this->pixelId = kwai_get_pixel_id();
        $this->accessToken = kwai_get_access_token();
        $this->mmpcode = kwai_get_mmpcode();
        $this->thirdParty = kwai_get_third_party();
        $this->trackFlag = kwai_get_track_flag();
        $this->testFlag = kwai_is_test_request();
        $this->sdkVersion = kwai_get_sdk_version();
    }
    
    /**
     * Obtém o clickid da requisição ou cookie
     * @param array $body
     * @return string|null
     */
    public function getClickId($body = []) {
        return kwai_get_clickid_from_request($body);
    }
    
    /**
     * Persiste o clickid em cookie
     * @param string $clickId
     * @param int $days
     * @return bool
     */
    public function persistClickId($clickId, $days = KWAI_COOKIE_DAYS) {
        return kwai_persist_clickid($clickId, $days);
    }
    
    /**
     * Envia evento para a API do Kwai
     * @param string $eventName
     * @param string|null $clickId
     * @param float|null $value
     * @param string $currency
     * @param array $config
     * @return array
     */
    public function sendEvent($eventName, $clickId = null, $value = null, $currency = 'BRL', array $config = []) {
        if (!kwai_is_enabled()) {
            return ['ok' => false, 'error' => 'Kwai pixel disabled'];
        }
        
        if (empty($this->pixelId)) {
            return ['ok' => false, 'error' => 'Pixel ID not configured'];
        }

        $clickId = $clickId ?? $this->getClickId();

        $payload = [
            'access_token' => $this->accessToken,
            'clickid' => $clickId,
            'event_name' => kwai_normalize_event_name($eventName),
            'is_attributed' => 1,
            'mmpcode' => $this->mmpcode,
            'pixelId' => $this->pixelId,
            'pixelSdkVersion' => $this->sdkVersion,
            'currency' => $currency,
            'testFlag' => $this->testFlag || ($config['test'] ?? false),
            'third_party' => $this->thirdParty,
            'trackFlag' => $this->trackFlag,
            'timestamp' => time(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'ip' => kwai_client_ip(),
        ];
        
        if ($value !== null) {
            $payload['value'] = (float) $value;
        }
        
        if (!empty($config['url'])) {
            $payload['url'] = $config['url'];
        }
        
        if (!empty($config['page_name'])) {
            $payload['page_name'] = $config['page_name'];
        }
        
        if (!empty($config['properties'])) {
            $payload['properties'] = $config['properties'];
        }
        
        if (!empty($config['context'])) {
            $payload['context'] = $config['context'];
        }

        if (kwai_should_skip_duplicate_event($payload)) {
            return [
                'ok' => true,
                'http_code' => 200,
                'payload' => $payload,
                'response' => 'duplicate-skipped',
                'error' => '',
                'deduped' => true,
            ];
        }
        
        $ch = curl_init(KWAI_API_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CONNECTTIMEOUT => 10
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        $result = [
            'ok' => false,
            'http_code' => $httpCode,
            'payload' => $payload,
            'response' => $response,
            'error' => $error
        ];
        
        if ($error) {
            $safePayload = $payload;
            $safePayload['access_token'] = kwai_mask_secret($safePayload['access_token'] ?? '');
            kwai_log_fallback(json_encode([
                'type' => 'curl_error',
                'event' => $eventName,
                'http_code' => $httpCode,
                'error' => $error,
                'payload' => $safePayload,
            ], JSON_UNESCAPED_SLASHES));
            return $result;
        }
        
        if ($httpCode === 200) {
            $result['ok'] = true;
            $safePayload = $payload;
            $safePayload['access_token'] = kwai_mask_secret($safePayload['access_token'] ?? '');
            kwai_log_success(json_encode([
                'type' => 'success',
                'event' => $eventName,
                'http_code' => $httpCode,
                'payload' => $safePayload,
                'response' => $response,
            ], JSON_UNESCAPED_SLASHES));
        } else {
            $safePayload = $payload;
            $safePayload['access_token'] = kwai_mask_secret($safePayload['access_token'] ?? '');
            kwai_log_fallback(json_encode([
                'type' => 'http_error',
                'event' => $eventName,
                'http_code' => $httpCode,
                'payload' => $safePayload,
                'response' => $response,
            ], JSON_UNESCAPED_SLASHES));
        }
        
        return $result;
    }
    
    /**
     * Envia ContentView automaticamente
     * @param string $uri
     * @param array $body
     * @return array
     */
    public function sendContentView($uri = '', $body = []) {
        if (!kwai_is_enabled()) {
            return ['ok' => false, 'error' => 'disabled'];
        }
        
        if (!kwai_is_relevant_content_view_uri($uri)) {
            return ['ok' => false, 'error' => 'not relevant'];
        }
        
        $clickId = $this->getClickId($body);
        if ($clickId) {
            $this->persistClickId($clickId);
        }
        
        return $this->sendEvent('ContentView', $clickId, null, 'BRL', [
            'url' => $uri,
            'page_name' => parse_url($uri, PHP_URL_PATH)
        ]);
    }
}

/**
 * Função helper para enviar evento rapidamente
 * @param string $eventName
 * @param float|null $value
 * @param string|null $clickId
 * @param array $config
 * @return array
 */
function kwai_track_event($eventName, $value = null, $clickId = null, array $config = []) {
    $kwai = new KwaiPixel();
    return $kwai->sendEvent($eventName, $clickId, $value, 'BRL', $config);
}

/**
 * Envia ContentView no bootstrap da página
 * @param string $uri
 * @param array $body
 * @return array
 */
function kwai_send_content_view_on_bootstrap($uri = '', $body = []) {
    $kwai = new KwaiPixel();
    return $kwai->sendContentView($uri, $body);
}

/**
 * Wrapper para webhook - dispara Purchase
 * @param float $value
 * @param string|null $clickId
 * @return array
 */
function kwai_track_purchase($value, $clickId = null) {
    return kwai_track_event('Purchase', $value, $clickId, ['page_name' => 'purchase_confirmed']);
}

/**
 * Wrapper para gerar PIX - dispara AddToCart
 * @param float $value
 * @param string|null $clickId
 * @return array
 */
function kwai_track_add_to_cart($value, $clickId = null) {
    return kwai_track_event('AddToCart', $value, $clickId, ['page_name' => 'pix_generated']);
}

/**
 * Wrapper para formulário preenchido - dispara EventFormSubmit
 * @param float|null $value
 * @param string|null $clickId
 * @return array
 */
function kwai_track_form_submit($value = null, $clickId = null) {
    return kwai_track_event('EventFormSubmit', $value, $clickId, ['page_name' => 'checkout_form']);
}
