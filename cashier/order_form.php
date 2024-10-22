<?php
// Include database connection
include '../conn/connection.php';

// Fetch available tables
$tables_query = "SELECT table_id, table_num FROM tables WHERE status = 'available'";
$tables_result = mysqli_query($conn, $tables_query);

// Fetch menu items
$menu_query = "SELECT item_id, item_name, price FROM menu";
$menu_result = mysqli_query($conn, $menu_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Order Form</title>
    <style>
        .order-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
        }
        .menu-item {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        .menu-item span {
            font-size: 16px;
            font-weight: 500;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
        .form-buttons button {
            width: 48%;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .cancel-btn {
            background-color: #d4edda; 
            border-color: #c3e6cb; 
        }
        .submit-btn {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>

    <script>
        // JavaScript to dynamically calculate total price
        function updateTotal() {
            let total = 0; // Initialize total to 0

            // Get all menu items
            const items = document.querySelectorAll('.menu-item');

            // Iterate through each item to calculate the total
            items.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]'); // Checkbox input
                const quantityInput = item.querySelector('input[type="number"]'); // Quantity input
                const price = parseFloat(checkbox.dataset.price) || 0; // Get price from checkbox

                // If the item is selected and quantity is valid, add to total
                if (checkbox.checked && quantityInput.value) {
                    total += price * parseInt(quantityInput.value);
                }
            });

            // Update the total price field
            document.getElementById('total_price').value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="order-form">
        <h2>Place an Order</h2>
        <form action="process_order.php" method="POST">
            <!-- Customer Name -->
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>
            </div>

            <!-- Table Selection -->
            <div class="form-group">
                <label for="table">Select Table:</label>
                <select name="table_id" required>
                    <option value="">Select Table</option>
                    <?php while ($row = mysqli_fetch_assoc($tables_result)): ?>
                        <option value="<?= $row['table_id']; ?>"><?= $row['table_num']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Menu Items Selection -->
            <div class="form-group">
                <label for="menu_items">Select Menu Items:</label>
                <?php while ($row = mysqli_fetch_assoc($menu_result)): ?>
                    <div class="menu-item">
                        <span><?= $row['item_name']; ?> - $<?= $row['price']; ?></span>
                        <input type="checkbox" 
                               name="items[<?= $row['item_id']; ?>][id]" 
                               value="<?= $row['item_id']; ?>" 
                               data-price="<?= $row['price']; ?>" 
                               onclick="updateTotal()">
                        <input type="number" 
                               name="items[<?= $row['item_id']; ?>][quantity]" 
                               placeholder="Quantity" 
                               min="1" 
                               oninput="updateTotal()" 
                               style="margin-top: 5px;">
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Total Price -->
            <div class="form-group">
                <label for="total_price">Total Price:</label>
                <input type="text" id="total_price" name="total_price" readonly>
            </div>

            <!-- Form Buttons -->
            <div class="form-buttons">
                <button type="submit" class="submit-btn">Place Order</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='index.php';">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
