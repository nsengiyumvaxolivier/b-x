<?php
include("connection.php");
$businessid=$_SESSION['user'];
$business_select=$conn->prepare("SELECT * FROM business where admin= ?");
$business_select->bind_param("i",$businessid);
$business_select->execute();
$result=$business_select->get_result();
$business=$result->fetch_assoc();
$sale=$_GET['sale'];

$select_customer=$conn->prepare("SELECT *FROM customer,salles where customer.c_id =salles.customer and salles.sale_id=? and customer.business=salles.business  and customer.business = ?");
$select_customer->bind_param("ii",$sale,$businessid);
$select_customer->execute();
$customer_result=$select_customer->get_result();
$customer=$customer_result->fetch_assoc();
$customerid=$customer['c_id'];
$customername=$customer['name'];




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale View</title>
    <script src="../plugins/js/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid w-full h-[100%]">
        <form action="" method="post" class="p-0 h-[100%]">
         <div class="flex justify-between bg-yellow-900 p-2 w-full">
            <h1 class="text-white font-bold p-1"><i class="bi bi-person-fill"></i><?php echo $customer['name'] ?></h1>
             <button type="button" class="p-1 bg-green-700 px-2 font-bold rounded shadow shadow-green-500 border-2 border-green-500 text-white" id="download"><i class="bi bi-box-arrow-in-down"></i> A5</button>
            <button type="button" class="p-1 bg-green-700 px-2 font-bold rounded shadow shadow-green-500 border-2 border-green-500 text-white" id="btn"><i class="bi bi-box-arrow-in-down"></i> A4</button>
             <button class="p-1 bg-blue-500/20 font-bold rounded shadow shadow-blue-500 border-2 border-blue-500 text-white"><i class="bi bi-pencil"></i> Update</button>
         </div>
         <div class="flex h-[90%] my-1 border border-yellow-900 border-2">
         <div class="right h-[100%] w-[100%] p-2">
         <div id="card" class="card border border-black  w-full h-[100%] p-2 overflow-y-auto">
            <div class="reciept w-[100%] p-2">
            <div class="info flex justify-between bg-white p-1 w-100% h-[15%]">
                <div class="left w-[40%]">
                    <h1 class="font-bold"><?php echo $business['business'] ?></h1>
                   <label for="" class="block text-sm"><b>Phone:</b> <?php echo $business['phone'] ?></label>
                    
                </div> 
                <div class="logo w-[20%] h-[80px] ">
                    <img src="../asets/images/logos/<?php echo $business['logo'] ?>" alt="" class="md:w-1/2 h-[100%]">
                </div>
                <div class="right w-[40%]">
                    <label for="" class="block text-sm"><b>Email: </b><?php echo $business['email'] ?></label>
                    <label for="" class="block text-sm"><b>Location: </b><?php echo $business['location'] ?></label>
                </div>

            </div>
            
            <div class="customer flex bg-white justify-between p-2 my-2">
                <div class="name"><b>Customer: </b> <?php echo $customer['name'] ?></div>
                <div class="hpone"><b>Phone: </b> <?php echo $customer['phone'] ?></div>
                <div class="location"><b>Location: </b> <?php echo $customer['location'] ?></div>
            </div>
            <hr class=" border border-dashed border-black">
            <table class="w-full my-2 [&_th]:text-left [&_th]:p-1 [&_tr]:p-2 [&_td]:p-2 [&_th]:p-2 [&_tr]:border-g [&_tr]:border-black [&_td]:border [&_td]:border-black [&_td]:border-dashed [&_td]:text-sm">
                <tr class="bg-black text-white [&_th]:border-l border border-black border-2 [&_th]:border-white text-sm">
                    <th>N<sup><u>o</u></sup></th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Dsc</th>
                    <th>Total Price</th>
                    <th>Total Dsc</th>
                    
                </tr>
                <?php
                $select_sales=$conn->prepare("SELECT * FROM item,salles_item where item.business = ? and salles_item.business=? and item.id=salles_item.product and salles_item.sale=? and salles_item.customer=?");
                $select_sales->bind_param("iiii",$businessid,$businessid,$sale,$customerid);
                $select_sales->execute();
                $sales_result=$select_sales->get_result();
                $no=0;

                while ($sales=$sales_result->fetch_assoc()) {
                    $no++;
                    ?>

                    <tr>
                        <td> <?php echo $no ?></td>
                        <td> <?php echo $sales['item_name'] ?></td>
                        <td> <?php echo $sales['ord_quantity'] ?></td>
                        <td id="pricies"> <?php echo $sales['price'] ?></td>
                        <td id="pricies"> <?php echo $sales['discount'] ?></td>
                        <td id="pricies"> <?php echo $sales['ord_quantity']*$sales['price'] ?></td>
                        <td id="pricies"> <?php echo $sales['ord_quantity']*$sales['discount'] ?></td>
                    </tr>

                    <?php
                }
                
                
                
                ?>
            </table>
            <div class="bottom flex my-2 p-3 border-t border-gray-500">
                <?php
                
                $select_sale=$conn->prepare("SELECT * FROM salles where sale_id = ?");
                $select_sale->bind_param("i",$sale);
                $select_sale->execute();
                $sale_result=$select_sale->get_result();
                $sal=$sale_result->fetch_assoc();
                ?>
                <div class="left w-[50%]"></div>
                <div class="right w-[50%] text-left">
                    <label for="" class="block text-sm"><b>Total Ammount: </b><span id="pricies"><?php echo $sal['ammount'] ?></span></label>
                    <label for="" class="block text-sm"><b>Total Discount: </b><span id="pricies"><?php echo $sal['discount'] ?></span></label>
                    <label for="" class="block text-sm"><b>Total product: </b><span><?php echo $sal['products'] ?></span></label>
                    <label for="" class="block text-sm"><b>Create At: </b><span><?php echo $sal['salles_date'] ?></span></label>
                </div>

            </div>
            </div>
         </div>
         </div>
         </div>



        </form>
    </div>
</body>
</html>
<script>
    var button=document.getElementById("download");           
    var btn=document.getElementById("btn"); 
    var name ="<?php echo $customername ?>"          
   
  
    button.addEventListener("click",function () {  
        var text=document.getElementById("card");
      
        var opt={
            margin:0.2,
            with:100,
            filename:name,
            image: {type:'jpeg',quality: 0.8},
            html2canvas:{scale: 5},
            jsPDF:{unit: 'in', format: 'A5', orientation: 'portrait'}
        };
        html2pdf(text,opt);
    });

    
    btn.addEventListener("click",function () {  
        var text=document.getElementById("card");
      
        var opt={
            margin:0.2,
            with:100,
            filename:name,
            image: {type:'jpeg',quality: 0.8},
            html2canvas:{scale: 5},
            jsPDF:{unit: 'in', format: 'A4', orientation: 'portrait'}
        };
        html2pdf(text,opt);
    });



document.querySelectorAll("#pricies").forEach(
    e=>{
        var price=parseFloat(e.innerHTML);
        e.innerHTML=price.toLocaleString();
    }
)






  
  
   
</script>