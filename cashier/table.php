<?php
// Include your database connection
include '../conn/connection.php';

// Fetch table data
$sql = "SELECT table_id, table_num, status FROM tables";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Table ID</th>
                <th>Table Number</th>
                <th>Status</th>
            </tr>";
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["table_id"] . "</td>
                <td>" . $row["table_num"] . "</td>
                <td>" . $row["status"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No tables found.";
}

$conn->close();
?>
