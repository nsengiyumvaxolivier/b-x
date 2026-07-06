<?php
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid h-[100%]">
        <div class="flex w-full p-2 bg-yellow-900 justify-between"><h1 class="text-white font-bold text-sm p-1"><i class="bi bi-tags"></i> Purchase List</h1> <a href="add_purchase" class="font-bold text-white p-1 border border-2 hover:bg-blue-500 hover:text-white border-blue-500 shadow shadow-blue-500 bg-blue-500/30 rounded text-sm"> <i class="bi bi-plus-circle"></i> New Purchase</a></div>
        <div class="table-responsive w-full overflow-y-auto my-2">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm"><tr>
                    <th>#</th>
                    <th class="">Supplier</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th class="text-right">View</th>

                </tr></thead>
                <tbody>
                    <?php
                    $no=0;
                    $business= $_SESSION['user'];
                    $select = $conn->prepare("SELECT * FROM supplier,purchases where supplier.business=? and purchases.business=? and supplier.sp_id=purchases.supplier order by purchases.created_at desc");
                    $select->bind_param("ii",$business,$business);
                    $select->execute();

                    $result=$select->get_result();
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        ?>
                        
                        <tr class="border hover:bg-gray-200">
                            
                              <td>
                            <span class=""><?php echo $no ?></span>
                           
                            </td> 
                             
                            
                            <td>
                        <p><?php echo $a['name'] ?></p>
                        <hr>
                        <p class="text-[10px] text-blue-500"><?php echo htmlspecialchars($a['created_at'])?></p>
                        </td>
                            <td><?php echo $a['items'] ?></td>
                            <td class="price"><?php echo $a['ammount'] ?></td>
                            <td class="text-right "><a href="purchase_view?purchase=<?php echo $a['purchase_id']?>" class="text-white bg-blue-500 rounded p-1 text-sm px-2"><i class="bi bi-eye"></i></a></td>
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