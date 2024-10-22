<?php
include '../conn/connection.php';

// Check if the form data is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_id = $_POST['table_id'];
    $customer_name = $_POST['customer_name'];
    $menu_items = $_POST['menu_items']; // This will be an array of selected item IDs
    $total_price = $_POST['total_price']; // Get the total price from the form
    $order_date = date("Y-m-d H:i:s"); // Get the current date and time

    // Prepare to insert the order into the orders table
    $sql_order = "INSERT INTO orders (customer_name, table_id, total_price, order_date) VALUES (?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("sids", $customer_name, $table_id, $total_price, $order_date); // Notice the 'd' for double

    // Execute the order insert
    if ($stmt_order->execute()) {
        // Get the last inserted order ID
        $order_id = $stmt_order->insert_id;

        // Insert order items into the order_items table
        $sql_order_item = "INSERT INTO order_items (order_id, item_id) VALUES (?, ?)";
        $stmt_order_item = $conn->prepare($sql_order_item);

        foreach ($menu_items as $item_id) {
            $stmt_order_item->bind_param("ii", $order_id, $item_id);
            $stmt_order_item->execute();
        }

        // Update the table status to 'occupied'
        $sql_update_table = "UPDATE tables SET status = 'occupied' WHERE id = ?";
        $stmt_update_table = $conn->prepare($sql_update_table);
        $stmt_update_table->bind_param("i", $table_id);
        $stmt_update_table->execute();

        // Success message
        echo "Order placed successfully for Table " . $table_id;
    } else {
        // Error handling
        echo "Error: " . $stmt_order->error;
    }

    // Close the prepared statements
    $stmt_order->close();
    $stmt_order_item->close();
    $stmt_update_table->close();
}

// Close the database connection
$conn->close();
?>
