<?php
include("connection.php");
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
        <div class="flex w-full p-2 bg-yellow-900 justify-between h-[8%]"><h1 class="text-white font-bold text-sm p-1"><i class="bi bi-tags"></i> Pending Sales</h1> <a href="add_sale" class="font-bold text-white p-2 md:p-1 border border-green-500 shadow shadow-green-500 rounded text-sm bg-green-500/30"><i class="bi bi-plus-circle"></i> New Sale</a></div>
        <div class="table-responsive w-full overflow-y-auto my-2 h-[92%]">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm stiky"><tr>
                    <th>#</th>
                    <th class="">Customer</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th class="text-right">View</th>

                </tr></thead>
                <tbody class="overflow-y-auto">
                    <?php
                    $no=0;
                    $business= $_SESSION['user'];
                    $select = $conn->prepare("SELECT customer.name, customer.c_id,min(orders.ordered_at) as ordered_at FROM customer, orders WHERE customer.business=? AND orders.business=? AND customer.c_id=orders.customer AND orders.status=0  group by customer.c_id order by ordered_at desc");
                    $select->bind_param("ii",$business,$business);
                    $select->execute();

                    $result=$select->get_result();
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        ?>
                        
                        <tr class="border hover:bg-gray-200 rounded my-1">
                           
                              <td><span class=""><?php echo $no ?></span></td> 
                            
                            
                            <td>
                            <p class=""><?php echo $a['name'] ?></p>
                            <hr>
                            <p class="text-[12px] text-yellow-800 p-0 font-bold"><?php echo $a['ordered_at'] ?></p>
                            
                        </td>
                            <td>
                                
                            <?php 
                            
                            $selectitems = $conn->prepare("SELECT count(*) as total from orders where business=? and customer=? and status=0");
                            $selectitems->bind_param("ii",$business,$a['c_id']);
                            $selectitems->execute();
                            $items_result = $selectitems->get_result();
                            $items = $items_result->fetch_assoc();
                            echo htmlspecialchars($items['total']);
                            ?>
                        
                        </td>
                          
                            <td class="price">
                            <?php
                            
                            $selectamount = $conn->prepare("SELECT sum(price * ord_quantity) as amount from orders where business=? and customer=? and status=0");
                            $selectamount->bind_param("ii",$business,$a['c_id']);
                            $selectamount->execute();
                            $amount_result = $selectamount->get_result();
                            $amount = $amount_result->fetch_assoc();
                            echo htmlspecialchars($amount['amount']);
                            ?>
                            
                            
                            
                        </td>
                            <td class=""><a href="add_sale?customer=<?php echo $a['c_id']?>" class="text-white bg-green-500 rounded p-1 text-sm px-2"><i class="bi bi-eye"></i></a></td>
                        </tr>
                        
                        <?php
                    }
                    
                    ?>
                </tbody>
            </table>
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