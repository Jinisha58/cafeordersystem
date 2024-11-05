<?php
include '../conn/connection.php';
 // Include your database connection
 include 'dashboard_flex.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if a form has been submitted to update the table status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table_id'])) {
    $table_id = $_POST['table_id'];
    $new_status = $_POST['new_status'];

    // Update the status in the database
    $update_query = "UPDATE tables SET status = ? WHERE table_id = ?";
    $stmt = $conn->prepare($update_query);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param('si', $new_status, $table_id);
    
    if ($stmt->execute()) {
        // Redirect to the same page to see the updated status
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error updating record: " . $stmt->error; // Display error message
    }

    $stmt->close();
}

// Fetch existing tables for display
$query = "SELECT * FROM tables";
$result = $conn->query($query);
if ($result === false) {
    die("Error fetching tables: " . $conn->error); // Log the error if query fails
}
?>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            text-align: center;
            cursor: pointer;
        }
        .available {
            background-color: #d4edda; /* Light green for available */
            border-color: #c3e6cb; /* Border color for available */
        }
        .occupied {
            background-color: #f8d7da; /* Light red for occupied */
            border-color: #f5c6cb; /* Border color for occupied */
        }
        .booked {
            background-color: #fff3cd; /* Light yellow for booked */
            border-color: #ffeeba; /* Border color for booked */
        }
        .delete-button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            margin-top: 5px;
            text-decoration: none;
        }
    </style>

<div class="container">
    <h4>Manage Tables</h4>
    <form method="post" action="add_table.php" class="mb-4">
        <label for="table_num">Table Number:</label>
        <input type="text" id="table_num" name="table_num" required>
        
        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity" min="1" required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="available">Available</option>
            <option value="occupied">Occupied</option>
            
        </select>

        <input type="submit" value="Add Table" class="btn btn-success">
    </form>

    <h2>Current Tables</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="table-box <?php echo htmlspecialchars($row['status']); ?>">
                        <h4>Table <?php echo htmlspecialchars($row['table_num']); ?></h4>
                        <p>Status: <strong>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="table_id" value="<?php echo $row['table_id']; ?>">
                                <input type="hidden" name="new_status" value="<?php echo $row['status'] === 'available' ? 'occupied' : 'available'; ?>">
                                <button type="submit" class="btn btn-link p-0" style="text-decoration: underline;"><?= ucfirst($row['status']); ?></button>
                            </form>
                        </strong></p>
                        <p>Capacity: <strong><?php echo htmlspecialchars($row['capacity']); ?> seats</strong></p>
                        
                        <br>
                        <a href="delete_table.php?table_id=<?= $row['table_id'] ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this table?');">Delete</a>
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
        </div>

</body>
</html>

<?php
$conn->close();
?>
