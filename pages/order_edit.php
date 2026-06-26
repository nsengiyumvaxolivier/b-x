<?php
include("connection.php");

if (!isset($_SESSION['customer'])) {
    echo "<script>alert('Please select Customer',location='add_sale')</script>";
    exit;
}
$customer = $_SESSION['customer'];
$orderid= $_GET['order'];
$stmt = $conn->prepare("SELECT * FROM orders where ord_id =?");
$stmt->bind_param("i",$orderid);
$stmt->execute();
$result=$stmt->get_result();
$a=$result->fetch_assoc();
$item =$a['product'];
$selectproduct=$conn->prepare("SELECT * FROM item where id =?");
$selectproduct->bind_param("i",$item);
$selectproduct->execute();
$result2=$selectproduct->get_result();
$b=$result2->fetch_assoc();

$business = $_SESSION['user'];




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Quantity</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>

    <div class="container-fluid p-2 w-full h-[100%] flex">

        <div class="conatiner bg-yellow-800 p-2 rounder w-full md:w-1/3 m-auto rounded">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Edit <?php echo htmlspecialchars($b['item_name']) ?></h1>
                <hr class="text-white">
               
                <!--Row Start-->
              
                    
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Current Stock</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            
                             <input type="text" disabled value="<?php echo $b['quantity']?>" name="name" id=""
                            class="w-full rounded p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Selected Quantity</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            
                             <input type="text" disabled value="<?php echo $a['ord_quantity']?>" name="name" id=""
                            class="w-full rounded p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                       <label for="" class="block p-1 text-sm text-white font-bold my-2">New Quantity</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                           
                             <input type="number" required name="quantity" id="" value="<?php echo $a['ord_quantity']?>"
                            class="w-full rounded p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Discount</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                           
                             <input type="number" value="<?php echo $a['discount'] ?>" required name="disacount" id=""
                            class="w-full p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                    
    
                 
                <!--Row End-->
              
                
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-white border font-bold">Save Changes</button>
                </div>

            </form>
        </div>


    </div>
   

</body>

</html>
<?php
if (isset($_POST['save'])) {
    $quantity=$_POST['quantity'];
    $disacount=$_POST['disacount'];
    $price= $b['out_price']-$disacount;
    $status=0;
    $current=$b['quantity'];

    if ($current >= $quantity) {
     $update=$conn->prepare("UPDATE orders set ord_quantity=?,price=?,discount=? where ord_id=?");
    $update->bind_param("dddi",$quantity,$price,$disacount,$orderid);
    if ($update->execute()) {
    echo "<script>alert('item Updated'),location='add_sale'</script>"; 
    }
    }
    else {
         echo "<script>alert('stock is low')</script>"; 
    }

    

}


?>