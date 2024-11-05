<?php
include '../conn/connection.php'; // Database connection
include 'dashboard_flex.php';
include 'modals.php'; // Include the modals file

// Fetch active orders
$activeSql = "
    SELECT 
        o.order_id AS order_id, 
        o.customer_name, 
        t.table_num, 
        o.order_date, 
        o.status, 
        GROUP_CONCAT(m.item_name SEPARATOR ', ') AS item_names,
        GROUP_CONCAT(oi.quantity SEPARATOR ', ') AS quantities,
        SUM(oi.quantity * m.price) AS order_total
    FROM orders o
    JOIN tables t ON o.table_id = t.table_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu m ON oi.item_id = m.item_id
    WHERE o.status != 'Completed'
    GROUP BY o.order_id, o.customer_name, t.table_num, o.order_date, o.status
    ORDER BY o.order_id";

$completedSql = "
    SELECT 
        o.order_id AS order_id, 
        o.customer_name, 
        t.table_num, 
        o.order_date, 
        o.status, 
        GROUP_CONCAT(m.item_name SEPARATOR ', ') AS item_names,
        GROUP_CONCAT(oi.quantity SEPARATOR ', ') AS quantities,
        SUM(oi.quantity * m.price) AS order_total
    FROM orders o
    JOIN tables t ON o.table_id = t.table_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu m ON oi.item_id = m.item_id
    WHERE o.status = 'Completed'
    GROUP BY o.order_id, o.customer_name, t.table_num, o.order_date, o.status
    ORDER BY o.order_id";

$activeResult = $conn->query($activeSql);
$completedResult = $conn->query($completedSql);

if (!$activeResult || !$completedResult) {
    die("Query Failed: " . $conn->error);  // Error handling
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
</style>

<div class="container mt-5">
    <h2>Customer Orders</h2>

    <!-- Nav tabs for filtering -->
    <ul class="nav nav-tabs" id="orderTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="active-orders-tab" data-toggle="tab" href="#active-orders" role="tab" aria-controls="active-orders" aria-selected="true">Active Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="completed-orders-tab" data-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">Completed Orders</a>
        </li>
    </ul>

    <div class="tab-content" id="orderTabsContent">
        <div class="tab-pane fade show active" id="active-orders" role="tabpanel" aria-labelledby="active-orders-tab">
            <?php if ($activeResult->num_rows > 0): ?>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Table Number</th>
                            <th>Items</th>
                            <th>Quantities</th>
                            <th>Order Total</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php 
            while ($row = $activeResult->fetch_assoc()): 
            ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['table_num']; ?></td>
                    <td><?php echo $row['item_names']; ?></td>
                    <td><?php echo $row['quantities']; ?></td>
                    <td class="text-right"><?php echo number_format($row['order_total'], 2); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td>
                        <span class="badge 
                            <?php 
                                if ($row['status'] == 'Pending') echo 'badge-warning';
                                elseif ($row['status'] == 'In Progress') echo 'badge-primary';
                            ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $row['order_id']; ?>">Edit</button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $row['order_id']; ?>">Delete</button>
                        </div>
                    </td>
                </tr>

                <?php 
                // Render modals for this order
                renderEditModal($row['order_id'], $row['status']);
                renderDeleteModal($row['order_id']);
                ?>
                
            <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No active orders found.</p>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="completed-orders" role="tabpanel" aria-labelledby="completed-orders-tab">
            <?php if ($completedResult->num_rows > 0): ?>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Table Number</th>
                            <th>Items</th>
                            <th>Quantities</th>
                            <th>Order Total</th>
                            <th>Order Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php 
            while ($row = $completedResult->fetch_assoc()): 
            ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['table_num']; ?></td>
                    <td><?php echo $row['item_names']; ?></td>
                    <td><?php echo $row['quantities']; ?></td>
                    <td class="text-right"><?php echo number_format($row['order_total'], 2); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td>
                        <span class="badge badge-success"><?php echo $row['status']; ?></span>
                    </td>
                </tr>
            <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No completed orders found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
$conn->close();
?>
