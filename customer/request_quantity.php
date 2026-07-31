<?php
include("../pages/connection.php");
$shop = $_SESSION['shop'] ?? 0;
$customer = $_SESSION['customer'] ?? 0;
$product = intval($_GET['product'] ?? 0);

if (! $shop) {
    echo "<script>alert('No business selected.');location='business'</script>";
    exit;
}

if (! $customer) {
    echo "<script>alert('Please select a customer.');location='business?business=" . $shop . "'" . "</script>";
    exit;
}

if (! $product) {
    echo "<script>alert('No product selected.');location='get_item'</script>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM item WHERE id = ? AND business = ?");
$stmt->bind_param("ii", $product, $shop);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();
if (! $item) {
    echo "<script>alert('Item not found.');location='get_item'</script>";
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_list'])) {
    $quantity = max(1, intval($_POST['quantity']));
    $pid = $product;
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$pid] = [
            'id' => $pid,
            'name' => $item['item_name'],
            'quantity' => $quantity,
            'price' => $item['out_price']
        ];
    }
    echo "<script>alert('Added to list'),location='get_item'</script>";
    exit;
}

if (isset($_POST['add_and_request'])) {
    // Backwards compatibility: add to cart and directly send single request
    $quantity = max(1, intval($_POST['quantity']));
    $pid = $product;
    // insert directly into request_orders
    $insert = $conn->prepare("INSERT INTO request_orders(shop, customer, req_item, req_quantity, price, allowed_quantity) VALUES (?, ?, ?, ?, ?, 0)");
    $insert->bind_param("iiidd", $shop, $customer, $pid, $quantity, $item['out_price']);
    $insert->execute();
    echo "<script>alert('Request submitted'),location='ordering?customer=".$customer."'</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Quantity</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid p-3 w-full h-screen flex justify-center">
        <div class="conatiner bg-gradient-to-r from-yellow-900 via-yellow-400 to-yellow-900 p-2 rounder w-full md:w-1/3 m-auto rounded">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Request <?php echo htmlspecialchars($item['item_name']) ?></h1>
                <hr class="text-white">
                <div class="p-2">
                   
                    <label class="block p-1 text-sm text-white font-bold my-2">Quantity</label>
                    <input type="number" required name="quantity" min="1" step="1" class="w-full rounded p-2 outline-0 focus:outline-none text-sm font-bold">
                    <div class="text-white font-bold mt-3">Price per unit: <span class="price"><?php echo htmlspecialchars($item['out_price']) ?></span></div>
                </div>
                <div class="flex p-2 justify-betweenx gap-2">
                    <button type="submit" name="add_to_list" class="p-2 text-white text-sm rounded shadow shadow-white border font-bold bg-green-600">Add to List</button>
                    <button type="submit" name="add_and_request" class="p-2 text-white text-sm rounded shadow shadow-white border font-bold bg-blue-600">Request Now</button>
                </div>
                <div class="flex p-2 justify-start">
                    <a href="ordering?customer=<?php echo $customer ?>" class="text-white text-sm">Back to requests</a>
                </div>
            </form>
        </div>
    </div>
     <script>
 document.querySelectorAll(".price").forEach(e=>{
    var numbers=Number(e.textContent);
    e.textContent=numbers.toLocaleString();
 })
    </script>
</body>
</html>
