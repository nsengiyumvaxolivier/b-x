<?php
include("../pages/connection.php");
$shop = $_SESSION['shop'] ?? 0;
$customer = $_SESSION['customer'] ?? 0;

if (! $shop) {
    echo "<script>alert('No business selected.');location='business'</script>";
    exit;
}
if (! $customer) {
    echo "<script>alert('Please select a customer.');location='business?business=" . $shop . "'</script>";
    exit;
}

// ensure request_messages table exists
$createMessages = "CREATE TABLE IF NOT EXISTS request_messages (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    shop INT NOT NULL,
    customer INT NOT NULL,
    sender ENUM('customer','shop') NOT NULL,
    message TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($createMessages);

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) < 1) {
    $cart = [];
} else {
    $cart = $_SESSION['cart'];
}

if (isset($_POST['send_all'])) {
    $message = trim($_POST['message'] ?? '');
    // insert message
    if ($message !== '') {
        $ins = $conn->prepare("INSERT INTO request_messages (shop, customer, sender, message) VALUES (?, ?, 'customer', ?)");
        $ins->bind_param("iis", $shop, $customer, $message);
        $ins->execute();
    }
    // insert request orders
    foreach ($cart as $pid => $row) {
        $p = intval($row['id']);
        $q = floatval($row['quantity']);
        $price = floatval($row['price']);
        $check = $conn->prepare("SELECT req_ord_id, req_quantity FROM request_orders WHERE shop = ? AND customer = ? AND req_item = ? AND allowed_quantity = 0");
        $check->bind_param("iii", $shop, $customer, $p);
        $check->execute();
        $cr = $check->get_result();
        if ($cr->num_rows > 0) {
            $r = $cr->fetch_assoc();
            $newQ = $r['req_quantity'] + $q;
            $u = $conn->prepare("UPDATE request_orders SET req_quantity = ? WHERE req_ord_id = ?");
            $u->bind_param("di", $newQ, $r['req_ord_id']);
            $u->execute();
        } else {
            $ins = $conn->prepare("INSERT INTO request_orders (shop, customer, req_item, req_quantity, price, allowed_quantity) VALUES (?, ?, ?, ?, ?, 0)");
            $ins->bind_param("iiidd", $shop, $customer, $p, $q, $price);
            $ins->execute();
        }
    }
    // clear cart
    unset($_SESSION['cart']);
    echo "<script>alert('Requests sent'),location='ordering'</script>";
    exit;
}

if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $pid => $qty) {
        $pid = intval($pid);
        $qty = max(1,intval($qty));
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['quantity'] = $qty;
        }
    }
    header('Location: cart');
    exit;
}

if (isset($_POST['remove'])) {
    $pid = intval($_POST['remove']);
    if (isset($_SESSION['cart'][$pid])) unset($_SESSION['cart'][$pid]);
    header('Location: cart');
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
    <title>Request List</title>
</head>
<body>
<div class="container-fluid p-2">
    <h1 class="font-bold">Request List for <?php echo htmlspecialchars($_SESSION['customername'] ?? '') ?></h1>
    <form method="post">
    <div class="overflow-auto">
    <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
        <thead class="bg-yellow-900 text-white"><tr><th>#</th><th>Item</th><th>Qty</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
        <tbody>
        <?php $i=0; $sum=0; foreach($cart as $pid=>$it){ $i++; $sum += $it['quantity']*$it['price']; ?>
            <tr class="border hover:bg-gray-100">
                <td><?php echo $i ?></td>
                <td><?php echo htmlspecialchars($it['name']) ?></td>
                <td><input type="number" name="qty[<?php echo $it['id'] ?>]" value="<?php echo $it['quantity'] ?>" min="1" class="w-20 p-1"></td>
                <td><?php echo htmlspecialchars($it['price']) ?></td>
                <td><?php echo htmlspecialchars($it['quantity']*$it['price']) ?></td>
                <td><button name="remove" value="<?php echo $it['id'] ?>" class="p-1 text-red rounded"><i class="bi bi-x-circle"></i></button></td>
            </tr>
        <?php } if ($i==0){ echo '<tr><td colspan="6" class="p-4">No items in list.</td></tr>'; } ?>
        <tr class="bg-yellow-900 text-white"><th colspan="4">Total</th><th><?php echo $sum ?></th><th></th></tr>
        </tbody>
    </table>
    </div>
   
    <div class="flex justify-between my-3">
        <div>
            <button name="update" class="p-2 bg-blue-500 text-white rounded">Update Quantities</button>
        </div>
        <div>
            <button name="send_all" class="p-2 bg-green-600 text-white rounded">Send All Requests</button>
        </div>
    </div>
    </form>
</div>
</body>
</html>
