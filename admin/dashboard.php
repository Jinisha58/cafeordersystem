<?php
session_start(); // Start the session

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not logged in or not an admin
    header("Location: ../view/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Order System - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="../js/script.js"></script>
</head>
<body>
    <div class="header">
        <span>Welcome, <strong>Admin</strong></span>
        <a href="../process/logout.php">
            <button class="logout-btn">Logout</button>
        </a>
    </div>

    <div class="sidebar">
        <h4><a href="admin_layout.php">Admin Dashboard</a></h4>
        <a href="#tables" onclick="toggleSection('tables')">Tables</a>
        <a href="#menu" onclick="toggleSection('menu')">Menu</a>
        <a href="#customers" onclick="toggleSection('customers')">Customers</a>
        <a href="#cashiers" onclick="toggleSection('cashiers')">Cashiers</a>
        
        <!-- Dropdown for Add Menu Item -->
        <div class="dropdown">
            <a class="dropdown-item" href="add_subcategory.php">Add SubCategory</a>
<a class="dropdown-item" href="add_category.php">Add category</a>

            <ul class="dropdown-menu" aria-labelledby="addItemsDropdown">
                <li><a class="dropdown-item" href="add_subcategory.php">Add SubCategory</a></li>
                <li><a class="dropdown-item" href="add_category.php">Add category</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <?php include('index.php'); ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function toggleSection(section) {
            const sections = ['tables', 'menu', 'customers', 'cashiers'];
            sections.forEach(sec => {
                const element = document.getElementById(sec);
                if (element) {
                    element.style.display = (sec === section && (element.style.display === 'none' || element.style.display === '')) ? 'block' : 'none';
                }
            });
        }
    </script>
</body>
</html>
