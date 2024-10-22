<!-- Content -->
<div class="content">
<?php
include '../conn/connection.php'; // Include your database connection

// Fetch all tables
$query_tables = "SELECT * FROM tables"; // Fetch all tables
$result_tables = $conn->query($query_tables);

// Fetch menu items
$query_menu = "SELECT * FROM menu"; // Adjust according to your menu table structure
$result_menu = $conn->query($query_menu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier - Take Order</title>
    <style>
        .table-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            cursor: pointer;
            width: 150px;
            text-align: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .available {
            background-color: green;
            color: white;
        }
        .occupied {
            background-color: red;
            color: white;
        }
        .order-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            margin-top: 5px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
        }
        .quantity-control input {
            width: 50px;
            text-align: center;
            margin-left: 5px;
            margin-right: 5px;
        }
        .total-price {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Take Order</h2>

<h3>Select Table</h3>
<div id="tables">
    <?php while ($row = $result_tables->fetch_assoc()): ?>
        <div class="table-box <?= ($row['status'] === 'available') ? 'available' : 'occupied' ?>">
            Table <?= htmlspecialchars($row['table_num']) ?>
            <br>
            <?php if ($row['status'] === 'available'): ?>
                <button class="order-button" onclick="openOrderForm(<?= $row['id'] ?>)">Take Order</button>
            <?php else: ?>
                <span>Occupied</span>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<div id="order-form" style="display:none;">
    <h3>Order Form for Table <span id="table-id"></span></h3>
    <form id="form" method="post" action="process_order.php" onsubmit="return validateOrder()">
        <input type="hidden" name="table_id" id="hidden-table-id">

        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required>

        <label for="menu_items">Select Items</label>
        <div id="menu_items">
    <?php while ($menu_item = $result_menu->fetch_assoc()): ?>
        <div class="menu-item">
            <span>
                <?= htmlspecialchars($menu_item['item_name']) ?> - 
                $<span class="item-price"><?= htmlspecialchars($menu_item['price']) ?></span>
            </span>
            <div class="quantity-control">
                <button type="button" onclick="changeQuantity('<?= htmlspecialchars($menu_item['item_id']) ?>', -1)">-</button>
                
                <!-- Quantity Input -->
                <input type="number" 
                       name="quantities[<?= htmlspecialchars($menu_item['item_id']) ?>]" 
                       value="0" min="0" class="quantity" 
                       id="quantity-<?= htmlspecialchars($menu_item['item_id']) ?>" 
                       onchange="updateTotalPrice()">

                <button type="button" onclick="changeQuantity('<?= htmlspecialchars($menu_item['item_id']) ?>', 1)">+</button>
            </div>
        </div>
    <?php endwhile; ?>
</div>

        <h4 class="total-price">Total Price: $<span id="total-price">0.00</span></h4>

        <input type="submit" value="Submit Order">
        <button type="button" onclick="closeOrderForm()">Cancel</button>
    </form>
</div>

<script>
// Function to change quantity
function changeQuantity(itemId, delta) {
    let quantityInput = document.getElementById('quantity-' + itemId);
    let currentQuantity = parseInt(quantityInput.value) || 0; // Ensure it's a valid number
    let newQuantity = currentQuantity + delta;

    if (newQuantity >= 0) {
        quantityInput.value = newQuantity;
        updateTotalPrice();
    }
}

// Function to update total price based on selected quantities
function updateTotalPrice() {
    let totalPrice = 0;
    let menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(function(item) {
        let price = parseFloat(item.querySelector('.item-price').innerText);
        let quantityInput = item.querySelector('.quantity');
        let quantity = parseInt(quantityInput.value) || 0;

        totalPrice += price * quantity;
    });

    document.getElementById('total-price').innerText = totalPrice.toFixed(2);
}

// Open the order form for a specific table
function openOrderForm(tableId) {
    document.getElementById('order-form').style.display = 'block';
    document.getElementById('table-id').innerText = tableId;
    document.getElementById('hidden-table-id').value = tableId;
}

// Close the order form
function closeOrderForm() {
    document.getElementById('order-form').style.display = 'none';
}

// Validate if at least one item with quantity > 0 is selected before submitting
function validateOrder() {
    let quantities = document.querySelectorAll('.quantity');
    let isValid = Array.from(quantities).some(input => parseInt(input.value) > 0);

    if (!isValid) {
        alert('Please select at least one item with a quantity greater than zero.');
        return false; // Block form submission
    }
    return true; // Allow form submission
}
</script>

</body>
</html>
