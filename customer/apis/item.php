<?php
session_start();
include("../../pages/connection.php");
header("Content-Type: application/json");
$filter=$_POST['filter'] ?? "all";
$shop= $_SESSION['shop'];
echo $shop;
if ($filter=="all") {
   $select = $conn->prepare("SELECT * FROM item where business= ? order by item_name asc");
}
else{
   $select = $conn->prepare("SELECT * FROM item where business= ? and (item_name like '%$filter%' or item_supliyer like'%$filter%') order by item_name asc");  
}

$select->bind_param("i",$shop);
$select->execute();
$result=$select->get_result();
$data=array();
while ($a= $result->fetch_assoc()) {
    $data[]=$a;
                    

}
echo json_encode($data);


?>