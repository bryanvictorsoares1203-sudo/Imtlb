<?php
session_start();

require_once __DIR__ . '/../checkout/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $storedUser = db_get_setting('ADMIN_USERNAME');
    $storedPass = db_get_setting('ADMIN_PASSWORD');

    if (!$storedUser) $storedUser = 'admin';
    if (!$storedPass) $storedPass = password_hash('admin123', PASSWORD_DEFAULT);

    if ($username === $storedUser && password_verify($password, $storedPass)) {
        $_SESSION['admin_logged'] = true;
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Credenciais inválidas';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h1 { color: #1a1a2e; margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #333; }
        input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; }
        button { width: 100%; padding: 0.75rem; background: #e94560; color: #fff; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; margin-top: 1rem; }
        button:hover { background: #d63850; }
        .error { color: #e94560; margin-bottom: 1rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Admin Login</h1>
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>