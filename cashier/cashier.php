<?php
include('../conn/connection.php'); // Include your database connection

// Handle the order form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = $_POST['customer_name'];
    $tableId = $_POST['table_id'];
    $orderItems = $_POST['order_items']; // This should be an array

    // Prepare and execute your insert statement for the orders table
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, order_items, table_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $customerName, json_encode($orderItems), $tableId);
    
    if ($stmt->execute()) {
        // Update table status to 'occupied' after a successful order placement
        $updateTableStmt = $conn->prepare("UPDATE tables SET status = 'occupied' WHERE id = ?");
        $updateTableStmt->bind_param("i", $tableId);
        $updateTableStmt->execute();

        // Get the newly created order_id
        $orderId = $stmt->insert_id; // This gets the last inserted order ID

        // Set a success message
        $message = "Order placed successfully! Table status updated.";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<?php include('dashboard.php'); ?>

<!-- for alert message -->
<?php if (isset($message)): ?>
    <script>alert("<?php echo htmlspecialchars($message); ?>");</script>
<?php endif; ?>

<?php include('take-order.php'); ?>
