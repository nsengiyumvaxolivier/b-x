<?php
session_start();
include("../connection.php");
$business=$_SESSION['user'];
$customer=$_POST['customer'];
$deletecustomer=$conn->prepare("DELETE FROM customer where c_id=? and business=?");
$deletecustomer->bind_param("ii",$customer,$business);
if ($deletecustomer->execute()) {
    echo json_encode("customer Deleted ");
}else{
    echo json_encode("customer Not Deleted");
}



?>