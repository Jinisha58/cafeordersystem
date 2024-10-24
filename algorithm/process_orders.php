<?php
/*
session_start();

include '../conn/connection.php'; // Include your connection file

include_once 'deque.php'; // Include the Deque class

if (!isset($_SESSION['orderDeque'])) {
    $_SESSION['orderDeque'] = new Deque();
}
$deque = $_SESSION['orderDeque'];

// Fetch all orders with their items, quantities, and total price
$sql = "
    SELECT 
        o.order_id AS order_id, 
        o.customer_name, 
        t.table_num, 
        o.order_date, 
        o.status, 
        m.item_name, 
        oi.quantity, 
        (oi.quantity * m.price) AS item_total,
        SUM(oi.quantity * m.price) OVER (PARTITION BY o.order_id) AS order_total
    FROM orders o
    JOIN tables t ON o.table_id = t.table_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu m ON oi.item_id = m.item_id
    ORDER BY o.order_id, m.item_name";

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);  // Error handling
}

// Create a new Deque instance
$ordersDeque = new Deque();

// Fetch orders and enqueue them to the deque
while ($row = $result->fetch_assoc()) {
    $order = new Order($row['order_id'], $row['customer_name'], $row['item_name'], $row['quantity']);
    $ordersDeque->addRear($order); // Add orders to the rear of the deque
}

// Process orders using the deque
$processing_results = [];

while (!$ordersDeque->isEmpty()) {
    $currentOrder = $ordersDeque->removeFront(); // Process orders from the front
    // Simulate order processing time (e.g., 5 seconds)
    sleep(5); // Simulates processing delay

    $completion_time = date("H:i:s", time());
    $processing_results[] = [
        'order_id' => $currentOrder->order_id,
        'customer_name' => $currentOrder->customer_name,
        'completion_time' => $completion_time,
        'items' => $currentOrder->items,
    ];
}

// Optionally store or use $processing_results as needed
?>
*/


session_start();
include '../conn/connection.php';  
include_once 'deque.php';  

// Initialize the deque in session if not already present
if (!isset($_SESSION['orderDeque'])) {
    $_SESSION['orderDeque'] = new Deque();
}
$ordersDeque = $_SESSION['orderDeque'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Retrieve form data
    $customer_name = $_POST['customer_name'];
    $table_id = $_POST['table_id'];
    $total_price = $_POST['total_price'];

    // 2. Insert new order into the orders table
    $insertOrderQuery = "INSERT INTO orders (customer_name, table_id, total_price, status) 
                         VALUES ('$customer_name', $table_id, $total_price, 'pending')";
    mysqli_query($conn, $insertOrderQuery);
    $order_id = mysqli_insert_id($conn);  // Get the new order ID

    // 3. Insert each menu item into the order_items table
    foreach ($_POST['items'] as $item) {
        $item_id = $item['id'];
        $quantity = $item['quantity'];
        $insertItemQuery = "INSERT INTO order_items (order_id, item_id, quantity) 
                            VALUES ($order_id, $item_id, $quantity)";
        mysqli_query($conn, $insertItemQuery);
    }

    // 4. Create a new Order object and add it to the deque
    $newOrder = new Order($order_id, $customer_name, $item['item_name'], $quantity);
    $ordersDeque->addRear($newOrder);

    // 5. Provide feedback to the user
    header('Location: dashboard.php?message=Order Placed Successfully');
    exit();
}
?>
