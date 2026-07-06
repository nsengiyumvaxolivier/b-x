<?php
include("connection.php");

if (!isset($_SESSION['customer'])) {
    echo "<script>alert('Please select Customer',location='add_sale')</script>";
    exit;
}$business = $_SESSION['user'];
$customer = $_SESSION['customer'];
$product = $_GET['product'];

$stmt = $conn->prepare("SELECT * FROM item where id =?");
$stmt->bind_param("i",$product);
$stmt->execute();
$result=$stmt->get_result();
$a=$result->fetch_assoc();
  $status=0;


$checkitem= $conn->prepare("SELECT * FROM orders where product =? and customer=? and business=? and status =?");
$checkitem->bind_param("iiii",$product,$customer,$business,$status);
$checkitem->execute();
$checkresult = $checkitem->get_result();
if ($checkresult->num_rows > 0) {
    echo "<script>alert('Product Already Selected'),location='get_item'</script>";
   
}




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
                <h1 class="text-white font-bold p-2">Enter Quantity</h1>
                <hr class="text-white">
               
                <!--Row Start-->
              
                    
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Current Stock</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            
                             <input type="text" disabled value="<?php echo $a['quantity']?>" name="name" id=""
                            class="w-full rounded p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                       <label for="" class="block p-1 text-sm text-white font-bold my-2">Quantity</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                           
                             <input type="number" required name="quantity" id=""
                            class="w-full rounded p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Discount</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                           
                             <input type="number" value="0" required name="disacount" id=""
                            class="w-full p-1 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                    
    
                 
                <!--Row End-->
              
                
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-green-500 hover:bg-green-500 bg-green-500/30 border-green-500 border border-2 font-bold"> <i class="bi bi-check-circle"></i> Confirm</button>
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
    $price= $a['out_price']-$disacount;
  
    $current=$a['quantity'];

    if ($current >= $quantity) {
     $insert=$conn->prepare("INSERT INTO orders(business,customer,product,ord_quantity,discount,status,price) values (?,?,?,?,?,?,?)");
    $insert->bind_param("iiiddid",$business,$customer,$product,$quantity,$disacount,$status,$price);
    if ($insert->execute()) {
    echo "<script>alert('Product Selected'),location='add_sale'</script>"; 
    }
    }
    else {
         echo "<script>alert('stock is low')</script>"; 
    }

    

}


?>