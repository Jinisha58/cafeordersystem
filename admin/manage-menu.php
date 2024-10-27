<?php
// Connect to the database
include '../conn/connection.php';

// Fetch menu items with category, subcategory, and images
$sql = "
    SELECT 
        c.category_name, 
        sc.subcategory_name, 
        sc.image, 
        m.item_name, 
        m.price 
    FROM menu m
    JOIN sub_category sc ON m.subcategory_id = sc.id
    JOIN category c ON sc.category_id = c.id
    ORDER BY c.category_name, sc.subcategory_name, m.item_name";

$result = $conn->query($sql);

// Check if any items exist
if ($result->num_rows > 0) {
    $currentCategory = ''; // Track current category to avoid duplicates
    $currentSubcategory = ''; // Track current subcategory to avoid duplicates

    echo '<div class="menu-container" style="margin: 20px; font-family: Poppins, sans-serif;">';

    // Loop through the items and display them by category and subcategory
    while ($row = $result->fetch_assoc()) {
        // Check if the category has changed
        if ($currentCategory != $row['category_name']) {
            $currentCategory = $row['category_name'];
            echo "<h2 style='border-bottom: 2px solid #3498db; color: #2c3e50; margin-bottom: 15px;'>$currentCategory</h2>";
        }

        // Check if the subcategory has changed
        if ($currentSubcategory != $row['subcategory_name']) {
            $currentSubcategory = $row['subcategory_name'];

            // Display the subcategory heading with its image
            echo '<div class="subcategory" style="margin: 20px 0;">';
            echo '<h3 style="color: #34495e; font-weight: 600; margin-bottom: 10px;">' 
                 . htmlspecialchars($currentSubcategory) . '</h3>';
            echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" 
                     alt="' . htmlspecialchars($currentSubcategory) . '" 
                     style="width: 250px; height: 150px; object-fit: cover; border-radius: 10px; 
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 15px;">';
            echo '</div>';

            // Display the table headers for items and price
            echo '<div class="menu-table" style="margin-bottom: 15px; border-bottom: 1px solid #ccc;">';
            echo '<div style="display: flex; font-weight: bold; background-color: #ecf0f1; padding: 10px; 
                              border-radius: 5px 5px 0 0;">';
            echo '<div style="flex: 1; text-align: left; color: #2c3e50;">Item Name</div>';
            echo '<div style="flex: 0.2; text-align: right; color: #2c3e50;">Price</div>';
            echo '</div>';
        }

        // Display each menu item in a row with separate styles for name and price
        echo '<div class="menu-item-row" 
                  style="display: flex; justify-content: space-between; padding: 10px; 
                         border-bottom: 1px solid #e0e0e0; transition: background-color 0.3s;">';
        echo '<div class="item-name" style="flex: 1; text-align: left; color: #34495e;">' 
             . htmlspecialchars($row['item_name']) . '</div>';
        echo '<div class="item-price" style="flex: 0.2; text-align: right; color: #27ae60; font-weight: 600;"> ' 
             . htmlspecialchars($row['price']) . '</div>';
        echo '</div>';
    }

    echo '</div>'; // Close menu-container
} else {
    echo "<p style='font-family: Poppins, sans-serif; color: #7f8c8d;'>No menu items available.</p>";
}

// Close the connection
$conn->close();
?>
