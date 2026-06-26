<?php
include("connection.php");

$supplier=$_SESSION['supplier'];
$business=$_SESSION['user'];
$porder=$_GET['porder'];

$select_supplier=$conn->prepare("SELECT * FROM supplier where sp_id=?");
$select_supplier->bind_param("i",$supplier);
$select_supplier->execute();
$a_sp=$select_supplier->get_result();
$sp=$a_sp->fetch_assoc();

$select_purchase_order=$conn->prepare("SELECT * FROM purchase_orders where pord_id=?");
$select_purchase_order->bind_param("i",$porder);
$select_purchase_order->execute();
$poredr_result=$select_purchase_order->get_result();
$po=$poredr_result->fetch_assoc();

$item=$po['item'];

$select_item=$conn->prepare("SELECT * FROM item where id=?");
$select_item->bind_param("i",$item);
$select_item->execute();
$a_item=$select_item->get_result();
$it=$a_item->fetch_assoc();




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Item</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>

    <div class="container-fluid p-1 w-full h-[100%] flex">

        <div class="conatiner bg-yellow-800 p-2 rounder w-[100%] m-auto">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Edit purchase</h1>
                <hr class="text-white">
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Product Name</label>
                        <input type="text" required name="pname" id="" disabled value="<?php echo htmlspecialchars($it['item_name']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Supplier</label>
                        <select required name="supplier" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                            <option value="<?php echo $sp['sp_id'] ?>"><?php echo htmlspecialchars($sp['name']) ?></option>
                          
                            </select>
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Quantity</label>
                        <input type="text" required name="pstock" value="<?php echo htmlspecialchars($po['p_quantity']/$po['picies']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Unit Price</label>
                        <input type="text" required name="unitprice" id="unit_price" value="<?php echo htmlspecialchars($po['pin_Price']*$po['picies']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Picies</label>
                        <div class="flex border border-4 border-yellow-900 rounded w-full">
                            <input type="number" required name="picies" value="<?php echo htmlspecialchars($po['picies']) ?>" id="picie"
                                class="w-[60%] p-1 outline-0 focus:outline-none text-sm font-bold">
                            <div id="get" title="click to Get in Price Automaticaly"
                                class="text-sm text-center text-white p-auto w-[40%] font-bold bg-yellow-900 p-1 cursor-pointer">
                                <i class="bi bi-calculator-fill"></i> Get In Price</div>
                        </div>

                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">In Price</label>
                        <input type="number" disabled required id="in_price" name="inprice" value="<?php echo htmlspecialchars($po['pin_Price']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Out Price</label>
                        <input type="number" required name="outprice" id="" value="<?php echo htmlspecialchars($po['pout_price']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Expiry DAte</label>
                        <input type="date" required name="expiry" id="" value="<?php echo htmlspecialchars($po['expiry_date']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-blue-500 border border-2 bg-blue-500/20 border-blue-500 font-bold"> Save Changes</button>
                </div>

            </form>
        </div>


    </div>
    <script>
        var get = document.getElementById("get");
        var picie = document.getElementById("picie");
        var in_price = document.getElementById("in_price");
        var unit_price = document.getElementById("unit_price");
        get.addEventListener("click", function () {
            var result = unit_price.value/picie.value;
            in_price.value=result;
            get.style.background="green";

        })
    </script>

</body>

</html>
<?php
if (isset($_POST['save'])) {
   
    $pstock=$_POST['pstock'];
    $unitprice=$_POST['unitprice'];
    $picies=$_POST['picies'];
    $inprice=$unitprice/$picies;
    $outprice=$_POST['outprice'];
    $expiry=$_POST['expiry'];
    $business=$_SESSION['user'];
    $current_stock = $pstock*$picies;
   

    $update=$conn->prepare("UPDATE  purchase_orders set p_quantity=?,pin_price=?,pout_price=?,expiry_date=? where pord_id=?");
    $update->bind_param("dddsi",$current_stock,$inprice,$outprice,$expiry,$porder);
    if ($update->execute()) {
     echo "<script>location='add_purchase'</script>";
    

    }
    

    

}


?>