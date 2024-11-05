<?php
include '../conn/connection.php'; // Database connection

// Fetch all orders with their items, quantities, and total price
    $sql = "
    SELECT 
        o.order_id AS order_id, 
        o.customer_name, 
        t.table_num, 
        o.order_date, 
        o.status, 
        m.item_name, 
        oi.item_id,  -- Add item_id here
        oi.quantity, 
        (oi.quantity * m.price) AS item_total,
        SUM(oi.quantity * m.price) OVER (PARTITION BY o.order_id) AS order_total
    FROM orders o
    JOIN tables t ON o.table_id = t.table_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu m ON oi.item_id = m.item_id
    ORDER BY o.order_id, m.item_name";

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);  // Error handling
}

// Fetch historical data for forecasting
$forecastSql = "
    SELECT 
        oi.item_id, 
        SUM(oi.quantity) AS total_quantity, 
        DATE(o.order_date) AS order_date 
    FROM 
        orders o 
    JOIN 
        order_items oi ON o.order_id = oi.order_id 
    GROUP BY 
        oi.item_id, DATE(o.order_date) 
    ORDER BY 
        order_date DESC
";

$forecastResult = $conn->query($forecastSql);

$forecastData = [];
if ($forecastResult && $forecastResult->num_rows > 0) {
    while ($row = $forecastResult->fetch_assoc()) {
        $forecastData[$row['item_id']][] = [
            'date' => $row['order_date'],
            'quantity' => $row['total_quantity']
        ];
    }
}

$forecastResults = [];
foreach ($forecastData as $itemId => $data) {
    $totalQuantity = 0;
    $count = count($data);

    // Calculate the total quantity for the last n days (e.g., last 7 days)
    for ($i = 0; $i < min(7, $count); $i++) {
        $totalQuantity += $data[$i]['quantity'];
    }

    // Calculate the average quantity
    $averageQuantity = $totalQuantity / min(7, $count);

    // Forecast for the next day
    $forecastResults[$itemId] = round($averageQuantity);
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

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Table Number</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Item Total</th>
                    <th>Order Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Forecast Quantity</th> <!-- New Column -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
$currentOrderId = null;
while ($row = $result->fetch_assoc()): 
    $isNewOrder = $currentOrderId !== $row['order_id'];
    if ($isNewOrder) {
        if ($currentOrderId !== null) {
            // Close previous order group with total row
            echo "<tr>
                    <td colspan='9' class='text-right font-weight-bold'>Total Order Price:</td>
                    <td class='text-right'>" . number_format($orderTotal, 2) . "</td>
                  </tr>";
        }
        $currentOrderId = $row['order_id'];
        $orderTotal = $row['order_total'];
    }
    
    // Get the forecasted quantity for the item
    $forecastQuantity = isset($forecastResults[$row['item_id']]) ? $forecastResults[$row['item_id']] : 0;
?>
<tr>
    <td><?php echo $isNewOrder ? $row['order_id'] : ''; ?></td>
    <td><?php echo $isNewOrder ? $row['customer_name'] : ''; ?></td>
    <td><?php echo $isNewOrder ? $row['table_num'] : ''; ?></td>
    <td><?php echo $row['item_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td class="text-right"><?php echo number_format($row['item_total'], 2); ?></td>
    <td class="text-right"><?php echo $isNewOrder ? number_format($orderTotal, 2) : ''; ?></td>
    <td><?php echo $isNewOrder ? $row['order_date'] : ''; ?></td>
    <td>
        <?php if ($isNewOrder): ?>
            <span class="badge 
                <?php 
                    if ($row['status'] == 'Pending') echo 'badge-warning';
                    elseif ($row['status'] == 'In Progress') echo 'badge-primary';
                    elseif ($row['status'] == 'Completed') echo 'badge-success';
                ?>">
                <?php echo $row['status']; ?>
            </span>
        <?php endif; ?>
    </td>
    <td class="text-right"><?php echo $forecastQuantity; ?></td> <!-- New Column Data -->
    <td>
        <?php if ($isNewOrder): ?>
            <div class="btn-group" role="group">
                <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $row['order_id']; ?>">Edit</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $row['order_id']; ?>">Delete</button>
            </div>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>

<!-- After the loop -->
<?php if ($currentOrderId !== null): ?>
    <tr>
        <td colspan='9' class='text-right font-weight-bold'>Total Order Price:</td>
        <td class='text-right'><?php echo number_format($orderTotal, 2); ?></td>
    </tr>
<?php endif; ?>
</tbody>
</table>
<?php else: ?>
    <p>No orders found.</p>
<?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
