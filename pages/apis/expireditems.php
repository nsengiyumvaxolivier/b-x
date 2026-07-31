<?php
include("../connection.php");
session_start();
$business=$_SESSION['user'];
$status=0;

$selectexpireditem=$conn->prepare("SELECT COUNT(id) as expired_item from item where business=? and quantity >0 and expiry_date < CURDATE()");
$selectexpireditem->bind_param("i",$business);
$selectexpireditem->execute();
$expireditemsnumber=$selectexpireditem->get_result();
$expireditemsrows=$expireditemsnumber->fetch_assoc();
$expireditems=$expireditemsrows['expired_item'];
echo json_encode($expireditems);
