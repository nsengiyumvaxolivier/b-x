<?php
session_start();
include("../connection.php");
$business=$_SESSION['user'];
$item=$_POST['item'];
$deleteitem=$conn->prepare("DELETE FROM item where id=? and business=?");
$deleteitem->bind_param("ii",$item,$business);
if ($deleteitem->execute()) {
    echo json_encode("Item Deleted ");
}else{
    echo json_encode("Item Not Deleted");
}



?>