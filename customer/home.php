<?php
include("../pages/connection.php");
$shop = $_SESSION['shop'] ?? 0;
$customer = $_GET['customer'] ?? 0;

//select customer info...........................................................

$selectcustomer=$conn->prepare("SELECT * FROM customer where c_id=? and business=?");
$selectcustomer->bind_param("ii",$customer,$shop);
$selectcustomer->execute();
$customerresult=$selectcustomer->get_result();
$customerrow=$customerresult->fetch_assoc();

//select saless.....................................................................................................

$selectsales=$conn->prepare("SELECT customer,sale_id,business,products,ammount,date(salles_date) as date,discount,debit FROM salles where customer=? and business=? order by date desc");
$selectsales->bind_param("ii",$customer,$shop);
$selectsales->execute();
$salesresult=$selectsales->get_result();

//cilclate the total debit..................................................
$selectdebit=$conn->prepare("SELECT SUM(debit) as totaldebit from salles where customer=? and business=?");
$selectdebit->bind_param("ii",$customer,$shop);
$selectdebit->execute();
$debitresult=$selectdebit->get_result();
$debitrow=$debitresult->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid h-screen w-full p-1 bg-yellow-900">
        <div class="container bg-white w-full p-1 h-[100%] over">
            <div class="top w-full p-1 bg-yellow-900 flex-column md:flex">
                <div class="left w-full md:w-1/2 p-1"><h1 class="text-sm text-white"> <i class="bi bi-person"></i> <?php echo htmlspecialchars($customerrow['name']) ?></h1></div>
                <hr class="text-white bg-white my-2">
                <div class="right w-full md:w-1/2 p-1 flex justify-between px-2"><a class="bg-green-500/30 text-white borderd border-2 border-green-500 shadow shadow-green-500 text-sm font-bold p-1 rounded" href="ordering?customer=<?php echo $customer ?>"><i class="bi bi-cart"></i> New Cart</a> <div class="debit bg-red-500 text-sm text-white p-1 rounded font-bold">Debit: <span class="price"><?php echo htmlspecialchars($debitrow['totaldebit']) ?></span></div> </div>
            </div>
            <div class="sales w-full  p-1 my-2">
                <div class="flex p-1 my-2 text-yellow-800 font-bold overflow-y-auto"><h1 >Last Sales</h1></div>
                <div class="table-responsive w-full">
                    <table class="w-full text-sm [&_th]:p-1 [&_th]:text-left [&_td]:p-2 ">
                        <thead class="">
                            <tr class="bg-yellow-900 text-white">
                                <th>#</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Ammount</th>
                                <th class="hidden md:block">Discount</th>
                                <th>Debit</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($salesresult->num_rows >0):?>
                            <?php
                            $no=0;
                            while ($a = $salesresult->fetch_assoc()) {
                                $no++;
                                ?>
                                
                                <tr class="border hover:bg-gray-200">
                                <td><?php echo $no ?></td>
                                <td><?php echo htmlspecialchars($a['date']) ?></td>
                                <td><?php echo htmlspecialchars($a['products']) ?></td>
                                <td class="price"><?php echo htmlspecialchars($a['ammount']) ?></td>
                                <td class="hidden md:block price"><?php echo htmlspecialchars($a['discount']) ?></td>
                                <td class="price"><?php echo htmlspecialchars($a['debit']) ?></td>
                                <td><a href="saleview?sale=<?php echo htmlspecialchars($a['sale_id']) ?>" class="text-blue-500 hover:text-blue-700 font-bold">View</a></td>
                                </tr>
                                
                                <?php
                                
                            }
                            
                            ?>
                            <?php else :?>
                               <tr class=""><td colspan="8" class=" text-xl text-gray-500 font-bold text-center">No Lats Sales Exist</td></tr>
                            <?php endif ?>
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