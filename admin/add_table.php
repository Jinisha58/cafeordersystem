<?php
include '../conn/connection.php'; // Include your database connection

// Display errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_num = $_POST['table_num'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    // Insert the new table into the database
    $insert_query = "INSERT INTO tables (table_num, capacity, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('sis', $table_num, $capacity, $status);
    
    if ($stmt->execute()) {
        // Redirect back to the admin tables page after successful insertion
        header("Location: dashboard.php#tables");
        exit;
    } else {
        echo "Error inserting record: " . $stmt->error; // Display error message
    }

    $stmt->close();
}

$conn->close();
?>
