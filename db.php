<?php

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'paradise';
$db_pass = getenv('DB_PASS') ?: 'paradise';
$db_name = getenv('DB_NAME') ?: 'paradise';

$db = @new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($db->connect_error) {
    error_log('[DB] Conexão falhou: ' . $db->connect_error);
    $db = null;
} else {
    $db->set_charset('utf8mb4');
}

function db_get_setting($key) {
    global $db;
    if (!isset($db) || $db->connect_error) return null;
    $stmt = $db->prepare("SELECT value FROM settings WHERE `key` = ?");
    $stmt->bind_param('s', $key);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['value'] ?? null;
}

function db_save_transaction($data) {
    global $db;
    $stmt = $db->prepare("
        INSERT INTO transactions (external_id, reference, amount, status, pix_code, qr_code_base64, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param(
        'ssisss',
        $data['external_id'],
        $data['reference'],
        $data['amount'],
        $data['status'],
        $data['pix_code'],
        $data['qr_code_base64']
    );
    $stmt->execute();
    $stmt->close();
    return $db->insert_id;
}

function db_update_transaction_status($external_id, $status) {
    global $db;
    $stmt = $db->prepare("UPDATE transactions SET status = ?, updated_at = NOW() WHERE external_id = ?");
    $stmt->bind_param('ss', $status, $external_id);
    $stmt->execute();
    $stmt->close();
    return $stmt->affected_rows > 0;
}

function db_get_transaction($external_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM transactions WHERE external_id = ?");
    $stmt->bind_param('s', $external_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

function db_list_transactions($limit = 100, $offset = 0, $status = null) {
    global $db;
    if ($status) {
        $stmt = $db->prepare("SELECT * FROM transactions WHERE status = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param('sii', $status, $limit, $offset);
    } else {
        $stmt = $db->prepare("SELECT * FROM transactions ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $limit, $offset);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $stmt->close();
    return $rows;
}

function db_count_transactions($status = null) {
    global $db;
    if ($status) {
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM transactions WHERE status = ?");
        $stmt->bind_param('s', $status);
    } else {
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM transactions");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return (int) $row['cnt'];
}

function db_save_setting($key, $value) {
    global $db;
    $stmt = $db->prepare("INSERT INTO settings (`key`, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");
    $stmt->bind_param('ss', $key, $value);
    $stmt->execute();
    $stmt->close();
}

function db_list_settings() {
    global $db;
    $result = $db->query("SELECT `key`, value FROM settings ORDER BY `key`");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function db_save_analytics($data) {
    global $db;
    $stmt = $db->prepare("INSERT INTO analytics (session_id, page, state, country, referrer, user_agent, ip_hash) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        'sssssss',
        $data['session_id'],
        $data['page'],
        $data['state'],
        $data['country'],
        $data['referrer'],
        $data['user_agent'],
        $data['ip_hash']
    );
    $stmt->execute();
    $stmt->close();
    return $db->insert_id;
}

function db_count_online_users($minutes = 5) {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(DISTINCT session_id) as cnt FROM analytics WHERE created_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)");
    $stmt->bind_param('i', $minutes);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return (int) $row['cnt'];
}

function db_get_top_states($limit = 5) {
    global $db;
    $result = $db->query("SELECT state, COUNT(*) as cnt FROM analytics WHERE state IS NOT NULL AND state != '' AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY state ORDER BY cnt DESC LIMIT $limit");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function db_get_active_kwai_pixels() {
    global $db;
    $result = $db->query("SELECT pixel_id, access_token FROM kwai_pixels WHERE is_active = 1");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function db_save_kwai_pixel($data) {
    global $db;
    $stmt = $db->prepare("INSERT INTO kwai_pixels (pixel_id, access_token, is_active) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE access_token = VALUES(access_token), is_active = VALUES(is_active)");
    $stmt->bind_param('ssi', $data['pixel_id'], $data['access_token'], $data['is_active']);
    $stmt->execute();
    $stmt->close();
    return $db->insert_id;
}

function db_delete_kwai_pixel($id) {
    global $db;
    if (empty($db)) return false;
    $stmt = $db->prepare("DELETE FROM kwai_pixels WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    return $affected > 0;
}

function db_get_kwai_pixel($id) {
    global $db;
    if (!isset($db) || $db->connect_error) return null;
    $stmt = $db->prepare("SELECT * FROM kwai_pixels WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

function db_list_kwai_pixels($limit = 50, $offset = 0) {
    global $db;
    $result = $db->query("SELECT * FROM kwai_pixels ORDER BY id DESC LIMIT $limit OFFSET $offset");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    return $rows;
}

// ── Estatísticas Avançadas ─────────────────────────────────────────────────

function db_get_revenue($period = 'all') {
    global $db;
    $where = "status IN ('paid','approved')";
    if ($period === 'today')     $where .= " AND DATE(created_at) = CURDATE()";
    elseif ($period === 'yesterday') $where .= " AND DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    elseif ($period === '7d')    $where .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    elseif ($period === '30d')   $where .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $result = $db->query("SELECT COALESCE(SUM(amount),0) as total FROM transactions WHERE $where");
    $row = $result->fetch_assoc();
    return (int) $row['total'];
}

function db_get_average_ticket() {
    global $db;
    $result = $db->query("SELECT AVG(amount) as avg FROM transactions WHERE status IN ('paid','approved')");
    $row = $result->fetch_assoc();
    return (int) ($row['avg'] ?? 0);
}

function db_get_revenue_chart($days = 7) {
    global $db;
    $stmt = $db->prepare("
        SELECT DATE(created_at) as day, COALESCE(SUM(amount),0) as total, COUNT(*) as cnt
        FROM transactions
        WHERE status IN ('paid','approved') AND created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        GROUP BY DATE(created_at)
        ORDER BY day ASC
    ");
    $stmt->bind_param('i', $days);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $stmt->close();
    return $rows;
}

function db_get_transactions_by_hour() {
    global $db;
    $result = $db->query("
        SELECT HOUR(created_at) as hr, COUNT(*) as cnt
        FROM transactions
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY HOUR(created_at)
        ORDER BY hr ASC
    ");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function db_get_conversion_funnel($period_hours = 24) {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(DISTINCT session_id) as visitors FROM analytics WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? HOUR)");
    $stmt->bind_param('i', $period_hours);
    $stmt->execute();
    $visitors = (int) $stmt->get_result()->fetch_assoc()['visitors'];
    $stmt->close();

    $stmt2 = $db->prepare("SELECT COUNT(*) as pix FROM transactions WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? HOUR)");
    $stmt2->bind_param('i', $period_hours);
    $stmt2->execute();
    $pix = (int) $stmt2->get_result()->fetch_assoc()['pix'];
    $stmt2->close();

    $stmt3 = $db->prepare("SELECT COUNT(*) as paid FROM transactions WHERE status IN ('paid','approved') AND created_at >= DATE_SUB(NOW(), INTERVAL ? HOUR)");
    $stmt3->bind_param('i', $period_hours);
    $stmt3->execute();
    $paid = (int) $stmt3->get_result()->fetch_assoc()['paid'];
    $stmt3->close();

    return ['visitors' => $visitors, 'pix' => $pix, 'paid' => $paid];
}

function db_get_referrer_stats($limit = 6) {
    global $db;
    $stmt = $db->prepare("
        SELECT
            CASE
                WHEN referrer LIKE '%kwai%' OR referrer LIKE '%kwaiq%' OR referrer LIKE '%snack%' THEN 'Kwai'
                WHEN referrer LIKE '%tiktok%' OR referrer LIKE '%ttclid%' THEN 'TikTok'
                WHEN referrer LIKE '%facebook%' OR referrer LIKE '%fb.com%' OR referrer LIKE '%instagram%' THEN 'Meta'
                WHEN referrer LIKE '%google%' OR referrer LIKE '%gclid%' THEN 'Google'
                WHEN referrer IS NULL OR referrer = '' THEN 'Direto'
                ELSE 'Outros'
            END as source,
            COUNT(DISTINCT session_id) as sessions
        FROM analytics
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY source
        ORDER BY sessions DESC
        LIMIT ?
    ");
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $stmt->close();
    return $rows;
}

function db_get_device_stats() {
    global $db;
    $result = $db->query("
        SELECT
            SUM(CASE WHEN user_agent LIKE '%Mobile%' OR user_agent LIKE '%Android%' OR user_agent LIKE '%iPhone%' THEN 1 ELSE 0 END) as mobile,
            SUM(CASE WHEN user_agent NOT LIKE '%Mobile%' AND user_agent NOT LIKE '%Android%' AND user_agent NOT LIKE '%iPhone%' THEN 1 ELSE 0 END) as desktop
        FROM analytics
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ");
    $row = $result->fetch_assoc();
    return ['mobile' => (int)($row['mobile'] ?? 0), 'desktop' => (int)($row['desktop'] ?? 0)];
}

function db_get_top_states_revenue($limit = 8) {
    global $db;
    $stmt = $db->prepare("
        SELECT
            a.state,
            COUNT(DISTINCT a.session_id) as visitors,
            COUNT(t.id) as transactions,
            COALESCE(SUM(CASE WHEN t.status IN ('paid','approved') THEN t.amount ELSE 0 END), 0) as revenue,
            COUNT(CASE WHEN t.status IN ('paid','approved') THEN 1 END) as paid_count
        FROM analytics a
        LEFT JOIN transactions t ON DATE(t.created_at) = DATE(a.created_at)
        WHERE a.state IS NOT NULL AND a.state != '' AND a.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY a.state
        ORDER BY revenue DESC, visitors DESC
        LIMIT ?
    ");
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $stmt->close();
    return $rows;
}

function db_get_period_summary() {
    global $db;
    $periods = [
        'Hoje'      => "DATE(created_at) = CURDATE()",
        'Ontem'     => "DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)",
        '7 Dias'    => "created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)",
        '30 Dias'   => "created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)",
    ];
    $summary = [];
    foreach ($periods as $label => $cond) {
        $r = $db->query("SELECT COUNT(*) as total, COUNT(CASE WHEN status IN ('paid','approved') THEN 1 END) as paid, COALESCE(SUM(CASE WHEN status IN ('paid','approved') THEN amount ELSE 0 END),0) as revenue FROM transactions WHERE $cond");
        $row = $r->fetch_assoc();
        $summary[] = ['period' => $label, 'total' => (int)$row['total'], 'paid' => (int)$row['paid'], 'revenue' => (int)$row['revenue']];
    }
    return $summary;
}