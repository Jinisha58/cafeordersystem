<?php
session_start();

// Check if the user is logged in as an cashier
if (!isset($_SESSION['cashier_id']) || $_SESSION['role'] !== 'cashier') {
        // Redirect to login page if not logged in or not an cashier
    header("Location: ../view/login.php");
    exit();
}
// Check if the username is set in the session; fallback to 'Cashier' if not available.
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Cashier';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cashier Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Global Reset and Font Settings */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color: #f3f4f6; /* Soft gray background */
    }

    /* Sidebar Styling */
    .sidebar {
      width: 250px;
      background-color: #1b263b; /* Dark Blue */
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      padding-top: 30px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 40px;
      font-weight: 600;
      font-size: 22px;
      letter-spacing: 1px;
      color: #f8f9fa; /* Light Gray for title */
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      padding: 15px 25px;
      transition: background-color 0.3s;
    }

    .sidebar ul li:hover {
      background-color: #0d1b2a; /* Darker Blue on hover */
    }

    .sidebar ul li a {
      text-decoration: none;
      color: #e1e1e1; /* Light text color */
      display: block;
      font-size: 18px;
      transition: color 0.3s;
    }

    .sidebar ul li a:hover {
      color: #fca311; /* Orange on hover */
    }

    /* Top Navigation Bar */
    .top-nav {
      background-color: #3d5a80; /* Medium Blue */
      height: 60px;
      width: calc(100% - 250px);
      position: fixed;
      left: 250px;
      top: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 30px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      color: white;
    }

    .top-nav .nav-item {
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .nav-item img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
    }

    /* Main Content Styling */
    .main-content {
      margin-top: 60px;
      margin-left: 250px;
      padding: 30px;
      width: calc(100% - 250px);
      background-color: #f3f4f6; /* Matches body background */
      min-height: calc(100vh - 60px);
    }

    .main-content h1 {
      font-size: 28px;
      margin-bottom: 10px;
      color: #3d5a80; /* Medium Blue for heading */
    }

    .main-content p {
      font-size: 16px;
      color: #5f6c7b; /* Soft gray for text */
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Cashier Dashboard</h2>
    <ul>
      <li><a href="order_form.php">Order</a></li>
      <li><a href="cashier_tables.php">Tables</a></li>
      <li><a href="customer_orders.php">Customers</a></li>
      <li><a href="../process/logout.php">Logout</a></li>
    </ul>
  </div>

  <!-- Top Navigation Bar -->
  <div class="top-nav">
    <div>Cashier Dashboard</div>
    <div class="nav-item">
      <span>Welcome, <?= htmlspecialchars($username) ?></span>
    </div>
  </div>

  <!-- Main Content Area -->
  <div class="main-content">

</body>
</html>
