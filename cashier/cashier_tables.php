<?php
include '../conn/connection.php';

// Fetch tables from the database
$sql = "SELECT table_id, table_num, status, capacity FROM tables";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Table View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            text-align: center;
        }
        .available {
            background-color: #d4edda; /* Light green for available */
            border-color: #c3e6cb;
        }
        .occupied {
            background-color: #f8d7da; /* Light red for occupied */
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Tables</h2>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="table-box <?php echo ($row['status'] == 'available') ? 'available' : 'occupied'; ?>">
                        <h4>Table <?php echo $row['table_num']; ?></h4>
                        <p>Status: <?php echo ucfirst($row['status']); ?></p>
                        <p>Capacity: <?php echo $row['capacity']; ?> seats</p>
                        <?php if ($row['status'] == 'available'): ?>
                            <form method="POST" action="order_form.php">
                                <input type="hidden" name="table_id" value="<?php echo $row['table_id']; ?>">
                                <button type="submit" class="btn btn-primary">Take Order</button>
                            </form>
                        <?php else: ?>
                            <span class="text-danger">Occupied</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="text-center">No tables found</div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
