<?php

include("../pages/connection.php");
$shop = $_SESSION['shop'] ?? 0;
$customer = $_GET['customer'] ?? 0;
if (! $shop) {
    echo "<script>alert('No business selected.');location='business'</script>";
    exit;
}

if (! $customer) {
    echo "<script>alert('Please select a customer.');location='business?business=" . $shop . "'</script>";
    exit;
}

//select Customer..............................................................................................
$selectcustomer=$conn->prepare("SELECT * FROM customer where c_id=? and business=?");
$selectcustomer->bind_param("ii",$customer,$shop);
$selectcustomer->execute();
$customerresult=$selectcustomer->get_result();
$customerrow=$customerresult->fetch_assoc();

$_SESSION['customer']=$customer;


//delete..................................................................................................

if (isset($_POST['delete'])) {
    $requestId = intval($_POST['delete']);
    $delete = $conn->prepare("DELETE FROM request_orders WHERE req_ord_id = ? AND shop = ? AND customer = ?");
    $delete->bind_param("iii", $requestId, $shop, $customer);
    if ($delete->execute()) {
        echo "<script>alert('Request deleted'),location='ordering'</script>";
        exit;
    }
}

if (isset($_POST['send_message'])) {
    $m = trim($_POST['cust_message'] ?? '');
    if ($m !== '') {
        $conn->query("CREATE TABLE IF NOT EXISTS request_messages (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            shop INT NOT NULL,
            customer INT NOT NULL,
            sender ENUM('customer','shop') NOT NULL,
            message TEXT,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $ins = $conn->prepare("INSERT INTO request_messages (shop, customer, sender, message) VALUES (?, ?, 'customer', ?)");
        $ins->bind_param("iis", $shop, $customer, $m);
        $ins->execute();
    }
    echo "<script>alert('Message sent'),location='ordering'</script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>custoer ordering-page</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid h-[100%]">
         <form action="" class="p-0 h-[100%]" method="post">
        <div class="flex-column md:flex w-full p-2 bg-yellow-900 justify-between">
           <h1 class="text-white font-bold text-sm p-1"><i class="bi bi-person-fill"></i> <?= htmlspecialchars($_SESSION['customer'] ? $customerrow['name'] : 'No Customer') ?></h1>
           <hr class="my-2">
           <div class="flex md:w-1/2 p-1 justify-between">
               <a class="rounded p-1 border border-2 border-yellow-500 bg-yellow-500/20 text-sm text-white hover:text-yellow-500 font-bold shadow shadow-yellow-500" href="getitem"> <i class="bi bi-cart-plus"></i> Add Item</a>
            <a class="rounded p-1 border border-2 border-green-500 bg-green-500/20 text-sm text-white hover:bg-green-500 font-bold shadow shadow-green-500" href="getitem"> <i class="bi bi-cart-check"></i> Submit Cart</a>
           
              
                  
               </div>
           </div>
        </div>

        <div class="table-responsive  w-full overflow-y-auto my-2 h-[90%] flex-column md:flex">
            <table class=" w-full md:w-full border-collapse [&_td]:p-1 md:[&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm sticky top-0"><tr>
                    <th>#</th>
                    <th class="">Item</th>
                    <th>Quantity</th>
                    <th class="hidden md:block">Price</th>
                    <th>Total Price</th>
                    <th>Option</th>

                </tr></thead>
                <tbody>
                            <?php
                    $no = 0;
                    $business = $shop;
                    $total = 0;
                    $select = $conn->prepare(
                        "SELECT ro.req_ord_id, ro.req_item, ro.req_quantity, ro.price, i.item_name, i.quantity AS stock " .
                        "FROM request_orders ro JOIN item i ON ro.req_item = i.id " .
                        "WHERE ro.shop = ? AND ro.customer = ? AND ro.allowed_quantity = 0"
                    );
                    $select->bind_param("ii", $business, $customer);
                    $select->execute();

                    $result = $select->get_result();
                    if ($result->num_rows > 0) {
                        while ($a = $result->fetch_assoc()) {
                            $no++;
                            $total += $a['price'] * $a['req_quantity'];
                            ?>
                        <tr class="border hover:bg-gray-200">
                            <td><?php echo $no ?></td>
                            <td><?php echo htmlspecialchars($a['item_name']) ?></td>
                            <td><?php echo htmlspecialchars($a['req_quantity']) ?></td>
                            <td class="hidden md:block"><?php echo htmlspecialchars($a['price']) ?></td>
                            <td><?php echo htmlspecialchars($a['price'] * $a['req_quantity']) ?></td>
                            <td class="flex justify-between">
                                <button class="text-red-500 px-2 rounded p-1 text-sm" name="delete" value="<?php echo $a['req_ord_id'] ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                        }

                        ?>
                         <tr class=" p-1 [&_td]:bg-white [&_th]:bg-yellow-900 [&_th]:text-sm [&_th]:text-white border border-2 border-yellow-900 h-[40px] p-0 [&_th]:p-0 [&_td]:p-0">
                  
                  <th>Total</th><td><?php echo $total ?></td>
               
            </tr>
                        <?php
                    } else {
                        ?>
                        <tr class="py-4 h-[300px]"><td colspan="6" class="text-center py-2 text-2xl text-gray-500"><i class="bi bi-list-ol"></i> No Request Selected</td></tr>
                        <?php
                    }
                  ?>
                  
                 
                  
                </tbody>
            </table>
                  
        </div>
        <!---------------------------------------mesaagr---------------------------------------------------->
        

      </form>
    </div>

</body>

</html>
