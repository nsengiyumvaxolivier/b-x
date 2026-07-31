<?php
include("../pages/connection.php");

$phone=$_GET['phone'];
$business=$_SESSION['shop'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid w-full h-screen bg-yellow-900 flex">
        <div class="container bg-yellow-800 p-3 rounded m-auto md:w-1/3">
            <form action="" method="post">
            <h1 class="my-3">Register</h1>
            <hr>
            <label for="" class="block">Phone</label>
            <input type="text" name="phone" value="<?php echo $phone ?>" class="w-full p-2 bg-yellow-500 text-white font-bold rounded outline-none focus:outline focus:outline-blue-500">
            <label for="" class="block my-2">Your Name</label>
            <input type="text" name="name" id="" class="w-full p-2 bg-yellow-500 text-white font-bold rounded outline-none focus:outline focus:outline-blue-500">
            <label for="" class="block my-2">Your Location</label>
            <input type="text" name="location" id="" class="w-full p-2 bg-yellow-500 text-white font-bold rounded outline-none focus:outline focus:outline-blue-500">
            <div class="flex my-3 justify-end">
                <button name="submit" class="bg-green-500 p-3 text-sm text-white rounded">Submit</button>
            </div>
        </form>
        </div>

    </div>
    
    
</body>
</html>
<?php
if (isset($_POST['submit'])) {
$name=$_POST['name'];
$phone=$_POST['phone'];
$location=$_POST['location'];
$insert=$conn->prepare("INSERT INTO customer (name,phone,location,business) values(?,?,?,?)");
$insert->bind_param("sssi",$name,$phone,$location,$business);

if ($insert->execute()) {
    header("location:business");
}
}


?>