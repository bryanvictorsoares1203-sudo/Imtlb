<?php
session_start();
require_once __DIR__ . '/../checkout/db.php';
require_once __DIR__ . '/layout.php';

if (empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

// ── KPIs principais ────────────────────────────────────────────────────────
$totalTrans    = db_count_transactions();
$approvedTrans = db_count_transactions('approved');
$paidTrans     = db_count_transactions('paid');
$pendingTrans  = db_count_transactions('pending');
$cancelledTrans= db_count_transactions('cancelled');
$onlineUsers   = db_count_online_users(5);

// ── Receita ────────────────────────────────────────────────────────────────
$revenueToday     = db_get_revenue('today');
$revenueYesterday = db_get_revenue('yesterday');
$revenue7d        = db_get_revenue('7d');
$revenue30d       = db_get_revenue('30d');
$revenueTotal     = db_get_revenue('all');
$avgTicket        = db_get_average_ticket();

// ── Gráficos ───────────────────────────────────────────────────────────────
$revenueChart = db_get_revenue_chart(7);
$hourlyChart  = db_get_transactions_by_hour();

// ── Funil ─────────────────────────────────────────────────────────────────
$funnel24h = db_get_conversion_funnel(24);

// ── Origem / Dispositivos ──────────────────────────────────────────────────
$referrers  = db_get_referrer_stats(6);
$devices    = db_get_device_stats();

// ── Estados ────────────────────────────────────────────────────────────────
$topStates = db_get_top_states_revenue(8);

// ── Resumo por período ─────────────────────────────────────────────────────
$periodSummary = db_get_period_summary();

// ── Recentes ───────────────────────────────────────────────────────────────
$recent = db_list_transactions(10);

$stateNames = [
    'AC'=>'Acre','AL'=>'Alagoas','AP'=>'Amapá','AM'=>'Amazonas','BA'=>'Bahia',
    'CE'=>'Ceará','DF'=>'Distrito Federal','ES'=>'Espírito Santo','GO'=>'Goiás',
    'MA'=>'Maranhão','MT'=>'Mato Grosso','MS'=>'Mato Grosso do Sul','MG'=>'Minas Gerais',
    'PA'=>'Pará','PB'=>'Paraíba','PR'=>'Paraná','PE'=>'Pernambuco','PI'=>'Piauí',
    'RJ'=>'Rio de Janeiro','RN'=>'Rio Grande do Norte','RS'=>'Rio Grande do Sul',
    'RO'=>'Rondônia','RR'=>'Roraima','SC'=>'Santa Catarina','SP'=>'São Paulo',
    'SE'=>'Sergipe','TO'=>'Tocantins'
];

// Prepara dados para Chart.js
$chartDays   = [];
$chartRev    = [];
$chartCnt    = [];
// Preenche os 7 dias mesmo sem dados
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $chartDays[] = date('d/m', strtotime($d));
    $found = array_filter($revenueChart, fn($r) => $r['day'] === $d);
    $found = array_values($found);
    $chartRev[]  = $found ? round($found[0]['total'] / 100, 2) : 0;
    $chartCnt[]  = $found ? (int)$found[0]['cnt'] : 0;
}

$hourLabels = array_fill(0, 24, 0);
$hourData   = array_fill(0, 24, 0);
foreach ($hourlyChart as $h) { $hourData[(int)$h['hr']] = (int)$h['cnt']; }
for ($i = 0; $i < 24; $i++) { $hourLabels[$i] = str_pad($i, 2, '0', STR_PAD_LEFT) . 'h'; }

$sourceColors = [
    'Kwai'   => '#ff6b35',
    'TikTok' => '#69c9d0',
    'Meta'   => '#4267b2',
    'Google' => '#4285f4',
    'Direto' => '#6366f1',
    'Outros' => '#94a3b8',
];

// Taxa de conversão PIX→Pago (24h)
$convRate = $funnel24h['pix'] > 0 ? round(($funnel24h['paid'] / $funnel24h['pix']) * 100, 1) : 0;

// Variação receita hoje vs ontem
$revVar = $revenueYesterday > 0 ? round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100, 1) : null;

admin_layout('Dashboard', 'dashboard');
?>

