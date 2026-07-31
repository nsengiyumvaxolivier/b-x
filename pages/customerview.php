<?php
include("connection.php");
$business=$_SESSION['user'];
$customerid = $_GET['customer'];
//select customer...................................................................
$selectcustomer=$conn->prepare("SELECT * FROM customer where c_id=? and business=?");
$selectcustomer->bind_param("ii",$customerid,$business);
$selectcustomer->execute();
$customerresult=$selectcustomer->get_result();
$customerrow=$customerresult->fetch_assoc();
// select Last Sale.............................
$selectlastsale=$conn->prepare("SELECT MAX(salles_date) as last_sale from salles where customer=? and business=?");
$selectlastsale->bind_param("ii",$customerid,$business);
$selectlastsale->execute();
$lastsaleresult=$selectlastsale->get_result();
$lastsalerow=$lastsaleresult->fetch_assoc();

// select Customer Debt...........................................................................................................
$selectdebt=$conn->prepare("SELECT SUM(debit) as total_debt,count(*) as total_sales from salles where customer=? and business=?");
$selectdebt->bind_param("ii",$customerid,$business);
$selectdebt->execute();
$debtresult=$selectdebt->get_result();
$debtrow=$debtresult->fetch_assoc();

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
            <div class="left w-full p-1 font-bold text-white text-sm"><i class="bi bi-box"></i><?php echo htmlspecialchars(" ".$customerrow['name']) ?></div>
            <div class="right flex w-full p-1 justify-between">
               
                <a href="editcustomer?customer=<?php echo $customerid?>" class="p-1 rounded font-bold text-sm bg-blue-300">Update</a>
                 <button class="p-1 rounded font-bold text-sm bg-red-300" onclick="deletecustomer('<?= $customerid ?>')" type="button">Delete</button>

            </div>
            
        </div>
      <div class="body my-2 w-full flex-column md:flex p-2 gap-1 md:h-[93%]">
        <div class="left w-fyull md:w-[40%]">
            <h1 class="w-full bg-yellow-900 text-white text-sm p-1 font-bold"><i class="bi bi-info-circle-fill"></i> Customer Info</h1>
            <p class="text-sm my-2"><label for="" class="font-bold">Customer Name:</label> <?php echo htmlspecialchars($customerrow['name']) ?> </p>
            <p class="text-sm my-2"><label for="" class="font-bold">Telephone:</label> <?php echo htmlspecialchars($customerrow['phone']) ?> </p>
            <p class="text-sm my-2"><label for="" class="font-bold">Location: </label><?php echo htmlspecialchars($customerrow['location']) ?></p>
            <p class="text-sm my-2"><label for="" class="font-bold">Registed At: </label><?php echo htmlspecialchars($customerrow['created_at']) ?></p>
         
            <h1 class="text-yellow-800 p-1 my-2 font-bold text-center">Customer History</h1>
            <hr>
            <p class="text-sm my-2"><label for="" class="font-bold">Customer Debt:</label> <span id="price" class="text-red-500"><?php echo htmlspecialchars($debtrow['total_debt']) ?></span> RWF  </p>
            <p class="text-sm my-2"><label for="" class="font-bold">Total Sales:</label> <span id="price" class=""><?php echo htmlspecialchars($debtrow['total_sales']) ?></span> </p>
            <p class="text-sm my-2"><label for="" class="font-bold">Last Sales:</label> <?php echo htmlspecialchars($lastsalerow['last_sale']) ?> </p>

            
           </div>
           <div class="right w-full p-1 md:h-[100%] md:overflow-y-auto">
            <h1 class=" text-yellow-800 font-bold ">Customer Sales</h1>
            <div class="table-responsive w-full overflow-y-auto my-2">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm stiky"><tr>
                    <th>#</th>
                    <th class="">Date</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th class="text-right">View</th>

                </tr></thead>
                <tbody class="overflow-y-auto">
                    <?php
                    $no=0;
                   
                    $select = $conn->prepare("SELECT * FROM customer,salles where customer.business=? and salles.business=? and  customer.c_id=salles.customer and salles.customer=? order by salles_date desc");
                    $select->bind_param("iii",$business,$business,$customerid);
                    $select->execute();

                    $result=$select->get_result();
                    while ($a= $result->fetch_assoc()) {
                        $no++;
                        ?>
                        
                        <tr class="border hover:bg-gray-200 rounded my-1">
                           
                              <td><span class=""><?php echo $no ?></span></td> 
                            
                            
                            <td>
                            
                            <p class=" p-0"><?php echo $a['salles_date'] ?></p>
                            
                        </td>
                            <td><?php echo $a['products'] ?></td>
                          
                            <td>
                            <p id="price"><?php echo $a['ammount'] ?></p>
                            <hr>
                            <p class="text-[10px] text-red-500 p-0"> ~<span id="price"><?php echo $a['debit'] ?></span> </p>
                            
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
    function deletecustomer(customerid){
        var choise = confirm("Are Your Sure You Want To Delete This customer ?");
        if (choise==true) {
            $.ajax({
                url:"./apis/deletecustomer.php",
                type:"Post",
                dataType:"json",
                data:{customer:customerid},
                success:function(response){
                           alert(response);
                           window.location="customer";
                }
            })
        }
        else{
            alert("customer Not Deleted ");
            return false;
        }
    }

</script>