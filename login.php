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
<div class="container-fluid bg-yellow-900 h-screen flex p-2">
   <div class="container p-3 bg-yellow-800 border border-4 border-dashed border-yellow-700 rounded m-auto md:w-1/3">
    <form action="" method="post">
      <h1 class="text-white font-bold p-3">Login To <span class="animate animate-ping text-blue-500">B-X</span> </h1>
      <hr class="text-black">
      <div class="row p-3">
         <label for="" class="font-bold text-white">Username</label>
         <div class="flex rounded border border-yellow-900 border-4 my-3"><i class="bi bi-person-fill bg-yellow-800 font-bold w-[10%] p-1 text-center"></i><input type="text" name="username" autocomplete="off" id="" class="bg-white w-[90%] p-1 outline-none text-sm font-bold"></div>
      </div>
       <div class="row p-3">
         <label for="" class="font-bold text-white">Password</label>
         <div class="flex rounded border border-yellow-900 border-4 my-3"><i class="bi bi-lock-fill bg-yellow-800 font-bold w-[10%] p-1 text-center"></i><input type="password" name="password" autocomplete="off" id="" class="bg-white w-[90%] p-1 outline-none text-sm font-bold"></div>
      </div>
       <div class="row p-3">
       
         <div class="flex justify-between my-3 p-2">
            <button class="border border-2 shadow shadow-white rounded p-2 text-white px-4 font-bold" name="login"><b><i class="bi bi-box-arrow-in-right font-bold"></i></b> Login</button>
            <a href="account" class="border border-2 border-green-500 shadow shadow-green-500 rounded p-2 text-white px-4 font-bold">Register</a>
         </div>
      </div>
</form>
   </div>
</div>
   
</body>
</html>
<?php
if (isset($_POST['login'])) {

    $username=$_POST['username'];
    $password=$_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM business where username =? and password =?");
    $stmt->bind_param("ss",$username,$password);
    $stmt->execute();
    $result= $stmt->get_result();
    if ($result->num_rows <1) {
        echo "<script>alert('incorrect Passsword')</script>";
    }
    else{
        $a = $result->fetch_assoc();

    session_start();
    $_SESSION['user']=$a['admin'];
    $_SESSION['business']=$a['business'];
    header("location:./pages/"); 
    }
   
    
}
?>