<?php
include("../pages/connection.php");

$business=$_GET['business'] ?? null;
$message ="";
$_SESSION['shop']=$business;
$customernumber="";
if (isset($_POST['getin'])) {
   
    $phone=$_POST['phone'];
    $checkcustomer=$conn->prepare("SELECT * FROM customer where phone=? and business=?");
    $checkcustomer->bind_param("si",$phone,$business);
    $checkcustomer->execute();
    $checkresult=$checkcustomer->get_result();
    if ($checkresult->num_rows >0) {
        $customernumber=$phone;
        $message="exist";
    }
    else {
        $message="register";
    }






   
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer->Business</title>
</head>
<body>
    <form action="" method="post">
    <div class="container-fluid w-full h-screen bg-yellow-900 flex justify-center">
        <div class="conainer w-[95%] md:w-[fit-content] border border-2 p-3 m-auto rounded shadow bg-yellow-800 border-yellow-700">
            <?php if (! isset($_GET['business'])): ?>
                <div class="alert rounded p-2 bg-red-500 text-white text-sm">
No business selected try Again!

                </div>
                <?php endif ?>
            <?php if ($business != ""): ?>
                <?php
                    $selectbusiness= $conn->prepare("SELECT * FROM business where admin=?");
                    $selectbusiness->bind_param("i",$business);
                    $selectbusiness->execute();
                    $businessresult=$selectbusiness->get_result();
                   
                    
                    ?>
                    <?php if($businessresult->num_rows >0): ?>

                        <?php
                             $row=$businessresult->fetch_assoc();
                            ?>
                    

                 <div class="join text-center ">
                    <div class="business font-bold text-white p-2 flex justify-center my-3"><div class="logo h-[80px] w-[80px] rounded rounded-full bg-white m-auto mx-2">
                        <img src="../asets/images/logos/<?php echo htmlspecialchars($row ['logo'])?>" alt="" class="w-full h-full rounded rounded-full">
                    </div><div class="name m-auto mx-2"><?php echo htmlspecialchars($row ['business'])?></div></div>
                    <div class="flex justify-center my-1 font-bold">Enter Your Phone Number</div>
                    <div class="flex w-full justify-center p-1"><input type="text" name="phone" id="" class="font-bold text-sm bg-yellow-500/50 rounded outline-none focus:outline focus:outline-blue-500 p-2 w-[70%] placeholder-gray-200" placeholder="07xxxxxxxx" required></div>
                    <?php if ($message == "register"): ?>
                        <div class="new w-full p-2 bg-yellow-600 rounded my-2">
                           Your Phone Number(<?php echo htmlspecialchars($message) ?>) Is New To <b><?php echo htmlspecialchars($row ['business'])?></b>. Try registration First or Try Other Number. <a href="register?phone=<?php echo $phone ?>" class="bg-green-800 p-2 font-bold text-sm text-white mx-3 my-3 rounded">Register Now</a> 
                        </div>
                        <?php endif ?>
                        <?php if ($message=="exist"): ?>
                            <?php
                                $selesectcustomer=$conn->prepare("SELECT * FROM customer where phone=? and business=?");
                                $selesectcustomer->bind_param("si",$customernumber,$business);
                                $selesectcustomer->execute();
                                $customerresult=$selesectcustomer->get_result();
                                $customerrow=$customerresult->fetch_assoc();
                                ?>
                                <a href="home?customer=<?php echo $customerrow['c_id'] ?>" class="bg-green-600 rounded text-white text-sm p-3 m-auto my-3 block">Contnue As <b><?php echo htmlspecialchars($customerrow['name']) ?></b></a>
                            <?php endif ?>

                     <button class="rounded bg-yellow-400 text-white p-2 font-bold my-3 text-sm" name="getin">Get In</button>
                     <div class="flex text-sm text-white"><i class="bi bi-geo-alt-fill text-red-500"></i><i><?php echo htmlspecialchars(" ~".$row['location'])?></i></div>

                 </div>
                 <?php endif ?>
                 <?php if ($businessresult->num_rows <1 ): ?>
                    <div class="alert rounded p-2 bg-orange-500 text-white text-sm">
                    <i class="bi bi-exclamation-triangle"></i> Invalid Business 

                </div>
                <?php endif ?>

    

                <?php endif ?> 


                
        </div>
        
    </div>
    </form>
</body>
</html>
<?php




?>
