<?php
include '../conn/connection.php';

// Retrieve form data from $_POST
$formIdentifier = $_POST['identifier'];
$formPassword = $_POST['password'];

// Prepare the query to find the user by username or email
$sql = "SELECT user_id, username, email, password, role FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $formIdentifier, $formIdentifier);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($formPassword, $user['password'])) {
        // Start session and store user data
        session_start();
        $_SESSION['user_id'] = $user['user_id'];  // Store the user ID
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php"); // Redirect to admin dashboard
        } elseif ($user['role'] === 'cashier') {
            // For cashier, store necessary session variables
            $_SESSION['cashier_name'] = $user['username']; // Store cashier's name
            $_SESSION['cashier_id'] = $user['user_id']; // Store cashier's ID

            header("Location: ../cashier/dashboard.php"); // Redirect to cashier dashboard
        } else {
            echo "<p style='color: red;'>Invalid user role.</p>";
        }

        exit();
    } else {
        echo "<p style='color: red;'>Incorrect password.</p>";
    }
} else {
    echo "<p style='color: red;'>No user found with the provided username or email.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>
