<?php
function admin_layout($title, $active_page) {
    $nav_items = [
        'dashboard' => ['href' => 'dashboard.php', 'icon' => '&#9632;', 'label' => 'Dashboard'],
        'transactions' => ['href' => 'transactions.php', 'icon' => '&#8644;', 'label' => 'Transações'],
        'settings' => ['href' => 'settings.php', 'icon' => '&#9881;', 'label' => 'Configurações'],
    ];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?= htmlspecialchars($title) ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #1a1a2e;
            --accent: #e94560;
            --accent-hover: #d63850;
            --bg: #f0f2f5;
            --surface: #fff;
            --text: #1a1a2e;
            --text-muted: #666;
            --border: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --sidebar-width: 260px;
            --header-height: 60px;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        
        .sidebar {
            position: fixed; left: 0; top: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--primary);
            color: #fff;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .sidebar-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h1 { font-size: 1.25rem; font-weight: 600; }
        .sidebar-header span { font-size: 0.75rem; opacity: 0.7; }
        
        .sidebar-nav { flex: 1; padding: 1rem 0; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9375rem;
            transition: all 0.2s;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .sidebar-nav a.active { background: rgba(233,69,96,0.15); color: var(--accent); border-left: 3px solid var(--accent); }
        .sidebar-nav .icon { width: 20px; text-align: center; }
        
        .sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-footer a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-footer a:hover { color: #fff; }
        
        .main { margin-left: var(--sidebar-width); min-height: 100vh; }
        .header {
            height: var(--header-height);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
            position: sticky; top: 0; z-index: 50;
        }
        .header-title { font-size: 1.125rem; font-weight: 600; }
        .header-user { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--text-muted); }
        .menu-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; padding: 0.5rem; }
        
        .content { padding: 2rem; }
        
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 90; }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-toggle { display: block; }
            .overlay.show { display: block; }
            .content { padding: 1rem; }
            .header { padding: 0 1rem; }
        }
    </style>
</head>
<body>
    <div class="overlay" onclick="document.querySelector('.sidebar').classList.remove('open'); this.classList.remove('show');"></div>
    
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>Admin</h1>
            <span>Paradise Pags</span>
        </div>
        <nav class="sidebar-nav">
            <?php foreach ($nav_items as $key => $item): ?>
            <a href="<?= $item['href'] ?>" class="<?= $active_page === $key ? 'active' : '' ?>">
                <span class="icon"><?= $item['icon'] ?></span>
                <?= $item['label'] ?>
            </a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="logout.php">
                <span>&#10140;</span> Sair
            </a>
        </div>
    </aside>
    
    <main class="main">
        <header class="header">
            <button class="menu-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.querySelector('.overlay').classList.toggle('show');">&#9776;</button>
            <span class="header-title"><?= htmlspecialchars($title) ?></span>
            <div class="header-user">
                <span>&#128100;</span> admin
            </div>
        </header>
        <div class="content">
<?php
}

function admin_layout_end() {
    echo '</div></main>';
}

function formatCurrency($cents) {
    return 'R$ ' . number_format($cents / 100, 2, ',', '.');
}