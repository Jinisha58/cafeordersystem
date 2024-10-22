<?php
session_start(); // Start the session
include '../conn/connection.php'; // Include your database connection

// Fetch cashier details from the cashiers table
$query = "SELECT cashiers.cashier_id, users.username AS cashier_name, users.email, cashiers.shift, cashiers.status 
          FROM cashiers 
          JOIN users ON cashiers.user_id = users.user_id";
$result = $conn->query($query);

// Fetch all assigned cashiers from the orders table
$assigned_cashiers_query = "SELECT DISTINCT c.cashier_id, u.username AS cashier_name 
                             FROM orderss o 
                             JOIN cashiers c ON o.cashier_id = c.cashier_id 
                             JOIN users u ON c.user_id = u.user_id";

$assigned_cashiers_result = $conn->query($assigned_cashiers_query);

// Fetch the latest assigned cashier from the orders table
$latest_cashier_query = "SELECT u.username AS cashier_name 
                          FROM orderss o 
                          JOIN cashiers c ON o.cashier_id = c.cashier_id 
                          JOIN users u ON c.user_id = u.user_id 
                          ORDER BY o.order_date DESC 
                          LIMIT 1";

$latest_cashier_result = $conn->query($latest_cashier_query);
$latest_cashier = ($latest_cashier_result && $latest_cashier_result->num_rows > 0) 
                  ? $latest_cashier_result->fetch_assoc()['cashier_name'] 
                  : "None";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Cashiers</title>
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
</head>
<body>

<h2>List of Assigned Cashiers</h2>

<p style="text-align:center; font-weight: bold;">
    Assigned Cashiers: 
    <?php 
    if ($assigned_cashiers_result->num_rows > 0) {
        while ($row = $assigned_cashiers_result->fetch_assoc()) {
            echo $row['cashier_name'] . " (ID: " . $row['cashier_id'] . ") ";
        }
    } else {
        echo "None";
    }
    ?><br>
    Latest Cashier from Orders: <?php echo $latest_cashier; ?>
</p>

<table border="1" class="table table-bordered table-striped">
    <tr>
        <th>Cashier ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Shift</th>
        <th>Status</th>
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
                    <td>{$row['status']}</td>
                    <td>
                        <a href='?delete_id={$row['cashier_id']}' class='btn btn-danger btn-sm' 
                           onclick='return confirm(\"Are you sure you want to delete this cashier?\");'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No cashiers found</td></tr>";
    }
    ?>
</table>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
