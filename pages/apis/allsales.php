<?php
include("../connection.php");
session_start();
$business=$_SESSION['user'];
$status=0;

$selectsale=$conn->prepare("SELECT COUNT(distinct(customer)) as total_sales from orders where business=? and status=?");
$selectsale->bind_param("ii",$business,$status);
$selectsale->execute();
$salesnumber=$selectsale->get_result();
$salesrows=$salesnumber->fetch_assoc();
$sales=$salesrows['total_sales'];
echo json_encode($sales);
