<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../connection.php';

header('Content-Type: application/json');

$business_id = $_SESSION['user'] ?? 0;

if (!$business_id) {
    echo json_encode([
        'error' => 'No business ID found in session',
        'total_sales' => '0.00',
        'total_purchases' => '0.00',
        'profit' => '0.00',
        'transactions' => 0,
        'sales' => [],
        'purchases' => []
    ]);
    exit();
}

$filter = $_POST['filter'] ?? 'today';
$from = $_POST['from'] ?? null;
$to = $_POST['to'] ?? null;

$response = [
    'total_sales' => '0.00',
    'total_purchases' => '0.00',
    'profit' => '0.00',
    'transactions' => 0,
    'sales' => [],
    'purchases' => []
];

try {
    $whereConditions = ["s.business = '$business_id'"];
    $purchaseWhereConditions = ["p.business = '$business_id'"];

    if ($filter === 'today') {
        $whereConditions[] = "DATE(s.salles_date) = CURDATE()";
        $purchaseWhereConditions[] = "DATE(p.created_at) = CURDATE()";
    } elseif ($filter === 'week') {
        $whereConditions[] = "YEARWEEK(s.salles_date,1) = YEARWEEK(CURDATE(),1)";
        $purchaseWhereConditions[] = "YEARWEEK(p.created_at,1) = YEARWEEK(CURDATE(),1)";
    } elseif ($filter === 'month') {
        $whereConditions[] = "MONTH(s.salles_date) = MONTH(CURDATE()) AND YEAR(s.salles_date) = YEAR(CURDATE())";
        $purchaseWhereConditions[] = "MONTH(p.created_at) = MONTH(CURDATE()) AND YEAR(p.created_at) = YEAR(CURDATE())";
    } elseif ($filter === 'year') {
        $whereConditions[] = "YEAR(s.salles_date) = YEAR(CURDATE())";
        $purchaseWhereConditions[] = "YEAR(p.created_at) = YEAR(CURDATE())";
    } elseif ($filter === 'custom' && $from && $to) {
        $whereConditions[] = "DATE(s.salles_date) BETWEEN '$from' AND '$to'";
        $purchaseWhereConditions[] = "DATE(p.created_at) BETWEEN '$from' AND '$to'";
    }

    $whereClause = implode(' AND ', $whereConditions);
    $purchaseWhereClause = implode(' AND ', $purchaseWhereConditions);

    $salesQuery = "
        SELECT 
            s.sale_id,
            s.salles_date,
            c.name AS customer,
            s.ammount,
            s.discount
        FROM salles s
        LEFT JOIN customer c ON c.c_id = s.customer
        WHERE $whereClause
        ORDER BY s.salles_date DESC
    ";

    $salesResult = $conn->query($salesQuery);
    $totalSales = 0;
    $sales = [];

    if ($salesResult) {
        while ($row = $salesResult->fetch_assoc()) {
            $gross = (float)$row['ammount'];
            $discount = (float)$row['discount'];
            $net = $gross - $discount;

            $sales[] = [
                'date' => $row['salles_date'],
                'customer' => $row['customer'] ?? 'Unknown',
                'amount' => number_format($gross, 2),
                'discount' => number_format($discount, 2),
                'net' => number_format($net, 2)
            ];

            $totalSales += $net;
        }
    }

    $purchaseQuery = "
        SELECT 
            p.purchase_id,
            p.created_at,
            sp.name AS supplier,
            p.ammount
        FROM purchases p
        LEFT JOIN supplier sp ON sp.sp_id = p.supplier
        WHERE $purchaseWhereClause
        ORDER BY p.created_at DESC
    ";

    $purchaseResult = $conn->query($purchaseQuery);
    $totalPurchases = 0;
    $purchases = [];

    if ($purchaseResult) {
        while ($row = $purchaseResult->fetch_assoc()) {
            $amount = (float)$row['ammount'];

            $purchases[] = [
                'date' => $row['created_at'],
                'supplier' => $row['supplier'] ?? 'Unknown',
                'total' => number_format($amount, 2)
            ];

            $totalPurchases += $amount;
        }
    }

    $profit = $totalSales - $totalPurchases;

    $response = [
        'total_sales' => number_format($totalSales, 2),
        'total_purchases' => number_format($totalPurchases, 2),
        'profit' => number_format($profit, 2),
        'transactions' => count($sales) + count($purchases),
        'sales' => $sales,
        'purchases' => $purchases
    ];
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);