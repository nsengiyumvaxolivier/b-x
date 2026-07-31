<?php
session_start();
include("../connection.php");
$business=$_SESSION['user'];

$timezone=date_default_timezone_set("Africa/kigali");
$date=date("Y-m-d h:i:s");
$day=date("l");
$notes=$_POST['note'];
$title=$_POST['title'];
$insert=$conn->prepare("INSERT INTO notes(business,created_at,updated_at,created_day,notes,title) values(?,?,?,?,?,?)");
$insert->bind_param("isssss",$business,$date,$date,$day,$notes,$title);
if ($insert->execute()) {
    echo json_encode("Note Saved");
}


     
        
    
    






?>