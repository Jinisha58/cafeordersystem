<?php
session_start(); // Start the session
include '../conn/connection.php'; // Include your database connection

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
                   COUNT(o.order_id) AS workload, c.status 
            FROM cashiers c
            LEFT JOIN users u ON c.user_id = u.user_id
            LEFT JOIN orderss o ON c.cashier_id = o.cashier_id 
            WHERE c.status = 'available' 
            GROUP BY c.cashier_id 
            ORDER BY workload ASC 
            LIMIT 1";

            $result_cashier = $conn->query($sql_cashier);

            if ($result_cashier && $result_cashier->num_rows > 0) {
                $cashier = $result_cashier->fetch_assoc();
                $cashier_id = $cashier['cashier_id'];
                $cashier_name = $cashier['cashier_name']; // Fetch cashier name

                // Step 2: Insert the new order into orderss
                $order_query = "INSERT INTO orderss (cashier_id, customer_name, table_id, order_date, total_price, status) 
                                VALUES ('$cashier_id', '$customer_name', '$table_id', '$order_date', '$total_price', '$status')";

                if ($conn->query($order_query) === TRUE) {
                    // Step 3: Check current status before updating
                    $check_cashier_status = "SELECT status FROM cashiers WHERE cashier_id = '$cashier_id'";
                    $check_result = $conn->query($check_cashier_status);
                    if ($check_result && $check_result->num_rows > 0) {
                        $status_row = $check_result->fetch_assoc();
                        echo "Current status before update: " . $status_row['status'] . "<br>";
                    }

                    // Step 4: Update cashier status
                    $update_cashier_status = "UPDATE cashiers SET status = 'busy' WHERE cashier_id = '$cashier_id'";
                    if ($conn->query($update_cashier_status) === TRUE) {
                        echo "Cashier status updated successfully.<br>";
                    } else {
                        echo "Error updating cashier status: " . $conn->error . "<br>";
                    }

                    // Step 5: Confirm the update
                    $updated_cashier_result = $conn->query($check_cashier_status);
                    if ($updated_cashier_result && $updated_cashier_result->num_rows > 0) {
                        $updated_status_row = $updated_cashier_result->fetch_assoc();
                        echo "Updated status: " . $updated_status_row['status'] . "<br>";
                    }

                    // Step 6: Update the order_queue status to 'Assigned'
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
