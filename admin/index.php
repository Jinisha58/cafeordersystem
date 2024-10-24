<!-- index.php -->
<div class="section" id="tables" style="display: none;">
    <?php include('admin_tables.php'); ?> <!-- Include the table management content here -->
</div>

<div class="section" id="menu" style="display: none;">
    <h2>Menu Items</h2>
    <a href="add_menu.php">
        <button onclick="addMenuItem()">Add Menu Item</button>
    </a>
    <?php include('manage-menu.php'); ?> <!-- Include the menu management content here -->
</div>

<div class="section" id="customers" style="display: none;">
    <h2>Manage Customers</h2>
    <!-- Add customer management content here -->
     <?php include('customer_orders.php'); ?>
</div>


<div class="section" id="cashiers" style="display: none;">
    <!-- Add cashier management content here -->
<?php include ('display_cashier.php'); ?>

</div>

