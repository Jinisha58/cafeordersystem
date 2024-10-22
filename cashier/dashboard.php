<!-- dashboard.php -->
<?php
session_start();

// Check if the user is logged in as an cashier
if (!isset($_SESSION['cashier_id']) || $_SESSION['role'] !== 'cashier') {
        // Redirect to login page if not logged in or not an cashier
    header("Location: ../view/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Order System - Cashier Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Internal CSS for styling */
        body {
            display: flex;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            height: 100vh;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px 20px;
            text-align: center;
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        .header .logout-btn {
            position: absolute;
            right: 20px;
            top: 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            width: 250px;
            height: 100vh;
            padding: 20px;
            position: fixed;
            top: 60px;
            left: 0;
            overflow-y: auto;
        }
        .sidebar h4 a {
            color: white;
            text-decoration: none;
        }
        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
            flex-grow: 1;
            margin-top: 60px;
        }
        .section {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .section h2 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <span>Welcome, <strong><?php echo $_SESSION['cashier_name']; ?></strong></span>
        <a href="../process/logout.php">
            <button class="logout-btn">Logout</button>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><a href="#">Cashier Dashboard</a></h4>
        <a href="#orders" onclick="toggleSection('orders')">Orders</a>
        <a href="#tables" onclick="toggleSection('tables')">Tables</a>
        <a href="#customers" onclick="toggleSection('customers')">Customers</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'index.php'; // Include main content from index.php ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // JavaScript function to toggle sections
        function toggleSection(section) {
            const sections = ['orders', 'customers', 'tables'];
            sections.forEach(sec => {
                const element = document.getElementById(sec);
                if (sec === section) {
                    element.style.display = element.style.display === 'none' ? 'block' : 'none';
                } else {
                    element.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
