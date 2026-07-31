<?php
session_start();
include("../connection.php");
header("Content-Type: application/json");

$filter=$_POST['filter'] ?? "all";
                
$business= $_SESSION['user'];
if ($filter=="all") {
   $select = $conn->prepare("SELECT * FROM notes where business= ? order by created_at desc");
}
else{
   $select = $conn->prepare("SELECT * FROM notes where business= ? and (title like '%$filter%' or notes like'%$filter%') order by created_at desc");  
}

$select->bind_param("i",$business);
$select->execute();
$result=$select->get_result();
$data=array();
while ($a= $result->fetch_assoc()) {
    $data[]=$a;
                    

}
echo json_encode($data);


?>