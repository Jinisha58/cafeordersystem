// fetch_subcategories.php
<?php
include '../conn/connection.php';

$category_id = $_GET['category_id'];
$subcategories_query = "SELECT subcategory_id, subcategory_name FROM sub_category WHERE category_id = ?";
$stmt = $conn->prepare($subcategories_query);
$stmt->bind_param('i', $category_id);
$stmt->execute();
$result = $stmt->get_result();

$subcategories = [];
while ($row = $result->fetch_assoc()) {
    $subcategories[] = $row;
}

echo json_encode($subcategories);
?>
