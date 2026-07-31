<?php
session_start();
include("../connection.php");
$business=$_SESSION['user'];
$note=$_POST['note'];
$deletenote=$conn->prepare("DELETE FROM notes where note_id=? and business=?");
$deletenote->bind_param("ii",$note,$business);
if ($deletenote->execute()) {
    echo json_encode("Note Deleted ");
}else{
    echo json_encode("Note Not Deleted");
}



?>