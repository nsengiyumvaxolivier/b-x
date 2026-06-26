<?php
include("connection.php");
$business =$_SESSION['user'];
$itemid=$_GET['item'];
//select the Item info.................................................................
$selectitem = $conn->prepare("SELECT * FROM item where id=? and business=?");
$selectitem->bind_param("ii",$itemid,$business);
$selectitem->execute();
$selectitemresult=$selectitem->get_result();
$item=$selectitemresult->fetch_assoc();

$supplierid=$item['item_supliyer'];

//select the item supllier....................................................
$selectsupplier=$conn->prepare("SELECT * FROM supplier where sp_id=? and business=?");
$selectsupplier->bind_param("ii",$supplierid,$business);
$selectsupplier->execute();
$selectsupplierresult=$selectsupplier->get_result();
$supplierrow=$selectsupplierresult->fetch_assoc();






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>

    <div class="container-fluid p-1 w-full h-[100%] flex">

        <div class="conatiner bg-yellow-800 p-2 rounder w-[100%] md:w-1/2 m-auto">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Edit Item</h1>
                <hr class="text-white">
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Product Name</label>
                        <input type="text" required name="pname" id="" value="<?php echo htmlspecialchars($item['item_name']);?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Supplier</label>
                        <select required name="supplier" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                            <option value="<?php echo htmlspecialchars($supplierrow['sp_id']);?>"><?php echo htmlspecialchars($supplierrow['name']);?></option>
                            <?php
                            
                            $stmt=$conn->prepare("SELECT * FROM supplier where business =? and sp_id !=? ");
                            $stmt->bind_param("ii",$business,$supplierid);
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
                        <label for="" class="block p-1 text-sm text-white font-bold">Stock</label>
                        <input type="text" required name="pstock" id="" value="<?php echo htmlspecialchars($item['quantity']);?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">In Price</label>
                        <input type="text" required name="inprice" id="unit_price" value="<?php echo htmlspecialchars($item['in_price']);?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
               
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between ">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Out Price</label>
                        <input type="number" required name="outprice" id="" value="<?php echo htmlspecialchars($item['out_price']);?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Expiry DAte</label>
                        <input type="date" required name="expiry" id="" value="<?php echo htmlspecialchars($item['expiry_date']);?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-white border font-bold"> Save
                        Changes</button>
                </div>

            </form>
        </div>


    </div>
    

</body>

</html>
<?php
if (isset($_POST['save'])) {
    $pname=$_POST['pname'];
    $pstock=$_POST['pstock'];
    $supplier=$_POST['supplier'];
    $inprice=$_POST['inprice'];
    $outprice=$_POST['outprice'];
    $expiry=$_POST['expiry'];
    $profit=$outprice-$inprice;

    $update=$conn->prepare("UPDATE  item SET item_name=?,in_price=?,out_price=?,quantity=?,item_supliyer=?,expiry_date=?,profit=? where id=? and business=?");
    $update->bind_param("sdddisdii",$pname,$inprice,$outprice,$pstock,$supplier,$expiry,$profit,$itemid,$business);
    if ($update->execute()) {
   echo "<script>alert('Item updated'),location='item_view?id=".$itemid."'</script>";
    

    }
    

    

}


?>