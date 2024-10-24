<?php
session_start();
include '../conn/connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // Fetch the table ID associated with the order
    $sql = "SELECT table_id FROM orders WHERE order_id = '$order_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $table_id = $order['table_id'];
        error_log("Table ID: $table_id"); // Log the table ID for debugging

        // Update the order status
        $update_order_sql = "UPDATE orders SET status = '$new_status' WHERE order_id = '$order_id'";
        if ($conn->query($update_order_sql) === TRUE) {
            // Check if the new status is 'Completed'
            if ($new_status === 'Completed') {
                // Update the table status to 'available'
                $update_table_sql = "UPDATE tables SET status = 'available' WHERE table_id = '$table_id'";
                if ($conn->query($update_table_sql) === TRUE) {
                    error_log("Table status updated successfully to available."); // Log success
                } else {
                    error_log("Error updating table status: " . $conn->error); // Log error for debugging
                }
            }

            $_SESSION['message'] = "Order status updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating order status: " . $conn->error;
        }
    } else {
        error_log("Order not found or no table associated with this order."); // Log error for debugging
        $_SESSION['error'] = "Order not found.";
    }

    // Redirect back to the previous page (or any desired page)
    header("Location: dashboard.php");
    exit();
}

// Close the connection
$conn->close();
?>
