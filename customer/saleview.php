<?php
include("../pages/connection.php");
$shop=$_SESSION['shop'];
$sale=$_GET['sale'];
//se;lect sale info..........................................................................................
$selectsale=$conn->prepare("SELECT * FROM salles where sale_id=? and business=?");
$selectsale->bind_param("ii",$sale,$shop);
$selectsale->execute();
$saleresult=$selectsale->get_result();
$salerow=$saleresult->fetch_assoc();
//fet customer..............................................................................................
$customerid=$salerow['customer'];
$selectcustomer=$conn->prepare("SELECT * FROM customer where c_id=?");
$selectcustomer->bind_param("i",$customerid);
$selectcustomer->execute();
$customerresult=$selectcustomer->get_result();
$customerrow=$customerresult->fetch_assoc();

//select the items and its sales information....................................................
$selectitem=$conn->prepare("SELECT * FROM item,salles_item where item.id=salles_item.product and salles_item.sale=?");
$selectitem->bind_param("i",$sale);
$selectitem->execute();
$itemresult=$selectitem->get_result();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sale view</title>
</head>
<body>
    <div class="container-fluid bg-gray-100/30 h-screen w-full p-1">
        <div class="container flex w-[98%] m-auto h-[100%] ovrflow-y-auto">
            <div class="card border bg-white p-1 m-auto w-full md:w-1/2 shadow shadow-lg transition-all duration-300 scale-101 rounded">
                <div class="top w-full text-bold text-sm">
                    <div class="flex justify-between px-2 my-2">
                        <h1><i class="bi bi-person"></i> <?php echo htmlspecialchars($customerrow['name']) ?> </h1>
                        <p><label for="">At:</label> <?php echo htmlspecialchars($salerow['salles_date']) ?></p>
                     </div>
                     <div class="flex justify-between px-2 my-2">
                        <p>Ammount: <span class="price"><?php echo htmlspecialchars($salerow['ammount']) ?></span></p>
                        <p>Discount: <span class="price"><?php echo htmlspecialchars($salerow['discount']) ?></span></p>
                     </div>
                     <div class="flex justify-between px-2 my-2">
                        <p>Debit: <span class="price"><?php echo htmlspecialchars($salerow['debit']) ?></span></p>
                        <p>Items: <span><?php echo htmlspecialchars($salerow['products']) ?></span></p>
                     </div>
                    
                </div>
                <h1 class="w-full text-center my-2 p-1 font-bold text-yellow-800">Item List</h1>
                <div class="table-responsive w-full my-2 py-3">
                    <table class="w-full text-sm [&_th]:text-left [&_th]:p-1 [&_td]:p-2">
                       <thead>
                        <tr class="bg-yellow-900 text-white" >
                            <th>#</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Dsc</th>
                            <th>total</th>
                        </tr>
                       </thead>
                       <tbody>
                        <?php
                        $no=0;
                        while ($a =$itemresult->fetch_assoc()) {
                          $no++;
                          ?>
                          <tr class="border border-b-2">
                            <td><?php echo $no ?></td>
                            <td><?php echo htmlspecialchars($a['item_name']) ?></td>
                            <td><?php echo htmlspecialchars($a['ord_quantity']) ?></td>
                            <td class="price"><?php echo htmlspecialchars($a['price']) ?></td>
                            <td class="price"><?php echo htmlspecialchars($a['discount']) ?></td>
                            <td class="price"><?php echo htmlspecialchars($a['ord_quantity']*$a['price']) ?></td>
                          </tr>
                          
                          
                          <?php
                        }
                        
                        ?>
                       </tbody>

                    </table>
                </div>
                

            </div>
        </div>
    </div>
</body>
</html>
<script>
    document.querySelectorAll(".price").forEach(e=>{
        var numbers=Number(e.textContent);
        e.textContent=numbers.toLocaleString();
    })
</script>