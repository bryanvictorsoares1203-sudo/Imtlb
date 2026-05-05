<?php
session_start();
require_once __DIR__ . '/../checkout/db.php';
require_once __DIR__ . '/layout.php';

if (empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_setting') {
        $key = trim($_POST['key'] ?? '');
        $value = '';

        if ($key === 'kwai_pixel_ativo') {
            $value = isset($_POST['kwai_pixel_ativo']) ? '1' : '0';
        } else {
            $value = isset($_POST['value']) ? trim($_POST['value']) : '';
        }

        if ($key) {
            db_save_setting($key, $value);
            $message = 'Configuração salva com sucesso';
        } else {
            $error = 'Campos obrigatórios ausentes';
        }
    } elseif ($action === 'save_admin_creds') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username && $password) {
            db_save_setting('ADMIN_USERNAME', $username);
            db_save_setting('ADMIN_PASSWORD', password_hash($password, PASSWORD_DEFAULT));
            $message = 'Credenciais admin atualizadas';
        } else {
            $error = 'Campos obrigatórios ausentes';
        }
    } elseif ($action === 'save_kwai_pixel') {
        $pixel_id = trim($_POST['pixel_id'] ?? '');
        $access_token = trim($_POST['access_token'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($pixel_id) {
            db_save_kwai_pixel([
                'pixel_id' => $pixel_id,
                'access_token' => $access_token,
                'is_active' => $is_active
            ]);
            $message = 'Kwai Pixel salvo com sucesso';
        } else {
            $error = 'Pixel ID é obrigatório';
        }
    } elseif ($action === 'delete_kwai_pixel') {
        $pixel_id = (int)($_POST['pixel_id'] ?? 0);
        if ($pixel_id) {
            db_delete_kwai_pixel($pixel_id);
            $message = 'Kwai Pixel removido';
        }
    }
}

$settings = db_list_settings();
$settingsMap = [];
foreach ($settings as $s) {
    $settingsMap[$s['key']] = $s['value'];
}

// Backward compatibility with older uppercase seeds.
if (!isset($settingsMap['kwai_pixel_id']) && isset($settingsMap['KWAI_PIXEL_ID'])) {
    $settingsMap['kwai_pixel_id'] = $settingsMap['KWAI_PIXEL_ID'];
}
if (!isset($settingsMap['kwai_access_token']) && isset($settingsMap['KWAI_ACCESS_TOKEN'])) {
    $settingsMap['kwai_access_token'] = $settingsMap['KWAI_ACCESS_TOKEN'];
}
if (!isset($settingsMap['kwai_pixel_ativo']) && isset($settingsMap['KWAI_PIXEL_ATIVO'])) {
    $settingsMap['kwai_pixel_ativo'] = $settingsMap['KWAI_PIXEL_ATIVO'];
}

$kwaiPixels = db_list_kwai_pixels();

admin_layout('Configurações', 'settings');
?>

<?php if ($message): ?><div class="alert success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="settings-grid">
    <div class="card">
        <h2>Credenciais Admin</h2>
        <form method="POST">
            <input type="hidden" name="action" value="save_admin_creds">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" value="<?= htmlspecialchars($settingsMap['ADMIN_USERNAME'] ?? 'admin') ?>">
            </div>
            <div class="form-group">
                <label>Nova Senha</label>
                <input type="password" name="password" placeholder="Deixe em branco para manter">
            </div>
            <button type="submit">Salvar</button>
        </form>
    </div>

    <div class="card">
        <h2>URL do Webhook (Paradise Pags)</h2>
        <div class="form-group">
            <label>Webhook URL</label>
            <div class="webhook-url">
                <input type="text" id="webhookUrl" value="<?= 'https://' . ($_SERVER['HTTP_HOST'] ?? 'seudominio.com') . '/checkout/webhook.php' ?>" readonly>
                <button type="button" class="btn-copy" onclick="copyWebhookUrl()">Copiar</button>
            </div>
            <div class="hint">Cole esta URL no painel da Paradise Pags para receber notificações de pagamento</div>
        </div>
    </div>

    <div class="card">
        <h2>Paradise Pags</h2>
        <form method="POST">
            <input type="hidden" name="action" value="save_setting">
            <input type="hidden" name="key" value="PARADISE_API_KEY">
            <div class="form-group">
                <label>API Key</label>
                <input type="text" name="value" value="<?= htmlspecialchars($settingsMap['PARADISE_API_KEY'] ?? '') ?>" placeholder="sk_...">
            </div>
            <button type="submit">Salvar</button>
        </form>
    </div>

    <div class="card">
        <h2>Kwai Pixel (S2S)</h2>
        <form method="POST">
            <input type="hidden" name="action" value="save_setting">
            <input type="hidden" name="key" value="kwai_pixel_id">
            <div class="form-group">
                <label>Pixel ID</label>
                <input type="text" name="value" value="<?= htmlspecialchars($settingsMap['kwai_pixel_id'] ?? '') ?>" placeholder="Ex: 123456789">
                <div class="hint">ID numérico do pixel Kwai</div>
            </div>
            <button type="submit">Salvar</button>
        </form>
        <form method="POST" style="margin-top: 1rem;">
            <input type="hidden" name="action" value="save_setting">
            <input type="hidden" name="key" value="kwai_access_token">
            <div class="form-group">
                <label>Access Token</label>
                <input type="text" name="value" value="<?= htmlspecialchars($settingsMap['kwai_access_token'] ?? '') ?>" placeholder="Token de acesso">
            </div>
            <button type="submit">Salvar</button>
        </form>
        <form method="POST" style="margin-top: 1rem;">
            <input type="hidden" name="action" value="save_setting">
            <input type="hidden" name="key" value="kwai_pixel_ativo">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="kwai_pixel_ativo" value="1" <?= ($settingsMap['kwai_pixel_ativo'] ?? '0') === '1' ? 'checked' : '' ?>> Ativar Pixel
                </label>
            </div>
            <button type="submit">Salvar</button>
        </form>
    </div>

    <div class="card">
        <h2>Upsell</h2>
        <form method="POST">
            <input type="hidden" name="action" value="save_setting">
            <input type="hidden" name="key" value="UPSELL_URL">
            <div class="form-group">
                <label>Link de Upsell</label>
                <input type="url" name="value" value="<?= htmlspecialchars($settingsMap['UPSELL_URL'] ?? '') ?>" placeholder="https://exemplo.com/upsell">
                <div class="hint">URL para redirecionamento após pagamento</div>
            </div>
            <button type="submit">Salvar</button>
        </form>
    </div>

   		    <?php
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$scheme = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'seudominio.com';
$scriptDir = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '/admin/settings.php'))), '/');
if ($scriptDir === '.' || $scriptDir === '/') {
    $scriptDir = '';
}
$baseUrl = $scheme . '://' . $host . $scriptDir;
$testClickId = $settingsMap['kwai_preview_clickid'] ?? 'TESTE123456';
$testUrl = $baseUrl . '/index.html?clickid=' . rawurlencode($testClickId) . '&ks_px_test=1';
?>