<!-- ── KPIs Receita ────────────────────────────────────────────────── -->
<div class="kpi-row">
    <div class="kpi-card accent">
        <div class="kpi-icon">💰</div>
        <div class="kpi-body">
            <div class="kpi-label">Receita Hoje</div>
            <div class="kpi-value"><?= formatCurrency($revenueToday) ?></div>
            <?php if ($revVar !== null): ?>
            <div class="kpi-trend <?= $revVar >= 0 ? 'up' : 'down' ?>">
                <?= $revVar >= 0 ? '▲' : '▼' ?> <?= abs($revVar) ?>% vs ontem
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">📅</div>
        <div class="kpi-body">
            <div class="kpi-label">Receita 7 Dias</div>
            <div class="kpi-value"><?= formatCurrency($revenue7d) ?></div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">📆</div>
        <div class="kpi-body">
            <div class="kpi-label">Receita 30 Dias</div>
            <div class="kpi-value"><?= formatCurrency($revenue30d) ?></div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">🎯</div>
        <div class="kpi-body">
            <div class="kpi-label">Receita Total</div>
            <div class="kpi-value"><?= formatCurrency($revenueTotal) ?></div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">🎫</div>
        <div class="kpi-body">
            <div class="kpi-label">Ticket Médio</div>
            <div class="kpi-value"><?= formatCurrency($avgTicket) ?></div>
        </div>
    </div>
    <div class="kpi-card online-card">
        <div class="kpi-icon">🟢</div>
        <div class="kpi-body">
            <div class="kpi-label">Online Agora</div>
            <div class="kpi-value"><?= $onlineUsers ?></div>
        </div>
    </div>
</div>

<!-- ── Status Transactions ─────────────────────────────────────────── -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-label">Total</div>
        <div class="stat-value"><?= $totalTrans ?></div>
    </div>
    <div class="stat-card paid-card">
        <div class="stat-label">Pagas</div>
        <div class="stat-value"><?= $paidTrans + $approvedTrans ?></div>
    </div>
    <div class="stat-card pending-card">
        <div class="stat-label">Pendentes</div>
        <div class="stat-value"><?= $pendingTrans ?></div>
    </div>
    <div class="stat-card danger-card">
        <div class="stat-label">Canceladas</div>
        <div class="stat-value"><?= $cancelledTrans ?></div>
    </div>
    <div class="stat-card conv-card">
        <div class="stat-label">Conv. PIX→Pago (24h)</div>
        <div class="stat-value"><?= $convRate ?>%</div>
    </div>
</div>

<!-- ── Funil de Conversão ──────────────────────────────────────────── -->
<div class="section-title">Funil de Conversão — últimas 24h</div>
<div class="funnel-wrap card">
    <?php
    $fSteps = [
        ['label' => 'Visitantes', 'icon' => '👥', 'val' => $funnel24h['visitors'], 'color' => '#6366f1'],
        ['label' => 'PIX Gerado', 'icon' => '📲', 'val' => $funnel24h['pix'],      'color' => '#f59e0b'],
        ['label' => 'Pagos',      'icon' => '✅', 'val' => $funnel24h['paid'],     'color' => '#10b981'],
    ];
    $maxVal = max(1, $funnel24h['visitors']);
    foreach ($fSteps as $i => $step):
        $pct = round(($step['val'] / $maxVal) * 100);
        $convPct = '';
        if ($i === 1 && $funnel24h['visitors'] > 0)
            $convPct = round(($step['val'] / $funnel24h['visitors']) * 100, 1) . '% de visitantes';
        if ($i === 2 && $funnel24h['pix'] > 0)
            $convPct = round(($step['val'] / max(1,$funnel24h['pix'])) * 100, 1) . '% de PIX gerados';
    ?>
    <div class="funnel-step">
        <div class="funnel-meta">
            <span class="funnel-icon"><?= $step['icon'] ?></span>
            <span class="funnel-label"><?= $step['label'] ?></span>
            <?php if ($convPct): ?><span class="funnel-conv"><?= $convPct ?></span><?php endif; ?>
        </div>
        <div class="funnel-bar-wrap">
            <div class="funnel-bar" style="width:<?= max(4,$pct) ?>%;background:<?= $step['color'] ?>"></div>
            <span class="funnel-num"><?= number_format($step['val']) ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- ── Resumo por Período ──────────────────────────────────────────── -->
