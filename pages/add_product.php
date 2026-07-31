<?php
include("connection.php");

date_default_timezone_set("Africa/kigali");
$timezone=date('Y-m-d h:i:s');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add_product</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>

    <div class="container-fluid p-1 w-full h-[100%] flex">

        <div class="conatiner bg-yellow-800 p-2 rounder w-[100%] m-auto">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Add Item</h1>
                <hr class="text-white">
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Product Name</label>
                        <input type="text" required name="pname" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Supplier</label>
                        <select required name="supplier" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                            <option value="0">--------</option>
                            <?php
                            $business =$_SESSION['user'];
                            $stmt=$conn->prepare("SELECT * FROM supplier where business =? ");
                            $stmt->bind_param("i",$business);
                            $stmt->execute();
                            $result=$stmt->get_result();
                            while ($a = $result->fetch_assoc() ) {
                            ?>
                            
                            <option value="<?php echo $a['sp_id'] ?>"><?php echo $a['name'] ?></option>
                            <?php
                            }
                            
                            ?>
                            </select>
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Opening Stock</label>
                        <input type="text" required name="pstock" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Unit Price</label>
                        <input type="text" required name="unitprice" id="unit_price"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Picies</label>
                        <div class="flex border border-4 border-yellow-900 rounded w-full">
                            <input type="number" required name="picies" value="1" id="picie"
                                class="w-[60%] p-1 outline-0 focus:outline-none text-sm font-bold">
                            <div id="get" title="click to Get in Price Automaticaly"
                                class="text-sm text-center text-white p-auto w-[40%] font-bold bg-yellow-900 p-1 cursor-pointer">
                                <i class="bi bi-calculator-fill"></i> Get In Price</div>
                        </div>

                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">In Price</label>
                        <input type="number" disabled required id="in_price" name="inprice"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Out Price</label>
                        <input type="number" required name="outprice" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Expiry DAte</label>
                        <input type="date" required name="expiry" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-white border font-bold"> Save
                        Item</button>
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
    $pname=$_POST['pname'];
    $pstock=$_POST['pstock'];
    $supplier=$_POST['supplier'];
    $unitprice=$_POST['unitprice'];
    $picies=$_POST['picies'];
    $inprice=$unitprice/$picies;
    $outprice=$_POST['outprice'];
    $expiry=$_POST['expiry'];
    $business=$_SESSION['user'];
    $current_stock = $pstock*$picies;
    $profit=$outprice-$inprice;

    $insert=$conn->prepare("INSERT INTO item(item_name,in_price,out_price,quantity,item_supliyer,business,pcs,expiry_date,profit,reg_date) values (?,?,?,?,?,?,?,?,?,?)");
    $insert->bind_param("sdddiiisds",$pname,$inprice,$outprice,$current_stock,$supplier,$business,$picies,$expiry,$profit,$timezone);
    if ($insert->execute()) {
   echo "<script>alert('Item Added'),location='item'</script>";
    

    }
    

    

}


?>