<?php
include 'dashboard_flex.php';
?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .button-container {
            margin: 30px 0;
            text-align: center;
        }

        .button {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .menu-container {
            padding: 20px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="button-container">
        <a href="add_menu.php" class="button">Add Menu Item</a>
    </div>

    <div class="menu-container">
        <?php include 'manage-menu.php'; ?>
    </div>
</div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
