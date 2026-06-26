<?php
include("connection.php");
if (isset($_GET['customer'])) {
    $customer = $_GET['customer'];
    $stmt = $conn->prepare("SELECT * FROM customer where c_id =?");
    $stmt->bind_param("i",$customer);
    $stmt->execute();
    $row=$stmt->get_result();
    $selected_customer=$row->fetch_assoc();
    $_SESSION['customer']= $selected_customer['c_id'];
    $_SESSION['customername']=$selected_customer['name'];
   
    

}
elseif (!isset($_GET['customer']) && !isset($_SESSION['customer'])) {
    $_SESSION['customer']="";
    $_SESSION['customername']="";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid h-[100%]">
         <form action="" class="p-0 h-[100%]" method="post">
        <div class="flex-column md:flex w-full p-2 bg-yellow-900 justify-between">
           <h1 class="text-white font-bold text-sm p-1"><i class="bi bi-person-fill"></i> <?= $_SESSION['customer'] ? $_SESSION['customername'] :'No Customer' ?></h1>
           <div class="flex justify-between md:w-1/2">
           <a class="rounded p-1 border border-blue-500 text-sm text-white hover:text-blue-500 font-bold shadow shadow-blue-500 bg-blue-500/20" href="get_customer"><i class="bi bi-person"></i> Get Customer</a>
        <a class="rounded p-1 border border-2 border-yellow-500 bg-yellow-500/20 text-sm text-white hover:text-yellow-500 font-bold shadow shadow-yellow-500" href="get_item"> <i class="bi bi-box"></i> Get Item</a>
        <button name="save" href="add_sale" class="font-bold text-white p-1 border border-2 bg-green-500/20 border-green-500 shadow shadow-green-500 rounded text-sm"><i class="bi bi-check text-green-500"></i> Save Sale</button>
    </div> 
        
    </div> 

        <div class="table-responsive  w-full overflow-y-auto my-2 h-[90%]">
            <table class="w-full border-collapse [&_td]:p-1 md:[&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm sticky top-0"><tr>
                    <th>#</th>
                    <th class="">Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Disc</th>
                    <th>Total Price</th>
                    <th>Option</th>

                </tr></thead>
                <tbody>
                    <?php
                    if ($_SESSION['customer']) {
                       $customer=$_SESSION['customer'];
                     
                    }-
                    $no=0;
                    $business= $_SESSION['user'];
                    $status=0; 
                    $total=0;
                    $total_dsc=0;
                    $select = $conn->prepare("SELECT * FROM orders,item where orders.product = item.id and orders.business= ? and item.business = ? and orders.status=? and orders.customer =? and orders.business = item.business ");
                    $select->bind_param("iiii",$business,$business,$status,$customer);
                    $select->execute();

                    $result=$select->get_result();
                    if ($result->num_rows >0) {
                       
                    
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        $total+=$a['price']*$a['ord_quantity'];
                        $total_dsc+=$a['discount']*$a['ord_quantity'];
                       
                        ?>
                        
                        <tr class="border hover:bg-gray-200">
                            <td><?php echo $no ?></td>
                            <td><?php echo $a['item_name'] ?></td>
                            <td><?php echo $a['ord_quantity'] ?></td>
                            <td><?php echo $a['price'] ?></td>
                            <td><?php echo $a['discount'] ?></td>
                            <td><?php echo $a['price']*$a['ord_quantity']?></td>
                            <td class="flex justify-between">
                                
                                <a href="order_edit?order=<?php echo $a['ord_id']?>" class="text-white bg-blue-500 px-2 rounded p-1 text-sm"><i class="bi bi-pencil"></i></a>
                                <button class="text-white bg-red-500 px-2 rounded p-1 text-sm" name="delete" value="<?php echo $a['ord_id'] ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        
                        <?php
                    }
                    }
                    else{
                        ?>
                        
                        <tr class="py-4 h-[300px]"><td colspan="7" class="text-center py-2 text-2xl text-gray-500"><i class="bi bi-list-ol"></i> No Product Selected</td></tr>
                        
                        
                        <?php
                    }
                    

                  ?>
                  
                  <tr class=" p-1 [&_td]:bg-white [&_th]:bg-yellow-900 [&_th]:text-sm [&_th]:text-white border border-2 border-yellow-900 h-[40px] p-0 [&_th]:p-0 [&_td]:p-0">
                  
                  <th>Total</th><td><?php echo $total ?></td><th>Dsc</th><td><?php  echo $total_dsc ?></td><th>Paird</th><td><input type="number" name="p" value="<?php echo $total ?>" id="" class="ouline-0 focus:outline-2 border border-gray-300 border-2 rounded focus:outline-blue-500  p-1"></td><td>h</td>
               
            </tr>
                  
                </tbody>
            </table>
        </div>

      </form>
    </div>

</body>

</html>
<?php
if (isset($_POST['save'])) {
    $debit= $total-$_POST['p'];
    $status_true=1;

  $select_sale= $conn->prepare("SELECT COUNT(sale_id) as current from salles");
  $select_sale->execute();
  $sale_result=$select_sale->get_result();
  $row=$sale_result->fetch_assoc();
  $sale=$row['current']+1;
  $business= $_SESSION['user'];
  $select = $conn->prepare("SELECT * FROM orders,item where orders.product = item.id and orders.business= ? and item.business = ? and orders.status=? and orders.customer =? and orders.business = item.business ");
  $select->bind_param("iiii",$business,$business,$status,$customer);
  $select->execute();
  $result=$select->get_result();
  while ($a= $result->fetch_assoc()) {
    $ord=$a['ord_id'];
    $update=$conn->prepare("UPDATE orders set status =? where ord_id=? ");
    $update->bind_param("ii",$status_true,$ord);
    $update->execute();
    $item=$a['id'];
    $totel_price= $a['price']*$a['ord_quantity'];
    $quantity = $a['ord_quantity'];
    $dsc = $a['discount'];
    $price=$a['price'];
    $insert=$conn->prepare("INSERT into salles_item(business,product,ord_quantity,status,discount,customer,sale,price) values(?,?,?,?,?,?,?,?)");
    $insert->bind_param("iididiid",$business,$item,$quantity,$status,$dsc,$customer,$sale,$price);
    $insert->execute();

   
    
  }
  $sale_insert=$conn->prepare("INSERT INTO salles(customer,products,business,status,discount,debit,sale,ammount) values(?,?,?,?,?,?,?,?)");
  $sale_insert->bind_param("iiiiddid",$customer,$no,$business,$status,$total_dsc,$debit,$sale,$total);
  
  if ($sale_insert->execute()) {
    unset($_SESSION['customer']);
    unset($_SESSION['customername']);
    
   echo"<script>alert('List Save'),location='add_sale'</script>";}
 
  
  
 
}
if (isset($_POST['delete'])) {
    $productd = $_POST['delete'];
    $delete =$conn->prepare("DELETE FROM orders where ord_id=?");
    $delete->bind_param("i",$productd);
    if ($delete->execute()) {
       echo"<script>alert('Item Deleted'),location='add_sale'</script>";
    }
}
?>