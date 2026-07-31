<?php
include("connection.php");
$customerid=$_GET['customer'];
$business=$_SESSION['user'];

$fournd="";
$customer="";

//
//select customer...................................................................
$selectcustomer=$conn->prepare("SELECT * FROM customer where c_id=? and business=?");
$selectcustomer->bind_param("ii",$customerid,$business);
$selectcustomer->execute();
$customerresult=$selectcustomer->get_result();
$customerrow=$customerresult->fetch_assoc();

if (isset($_POST['save'])) {
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $location=$_POST['location'];
    $business= $_SESSION['user'];

    //check custoer before to be added..........................................................................

    $checkcustomer=$conn->prepare("SELECT * FROM customer where phone=? and business=? and c_id !=?");
    $checkcustomer->bind_param("sii",$phone,$business,$customerid);
    $checkcustomer->execute();
    $customerresult=$checkcustomer->get_result();
   
    if ($customerresult->num_rows >0) {
     $fournd="found";
     $customer=$customerresult->fetch_assoc()['name'];
  
    }
    else{
    $update=$conn->prepare("UPDATE customer set name=?,phone=?,location=? where c_id=?");
    $update->bind_param("sssi",$name,$phone,$location,$customerid);
    $update->execute();
    echo "<script>alert('Customer Updated'),location='customerview?customer=".$customerid."'</script>"; 
    }
    

    

}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Edit</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>

    <div class="container-fluid p-2 w-full h-[100%] flex">
        <?php if($fournd !=""): ?>
            <div class=" message bg-orange-500 p-3 rounded text-sm  text-white absolute m-auto md:w-1/2">
                Phone NUmber was Taken By <b><?php echo htmlspecialchars($customer)?></b>
            
            </div>



            <?php endif?>


        <div class="conatiner bg-yellow-800 p-2 rounder w-full md:w-1/2 m-auto rounded">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Edit Customer</h1>
                <hr class="text-white">
               
                <!--Row Start-->
              
                    
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Customer Name</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            <i class="bi bi-person-fill w-[10%] text-center p-1"></i>
                             <input type="text" required name="name" id="" value="<?php echo htmlspecialchars($customerrow['name']) ?>"
                            class="w-[90%] p-2 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                       <label for="" class="block p-1 text-sm text-white font-bold my-2">Customer Phone</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            <i class="bi bi-telephone-fill w-[10%] text-center p-1"></i>
                             <input type="text" required name="phone" id="" value="<?php echo htmlspecialchars($customerrow['phone']) ?>"
                            class="w-[90%] p-2 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Location</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            <i class="bi bi-geo-alt-fill w-[10%] text-center p-1"></i>
                             <input type="text" name="location" id="" value="<?php echo htmlspecialchars($customerrow['location']) ?>"
                            class="w-[90%] p-2 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                    
    
                 
                <!--Row End-->
              
                
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-blue-500 border-blue-500 hover:bg-blue-500 bg-blue-500/30 border font-bold"> <i class="bi bi-check-circle"></i> Saver Changes</button>
                </div>

            </form>
        </div>


    </div>
   

</body>

</html>
<?php


?>