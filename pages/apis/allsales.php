<?php
include("../connection.php");
session_start();
$business=$_SESSION['user'];

$selectsale=$conn->prepare("SELECT COUNT(sale_id) as total_sales from salles where business=?");
$selectsale->bind_param("i",$business);
$selectsale->execute();
$salesnumber=$selectsale->get_result();
$salesrows=$salesnumber->fetch_assoc();
$sales=$salesrows['total_sales'];
echo json_encode($sales);
