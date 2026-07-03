<?php

include("../pages/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <script src="../plugins/css/tailwindcss.js"></script>

</head>
<body>
    <div class="container-fluid w-full h-screen bg-yellow-900 flex justify-center items-center p-3">
        <div class="container p-3 bg-yellow-800 border border-4 border-dashed border-yellow-700 rounded m-auto md:w-1/3">
            <form action="" method="post">
                <h1 class="text-white font-bold p-3">Customer Login</h1>
                <hr class="text-black mb-2">
                <label for="phone" class="font-bold text-white block mb-2">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-control bg-yellow-600 text-white placeholder:text-yellow-400 border border-gray-400 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full mb-4 font-bold" placeholder="Enter your phone number" required>
                <div class="flex py-2"><button name="continue" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contnue</button></div>
                <div class="flex">
                   <a href="register.php" class="text-white underline">Don't have an account? Register here</a>
                  
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>
<?php

if (isset($_POST['continue'])) {
    $phone = $_POST['phone'];
    $stmt = $conn->prepare("SELECT * FROM customer WHERE phone = ? AND business = ?");
    $stmt->bind_param("si", $phone, $business);
    $stmt->execute();
    $result = $stmt->get_result();
    
    
    if ($result->num_rows < 1) {
        echo "<script>alert('Phone number not found. Please register.')</script>";
    } else {
      $customer =$result->fetch_assoc()['c_id'];
      $_SESSION['customer']=$customer;
      header("location:ordering");  
       
    }
}




?>