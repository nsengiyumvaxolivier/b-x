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
        'total_sales_count' => 0,
        'total_purchases_count' => 0,
        'total_debit' => '0.00',
        'total_items_sold' => 0,
        'sales_by_item' => [],
        'purchase_by_item' => []
    ]);
    exit();
}

$filter = $_POST['filter'] ?? 'today';
$from = $_POST['from'] ?? null;
$to = $_POST['to'] ?? null;

$conditions = ["s.business = '$business_id'"];
$purchaseConditions = ["p.business = '$business_id'"];

if ($filter === 'today') {
    $conditions[] = "DATE(s.salles_date) = CURDATE()";
    $purchaseConditions[] = "DATE(p.created_at) = CURDATE()";
} elseif ($filter === 'week') {
    $conditions[] = "YEARWEEK(s.salles_date, 1) = YEARWEEK(CURDATE(), 1)";
    $purchaseConditions[] = "YEARWEEK(p.created_at, 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter === 'month') {
    $conditions[] = "MONTH(s.salles_date) = MONTH(CURDATE()) AND YEAR(s.salles_date) = YEAR(CURDATE())";
    $purchaseConditions[] = "MONTH(p.created_at) = MONTH(CURDATE()) AND YEAR(p.created_at) = YEAR(CURDATE())";
} elseif ($filter === 'year') {
    $conditions[] = "YEAR(s.salles_date) = YEAR(CURDATE())";
    $purchaseConditions[] = "YEAR(p.created_at) = YEAR(CURDATE())";
} elseif ($filter === 'custom' && $from && $to) {
    $conditions[] = "DATE(s.salles_date) BETWEEN '$from' AND '$to'";
    $purchaseConditions[] = "DATE(p.created_at) BETWEEN '$from' AND '$to'";
}

$whereSales = implode(' AND ', $conditions);
$wherePurchases = implode(' AND ', $purchaseConditions);

$response = [
    'total_sales_count' => 0,
    'total_purchases_count' => 0,
    'total_debit' => '0.00',
    'total_items_sold' => 0,
    'sales_by_item' => [],
    'purchase_by_item' => []
];

try {
    $salesByItemQuery = "
        SELECT 
            i.item_name,
            SUM(si.ord_quantity) AS quantity_sold,
            SUM(si.ord_quantity * si.discount) AS total_discount,
            SUM(si.ord_quantity * si.price) AS total_amount,
            SUM(si.ord_quantity * i.out_price) AS total_out_price,
            MAX(i.quantity) AS left_stock
        FROM salles_item si
        JOIN salles s ON s.sale_id = si.sale
        JOIN item i ON i.id = si.product
        WHERE $whereSales
        GROUP BY i.id, i.item_name
        ORDER BY quantity_sold DESC
    ";

    $salesByItemResult = $conn->query($salesByItemQuery);
    $totalItemsSold = 0;

    if ($salesByItemResult) {
        while ($row = $salesByItemResult->fetch_assoc()) {
            $row['quantity_sold'] =$row['quantity_sold'];
            $row['total_discount'] =$row['total_discount'];
            $row['total_amount'] = $row['total_amount'];
            $row['left_stock'] = $row['left_stock'];

            $totalItemsSold += $row['quantity_sold'];
            $response['sales_by_item'][] = $row;
        }
    }

    $purchaseByItemQuery = "
        SELECT
            i.item_name,
            SUM(pi.quantity) AS quantity_purchased,
            SUM(pi.quantity * pi.in_price) AS total_in_cost,
            SUM(pi.quantity * pi.out_price) AS total_out_cost,
            MAX(i.quantity) AS left_stock
        FROM purchase_items pi
        JOIN purchases p ON p.purchase_id = pi.purchase
        JOIN item i ON i.id = pi.item
        WHERE $wherePurchases
        GROUP BY i.id, i.item_name
        ORDER BY quantity_purchased DESC
    ";

    $purchaseByItemResult = $conn->query($purchaseByItemQuery);

    if ($purchaseByItemResult) {
        while ($row = $purchaseByItemResult->fetch_assoc()) {
            $row['quantity_purchased'] =$row['quantity_purchased'];
            $row['total_in_cost'] =$row['total_in_cost'];
            $row['total_out_cost'] =$row['total_out_cost'];
            $row['left_stock'] =$row['left_stock'];

            $response['purchase_by_item'][] = $row;
        }
    }

    $salesCountQuery = "
        SELECT COUNT(DISTINCT s.sale_id) AS sales_count, COALESCE(SUM(s.debit), 0) AS total_debit
        FROM salles s
        WHERE $whereSales
    ";
    $salesCountResult = $conn->query($salesCountQuery);
    if ($salesCountResult) {
        $row = $salesCountResult->fetch_assoc();
        $response['total_sales_count'] =$row['sales_count'];
        $response['total_debit'] =$row['total_debit'];
    }

    $purchaseCountQuery = "
        SELECT COUNT(DISTINCT p.purchase_id) AS purchases_count
        FROM purchases p
        WHERE $wherePurchases
    ";
    $purchaseCountResult = $conn->query($purchaseCountQuery);
    if ($purchaseCountResult) {
        $row = $purchaseCountResult->fetch_assoc();
        $response['total_purchases_count'] = (int)$row['purchases_count'];
    }

    $response['total_items_sold'] = $totalItemsSold;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);