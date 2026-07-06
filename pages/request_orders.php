<?php

include("connection.php");
$business = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Requests</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid h-[100%]">
        <div class="flex w-full p-2 bg-yellow-900 justify-between"><h1 class="text-white font-bold text-sm p-1"><i class="bi bi-card-checklist"></i> Pending Requests</h1></div>
        <div class="table-responsive w-full overflow-y-auto my-2">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm"><tr>
                    <th>#</th>
                    <th class="">Customer</th>
                    <th>Phone</th>
                  
                    <th>Items</th>
                    <th>Action</th>
                </tr></thead>
                <tbody>
                    <?php
                    $no = 0;
                    $select = $conn->prepare(
                        "SELECT c.c_id, c.name, c.phone, COUNT(ro.req_ord_id) AS items, SUM(ro.req_quantity) AS total_quantity " .
                        "FROM request_orders ro " .
                        "JOIN customer c ON ro.customer = c.c_id " .
                        "JOIN item i ON ro.req_item = i.id " .
                        "WHERE ro.shop = ? AND ro.allowed_quantity = 0 " .
                        "GROUP BY c.c_id, c.name, c.phone"
                    );
                    $select->bind_param("i", $business);
                    $select->execute();
                    $result = $select->get_result();
                    if ($result->num_rows > 0) {
                        while ($a = $result->fetch_assoc()) {
                            $no++;
                            ?>
                            <?php
                            // fetch latest message for this customer
                            $msg = '';
                            $msgStmt = $conn->prepare("SELECT sender, message, created_at FROM request_messages WHERE shop = ? AND customer = ? ORDER BY created_at DESC LIMIT 1");
                            $msgStmt->bind_param("ii", $business, $a['c_id']);
                            $msgStmt->execute();
                            $mr = $msgStmt->get_result();
                            if ($mr && $mr->num_rows > 0) {
                                $mrow = $mr->fetch_assoc();
                                $msg = htmlspecialchars($mrow['sender'] . ': ' . (strlen($mrow['message'])>80 ? substr($mrow['message'],0,77).'...' : $mrow['message']));
                            }
                            ?>
                            <tr class="border hover:bg-gray-200">
                                <td><?php echo $no ?></td>
                                <td><?php echo htmlspecialchars($a['name']) ?></td>
                                <td><?php echo htmlspecialchars($a['phone']) ?></td>
                               
                                <td><?php echo htmlspecialchars($a['items']) ?></td>
                              
                                <td><a href="approve_request?customer=<?php echo $a['c_id'] ?>" class="text-blue-400 text-xl font-bold rounded p-1 px-2 text-sm"><i class="bi bi-eye"></i></a></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr><td colspan="6" class="text-center p-4 text-gray-500">No pending requests.</td></tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
