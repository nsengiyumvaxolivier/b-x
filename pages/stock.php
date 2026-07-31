<?php
include("./connection.php");
// select expected Total Investment, Total Sales, Total Profit...........................................................................................................
$business=$_SESSION['user'];
$selectvalues= $conn->prepare("SELECT SUM(in_price * quantity) as total_investment, SUM(out_price * quantity) as total_sales, SUM((out_price * quantity) - (in_price * quantity)) as total_profit from item where business=?");
$selectvalues->bind_param("i",$business);
$selectvalues->execute();
$valuesresult=$selectvalues->get_result();
$valuesrow=$valuesresult->fetch_assoc();

// select the all sales profit 

$selectsalesprofit=$conn->prepare("select sum(profit) as total_sales_profit from salles_item where business=?");
$selectsalesprofit->bind_param("i",$business);
$selectsalesprofit->execute();
$salesprofitresult=$selectsalesprofit->get_result();
$salesprofitrow=$salesprofitresult->fetch_assoc();

//select total sales ammount from salles table
$selecttotalsales=$conn->prepare("select sum(ammount) as total_sales from salles where business=?");
$selecttotalsales->bind_param("i",$business);
$selecttotalsales->execute();
$totalsalesresult=$selecttotalsales->get_result();
$totalsalesrow=$totalsalesresult->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="conteiner">
     <div class="cards">
        <div class="card bg-yellow-900 text-white p-2 rounded my-2">
            <h1 class="font-bold text-sm">Total Investment</h1>
            <p class="text-sm my-2"><span id="price" class="text-white"><?php echo htmlspecialchars($valuesrow['total_investment']) ?></span> RWF  </p>
        </div>
        <div class="card bg-yellow-900 text-white p-2 rounded my-2">
            <h1 class="font-bold text-sm">Total Sales Ammount</h1>
            <p class="text-sm my-2"><span id="price" class="text-white"><?php echo htmlspecialchars($totalsalesrow['total_sales']) ?></span> RWF  </p>
        </div>
       
        <div class="card bg-yellow-900 text-white p-2 rounded my-2">
            <h1 class="font-bold text-sm">Total Sales Profit</h1>
            <p class="text-sm my-2"><span id="price" class="text-white"><?php echo htmlspecialchars($salesprofitrow['total_sales_profit']) ?></span> RWF  </p>
     </div>
    </div>
    
</body>
</html>
<script>
    document.querySelectorAll("#price").forEach(e=>{
        e.textContent=Number(e.textContent).toLocaleString()
    })
</script>