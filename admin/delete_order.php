<?php
include '../conn/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?status=deleted");
        exit();
    } else {
        header("Location: dashboard.php?status=error");
        exit();
    }
}
?>
