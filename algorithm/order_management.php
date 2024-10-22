<?php
include 'db_connection.php';
include 'Deque.php';

// Create a global deque instance
$ordersDeque = new Deque($conn);

// Function to assign a table
function assignTable($tableId) {
    global $conn;
    $query = "UPDATE tables SET status = 'occupied' WHERE table_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tableId);
    $stmt->execute();
    $stmt->close();
}

// Function to release a table
function releaseTable($tableId) {
    global $conn;
    $query = "UPDATE tables SET status = 'available' WHERE table_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tableId);
    $stmt->execute();
    $stmt->close();
}

// Function to place an order with table assignment
function placeOrder($order, $tableId) {
    global $ordersDeque, $conn;

    // Assign the table to the order
    assignTable($tableId);

    // Insert the order into the database
    $query = "INSERT INTO orders (customer_name, items, table_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $order['customer_name'], json_encode($order['items']), $tableId);
    $stmt->execute();
    $stmt->close();

    // Load the newly inserted order into the deque
    $order['order_id'] = $conn->insert_id; // Get the newly inserted order ID
    $order['table_id'] = $tableId; // Include the assigned table
    $ordersDeque->addBack($order);
}

// Function to process an order
function processOrder() {
    global $ordersDeque;
    if (!$ordersDeque->isEmpty()) {
        $currentOrder = $ordersDeque->removeFront(); // Process the first order
        // Mark the order as completed in the database
        $ordersDeque->completeOrder($currentOrder['order_id']);
        // Release the assigned table
        releaseTable($currentOrder['table_id']);
        return $currentOrder;
    }
    return null; // No orders to process
}

// Function to get available tables
function getAvailableTables() {
    global $conn;
    $query = "SELECT * FROM tables WHERE status = 'available'";
    $result = $conn->query($query);
    $availableTables = [];
    while ($row = $result->fetch_assoc()) {
        $availableTables[] = $row;
    }
    return $availableTables;
}

// Example usage
$tableId = 1;  // Assuming table ID 1 is available

$order1 = [
    'customer_name' => 'Alice',
    'items' => ['Coffee', 'Sandwich'],
];

// Place the order and assign the table
placeOrder($order1, $tableId);

// Process the next order
$processedOrder = processOrder();
if ($processedOrder) {
    echo "Processing order for " . $processedOrder['customer_name'] . "\n";
}
?>
