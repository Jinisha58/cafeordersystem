<?php
include '../conn/connection.php'; // Include your database connection

// Check if an ID is provided in the URL
if (isset($_GET['table_id'])) {
    $table_id = $_GET['table_id'];

    // Prepare the delete statement
    $delete_query = "DELETE FROM tables WHERE table_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $table_id);
    
    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to the main table management page after deletion
        header("Location: dashboard.php?message=Table deleted successfully");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No table ID provided for deletion.";
}

$conn->close();
?>
