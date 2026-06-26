<?php
include("./pages/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>B-X Login</title>
   <script src="./plugins/css/tailwindcss.js"></script>
   <link rel="stylesheet" href="./plugins/icons/bootstrap-icons.css">
</head>
<body>
<div class="container-fluid bg-yellow-900 h-screen flex p-2 overflow-y-auto">
    <div class="conatiner bg-yellow-800 p-2 rounder border border-4 border-dashed border-yellow-700 w-[95%] m-auto">
            <form action="" method="post" enctype="multipart/form-data">
                <h1 class="text-white font-bold p-2">Register Your Business To B-X </h1>
                <hr class="text-white">
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Busines Owner</label>
                        <input type="text" required name="names" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Phone Number</label>
                        <input type="text" required name="phone" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Email</label>
                        <input type="text" required name="email" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Business Name</label>
                        <input type="text" required name="bname" id="unit_price"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">BUsiness Logo (option)</label>
                        <div class="flex-column rounded justify-between w-full md:flex">
                            <img alt="logo " id="image" class="w-[80px] h-[80px] rounded p-1 my-2">
                            <input type="file" id="file" name="logo" hidden>
                            <label for="file" class="border border-green-500 shadow shadow-green-500 p-1 cursor-pointer rounded m-auto text-green-500 font-bold text-sm" id="get">Upload</label>
                            
                        </div>

                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                         <label for="" class="block p-1 text-sm text-white font-bold">Location</label>
                        <input type="text" required name="location" id="in_price"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                        
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Username</label>
                        <input type="text" required name="username" id="in_price"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Password</label>
                        <input type="password" required name="password" id=""
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <div class="flex p-2 justify-end">
                    <button class="p-2 text-white text-sm rounded shadow shadow-white border font-bold" name="register">Register</button>
                </div>

            </form>
        </div>
</div>
   
</body>
</html>
<script>
    var file = document.getElementById("file");
    var get = document.getElementById("get");
    var image = document.getElementById("image");
    file.addEventListener("change",
        function () {
            image.src=URL.createObjectURL(file.files[0]);

        }
    )
</script>

<?php
if (isset($_POST['register'])) {
    $names=$_POST['names'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bname = $_POST['bname'];
    $logo = $_FILES['logo']['name'];
    $file=$_FILES['logo']['tmp_name'];
    $folder="./asets/images/logos/";
    if (move_uploaded_file($file,$folder.$logo)) {
        $stmt =$conn->prepare("INSERT INTO business(names,phone,email,logo,username,password,location,business) values(?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss",$names,$phone,$email,$logo,$username,$password,$location,$bname);
        if ($stmt->execute()) {
            echo "data Inserted";
        }
    }
}


?>