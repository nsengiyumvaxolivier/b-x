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
        <div class="flex w-full p-2 bg-yellow-900 justify-between h-[8%]"><h1 class="text-white font-bold text-sm p-1"><i class="bi bi-tags"></i> Sales List</h1> <a href="add_sale" class="font-bold text-white p-2 md:p-1 border border-green-500 shadow shadow-green-500 rounded text-sm bg-green-500/30"><i class="bi bi-plus-circle"></i> New Sale</a></div>
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
                    $select = $conn->prepare("SELECT * FROM customer,salles where customer.business=? and salles.business=? and customer.c_id=salles.customer order by salles_date desc");
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
                            <p class="text-[10px] text-green-500 p-0"><?php echo $a['salles_date'] ?></p>
                            
                        </td>
                            <td><?php echo $a['products'] ?></td>
                          
                            <td>
                            <p class="price"><?php echo $a['ammount'] ?></p>
                            <hr>
                            <p class="text-[10px] text-red-500 p-0"> ~<span class="price"><?php echo $a['debit'] ?></span> </p>
                            
                        </td>
                            <td class=""><a href="sale_view?sale=<?php echo $a['sale_id']?>" class="text-white bg-green-500 rounded p-1 text-sm px-2"><i class="bi bi-eye"></i></a></td>
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