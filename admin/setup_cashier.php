<?php
// setup_database.php
include '../conn/connection.php'; // Include your database connection file

// Modify the shift column to ensure it's an ENUM if it isn't already
$sql = "
ALTER TABLE cashiers 
MODIFY COLUMN shift ENUM('Morning', 'Evening', 'Night') NOT NULL;";

if ($conn->query($sql) === TRUE) {
    echo "Shift column modified successfully.<br>";
} else {
    echo "Error modifying column: " . $conn->error . "<br>";
}

$conn->close();
?>
