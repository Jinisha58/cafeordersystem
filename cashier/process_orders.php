<?php
include '../conn/connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $customerName = $_POST['customer_name'];
    $tableId = $_POST['table_id'];
    $quantities = $_POST['quantities']; // Array of quantities from form
    
    // Calculate total price
    $totalPrice = 0;
    
    // Prepare menu items to be inserted
    $orderItems = array();
    foreach ($quantities as $menu_id => $quantity) {
        if ($quantity > 0) {
            // Fetch menu item price from database
            $query = "SELECT price FROM menu WHERE menu_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $menu_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $menuItem = $result->fetch_assoc();
            $itemPrice = $menuItem['price'];
            
            // Calculate price for the item
            $totalPrice += $itemPrice * $quantity;
            
            // Store in orderItems array
            $orderItems[] = array(
                'menu_id' => $menu_id,
                'quantity' => $quantity,
                'item_price' => $itemPrice
            );
        }
    }

    // Prepare and execute the insert query for customers (without contact)
    $customer_query = "INSERT INTO customers (customer_name) VALUES (?)"; // Removed customer_contact
    $customer_stmt = $conn->prepare($customer_query);
    $customer_stmt->bind_param("s", $customerName); // Adjusted bind_param accordingly

    if ($customer_stmt->execute()) {
        $customer_id = $customer_stmt->insert_id; // Get the last inserted customer ID
        
        // Insert into orders table
        $query = "INSERT INTO orders (customer_id, table_id, total_price) VALUES (?, ?, ?)"; // Adjusted to use customer_id
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iid", $customer_id, $tableId, $totalPrice);
        
        if ($stmt->execute()) {
            // Get the last inserted order ID
            $orderId = $conn->insert_id;
            
            // Insert each menu item into order_items table
            foreach ($orderItems as $item) {
                $query = "INSERT INTO order_items (order_id, menu_id, quantity, item_price) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiid", $orderId, $item['menu_id'], $item['quantity'], $item['item_price']);
                $stmt->execute();
            }
            
            // Update table status to 'occupied'
            $query = "UPDATE tables SET status = 'occupied' WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $tableId);
            $stmt->execute();
            
            // Redirect or show success message
            header("Location: cashier.php?message=Order placed successfully! Table status updated.");
            exit();
        } else {
            echo "Error placing order: " . $stmt->error;
        }
    } else {
        echo "Error registering customer: " . $customer_stmt->error;
    }

    $customer_stmt->close();
}

$conn->close();
?>
