<?php
include("../pages/connection.php");
header("Content-Type: application/json");
    $username=$_POST['username'];
    $password=$_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM business where username =? and password =?");
    $stmt->bind_param("ss",$username,$password);
    $stmt->execute();
    $result= $stmt->get_result();
    $responce=array(
        "status"=>"",
        "message"=>""
    );
    
    if ($result->num_rows <1) {
      $response['status']="fail";
      $response['message']="Invalid username or password";

       
     
    }
    else{
        $a = $result->fetch_assoc();

    session_start();
    $_SESSION['user']=$a['admin'];
    $_SESSION['business']=$a['business'];
    $response['status']="ok";
    
  
    
    }
      
echo json_encode($response);