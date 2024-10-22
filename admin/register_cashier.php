<?php
session_start(); // Start the session
include '../conn/connection.php'; // Include your database connection file

// Processing the registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cashier_name = $_POST['cashier_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $shift = $_POST['shift'];

    // Check if cashier name or email already exists
    $queryCheck = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("ss", $cashier_name, $email);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // If there is already a user with the same name or email
        $error_message = "Cashier with this name or email already exists.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT); 

        // Insert into users table
        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'cashier')";
        $stmt = $conn->prepare($query);
        
        // Check if statement prepared successfully
        if (!$stmt) {
            die("Statement preparation failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("sss", $cashier_name, $email, $hashed_password);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id; // Get the ID of the newly created user
            
            // Insert into cashiers table
            $queryCashier = "INSERT INTO cashiers (user_id, shift) VALUES (?, ?)";
            $stmtCashier = $conn->prepare($queryCashier);
            
            if (!$stmtCashier) {
                die("Statement preparation for cashiers failed: " . $conn->error);
            }

            // Bind parameters for cashiers table
            $stmtCashier->bind_param("is", $user_id, $shift);

            // Execute the statement and check for errors
            if ($stmtCashier->execute()) {
                $_SESSION['success_message'] = "Cashier registered successfully!";
            } else {
                echo "Error executing query for cashiers: " . $stmtCashier->error;
            }

            // Close the statements
            $stmtCashier->close();
        } else {
            echo "Error executing query for users: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Redirect to the admin dashboard or wherever appropriate
        header("Location: dashboard.php");
        exit();
    }

    // Close the check statement
    $stmtCheck->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Cashier</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Register Cashier</h2>

    <!-- Display error message if exists -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="register_cashier.php">
        <div class="form-group">
            <label for="cashier_name">Cashier Name:</label>
            <input type="text" class="form-control" id="cashier_name" name="cashier_name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="shift">Shift:</label>
            <select class="form-control" id="shift" name="shift" required>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
                <option value="Night">Night</option>
            </select>
        </div>

        <input type="submit" class="btn btn-primary" value="Register Cashier">
    </form>
</div>

</body>
</html>
