<?php
include("connection.php");
if (isset($_GET['supplier'])) {
    $supplier = $_GET['supplier'];
    $stmt = $conn->prepare("SELECT * FROM supplier where sp_id =?");
    $stmt->bind_param("i",$supplier);
    $stmt->execute();
    $row=$stmt->get_result();
    $selected_supplier=$row->fetch_assoc();
    $_SESSION['supplier']= $selected_supplier['sp_id'];
    $_SESSION['suppliername']=$selected_supplier['name'];
   
    

}
elseif (!isset($_GET['supplier']) && !isset($_SESSION['supplier'])) {
    $_SESSION['supplier']="";
    $_SESSION['suppliername']="";
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
           <h1 class="text-white font-bold text-sm p-1"><i class="bi bi-person-fill"></i> <?= $_SESSION['supplier'] ? $_SESSION['suppliername'] :'No supplier' ?></h1>
           <div class="flex justify-between md:w-1/2">
           <a class="rounded p-1 border border-blue-500 text-sm text-white hover:text-blue-500 font-bold shadow shadow-blue-500 bg-blue-500/20" href="get_supplier"><i class="bi bi-person"></i> Get supplier</a>
        <a class="rounded p-1 border border-2 border-yellow-500 bg-yellow-500/20 text-sm text-white hover:text-yellow-500 font-bold shadow shadow-yellow-500" href="get_purchase_item"> <i class="bi bi-box"></i> Get Item</a>
        <button name="save" href="add_sale" class="font-bold text-white p-1 border border-2 bg-green-500/20 border-green-500 shadow shadow-green-500 rounded text-sm"><i class="bi bi-check text-green-500"></i> Save</button>
    </div> 
        
    </div> 

        <div class="table-responsive  w-full overflow-y-auto my-2 h-[90%]">
            <table class="w-full border-collapse [&_td]:p-1 md:[&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm sticky top-0"><tr>
                    <th>#</th>
                    <th class="">Item</th>
                    <th>Quantity</th>
                    <th>In Price</th>
                    <th>Out Price</th>
                    <th>Total Price</th>
                    <th>Option</th>

                </tr></thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['supplier'])) {
                       $supplier=$_SESSION['supplier'];
                     
                    }
                    $no=0;
                    $business= $_SESSION['user'];
                    $status=0; 
                    $total=0;
                    $total_dsc=0;
                    $select = $conn->prepare("SELECT * FROM purchase_orders,item where purchase_orders.item = item.id and purchase_orders.business= ? and item.business = ? and purchase_orders.status=? and purchase_orders.supplier =? and purchase_orders.business = item.business ");
                    $select->bind_param("iiii",$business,$business,$status,$supplier);
                    $select->execute();

                    $result=$select->get_result();
                    if ($result->num_rows >0) {
                       
                    
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        $total+=$a['pin_Price']*$a['p_quantity'];
                      
                       
                        ?>
                        
                        <tr class="border hover:bg-gray-200">
                            <td><?php echo $no ?></td>
                            <td><?php echo $a['item_name'] ?></td>
                            <td><?php echo $a['p_quantity'] ?></td>
                            <td class="total"><?php echo $a['pin_Price'] ?></td>
                            <td class="total"><?php echo $a['pout_price'] ?></td>
                            <td class="total"><?php echo $a['pin_Price']*$a['p_quantity']?></td>
                            <td class="flex justify-between">
                                
                                <a href="edit_purchase_order?porder=<?php echo $a['pord_id']?>" class="text-white bg-blue-500 px-2 rounded p-1 text-sm"><i class="bi bi-pencil"></i></a>
                                <button class="text-white bg-red-500 px-2 rounded p-1 text-sm" name="delete" value="<?php echo $a['pord_id'] ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        
                        <?php
                    }
                    }
                    else{
                        ?>
                        
                        <tr class="py-4 h-[300px]"><td colspan="7" class="text-center py-2 text-2xl text-gray-500"><i class="bi bi-list-ol"></i> No Item Selected</td></tr>
                        
                        
                        <?php
                    }
                    

                  ?>
                  
                  <tr class=" p-1 [&_td]:bg-white [&_th]:bg-yellow-900 [&_th]:text-sm [&_th]:text-white border border-2 border-yellow-900 h-[40px] p-0 [&_th]:p-0 [&_td]:p-0">
                  
                  <th>Total</th><td colspan="6" class="total"><?php echo $total ?></td>
               
            </tr>
                  
                </tbody>
            </table>
        </div>

      </form>
    </div>

</body>

</html>

<script>

  document.querySelectorAll(".total").forEach(
    e=>{
        var numbers = Number(e.textContent);
        e.textContent=numbers.toLocaleString();
    }
  )
</script>
<?php
//save the purchase list............................................................................
if (isset($_POST['save'])) {
   $business= $_SESSION['user'];
    $status_true=1;

//select the cureent pruchase.................................................................................................
  $select_purchase= $conn->prepare("SELECT COUNT(purchase_id) as current from purchases");
  $select_purchase->execute();
  $purchase_result=$select_purchase->get_result();
  $row=$purchase_result->fetch_assoc();
  $purchase=$row['current']+1;

 
//select the All select purchase Item from purchase Orders...........................................
  $select = $conn->prepare("SELECT * FROM purchase_orders,item where purchase_orders.item = item.id and purchase_orders.business= ? and item.business = ? and purchase_orders.status=? and purchase_orders.supplier =? and purchase_orders.business = item.business ");
  $select->bind_param("iiii",$business,$business,$status,$supplier);
  $select->execute();
  $result=$select->get_result();
  while ($a= $result->fetch_assoc()) {
    $pord=$a['pord_id'];
    $update=$conn->prepare("UPDATE purchase_orders set status =? where pord_id=? ");
    $update->bind_param("ii",$status_true,$pord);
    $update->execute();
    $item=$a['id'];
    $in_price= $a['pin_Price'];
    $out_price= $a['pout_price'];
    $quantity = $a['p_quantity'];
    $expiry=$a['expiry_date'];
    $insert=$conn->prepare("INSERT into purchase_items(business,item,quantity,status,supplier,purchase,in_price,out_price,expiry_date) values(?,?,?,?,?,?,?,?,?)");
    $insert->bind_param("iidiiidds",$business,$item,$quantity,$status,$supplier,$purchase,$in_price,$out_price,$expiry);
    $insert->execute();

   
    
  }
  $purchase_insert=$conn->prepare("INSERT INTO purchases(supplier,items,business,status,purchase,ammount) values(?,?,?,?,?,?)");
  $purchase_insert->bind_param("iiiiid",$supplier,$no,$business,$status,$purchase,$total);
  
  if ($purchase_insert->execute()) {
    unset($_SESSION['supplier']);
    unset($_SESSION['suppliername']);
    
   echo"<script>alert('List Save'),location='add_purchase'</script>";}
 
  
  
 
}
if (isset($_POST['delete'])) {
    $productd = $_POST['delete'];
    $delete =$conn->prepare("DELETE FROM purchase_orders where pord_id=?");
    $delete->bind_param("i",$productd);
    if ($delete->execute()) {
       echo"<script>alert('Item Deleted'),location='add_purchase'</script>";
    }
}
?>