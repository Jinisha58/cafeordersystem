
// Retrieve form data
<?php
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
}*/
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