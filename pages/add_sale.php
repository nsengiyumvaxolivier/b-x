<?php
include("connection.php");
//set timezone...............................................................................................
date_default_timezone_set("Africa/kigali");
$timezone=date('Y-m-d h:i:s');

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
           <a class="rounded p-1 border border-blue-500 text-sm text-white hover:bg-blue-500 font-bold shadow shadow-blue-500 bg-blue-500/20" href="get_customer"><i class="bi bi-person"></i> Get Customer</a>
        <a class="rounded p-1 border border-2 border-yellow-500 bg-yellow-500/20 text-sm text-white hover:text-yellow-500 font-bold shadow shadow-yellow-500" href="get_item"> <i class="bi bi-box"></i> Get Item</a>
        <button name="save" href="add_sale" class="font-bold text-white p-1 border border-2 bg-green-500/20 border-green-500 hover:bg-green-500 shadow shadow-green-500 rounded text-sm"><i class="bi bi-check-circle text-white"></i> Approve Sale</button>
    </div> 
        
    </div> 

        <div class="table-responsive  w-full overflow-y-auto my-2 h-[90%]">
            <table class="w-full border-collapse [&_td]:p-1 md:[&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm sticky top-0"><tr>
                    <th>#</th>
                    <th class="">Item</th>
                    <th class=""><span class="md:hidden">Qty</span><span class="hidden md:block">Quantity</span></th>
                   
                    <th class="hidden md:block">Price</th>
                    
                    <th class=""><span class="md:hidden">Dsc</span><span class="hidden md:block">Disacount</span></th>
                   
                    <th> Total price</th>
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
                            <td><?php echo htmlspecialchars($a['item_name']) ?></td>
                            <td><?php echo htmlspecialchars($a['ord_quantity']) ?></td>
                            <td id="price" class="hidden md:block"><?php echo htmlspecialchars($a['price']) ?></td>
                            <td id="price"><?php echo htmlspecialchars($a['discount']) ?></td>
                            <td id="price"><?php echo htmlspecialchars($a['price']*$a['ord_quantity'])?></td>
                            <td class="flex gap-3">
                                
                                <a href="order_edit?order=<?php echo $a['ord_id']?>" class="text-blue-500 hover:text-blue-800 px-2 rounded p-1 text-sm"><i class="bi bi-pencil"></i></a>
                                <button class="text-red-500 font-bold px-2 rounded p-1 text-sm" name="delete" value="<?php echo $a['ord_id'] ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        
                        <?php
                    }
                   ?>
                    <tr class=" p-1 [&_td]:bg-white [&_th]:bg-yellow-900 [&_th]:text-sm [&_th]:text-white border border-2 border-yellow-800 h-[30px] p-0 [&_th]:p-0 [&_td]:p-0">
                  
                  <th>Dsc</th><td colspan="2"><span id="price"><?php  echo $total_dsc ?></span> RWF</td><th>Total</th><td colspan="2"><span id="price"><?php echo $total ?></span> RWF</td>
               
            </tr>
             <tr class=" p-1 [&_td]:bg-white [&_th]:bg-yellow-900 [&_th]:text-sm [&_th]:text-white border border-2 border-yellow-800 h-[30px] p-0 [&_th]:p-0 [&_td]:p-0">
                  
                  <th>Debt</th><td colspan="2" id="price"><span id=""></span></td><th>Paid</th><td colspan="2" class=""> <input type="number" class="w-full p-1 outline-none focus:outline focus:outline-yellow-900" name="paired" id="" value="<?php echo $total ?>"></td>
               
            </tr>
                   
                   <?php

                    }
                    else{
                        ?>
                        
                        <tr class="py-4 h-[300px]"><td colspan="7" class="text-center py-2 text-2xl text-gray-500"><i class="bi bi-list-ol"></i> No Product Selected</td></tr>
                        
                        
                        <?php
                    }
                    

                  ?>
                  
                 
                  
                </tbody>
            </table>
        </div>

      </form>
    </div>
    <script>
         document.querySelectorAll("#price").forEach(e=>{
    var numbers=Number(e.textContent);
    e.textContent=numbers.toLocaleString();
 })
    </script>

</body>

</html>
<?php
if (isset($_POST['save'])) {
    $debt= $total-$_POST['paired'];
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
    $profit = ($price - $a['in_price']) * $quantity;
    //Insert the selected Items intno the salles_item table..................................................................
    $insert=$conn->prepare("INSERT into salles_item(business,product,ord_quantity,status,discount,customer,sale,price,ordered_at,profit) values(?,?,?,?,?,?,?,?,?,?)");
    $insert->bind_param("iididiidsd",$business,$item,$quantity,$status,$dsc,$customer,$sale,$price,$timezone,$profit);
    $insert->execute();
    //Update Stock Quantity of the selected Items........................................................................
    $update_item=$conn->prepare("UPDATE item set quantity = quantity-? where id=?");
    $update_item->bind_param("ii",$quantity,$item);
    $update_item->execute();

   
    
  }
  
 
  $sale_insert=$conn->prepare("INSERT INTO salles(customer,products,business,status,discount,debit,sale,ammount,salles_date) values(?,?,?,?,?,?,?,?,?)");
  $sale_insert->bind_param("iiiiddids",$customer,$no,$business,$status,$total_dsc,$debt,$sale,$total,$timezone);
  
  if ($sale_insert->execute()) {


    unset($_SESSION['customer']);
    unset($_SESSION['customername']);
    
   echo"<script>alert('Sale Approved'),location='add_sale'</script>";}
 
  
  
 
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