<?php
include("connection.php");

if (! isset($_SESSION['supplier']) or $_SESSION['supplier'] == "") {
    echo"<script>alert('please select Supplier'),location='add_purchase'</script>";
    exit;
}

$supplier=$_SESSION['supplier'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid h-[100%]">
        <div class="flex w-full p-2 bg-yellow-900 justify-between"><h1 class="text-white font-bold text-sm p-1"><i class="bi bi-box"></i> Get Item</h1> <a href="add_product" class="font-bold text-white p-1 border shadow shadow-white rounded text-sm">Add Item</a></div>
        <div class="table-responsive w-full overflow-y-auto my-2">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm"><tr>
                    <th>#</th>
                    <th class="">Item</th>
                    <th>Stok</th>
                    <th>Price</th>
                    <th>Get</th>

                </tr></thead>
                <tbody>
                    <?php
                    $no=0;
                    $business= $_SESSION['user'];
                    $select = $conn->prepare("SELECT * FROM item where business= ?");
                    $select->bind_param("i",$business);
                    $select->execute();

                    $result=$select->get_result();
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        ?>
                        
                        <tr class="border hover:bg-gray-200">
                            <td><?php echo $no ?></td>
                            <td><?php echo $a['item_name'] ?></td>
                            <td><?php echo $a['quantity'] ?></td>
                            <td><?php echo $a['in_price'] ?></td>
                            <td><a href="purchase_item?item=<?php echo $a['id']?>" class="text-white bg-green-500 rounded p-1 px-2 text-sm"><i class="bi bi-check"></i></a></td>
                        </tr>
                        
                        <?php
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>

       
    </div>

</body>

</html>