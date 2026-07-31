<?php
include("../pages/connection.php");

$business=$_SESSION['user'] ?? "";

$selectbusiness=$conn->prepare("SELECT * FROM business where admin=?");
$selectbusiness->bind_param("i",$business);
$selectbusiness->execute();
$businessresult=$selectbusiness->get_result();
$businessrow=$businessresult->fetch_assoc();




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
                <h1 class="text-white font-bold p-2">Edit Business Information</h1>
                <hr class="text-white">
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Busines Owner</label>
                        <input type="text" required name="names" id="" value="<?= htmlspecialchars($businessrow['names']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Phone Number</label>
                        <input type="text" required name="phone" id="" value="<?= htmlspecialchars($businessrow['phone']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Email</label>
                        <input type="text" required name="email" id="" value="<?= htmlspecialchars($businessrow['email']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">Business Name</label>
                        <input type="text" required name="bname" id="unit_price" value="<?= htmlspecialchars($businessrow['business']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                    </div>
                </div>
                <!--Row End-->
                <!--Row Start-->
                <div class="row flex-column md:flex w-full p-1 my-2 justify-between">
                    <div class="col p-2 w-full md:w-1/2">
                        <label for="" class="block p-1 text-sm text-white font-bold">BUsiness Logo (option)</label>
                        <div class="flex-column rounded justify-between w-full md:flex">
                            <img alt="logo " id="image" class="w-[80px] h-[80px] rounded p-1 my-2" src="../asets/images/logos/<?= htmlspecialchars($businessrow['logo']) ?>">
                            <input type="file" id="file" hidden name="logo" value="">
                            <label for="file" class="border border-green-500 shadow shadow-green-500 p-1 cursor-pointer rounded m-auto text-white bg-green-500/30 hover:bg-green-500 font-bold text-sm" id="get"> <i class="bi bi-box-arrow-up"></i> Upload</label>
                           
                        
                            
                        </div>

                    </div>
                    <div class="col p-2 w-full md:w-1/2">
                         <label for="" class="block p-1 text-sm text-white font-bold">Location</label>
                        <input type="text" required name="location" id="in_price" value="<?= htmlspecialchars($businessrow['location']) ?>"
                            class="w-full p-1 rounded outline-0 focus:outline-blue-500 text-sm font-bold">
                        
                    </div>
                </div>
                <!--Row End-->
               
                <div class="flex p-2 justify-end">
                    <button class="p-2 text-white text-sm rounded shadow shadow-blue-500 border border-blue-400 border-2 bg-blue-500/30 hover:bg-blue-500 border font-bold" name="update">Save Changes</button>
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
if (isset($_POST['update'])) {
    $names=$_POST['names'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $bname = $_POST['bname'];
    $log=$_FILES['logo']['name'];
    $extension=pathinfo($log,PATHINFO_EXTENSION);
    $logo = "logo".$business.".".$extension;
    $file=$_FILES['logo']['tmp_name'];
    $folder="../asets/images/logos/";
    $currentlogo=$businessrow['logo'];

    if (! empty($log)) {
        if (file_exists($folder.$currentlogo)) {
            if(unlink($folder.$currentlogo)){
                if(move_uploaded_file($file,$folder.$logo)){
                    $updatebusiness=$conn->prepare("UPDATE business set names=?,phone=?,email=?,location=?,business=?,logo=? where admin=?");
                    $updatebusiness->bind_param("ssssssi",$names,$phone,$email,$location,$bname,$logo,$business);
                    $updatebusiness->execute();
                }
            }
         }
         elseif($businessrow['logo']=="default.png"){
                if(move_uploaded_file($file,$folder.$logo)){
                     $updatebusiness=$conn->prepare("UPDATE business set names=?,phone=?,email=?,location=?,business=?,logo=? where admin=?");
                $updatebusiness->bind_param("ssssssi",$names,$phone,$email,$location,$bname,$logo,$business);
                $updatebusiness->execute();
                }
               
                 
         }
    }
      
    
    else{
        $updatebusiness=$conn->prepare("UPDATE business set names=?,phone=?,email=?,location=?,business=? where admin=?");
        $updatebusiness->bind_param("sssssi",$names,$phone,$email,$location,$bname,$business);
        $updatebusiness->execute();
    }

   

 

       
        
}
    
      
        
    
        
    


?>