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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .menu-item {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        .menu-item span {
            font-size: 16px;
            font-weight: 500;
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
<div class="container mt-5">
    <h2>Place an Order</h2>
    <form action="order_process.php" method="POST">
        <!-- Customer Name -->
        <div class="form-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>

        <!-- Table Selection -->
        <div class="form-group">
            <label for="table">Select Table:</label>
            <select class="form-control" name="table_id" required>
                <option value="">Select Table</option>
                <?php while ($row = mysqli_fetch_assoc($tables_result)): ?>
                    <option value="<?= $row['table_id']; ?>">Table <?= $row['table_num']; ?></option>
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
                           style="margin-top: 5px;" 
                           class="form-control">
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Total Price -->
        <div class="form-group">
            <label for="total_price">Total Price:</label>
            <input type="text" class="form-control" id="total_price" name="total_price" readonly>
        </div>

        <!-- Form Buttons -->
        <button type="submit" class="btn btn-primary">Place Order</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php';">Cancel</button>
    </form>
</div>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
