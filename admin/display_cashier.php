<?php
session_start(); // Start the session
include '../conn/connection.php'; // Include your database connection file

// Fetch cashier details from the cashiers table
$query = "SELECT cashiers.cashier_id, users.username AS cashier_name, users.email, cashiers.shift FROM cashiers JOIN users ON cashiers.user_id = users.user_id";
$result = $conn->query($query);

// Handle delete action if the request is made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare the delete query
    $delete_query = "DELETE FROM cashiers WHERE cashier_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        // Successfully deleted, redirect or display a success message
        echo "<script>alert('Cashier deleted successfully.'); window.location.href='display_cashier.php';</script>";
    } else {
        echo "<script>alert('Error deleting cashier.');</script>";
    }
    
    $stmt->close(); // Close the statement
}
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
            background-color: #f4f4f4; /* Subtle background color */
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
            background-color: #ffffff; /* White table background */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
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
        .register-link {
            text-align: center;
            margin: 20px;
        }
        .register-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold; 
        }
        .register-link a:hover {
            text-decoration: underline;
            color: #0056b3; 
        }
        .btn-danger {
            background-color: #dc3545; 
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333; 
            border-color: #bd2130; 
        }
    </style>
</head>
<body>

<h2>List of Cashiers</h2>

<table border="1" class="table table-bordered table-striped">
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
                        <a href='?delete_id={$row['cashier_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this cashier?\");'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No cashiers found</td></tr>";
    }
    ?>
</table>

<div class="register-link">
    <p><a href="register_cashier.php">Register New Cashier</a></p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