<div class="card">
    <h2>Testar Rastreamento</h2>
    <p class="hint" style="margin-bottom: 1rem;">Esse botão abre exatamente `index.html?clickid=...&ks_px_test=1` para aparecer no preview do Kwai.</p>
    <form method="POST" style="margin-bottom: 1rem;">
        <input type="hidden" name="action" value="save_setting">
        <input type="hidden" name="key" value="kwai_preview_clickid">
        <div class="form-group">
            <label>ClickID de Preview do Kwai</label>
            <input type="text" name="value" value="<?= htmlspecialchars($settingsMap['kwai_preview_clickid'] ?? 'TESTE123456') ?>" placeholder="Cole o clickid do Kwai">
        </div>
        <button type="submit">Salvar</button>
    </form>
    <form method="POST" target="_blank">
        <input type="hidden" name="test_clickid" value="1">
        <input type="hidden" name="test_id" value="<?= $testClickId ?>">
        <button type="submit" formaction="<?= htmlspecialchars($testUrl) ?>" class="test-btn">
            Testar Capture
        </button>
    </form>
    <p class="hint" style="margin-top: 0.75rem;">Após clicar, verifique o preview do Kwai e os logs do backend.</p>
</div>
</div>

<div class="card">
    <h2>Kwai Pixels (Server-side)</h2>
    <form method="POST" style="margin-bottom: 1.5rem;">
        <input type="hidden" name="action" value="save_kwai_pixel">
        <div class="form-group">
            <label>Pixel ID</label>
            <input type="text" name="pixel_id" placeholder="Ex: 123456789" required>
        </div>
        <div class="form-group">
            <label>Access Token (opcional)</label>
            <input type="text" name="access_token" placeholder="Token de acesso">
        </div>
        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_active" value="1" checked> Ativo
            </label>
        </div>
        <button type="submit">Adicionar Pixel</button>
    </form>
    
    <?php if ($kwaiPixels): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pixel ID</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kwaiPixels as $px): ?>
            <tr>
                <td><?= $px['id'] ?></td>
                <td><code><?= htmlspecialchars($px['pixel_id']) ?></code></td>
                <td><span class="status <?= $px['is_active'] ? 'active' : 'inactive' ?>"><?= $px['is_active'] ? 'Ativo' : 'Inativo' ?></span></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete_kwai_pixel">
                        <input type="hidden" name="pixel_id" value="<?= $px['id'] ?>">
                        <button type="submit" class="btn-small btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<div class="card">
    <h2>Todas as Configurações</h2>
    <table>
        <thead>
            <tr>
                <th>Chave</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($settings as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['key']) ?></td>
                <td><code><?= htmlspecialchars($s['value']) ?></code></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.alert { padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9375rem; }
