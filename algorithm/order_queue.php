<?php
// Include database connection
include '../conn/connection.php';

// Start the session if not already started
session_start();

// Function to assign queued orders to cashier
function assignQueuedOrdersToCashier() {
    global $conn;

    // Fetch queued orders
    $sql_queue = "SELECT * FROM order_queue WHERE status = 'Pending' ORDER BY created_at ASC";
    $result_queue = $conn->query($sql_queue);

    // Check if there are any queued orders
    if ($result_queue && $result_queue->num_rows > 0) {
        while ($order = $result_queue->fetch_assoc()) {
            $customer_name = $order['customer_name'];
            $table_id = $order['table_id'];
            $total_price = $order['total_price'];
            $order_date = date('Y-m-d H:i:s'); // Current order date
            $status = 'Pending'; // Initial status

            // Step 1: Fetch the cashier with the least workload
            $sql_cashier = "
            SELECT c.cashier_id, u.username AS cashier_name, 
                   COUNT(o.order_id) AS workload 
            FROM cashiers c
            LEFT JOIN users u ON c.user_id = u.user_id
            LEFT JOIN orders o ON c.cashier_id = o.cashier_id 
            GROUP BY c.cashier_id 
            ORDER BY workload ASC 
            LIMIT 1";

            $result_cashier = $conn->query($sql_cashier);

            if ($result_cashier && $result_cashier->num_rows > 0) {
                $cashier = $result_cashier->fetch_assoc();
                $cashier_id = $cashier['cashier_id'];
                $cashier_name = $cashier['cashier_name']; // Fetch cashier name

                // Step 2: Insert the new order into orders
                $order_query = "INSERT INTO orders (cashier_id, customer_name, table_id, order_date, total_price, status) 
                                VALUES ('$cashier_id', '$customer_name', '$table_id', '$order_date', '$total_price', '$status')";

                if ($conn->query($order_query) === TRUE) {
                    // Get the last inserted order ID
                    $order_id = $conn->insert_id;

                    // Step 3: Optionally, you can handle items here if you have a way to store them in the queue
                    
                    // Step 4: Update the order_queue status to 'Assigned'
                    $update_queue_status = "UPDATE order_queue SET status = 'Assigned' WHERE queue_id = '{$order['queue_id']}'";
                    $conn->query($update_queue_status);

                    // Store the assigned cashier's name in the session (optional)
                    $_SESSION['last_assigned_cashier'] = $cashier_name;

                    echo "Order for customer $customer_name assigned to cashier: $cashier_name successfully!<br>";
                } else {
                    echo "Error placing order: " . $conn->error . "<br>";
                }
            } else {
                echo "No available cashier found for order from $customer_name.<br>";
            }
        }
    } else {
        echo "No queued orders to assign.";
    }
}

// Call the function to assign queued orders
assignQueuedOrdersToCashier();

// Close connection
$conn->close();
?>
