<?php

include("connection.php");
$business = $_SESSION['user'];
$customer = intval($_GET['customer'] ?? 0);

if (! $customer) {
    echo "<script>alert('Customer not selected.');location='request_orders'</script>";
    exit;
}

$customerStmt = $conn->prepare("SELECT * FROM customer WHERE c_id = ? AND business = ?");
$customerStmt->bind_param("ii", $customer, $business);
$customerStmt->execute();
$customerResult = $customerStmt->get_result();
$customerRow = $customerResult->fetch_assoc();
if (! $customerRow) {
    echo "<script>alert('Customer not found.');location='request_orders'</script>";
    exit;
}

if (isset($_POST['approve'])) {
    $requestIds = $_POST['request'] ?? [];
    foreach ($requestIds as $reqOrdId => $allowedQuantity) {
        $allowedQuantity = floatval($allowedQuantity);
        if ($allowedQuantity <= 0) {
            continue;
        }
        $requestStmt = $conn->prepare("SELECT req_item, req_quantity, price FROM request_orders WHERE req_ord_id = ? AND shop = ? AND customer = ? AND allowed_quantity = 0");
        $requestStmt->bind_param("iii", $reqOrdId, $business, $customer);
        $requestStmt->execute();
        $requestResult = $requestStmt->get_result();
        if ($requestResult->num_rows === 0) {
            continue;
        }
        $requestData = $requestResult->fetch_assoc();
        $product = intval($requestData['req_item']);
        $price = floatval($requestData['price']);

        $insert = $conn->prepare("INSERT INTO orders(business, customer, product, ord_quantity, discount, status, price) VALUES (?, ?, ?, ?, 0, 0, ?)");
        $insert->bind_param("iiidi", $business, $customer, $product, $allowedQuantity, $price);
        $insert->execute();

        $update = $conn->prepare("UPDATE request_orders SET allowed_quantity = ? WHERE req_ord_id = ?");
        $update->bind_param("di", $allowedQuantity, $reqOrdId);
        $update->execute();
    }
    echo "<script>alert('Request approved and moved to orders.');location='request_orders'</script>";
    exit;
}

if (isset($_POST['reply'])) {
    $reply = trim($_POST['reply_message'] ?? '');
    if ($reply !== '') {
        $conn->query("CREATE TABLE IF NOT EXISTS request_messages (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            shop INT NOT NULL,
            customer INT NOT NULL,
            sender ENUM('customer','shop') NOT NULL,
            message TEXT,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $ins = $conn->prepare("INSERT INTO request_messages (shop, customer, sender, message) VALUES (?, ?, 'shop', ?)");
        $ins->bind_param("iis", $business, $customer, $reply);
        $ins->execute();
    }
    echo "<script>alert('Reply sent'),location='approve_request?customer=".$customer."'</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Request</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid h-[100%]">
        <div class="flex w-full p-2 bg-yellow-900 justify-between items-center">
            <h1 class="text-white font-bold text-sm p-1"><i class="bi bi-person-fill"></i> <?php echo htmlspecialchars($customerRow['name']) ?> - Approve Request</h1>
            <a href="request_orders" class="font-bold text-white p-1 border shadow shadow-white rounded text-sm"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
       
       
        <form action="" method="post">
            <div class="table-responsive w-full overflow-y-auto my-2">
                <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                    <thead class="bg-yellow-900 text-white text-sm"><tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Stock</th>
                        <th class="hidden md:block">Price</th>
                        <th>Available</th>
                    </tr></thead>
                    <tbody>
                        <?php
                        $select = $conn->prepare(
                            "SELECT ro.req_ord_id, ro.req_item, ro.req_quantity, ro.price, i.item_name, i.quantity AS stock " .
                            "FROM request_orders ro " .
                            "JOIN item i ON ro.req_item = i.id " .
                            "WHERE ro.shop = ? AND ro.customer = ? AND ro.allowed_quantity = 0"
                        );
                        $select->bind_param("ii", $business, $customer);
                        $select->execute();
                        $result = $select->get_result();
                        if ($result->num_rows > 0) {
                            $no = 0;
                            while ($a = $result->fetch_assoc()) {
                                $no++;
                                ?>
                                <tr class="border hover:bg-gray-200">
                                    <td><?php echo $no ?></td>
                                    <td><?php echo htmlspecialchars($a['item_name']) ?></td>
                                    <td><?php echo htmlspecialchars($a['req_quantity']) ?></td>
                                    <td><?php echo htmlspecialchars($a['stock']) ?></td>
                                    <td class="hidden md:block"><?php echo htmlspecialchars($a['price']) ?></td>
                                    <td>
                                        <input type="number" min="0" max="<?php echo htmlspecialchars($a['stock']) ?>" step="1" name="request[<?php echo $a['req_ord_id'] ?>]" value="<?php echo htmlspecialchars(min($a['req_quantity'], $a['stock'])) ?>" class="w-full rounded p-1 outline-0 border border-gray-300 text-sm font-bold" />
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="6" class="text-center p-4 text-gray-500">No pending requests for this customer.</td></tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="flex p-2 justify-end">
                <button type="submit" name="approve" class="p-2 text-white rounded shadow shadow-white border font-bold bg-green-600">Approve Selected</button>
            </div>
        </form>
    </div>
</body>
</html>
