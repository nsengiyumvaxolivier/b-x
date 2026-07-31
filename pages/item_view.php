<?php
include("connection.php");
$business=$_SESSION['user'];
$itemid = $_GET['id'];
//select Item...................................................................
$selectitem=$conn->prepare("SELECT * FROM item where id=? and business=?");
$selectitem->bind_param("ii",$itemid,$business);
$selectitem->execute();
$iteresult=$selectitem->get_result();
$itemrow=$iteresult->fetch_assoc();
//get the item supplier.........
$supplier=$itemrow['item_supliyer'];
//select Supplier.................................................................
$selectsupplier=$conn->prepare("SELECT * FROM supplier where sp_id=? and business=?");
$selectsupplier->bind_param("ii",$supplier,$business);
$selectsupplier->execute();
$supplierresult=$selectsupplier->get_result();
$supplierrow=$supplierresult->fetch_assoc();

//select Last Transctions............................
// select Last Sale.............................
$selectlastsale=$conn->prepare("SELECT MAX(ordered_at) as last_sale from salles_item where product=? and business=?");
$selectlastsale->bind_param("ii",$itemid,$business);
$selectlastsale->execute();
$lastsaleresult=$selectlastsale->get_result();
$lastsalerow=$lastsaleresult->fetch_assoc();

// select Last Purchase.............................
$selectlastpurchase=$conn->prepare("SELECT MAX(created_at) as last_purchase from purchase_items where item=? and business=?");
$selectlastpurchase->bind_param("ii",$itemid,$business);
$selectlastpurchase->execute();
$lastpurchaseresult=$selectlastpurchase->get_result();
$lastpurchaserow=$lastpurchaseresult->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <div class="conatiner-fluid w-full h-[fit-content] md:h-[100%] bg-white">
        <div class="top p-1 w-full flex-column  md:flex gap-2 bg-yellow-900 md:h-[7%]">
            <div class="left w-full p-1 font-bold text-white text-sm"><i class="bi bi-box"></i><?php echo htmlspecialchars(" ".$itemrow['item_name']) ?></div>
            <div class="right flex w-full p-1 justify-between">
               
                <a href="edit_item?item=<?php echo $itemid?>" class="p-1 rounded font-bold text-sm bg-blue-300">Update</a>
                 <button class="p-1 rounded font-bold text-sm bg-red-300" onclick="gotodelete('<?= $itemid ?>')">Delete</button>

            </div>
            
        </div>
      <div class="body my-2 w-full flex-column md:flex p-2 gap-1 md:h-[93%]">
        <div class="left w-fyull md:w-[40%]">
            <h1 class="w-full bg-yellow-900 text-white text-sm p-1 font-bold"><i class="bi bi-info-circle-fill"></i> Item Info</h1>
            <p class="text-sm my-2"><label for="" class="font-bold">Item Name:</label> <?php echo htmlspecialchars($itemrow['item_name']) ?> </p>
            <p class="text-sm my-2"><label for="" class="font-bold">Registed At: </label><?php echo htmlspecialchars($itemrow['reg_date']) ?></p>
            <p class="text-sm my-2"><label for="" class="font-bold">Suplier: </label> <?= $supplierresult->num_rows >0 ? htmlspecialchars($supplierrow['name']) :"  ----" ?></p>
            <h1 class="w-full p-2 font-bold text-sm text-center text-yellow-800">Current Pricies</h1>
            <hr>
            <div class="flex-column md:flex w-full justify-between">
             <p class="text-sm my-2 w-full tex-left"><label for="" class="font-bold">In: </label> <span id="price"><?php echo htmlspecialchars($itemrow['in_price']) ?></span></p>
             <p class="text-sm my-2 w-full tex-left"><label for="" class="font-bold">Out: </label> <span id="price"><?php echo htmlspecialchars($itemrow['out_price']) ?></span></p>
              <p class="text-sm my-2 w-full tex-left"><label for="" class="font-bold">Profit: </label> <span id="price"><?php echo htmlspecialchars($itemrow['out_price']-$itemrow['in_price']) ?></span></p>
            </div>
            <h1 class="w-full p-2 font-bold text-sm text-left text-yellow-800">Current Stock</h1>
            <hr>
             <p class="text-sm my-2"><label for="" class="font-bold">Stok: </label><?php echo htmlspecialchars($itemrow['quantity']) ?></p>
