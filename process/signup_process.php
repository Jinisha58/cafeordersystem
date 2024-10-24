
// Retrieve form data
<?php
/*
include '../conn/connection.php';
$formUsername = $_POST['username'];
$formEmail = $_POST['email'];
$formPassword = $_POST['password'];
$formConfirmPassword = $_POST['confirm_password'];

// Validate form inputs
$errors = [];

if (strlen($formPassword) < 8) {
  $errors[] = "Password must be at least 8 characters long.";
}
/*if (!preg_match("/[A-Z]/", $formPassword) || !preg_match("/[a-z]/", $formPassword) || !preg_match("/[0-9]/", $formPassword)) {
  $errors[] = "Password must contain uppercase, lowercase, and a number.";
}
if ($formPassword !== $formConfirmPassword) {
  $errors[] = "Passwords do not match.";
}

// Display errors or proceed
if (!empty($errors)) {
  foreach ($errors as $error) {
    echo "<p style='color: red;'>$error</p>";
  }
  exit();
}

// Hash the password
$hashedPassword = password_hash($formPassword, PASSWORD_BCRYPT);

// Insert into the database
$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $formUsername, $formEmail, $hashedPassword);

if ($stmt->execute()) {
  echo "Registration successful!";
} else {
  echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
*/

include '../conn/connection.php'; // Include your connection file

$error = ""; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate form inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if the email is already registered
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user into the database
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                header("Location: login.php?success=1"); // Redirect to login page on success
                exit();
            } else {
                $error = "Error: " . $stmt->error; // Store error message
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>
