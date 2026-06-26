<?php
include("../pages/connection.php");
session_start();

header("Content-Type: application/json");

$business_id = $_SESSION['user'] ?? 0;

$filter = $_POST['filter'] ?? 'today';
$from = $_POST['from'] ?? null;
$to = $_POST['to'] ?? null;

/* ---------------- SALES DATE FILTER ---------------- */
$dateFilter = "";

if ($filter == "today") {
    $dateFilter = "DATE(s.salles_date) = CURDATE()";
} elseif ($filter == "week") {
    $dateFilter = "YEARWEEK(s.salles_date,1) = YEARWEEK(CURDATE(),1)";
} elseif ($filter == "month") {
    $dateFilter = "MONTH(s.salles_date)=MONTH(CURDATE()) AND YEAR(s.salles_date)=YEAR(CURDATE())";
} elseif ($filter == "year") {
    $dateFilter = "YEAR(s.salles_date)=YEAR(CURDATE())";
} elseif ($filter == "custom" && $from && $to) {
    $dateFilter = "DATE(s.salles_date) BETWEEN '$from' AND '$to'";
}

/* ---------------- SALES ---------------- */
$salesQuery = "
SELECT 
    s.sale_id,
    s.salles_date,
    c.name AS customer,
    s.ammount,
    s.discount
FROM salles s
LEFT JOIN customer c ON c.c_id = s.customer
WHERE s.business = '$business_id'
" . ($dateFilter ? " AND $dateFilter" : "") . "
ORDER BY s.salles_date DESC
";

$salesResult = $conn->query($salesQuery);

$sales = [];
$totalSales = 0;

if ($salesResult) {
    while ($row = $salesResult->fetch_assoc()) {

        $net = $row['ammount'] - $row['discount'];

        $sales[] = [
            "date" => $row['salles_date'],
            "customer" => $row['customer'] ?? 'Unknown',
            "total" => number_format($net, 2)
        ];

        $totalSales += $net;
    }
}

/* ---------------- PURCHASES ---------------- */
$purchaseQuery = "
SELECT 
    p.purchase_id,
    p.created_at,
    sp.name AS supplier,
    p.ammount
FROM purchases p
LEFT JOIN supplier sp ON sp.sp_id = p.supplier
WHERE p.business = '$business_id'
ORDER BY p.created_at DESC
";

$purchaseResult = $conn->query($purchaseQuery);

$purchases = [];
$totalPurchases = 0;

if ($purchaseResult) {
    while ($row = $purchaseResult->fetch_assoc()) {

        $purchases[] = [
            "date" => $row['created_at'],
            "supplier" => $row['supplier'] ?? 'Unknown',
            "total" => number_format($row['ammount'], 2)
        ];

        $totalPurchases += $row['ammount'];
    }
}

/* ---------------- SUMMARY ---------------- */
$profit = $totalSales - $totalPurchases;

$response = [
    "total_sales" => number_format($totalSales, 2),
    "total_purchases" => number_format($totalPurchases, 2),
    "profit" => number_format($profit, 2),
    "transactions" => count($sales) + count($purchases),
    "sales" => $sales,
    "purchases" => $purchases
];

echo json_encode($response);