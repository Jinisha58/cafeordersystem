<?php
// Include database connection
include '../conn/connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the customer name, table ID, and total price from the form
    $customer_name = $_POST['customer_name'];
    $table_id = $_POST['table_id'];
    $total_price = $_POST['total_price'];

    // Insert the order into the orders table
    $order_query = "INSERT INTO orderss (customer_name, table_id, total_price, order_date) VALUES (?, ?, ?, NOW())"; // Ensure 'orders' is the correct table name
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param("sid", $customer_name, $table_id, $total_price);

    if ($stmt->execute()) {
        // Get the last inserted order ID
        $order_id = $stmt->insert_id; // Using prepared statement's insert_id

        // Insert ordered items into the order_items table
        if (isset($_POST['items'])) {
            foreach ($_POST['items'] as $item) {
                if (isset($item['id']) && isset($item['quantity'])) {
                    $item_id = $item['id'];
                    $quantity = (int)$item['quantity']; // Ensure quantity is an integer

                    $order_item_query = "INSERT INTO order_items (order_id, item_id, quantity) VALUES (?, ?, ?)";
                    $item_stmt = $conn->prepare($order_item_query);
                    $item_stmt->bind_param("iii", $order_id, $item_id, $quantity);
                    $item_stmt->execute();
                }
            }
        }

        // Update table status to 'occupied'
        $update_table_query = "UPDATE tables SET status = 'occupied' WHERE table_id = ?";
        $update_stmt = $conn->prepare($update_table_query);
        $update_stmt->bind_param("i", $table_id);
        $update_stmt->execute();

        // Redirect to customer_orders.php after processing the order
        header("Location: customer_orders.php?message=Order placed successfully&alert=success");
        exit();
    } else {
        echo "Error: Unable to place the order.";
    }
}

// Close the connection
$conn->close();
?>
