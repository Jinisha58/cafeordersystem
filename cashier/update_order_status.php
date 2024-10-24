<?php
/*
include '../conn/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        header("Location: customer_orders.php?status=success");
        exit();
    } else {
        header("Location: customer_orders.php?status=error");
        exit();
    }
}
?>*/

include '../conn/connection.php'; // Database connection

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $table_status = $_POST['table_status']; // Get the new table status from the form

    // Update the order status
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();

    // Update the table status based on the new order status
    if ($status == 'Completed') {
        $table_status = 'Available'; // Table can be marked as available after completion
    } elseif ($status == 'Pending') {
        $table_status = 'Occupied'; // Table is still occupied
    }

    $sqlUpdateTable = "UPDATE tables SET status = ? WHERE table_id = (SELECT table_id FROM orders WHERE order_id = ?)";
    $stmt = $conn->prepare($sqlUpdateTable);
    $stmt->bind_param("si", $table_status, $order_id);
    $stmt->execute();

    // Redirect or show success message
    header("Location: dashboard.php?success=Order status updated successfully.");
    exit();
}
?>

