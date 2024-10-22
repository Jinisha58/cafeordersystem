<?php
include '../conn/connection.php'; // Database connection

// Fetch all orders with their items, quantities, and total price, including cashier name
$sql = "
    SELECT 
        o.order_id AS order_id, 
        o.customer_name, 
        t.table_num, 
        o.order_date, 
        o.status, 
        m.item_name, 
        oi.quantity, 
        (oi.quantity * m.price) AS item_total,
        SUM(oi.quantity * m.price) OVER (PARTITION BY o.order_id) AS order_total,
        c.cashier_name AS cashier_name  -- Fetch cashier name
    FROM orderss o
    JOIN tables t ON o.table_id = t.table_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu m ON oi.item_id = m.item_id
    JOIN cashiers c ON o.cashier_id = c.cashier_id  -- Ensure IDs match
    ORDER BY o.order_id, m.item_name";

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);  // Error handling
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
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
                    <th>Item Total ($)</th>
                    <th>Order Total ($)</th>
                    <th>Order Date</th>
                    <th>Order By</th> 
                    <th>Status</th>
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
                                <td class='text-right'>$" . number_format($orderTotal, 2) . "</td>
                              </tr>";
                    }
                    $currentOrderId = $row['order_id'];
                    $orderTotal = $row['order_total'];
                }
            ?>
                <tr>
                    <td><?php echo $isNewOrder ? $row['order_id'] : ''; ?></td>
                    <td><?php echo $isNewOrder ? $row['customer_name'] : ''; ?></td>
                    <td><?php echo $isNewOrder ? $row['table_num'] : ''; ?></td>
                    <td><?php echo $row['item_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td class="text-right">$<?php echo number_format($row['item_total'], 2); ?></td>
                    <td class="text-right"><?php echo $isNewOrder ? "$" . number_format($row['order_total'], 2) : ''; ?></td>
                    <td><?php echo $isNewOrder ? $row['order_date'] : ''; ?></td>
                    <td><?php echo $isNewOrder ? $row['cashier_name'] : ''; ?></td> <!-- Display Cashier Name -->
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

                    <td>
                        <?php if ($isNewOrder): ?>
                            <div class="btn-group" role="group">
                                <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $row['order_id']; ?>">Edit</button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $row['order_id']; ?>">Delete</button>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Modal for Editing Status -->
                <div class="modal fade" id="editModal<?php echo $row['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['order_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?php echo $row['order_id']; ?>">Edit Order Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="update_order_status.php">
                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                <div class="form-group">
                                    <label for="status">Select New Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="In Progress" <?php if ($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                    </select>       
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal for Deleting Order -->
                <div class="modal fade" id="deleteModal<?php echo $row['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $row['order_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row['order_id']; ?>">Delete Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="delete_order.php">
                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this order?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="delete_order" class="btn btn-danger">Delete Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

            <!-- Last order's total row -->
            <tr>
                <td colspan="9" class="text-right font-weight-bold">Total Order Price:</td>
                <td class="text-right">$<?php echo number_format($orderTotal, 2); ?></td>
            </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
