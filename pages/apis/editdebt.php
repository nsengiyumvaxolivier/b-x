<?php
session_start();
include("../connection.php");
$sale=$_POST['sale'];
$amount=$_POST['leftamount'];
$business = $_SESSION['user'];

$update =$conn->prepare("UPDATE salles set debit=? where business=? and sale_id=?");
$update->bind_param("dii",$amount,$business,$sale);
if ($update->execute()) {
    echo json_encode("Pay Successfuly");
}

?>