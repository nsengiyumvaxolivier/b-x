<?php
header('Content-Type: application/json');
include(__DIR__.'/../connection.php');
$shop = intval($_GET['shop'] ?? 0);
$customer = intval($_GET['customer'] ?? 0);
if (! $shop || ! $customer) {
    echo json_encode(['success' => false, 'error' => 'Missing params']);
    exit;
}
$stmt = $conn->prepare("SELECT id, sender, message, created_at FROM request_messages WHERE shop = ? AND customer = ? ORDER BY created_at ASC");
$stmt->bind_param("ii", $shop, $customer);
$stmt->execute();
$res = $stmt->get_result();
$rows = [];
while ($r = $res->fetch_assoc()) {
    $rows[] = $r;
}
echo json_encode(['success' => true, 'messages' => $rows]);
