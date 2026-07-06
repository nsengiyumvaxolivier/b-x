<?php
session_start();
include("../connection.php");
header("Content-Type: application/json");

$filter=$_POST['filter'] ?? "all";
                
$business= $_SESSION['user'];
if ($filter=="all") {
   $select = $conn->prepare("SELECT * FROM customer where business= ? order by name asc");
}
else{
   $select = $conn->prepare("SELECT * FROM customer where business= ? and (name like '%$filter%' or phone like'%$filter%' or location like'%$filter%') order by name asc");  
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