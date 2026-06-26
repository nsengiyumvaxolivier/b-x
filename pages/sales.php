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
        <div class="flex w-full p-2 bg-yellow-900 justify-between"><h1 class="text-white font-bold text-sm p-1"><i class="bi bi-tags"></i> Sales List</h1> <a href="add_sale" class="font-bold text-white p-1 border shadow shadow-white rounded text-sm">New Sale</a></div>
        <div class="table-responsive w-full overflow-y-auto my-2">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm"><tr>
                    <th>#</th>
                    <th class="">Customer</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th class="text-right">View</th>

                </tr></thead>
                <tbody>
                    <?php
                    $no=0;
                    $business= $_SESSION['user'];
                    $select = $conn->prepare("SELECT * FROM customer,salles where customer.business=? and salles.business=? and customer.c_id=salles.customer");
                    $select->bind_param("ii",$business,$business);
                    $select->execute();

                    $result=$select->get_result();
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        ?>
                        
                        <tr class="border hover:bg-gray-200">
                            <?php
                            if ($a['status'] ==1) {
                                ?>
                              <td><span class="bg-green-500 p-1 px-2 rounded"><?php echo $no ?></span></td> 
                               <?php
                            }
                            else{
                                ?>
                                <td><span class="bg-orange-500 p-1 px-2 rounded"><?php echo $no ?></span></td> 
                                <?php
                            }

                            ?>
                            
                            <td><?php echo $a['name'] ?></td>
                            <td><?php echo $a['products'] ?></td>
                            <td><?php echo $a['ammount'] ?></td>
                            <td class="text-right "><a href="sale_view?sale=<?php echo $a['sale_id']?>" class="text-white bg-blue-500 rounded p-1 text-sm px-2"><i class="bi bi-eye"></i></a></td>
                        </tr>
                        
                        <?php
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>

       
    </div>

</body>

</html>