<h1 class="w-full p-2 font-bold text-sm text-left text-yellow-800">Net Package</h1>
            <hr>

 <p class="text-sm my-2"><label for="" class="font-bold">1 Pachage</label> <i class="bi bi-arrow-right"></i>
  <?= $itemrow['pcs'] >1 ? htmlspecialchars($itemrow['pcs']." Itmes") : htmlspecialchars($itemrow['pcs']." Item") ?></p>

  <h1 class="w-full p-2 font-bold text-sm text-center text-yellow-800">Last Transctions</h1>
            <hr>
            <div class="flex-column md:flex w-full justify-between">
            <p class="text-sm my-2 w-full tex-left"><label for="" class="font-bold">Last In: </label> <span><?php echo htmlspecialchars($lastpurchaserow['last_purchase']); ?></span></p>
             <p class="text-sm my-2 w-full tex-left"><label for="" class="font-bold">Last Out: </label> <span><?php echo htmlspecialchars($lastsalerow['last_sale']); ?></span></p>
             
            </div>
        </div>

        <div class="right w-full bg-gray-200 h-[98%]">
               <h1 class="w-full bg-yellow-900 text-white text-sm p-1  h-[5%] font-bold"> <i class="bi bi-clock-fill"></i> Item History</h1>
               <div class="cards w-[100%] md:h-[95%] overflow-y-auto overflow-x-none">
             

<?php
$selectreport=$conn->prepare("SELECT date from (SELECT date(created_at) as date from purchase_items where item=? and business=? union all select date(ordered_at) as date from salles_item where product=? and business=?) t group by date desc");
$selectreport->bind_param("iiii",$itemid,$business,$itemid,$business);
$selectreport->execute();
$reportresult=$selectreport->get_result();

while ($a=$reportresult->fetch_assoc()) {
    $date=$a['date'] ;
    //select Salles Per Date............................................
    $selectsalles=$conn->prepare("SELECT time(ordered_at) as time,ord_quantity,price FROM salles_item where product=? and business=? and date(ordered_at) =? order by time desc");
    $selectsalles->bind_param("iis",$itemid,$business,$date);
    $selectsalles->execute();
    $selectsallesresult=$selectsalles->get_result();

    //select Purchase Per Date.........................................................

    $selectpurchase=$conn->prepare("SELECT TIME(created_at) as time,quantity,in_Price from purchase_items where item=? and business=? and date(created_at)=? order by time desc");
    $selectpurchase->bind_param("iis",$itemid,$business,$date);
    $selectpurchase->execute();
    $selectpurchaseresult=$selectpurchase->get_result();
    
    ?>
    <div class="card w-[98%] m-auto p-2 bg-white my-2 rounded">
        <h1 class="w-full font-bold text-yellow-800 text-sm text-center"><i class="bi bi-calendar-fill"></i> <?php echo $a['date']; ?> </h1>
        <hr>
        <table class=" w-full">
            <tr class="text-sm text-green-600"><th colspan="3">Salles</th></tr>
            <tr class="text-sm text-green-500 bg-gray-200 [&_th]:text-left"><th>Time</th><th>Quantity</th> <th>Price</th></tr>
            <?php
            
           
            
            ?>
            <?php 
            if($selectsallesresult->num_rows >0){
            while ($sales =$selectsallesresult->fetch_assoc()) {
               
            ?>
             
            
               
                    <tr class="text-sm [&_td]:p-1">
                     <td><?php echo htmlspecialchars($sales['time'])?></td>
                <td><?php echo htmlspecialchars($sales['ord_quantity'])?></td>
                <td id="price"><?php echo htmlspecialchars($sales['price'])?></td>
             </tr>
               

                    <?php
                
               
            }
            }
            else{
                ?>

                <tr class="h-[80px]"><td class="text-center text-2xl text-gray-500" colspan="3">No Sales</td> </tr>
                <?php

            }
            
            
            ?>
            <tr class="text-sm text-blue-600 p-3"><th colspan="3">Purchases</th></tr>
             <tr class="text-sm text-blue-500 bg-gray-200 [&_th]:text-left"><th>Time</th><th>Quantity</th> <th>Price</th></tr>
            <?php
              if($selectpurchaseresult->num_rows >0){
            while ($purchase =$selectpurchaseresult->fetch_assoc()) {
               
            ?>
             
            
               
                    <tr class="text-sm [&_td]:p-1">
                     <td><?php echo htmlspecialchars($purchase['time'])?></td>
                <td><?php echo htmlspecialchars($purchase['quantity'])?></td>
                <td id="price"><?php echo htmlspecialchars($purchase['in_Price'])?></td>
             </tr>
               

                    <?php
                
               
            }
              }
              else{
                ?>
<tr class="h-[80px]"><td class="text-center text-2xl text-gray-500" colspan="3">No Purchase</td> </tr>
                <?php
              }
            
            
            ?>
        </table>
    </div>


    <?php
}

?>

       </div>
        </div>
        </div>
    </div>
</body>
</html>
<script>
    document.querySelectorAll("#price").forEach(e=>{
        var numbers=Number(e.textContent);
        e.textContent=numbers.toLocaleString();
    })
    //delete button...........................................
    function gotodelete(itemid){
        var choise = confirm("Are Your Sure You Want To Delete This Item ?");
        if (choise==true) {
            $.ajax({
                url:"./apis/deleteitem.php",
                type:"Post",
                dataType:"json",
                data:{item:itemid},
                success:function(response){
                           alert(response);
                           window.location="item";
                }
            })
        }
        else{
            alert("Item Not Deleted ");
            return false;
        }
    }
</script>