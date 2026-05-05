<?php
session_start();
require_once __DIR__ . '/../checkout/db.php';
require_once __DIR__ . '/layout.php';

if (empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$status = $_GET['status'] ?? null;
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$transactions = db_list_transactions($perPage, $offset, $status);
$total = db_count_transactions($status);
$totalPages = ceil($total / $perPage);

admin_layout('Transações', 'transactions');
?>
<div class="filters">
    <a href="transactions.php" class="<?= !$status ? 'active' : '' ?>">Todos</a>
    <a href="transactions.php?status=pending" class="<?= $status === 'pending' ? 'active' : '' ?>">Pendentes</a>
    <a href="transactions.php?status=approved" class="<?= $status === 'approved' ? 'active' : '' ?>">Aprovadas</a>
    <a href="transactions.php?status=paid" class="<?= $status === 'paid' ? 'active' : '' ?>">Pagas</a>
</div>

<div class="card">
    <?php if ($transactions): ?>
    <table>
        <thead>
            <tr>
                <th>ID Transação</th>
                <th>Reference</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $tx): ?>
            <tr>
                <td><code><?= htmlspecialchars($tx['external_id']) ?></code></td>
                <td><?= htmlspecialchars($tx['reference']) ?></td>
                <td><?= formatCurrency($tx['amount']) ?></td>
                <td><span class="status <?= $tx['status'] ?>"><?= $tx['status'] ?></span></td>
                <td><?= date('d/m/Y H:i', strtotime($tx['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty">Nenhuma transação encontrada</div>
    <?php endif; ?>
</div>

<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?><?= $status ? '&status=' . $status : '' ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<style>
.filters { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.filters a { padding: 0.5rem 1rem; background: var(--surface); border: 1px solid var(--border); border-radius: 6px; text-decoration: none; color: var(--text-muted); font-size: 0.875rem; transition: all 0.2s; }
.filters a:hover { border-color: var(--accent); color: var(--accent); }
.filters a.active { background: var(--accent); color: #fff; border-color: var(--accent); }
.card { background: var(--surface); padding: 1.25rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid var(--border); }
th { color: var(--text-muted); font-weight: 500; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px; }
code { background: #f3f4f6; padding: 0.125rem 0.375rem; border-radius: 3px; font-size: 0.8125rem; }
.status { display: inline-block; padding: 0.25rem 0.625rem; border-radius: 999px; font-size: 0.75rem; font-weight: 500; text-transform: capitalize; }
.status.pending { background: #fef3c7; color: #d97706; }
.status.approved, .status.paid { background: #d1fae5; color: #059669; }
.status.rejected, .status.cancelled { background: #fee2e2; color: #dc2626; }
.pagination { margin-top: 1.5rem; display: flex; gap: 0.375rem; flex-wrap: wrap; }
.pagination a, .pagination span { padding: 0.5rem 0.75rem; background: var(--surface); border: 1px solid var(--border); border-radius: 6px; text-decoration: none; color: var(--text-muted); font-size: 0.875rem; transition: all 0.2s; }
.pagination a:hover { border-color: var(--accent); color: var(--accent); }
.pagination a.active { background: var(--accent); color: #fff; border-color: var(--accent); }
.empty { text-align: center; color: var(--text-muted); padding: 2rem; }
</style>
<?php admin_layout_end(); ?>