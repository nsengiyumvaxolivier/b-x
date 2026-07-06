<?php
header('Content-Type: application/json');
include(__DIR__.'/../connection.php');
$shop = intval($_POST['shop'] ?? 0);
$customer = intval($_POST['customer'] ?? 0);
$sender = in_array($_POST['sender'] ?? '', ['customer','shop']) ? $_POST['sender'] : 'customer';
$message = trim($_POST['message'] ?? '');
if (! $shop || ! $customer) {
    echo json_encode(['success' => false, 'error' => 'Missing params']);
    exit;
}
// ensure table exists
$conn->query("CREATE TABLE IF NOT EXISTS request_messages (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    shop INT NOT NULL,
    customer INT NOT NULL,
    sender ENUM('customer','shop') NOT NULL,
    message TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// handle uploaded audio
if (!empty($_FILES['audio']) && is_uploaded_file($_FILES['audio']['tmp_name'])) {
    $uploaddir = __DIR__ . '/../uploads/voices/';
    if (!is_dir($uploaddir)) {
        mkdir($uploaddir, 0755, true);
    }
    $ext = pathinfo($_FILES['audio']['name'], PATHINFO_EXTENSION);
    $filename = 'voice_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . ($ext ?: 'webm');
    $dest = $uploaddir . $filename;
    if (move_uploaded_file($_FILES['audio']['tmp_name'], $dest)) {
        // store as special audio marker with relative path from pages/
        $message = 'audio:uploads/voices/' . $filename;
    } else {
        echo json_encode(['success' => false, 'error' => 'Upload failed']);
        exit;
    }
}

$ins = $conn->prepare("INSERT INTO request_messages (shop, customer, sender, message) VALUES (?, ?, ?, ?)");
$ins->bind_param("iiss", $shop, $customer, $sender, $message);
$ok = $ins->execute();
if (! $ok) {
    echo json_encode(['success' => false, 'error' => $conn->error]);
    exit;
}
$inserted_id = $conn->insert_id;
echo json_encode(['success' => true, 'id' => $inserted_id, 'message' => $message]);
