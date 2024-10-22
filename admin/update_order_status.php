
<?php
include '../conn/connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $table_num = $_POST['table_id']; // Get the table number
    $new_status = $_POST['status'];

    // Update order status
    $update_order_sql = "UPDATE orderss SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_order_sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        // If status is 'Completed', set the table to 'Available'
        if ($new_status === 'Completed') {
            $update_table_sql = "UPDATE tables SET status = 'Available' WHERE table_num = ?";
            $stmt_table = $conn->prepare($update_table_sql);
            $stmt_table->bind_param("i", $table_num);
            $stmt_table->execute();
        }

        // Redirect with success message
        header("Location: dashboard.php?message=Order+status+updated+successfully&alert=success");
    } else {
        // Redirect with error message
        header("Location: dashboard.php?message=Error+updating+status&alert=danger");
    }

    $stmt->close();
    $conn->close();
}
?>
