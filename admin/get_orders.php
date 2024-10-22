<?php
include '../conn/connection.php';

if (isset($_GET['table_id'])) {
    $tableId = intval($_GET['table_id']);
    $query = "SELECT * FROM orders WHERE table_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tableId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h3>Orders for Table ID: $tableId</h3><ul>";
        while ($order = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($order['order_details']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No orders found for this table.";
    }
}
