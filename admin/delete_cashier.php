<?php
include '../conn/connection.php'; // Include your database connection

// Check if delete_id is set in the URL
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Ensure the ID is an integer

    // Prepare the DELETE query
    $query = "DELETE FROM cashiers WHERE cashier_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delete_id); // Bind the parameter

    // Execute the query and check if the deletion was successful
    if ($stmt->execute()) {
        // Deletion was successful
        $message = "Cashier deleted successfully.";
    } else {
        // Deletion failed
        $message = "Error deleting cashier: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // No delete_id was set
    $message = "No cashier ID provided for deletion.";
}

// Redirect back to the cashier list page with a message
header("Location: display_cashier.php?message=" . urlencode($message));
exit; // Terminate the script
?>
