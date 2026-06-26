<?php
include("connection.php");




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

    <div class="container-fluid p-2 w-full h-[100%] flex">

        <div class="conatiner bg-yellow-800 p-2 rounder w-full md:w-1/2 m-auto rounded">
            <form action="" method="post">
                <h1 class="text-white font-bold p-2">Add Customer</h1>
                <hr class="text-white">
               
                <!--Row Start-->
              
                    
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Customer Name</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            <i class="bi bi-person-fill w-[10%] text-center p-1"></i>
                             <input type="text" required name="name" id=""
                            class="w-[90%] p-2 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                       <label for="" class="block p-1 text-sm text-white font-bold my-2">Customer Phone</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            <i class="bi bi-telephone-fill w-[10%] text-center p-1"></i>
                             <input type="text" required name="phone" id=""
                            class="w-[90%] p-2 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                        <label for="" class="block p-1 text-sm text-white font-bold my-2">Location</label>
                        <div class="flex w-full border border-4 border-yellow-900 rounded my-2">
                            <i class="bi bi-geo-alt-fill w-[10%] text-center p-1"></i>
                             <input type="text" required name="location" id=""
                            class="w-[90%] p-2 outline-0 focus:outline-none text-sm font-bold">
                        </div>
                    
    
                 
                <!--Row End-->
              
                
                <div class="flex p-2 justify-end">
                    <button name="save" class="p-2 text-white text-sm rounded shadow shadow-white border font-bold"> Save
                        Customer</button>
                </div>

            </form>
        </div>


    </div>
   

</body>

</html>
<?php
if (isset($_POST['save'])) {
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $location=$_POST['location'];
    $business= $_SESSION['user'];
   

    $insert=$conn->prepare("INSERT INTO customer(name,phone,location,business) values (?,?,?,?)");
    $insert->bind_param("sssi",$name,$phone,$location,$business);
    if ($insert->execute()) {
    echo "<script>alert('Customer Added'),location='customer'</script>"; 
    
    

    }
    

    

}


?>