<?php
session_start();
include("../connection.php");
header("Content-Type: application/json");

$key=$_POST['key'] ?? 0;
$business= $_SESSION['user'];
//select  key from business table..................................
$selectkey = $conn->prepare("SELECT x_key from business where admin=?");
$selectkey->bind_param("i",$business);
$selectkey->execute();
$result=$selectkey->get_result();
$keyrow=$result->fetch_assoc();
$re=$keyrow['x_key'];
$autho="";

if ($key == $re) {
    $autho="authorized";
}
else{
    $autho="not authorized";
}

echo json_encode($autho);



?>