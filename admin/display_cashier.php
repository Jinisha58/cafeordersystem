<?php
include '../conn/connection.php'; // Include your database connection
include 'dashboard_flex.php';

// Fetch cashier details from the cashiers table
$query = "SELECT cashiers.cashier_id, users.username AS cashier_name, users.email, cashiers.shift 
          FROM cashiers 
          JOIN users ON cashiers.user_id = users.user_id";
$result = $conn->query($query);
?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f4f4f4;
    }
    h2 {
        text-align: center;
        margin-top: 20px;
        color: #343a40;
    }
    table {
        margin: 20px auto;
        width: 90%;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }
    th, td {
        padding: 10px;
        text-align: center;
    }
    th {
        background-color: #838F9E;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #e9ecef;
    }
</style>

<h2>List of Cashiers</h2>

<!-- Link to register a new cashier -->
<div class="text-center mb-3">
    <a href="register_cashier.php" class="btn btn-success">Register New Cashier</a>
</div>

<table class="table table-bordered table-striped">
    <tr>
        <th>Cashier ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Shift</th>
        <th>Action</th>
    </tr>
    <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['cashier_id']}</td>
                <td>{$row['cashier_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['shift']}</td>
                <td>
                    <a href='delete_cashier.php?delete_id={$row['cashier_id']}' 
                       class='btn btn-danger btn-sm' 
                       onclick='return confirm(\"Are you sure you want to delete this cashier?\");'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No cashiers found</td></tr>";
}
?>

</table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
