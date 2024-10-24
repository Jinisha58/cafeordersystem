<?php
// Include your database connection file
include '../conn/connection.php';

// Initialize variables
$totalOrders = $totalTables = $occupiedTables = $availableTables = 0;

// Queries to get data
$totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
$totalTablesQuery = "SELECT COUNT(*) AS total_tables FROM tables";
$occupiedTablesQuery = "SELECT COUNT(*) AS occupied_tables FROM tables WHERE status = 'occupied'";
$availableTablesQuery = "SELECT COUNT(*) AS available_tables FROM tables WHERE status = 'available'";

// Fetch total orders
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
if ($totalOrdersResult) {
    $totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'];
}

// Fetch total tables
$totalTablesResult = mysqli_query($conn, $totalTablesQuery);
if ($totalTablesResult) {
    $totalTables = mysqli_fetch_assoc($totalTablesResult)['total_tables'];
}

// Fetch occupied tables
$occupiedTablesResult = mysqli_query($conn, $occupiedTablesQuery);
if ($occupiedTablesResult) {
    $occupiedTables = mysqli_fetch_assoc($occupiedTablesResult)['occupied_tables'];
}

// Fetch available tables
$availableTablesResult = mysqli_query($conn, $availableTablesQuery);
if ($availableTablesResult) {
    $availableTables = mysqli_fetch_assoc($availableTablesResult)['available_tables'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .dashboard {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            width: 250px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .stat-card h3 {
            color: #555;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 2rem;
            color: #007bff; /* Bootstrap primary color */
            font-weight: bold;
            margin: 0;
        }

        @media (max-width: 600px) {
            .stat-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Cashier Insights</h1>
    <div class="dashboard">
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?php echo $totalOrders; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Tables</h3>
            <p><?php echo $totalTables; ?></p>
        </div>
        <div class="stat-card">
            <h3>Occupied Tables</h3>
            <p><?php echo $occupiedTables; ?></p>
        </div>
        <div class="stat-card">
            <h3>Available Tables</h3>
            <p><?php echo $availableTables; ?></p>
        </div>
    </div>
</body>
</html>