<div class="section-title">Performance por Período</div>
<div class="card table-card">
    <table>
        <thead><tr>
            <th>Período</th>
            <th>Transações</th>
            <th>Pagas</th>
            <th>Conv.</th>
            <th>Receita</th>
        </tr></thead>
        <tbody>
        <?php foreach ($periodSummary as $p): ?>
        <tr>
            <td><strong><?= $p['period'] ?></strong></td>
            <td><?= $p['total'] ?></td>
            <td><?= $p['paid'] ?></td>
            <td>
                <?php $c = $p['total'] > 0 ? round($p['paid']/$p['total']*100,1) : 0; ?>
                <span class="conv-badge <?= $c >= 30 ? 'good' : ($c >= 10 ? 'mid' : 'low') ?>"><?= $c ?>%</span>
            </td>
            <td><strong><?= formatCurrency($p['revenue']) ?></strong></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ── Gráficos ────────────────────────────────────────────────────── -->
<div class="charts-grid">
    <div class="card chart-card">
        <div class="card-head">
            <span>Receita 7 Dias (R$)</span>
        </div>
        <canvas id="revenueChart" height="200"></canvas>
    </div>
    <div class="card chart-card">
        <div class="card-head">
            <span>Atividade por Hora (7 dias)</span>
        </div>
        <canvas id="hourlyChart" height="200"></canvas>
    </div>
</div>

<!-- ── Origem do Tráfego + Dispositivos ───────────────────────────── -->
<div class="mid-grid">
    <div class="card">
        <div class="card-head"><span>Origem do Tráfego (7 dias)</span></div>
        <?php if ($referrers): ?>
        <div class="source-list">
            <?php
            $totalSessions = max(1, array_sum(array_column($referrers, 'sessions')));
            foreach ($referrers as $ref):
                $pct = round($ref['sessions'] / $totalSessions * 100);
                $color = $sourceColors[$ref['source']] ?? '#94a3b8';
            ?>
            <div class="source-item">
                <div class="source-top">
                    <span class="source-dot" style="background:<?= $color ?>"></span>
                    <span class="source-name"><?= htmlspecialchars($ref['source']) ?></span>
                    <span class="source-count"><?= number_format($ref['sessions']) ?></span>
                </div>
                <div class="source-bar-bg">
                    <div class="source-bar" style="width:<?= max(2,$pct) ?>%;background:<?= $color ?>"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?><div class="empty">Sem dados suficientes</div><?php endif; ?>
    </div>

    <div class="card">
        <div class="card-head"><span>Dispositivos (7 dias)</span></div>
        <?php
        $totalDev = max(1, $devices['mobile'] + $devices['desktop']);
        $mobPct   = round($devices['mobile']  / $totalDev * 100);
        $dskPct   = round($devices['desktop'] / $totalDev * 100);
        ?>
        <div class="device-wrap">
            <canvas id="deviceChart" width="140" height="140"></canvas>
            <div class="device-legend">
                <div class="dev-item">
                    <span class="dev-dot mobile"></span>
                    <span>Mobile</span>
                    <strong><?= $mobPct ?>%</strong>
                    <small>(<?= number_format($devices['mobile']) ?>)</small>
                </div>
                <div class="dev-item">
                    <span class="dev-dot desktop"></span>
                    <span>Desktop</span>
                    <strong><?= $dskPct ?>%</strong>
                    <small>(<?= number_format($devices['desktop']) ?>)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head"><span>Top Estados (7 dias)</span></div>
        <?php if ($topStates): ?>
        <div class="state-list">
        <?php foreach ($topStates as $i => $st):
            $name = $stateNames[$st['state']] ?? $st['state'];
        ?>
        <div class="state-item">
            <span class="state-rank"><?= $i+1 ?></span>
            <div class="state-body">
                <div class="state-top">
                    <span class="state-name"><?= $name ?></span>
                    <span class="state-rev"><?= formatCurrency($st['revenue']) ?></span>
                </div>
                <div class="state-sub">
                    <span><?= $st['visitors'] ?> visitas</span>
                    <span>·</span>
                    <span><?= $st['paid_count'] ?> pagos</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
        <?php else: ?><div class="empty">Sem dados suficientes</div><?php endif; ?>
    </div>
</div>

