<?php
session_start(); // Start the session
include '../conn/connection.php'; // Include your database connection

// Function to assign order to cashier and insert the order
function assignOrderToCashier($customer_name, $table_id, $menu_items, $total_price) {
    global $conn;

    // Step 1: Fetch the cashier with the least workload
    $sql = "
    SELECT c.cashier_id, u.username AS cashier_name, 
           COUNT(o.order_id) AS workload 
    FROM cashiers c
    LEFT JOIN users u ON c.user_id = u.user_id
    LEFT JOIN orderss o ON c.cashier_id = o.cashier_id 
    WHERE c.status = 'available'
    GROUP BY c.cashier_id 
    ORDER BY workload ASC 
    LIMIT 1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $cashier = $result->fetch_assoc();
        $cashier_id = $cashier['cashier_id'];
        $cashier_name = $cashier['cashier_name']; // Fetch cashier name

        // Step 2: Insert the new order
        $order_date = date('Y-m-d H:i:s');
        $status = 'Pending';
        $order_query = "INSERT INTO orderss (cashier_id, customer_name, table_id, order_date, total_price, status) 
                        VALUES ('$cashier_id', '$customer_name', '$table_id', '$order_date', '$total_price', '$status')";

        if ($conn->query($order_query) === TRUE) {
            // Get the last inserted order ID
            $order_id = $conn->insert_id; 

            // Step 3: Insert each menu item into the order_items table
            foreach ($menu_items as $item) {
                $item_id = $item['id'];
                $quantity = $item['quantity'];

                if ($quantity > 0) {
                    // Insert into order_items
                    $sql = "INSERT INTO order_items (item_id, order_id, quantity) 
                            VALUES ('$item_id', '$order_id', '$quantity')";
                    $conn->query($sql);
                }
            }

            // Step 4: Update the table status to 'occupied'
            $update_table_status = "UPDATE tables SET status = 'occupied' WHERE table_id = '$table_id'";
            mysqli_query($conn, $update_table_status);

            // Store the assigned cashier's name in the session
            $_SESSION['last_assigned_cashier'] = $cashier_name;
            echo "Order assigned to cashier: $cashier_name successfully!";
        } else {
            echo "Error placing order: " . $conn->error;
        }
    } else {
        // No cashiers are available, put the order in the queue
        $queue_query = "INSERT INTO order_queue (customer_name, table_id, total_price, order_date) 
                        VALUES ('$customer_name', '$table_id', '$total_price', NOW())";
        
        // Execute the queue query
        if (mysqli_query($conn, $queue_query)) {
            echo "Order placed in queue successfully!";
        } else {
            echo "Error adding order to queue: " . mysqli_error($conn);
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name']; // Get customer name
    $table_id = $_POST['table_id']; // Get selected table ID
    $total_price = $_POST['total_price']; // Get total price
    $menu_items = []; // Initialize an array to hold selected menu items

    // Loop through selected items
    foreach ($_POST['items'] as $item_id => $item) {
        $quantity = isset($item['quantity']) ? intval($item['quantity']) : 0; // Get quantity
        if ($quantity > 0) {
            $menu_items[] = ['id' => $item_id, 'quantity' => $quantity]; // Add to menu items array
        }
    }

    // Call the function to assign the order to a cashier
    assignOrderToCashier($customer_name, $table_id, $menu_items, $total_price);
}

// Close connection
mysqli_close($conn);
?>