.alert.success { background: #d1fae5; color: #059669; border: 1px solid #a7f3d0; }
.alert.error { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
.settings-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem; }
.card { background: var(--surface); padding: 1.25rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
.card h2 { font-size: 1rem; margin-bottom: 1rem; color: var(--text); font-weight: 600; border-bottom: 1px solid var(--border); padding-bottom: 0.75rem; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; margin-bottom: 0.375rem; color: var(--text-muted); font-size: 0.875rem; font-weight: 500; }
.form-group input { width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: 6px; font-size: 0.9375rem; transition: border-color 0.2s; }
.form-group input:focus { outline: none; border-color: var(--accent); }
.form-group input[readonly] { background: #f9fafb; color: var(--text-muted); }
.hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem; }
button { padding: 0.625rem 1.25rem; background: var(--accent); color: #fff; border: none; border-radius: 6px; font-size: 0.9375rem; cursor: pointer; transition: background 0.2s; }
button:hover { background: var(--accent-hover); }
.checkbox-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.checkbox-label input { width: auto; }
.btn-small { padding: 0.375rem 0.75rem; font-size: 0.8125rem; }
.btn-danger { background: #ef4444; }
.btn-danger:hover { background: #dc2626; }
.status { display: inline-block; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
.status.active { background: #d1fae5; color: #059669; }
.status.inactive { background: #fee2e2; color: #dc2626; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid var(--border); }
th { color: var(--text-muted); font-weight: 500; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px; }
code { background: #f3f4f6; padding: 0.125rem 0.375rem; border-radius: 3px; font-size: 0.8125rem; word-break: break-all; }
.webhook-url { display: flex; gap: 0.5rem; }
.webhook-url input { flex: 1; font-family: monospace; font-size: 0.8125rem; }
.btn-copy { padding: 0.625rem 1rem; background: #6b7280; white-space: nowrap; }
.btn-copy:hover { background: #4b5563; }
.test-btn { padding: 0.75rem 1.5rem; background: #10b981; color: #fff; border: none; border-radius: 6px; font-size: 0.9375rem; cursor: pointer; }
.test-btn:hover { background: #059669; }
</style>
<script>
function copyWebhookUrl() {
    const input = document.getElementById('webhookUrl');
    input.select();
    document.execCommand('copy');
    const btn = document.querySelector('.btn-copy');
    btn.textContent = 'Copiado!';
    setTimeout(() => btn.textContent = 'Copiar', 2000);
}
</script>
<?php admin_layout_end(); ?>
