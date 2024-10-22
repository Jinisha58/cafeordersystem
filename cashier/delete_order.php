<?php
include '../conn/connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

    // Delete order from order_items table
    $delete_items_query = "DELETE FROM order_items WHERE order_id = '$order_id'";
    mysqli_query($conn, $delete_items_query);

    // Delete order from orders table
    $delete_order_query = "DELETE FROM orderss WHERE order_id = '$order_id'";
    if (mysqli_query($conn, $delete_order_query)) {
        header("Location: customer_orders.php?message=Order deleted successfully&alert=success");
        exit();
    } else {
        header("Location: customer_orders.php?message=Error deleting order: " . mysqli_error($conn) . "&alert=danger");
        exit();
    }
} else {
    header("Location: orders.php?message=Invalid request&alert=danger");
    exit();
}

$conn->close();
?>
