<?php
// Include database connection
include '../conn/connection.php';

// Get the subcategory ID from the request
$subcategory_id = isset($_GET['subcategory_id']) ? intval($_GET['subcategory_id']) : 0;

// Prepare the query to fetch menu items based on the selected subcategory
$menu_query = "SELECT item_id, item_name, price FROM menu WHERE subcategory_id = ?";
$stmt = $conn->prepare($menu_query);
$stmt->bind_param("i", $subcategory_id); // Bind the subcategory_id parameter
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result set

// Initialize an array to store menu items
$menu_items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $menu_items[] = $row;
}
// Set the content type to JSON and return the menu items
header('Content-Type: application/json');
echo json_encode($menu_items); // Encode the array as JSON and output it

// Close the statement and connection
$stmt->close();
$conn->close();
?>
