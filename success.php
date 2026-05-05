<?php
require_once __DIR__ . '/db.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    http_response_code(400);
    echo 'Token ausente';
    exit;
}

$tx = db_get_transaction($token);

if ($tx && ($tx['status'] === 'approved' || $tx['status'] === 'paid')) {
    $upsellUrl = db_get_setting('UPSELL_URL');
    if ($upsellUrl) {
        $redirectUrl = $upsellUrl . (strpos($upsellUrl, '?') !== false ? '&' : '?') . 'transaction_id=' . urlencode($token) . '&reference=' . urlencode($tx['reference']);
        header('Location: ' . $redirectUrl);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Confirmado</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f2f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; max-width: 400px; }
        .icon { font-size: 4rem; margin-bottom: 1rem; }
        h1 { color: #10b981; margin-bottom: 0.5rem; }
        p { color: #666; margin-bottom: 1.5rem; }
        .spinner { width: 40px; height: 40px; border: 3px solid #e5e7eb; border-top-color: #e94560; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <h1>Pagamento Confirmado!</h1>
        <p>Verificando...</p>
    </div>
    <script>
        var token = <?= json_encode($token) ?>;
        var checked = 0;
        var maxChecks = 30;
        
        function checkPayment() {
            fetch('/checkout/verificar.php?id=' + token)
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success && (data.status === 'approved' || data.status === 'paid')) {
                        location.reload();
                    } else if (checked < maxChecks) {
                        checked++;
                        setTimeout(checkPayment, 2000);
                    }
                })
                .catch(function() {
                    if (checked < maxChecks) {
                        checked++;
                        setTimeout(checkPayment, 2000);
                    }
                });
        }
        
        setTimeout(checkPayment, 1000);
    </script>
</body>
</html>