<!-- ── Transações Recentes ─────────────────────────────────────────── -->
<div class="section-title">Transações Recentes</div>
<div class="card table-card">
    <?php if ($recent): ?>
    <table>
        <thead><tr>
            <th>ID</th>
            <th>Referência</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Data</th>
        </tr></thead>
        <tbody>
        <?php foreach ($recent as $tx): ?>
        <tr>
            <td><code><?= htmlspecialchars(substr($tx['external_id'], 0, 16)) ?>…</code></td>
            <td><?= htmlspecialchars($tx['reference']) ?></td>
            <td><strong><?= formatCurrency($tx['amount']) ?></strong></td>
            <td><span class="status <?= htmlspecialchars($tx['status']) ?>"><?= htmlspecialchars($tx['status']) ?></span></td>
            <td><?= date('d/m H:i', strtotime($tx['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><div class="empty">Nenhuma transação encontrada</div><?php endif; ?>
</div>

<!-- ── Chart.js ───────────────────────────────────────────────────── -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Inter','Segoe UI',sans-serif";
Chart.defaults.color = '#666';

const chartDays = <?= json_encode($chartDays) ?>;
const chartRev  = <?= json_encode($chartRev) ?>;
const chartCnt  = <?= json_encode($chartCnt) ?>;
const hourLabels= <?= json_encode($hourLabels) ?>;
const hourData  = <?= json_encode($hourData) ?>;
const mobPct    = <?= $mobPct ?>;
const dskPct    = <?= $dskPct ?>;

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: chartDays,
        datasets: [
            {
                label: 'Receita (R$)',
                data: chartRev,
                backgroundColor: 'rgba(99,102,241,0.75)',
                borderColor: '#6366f1',
                borderWidth: 1,
                borderRadius: 4,
                yAxisID: 'y',
            },
            {
                label: 'Transações',
                data: chartCnt,
                type: 'line',
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                tension: 0.4,
                pointRadius: 4,
                fill: true,
                yAxisID: 'y1',
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        scales: {
            y:  { position: 'left',  beginAtZero: true, ticks: { callback: v => 'R$'+v.toLocaleString('pt-BR') } },
            y1: { position: 'right', beginAtZero: true, grid: { drawOnChartArea: false } }
        },
        plugins: { legend: { position: 'top' } }
    }
});

new Chart(document.getElementById('hourlyChart'), {
    type: 'bar',
    data: {
        labels: hourLabels,
        datasets: [{
            label: 'Transações',
            data: hourData,
            backgroundColor: hourData.map(v => v === Math.max(...hourData) ? '#e94560' : 'rgba(99,102,241,0.6)'),
            borderRadius: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

new Chart(document.getElementById('deviceChart'), {
    type: 'doughnut',
    data: {
        labels: ['Mobile', 'Desktop'],
        datasets: [{ data: [mobPct, dskPct], backgroundColor: ['#6366f1','#e94560'], borderWidth: 0, hoverOffset: 4 }]
    },
    options: {
        cutout: '68%',
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => c.label+': '+c.raw+'%' } } }
    }
});
</script>

<style>
/* ── Seções ───────────────────────── */
.section-title { font-size: 0.9375rem; font-weight: 600; color: var(--text); margin: 1.75rem 0 0.75rem; }

/* ── KPIs ────────────────────────── */
.kpi-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap: 1rem; margin-bottom: 1.25rem; }
.kpi-card { background: var(--surface); border-radius: 10px; padding: 1rem 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); display: flex; align-items: flex-start; gap: .75rem; }
.kpi-card.accent { border-left: 4px solid var(--accent); }
.kpi-card.online-card { border-left: 4px solid #10b981; }
.kpi-icon { font-size: 1.5rem; line-height: 1; }
.kpi-label { font-size: .75rem; color: var(--text-muted); font-weight: 500; margin-bottom: .2rem; }
.kpi-value { font-size: 1.375rem; font-weight: 700; color: var(--text); }
.kpi-trend { font-size: .7rem; margin-top: .25rem; font-weight: 500; }
.kpi-trend.up { color: #10b981; }
.kpi-trend.down { color: #ef4444; }

/* ── Stats ───────────────────────── */
.stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px,1fr)); gap: .875rem; margin-bottom: 1.5rem; }
.stat-card { background: var(--surface); border-radius: 8px; padding: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.06); text-align: center; }
.stat-label { font-size: .75rem; color: var(--text-muted); font-weight: 500; margin-bottom: .35rem; }
.stat-value { font-size: 1.75rem; font-weight: 700; color: var(--text); }
.paid-card .stat-value { color: #10b981; }
.pending-card .stat-value { color: #f59e0b; }
.danger-card .stat-value { color: #ef4444; }
.conv-card .stat-value { color: #6366f1; }

/* ── Funil ───────────────────────── */
.funnel-wrap { padding: 1.25rem; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 1.1rem; }
.funnel-step { display: flex; flex-direction: column; gap: .35rem; }
.funnel-meta { display: flex; align-items: center; gap: .5rem; }
.funnel-icon { font-size: 1.1rem; }
.funnel-label { font-weight: 600; font-size: .875rem; color: var(--text); }
.funnel-conv { margin-left: auto; font-size: .75rem; color: var(--text-muted); }
.funnel-bar-wrap { display: flex; align-items: center; gap: .75rem; }
.funnel-bar { height: 18px; border-radius: 4px; transition: width .4s; min-width: 4px; }
.funnel-num { font-size: .8125rem; color: var(--text-muted); font-weight: 600; white-space: nowrap; }

/* ── Período ─────────────────────── */
.conv-badge { display: inline-block; padding: .15rem .45rem; border-radius: 999px; font-size: .75rem; font-weight: 600; }
.conv-badge.good { background: #d1fae5; color: #059669; }
.conv-badge.mid  { background: #fef3c7; color: #d97706; }
.conv-badge.low  { background: #fee2e2; color: #dc2626; }

/* ── Gráficos ────────────────────── */
.charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
@media (max-width: 900px) { .charts-grid { grid-template-columns: 1fr; } }
.chart-card { padding: 1.25rem; }
.card-head { font-size: .875rem; font-weight: 600; color: var(--text); margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between; }

/* ── Mid grid ────────────────────── */
.mid-grid { display: grid; grid-template-columns: 1fr 220px 1fr; gap: 1.25rem; margin-bottom: 1.5rem; }
@media (max-width: 900px) { .mid-grid { grid-template-columns: 1fr; } }

/* ── Origem ──────────────────────── */
.source-list { display: flex; flex-direction: column; gap: .8rem; }
.source-item { display: flex; flex-direction: column; gap: .25rem; }
.source-top { display: flex; align-items: center; gap: .5rem; }
.source-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.source-name { flex: 1; font-size: .8125rem; font-weight: 500; }
.source-count { font-size: .75rem; color: var(--text-muted); }
.source-bar-bg { background: var(--bg); border-radius: 3px; height: 6px; overflow: hidden; }
.source-bar { height: 100%; border-radius: 3px; transition: width .4s; }

/* ── Dispositivos ────────────────── */
.device-wrap { display: flex; flex-direction: column; align-items: center; gap: 1rem; padding-top: .5rem; }
.device-legend { display: flex; flex-direction: column; gap: .6rem; width: 100%; }
.dev-item { display: flex; align-items: center; gap: .5rem; font-size: .8125rem; }
.dev-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.dev-dot.mobile { background: #6366f1; }
.dev-dot.desktop { background: #e94560; }
.dev-item strong { margin-left: auto; }
.dev-item small { color: var(--text-muted); }

/* ── Estados ─────────────────────── */
.state-list { display: flex; flex-direction: column; gap: .6rem; }
.state-item { display: flex; align-items: flex-start; gap: .75rem; padding: .5rem 0; border-bottom: 1px solid var(--border); }
.state-item:last-child { border-bottom: none; }
.state-rank { width: 22px; height: 22px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .7rem; font-weight: 700; color: var(--text-muted); flex-shrink: 0; margin-top: 2px; }
.state-body { flex: 1; }
.state-top { display: flex; align-items: center; justify-content: space-between; }
.state-name { font-weight: 600; font-size: .8125rem; }
.state-rev { font-weight: 700; font-size: .8125rem; color: #10b981; }
.state-sub { font-size: .7rem; color: var(--text-muted); margin-top: .15rem; display: flex; gap: .35rem; }

/* ── Tabelas ─────────────────────── */
.table-card { padding: 0; overflow: hidden; margin-bottom: 1.5rem; }
.table-card table { width: 100%; border-collapse: collapse; }
.table-card th, .table-card td { padding: .65rem 1rem; text-align: left; border-bottom: 1px solid var(--border); }
.table-card th { font-size: .7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; background: var(--bg); }
.table-card td { font-size: .8125rem; }
.table-card tr:last-child td { border-bottom: none; }
.table-card tr:hover td { background: #f9fafb; }
code { background: #f3f4f6; padding: .1rem .35rem; border-radius: 3px; font-size: .7rem; }
.status { display: inline-block; padding: .2rem .55rem; border-radius: 999px; font-size: .6875rem; font-weight: 600; text-transform: capitalize; }
.status.pending   { background: #fef3c7; color: #d97706; }
.status.approved,
.status.paid      { background: #d1fae5; color: #059669; }
.status.rejected,
.status.cancelled { background: #fee2e2; color: #dc2626; }

/* ── Cards genéricos ─────────────── */
.card { background: var(--surface); border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,.07); padding: 1.25rem; }
</style>

<?php admin_layout_end(); ?>
