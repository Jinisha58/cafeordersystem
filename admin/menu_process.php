<?php
include '../conn/connection.php'; // Include your connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $subcategory_id = $_POST['subcategory_id'];
    $category_id = $_POST['category_id'];

    // Prepare an SQL statement to insert the data
    $sql = "INSERT INTO menu (item_name, price, subcategory_id, category_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param('sdii', $item_name, $price, $subcategory_id, $category_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Display success message and redirect to the dashboard
        echo "<script>
                alert('New record created successfully');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        // Display error message and redirect to the dashboard
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'dashboard.php';
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
