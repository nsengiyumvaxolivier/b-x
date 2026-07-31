<?php
session_start();
include("../connection.php");
$business=$_SESSION['user'];

$timezone=date_default_timezone_set("Africa/kigali");
$date=date("Y-m-d h:i:s");
$day=date("l");
$notes=$_POST['note'];
$title=$_POST['title'];
$noteid=$_POST['noteid'];
$update=$conn->prepare("UPDATE notes SET notes=?, title=?, updated_at=? WHERE note_id=? AND business=?");
$update->bind_param("sssii",$notes,$title,$date,$noteid,$business);
if ($update->execute()) {
    echo json_encode("Note Updated");
}


     
        
    
    






?>