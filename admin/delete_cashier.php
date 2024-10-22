<?php
// delete_cashier.php
include '../conn/connection.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cashier_id = $_POST['cashier_id'];

    // Prepare and execute the delete query
    $query = "DELETE FROM cashiers WHERE cashier_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cashier_id);

    if ($stmt->execute()) {
        echo "Cashier deleted successfully!<br>";
    } else {
        echo "Error deleting cashier: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();

// Redirect back to the list of cashiers or dashboard
header("Location: dashboard.php"); // Change this to your desired redirect location
exit;
?>
