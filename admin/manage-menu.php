<?php
// Connect to the database
include '../conn/connection.php';

// Fetch menu items with category, subcategory, and images from subcategory
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

    echo '<div class="menu-container" style="margin: 20px;">';

    // Loop through the items and display them by category and subcategory
    while ($row = $result->fetch_assoc()) {
        // Check if the category has changed
        if ($currentCategory != $row['category_name']) {
            $currentCategory = $row['category_name'];
            echo "<h2 style='border-bottom: 1px solid #000;'>$currentCategory</h2>";
        }

        // Check if the subcategory has changed
        if ($currentSubcategory != $row['subcategory_name']) {
            $currentSubcategory = $row['subcategory_name'];

            // Display the subcategory heading with its image
            echo '<div class="subcategory" style="margin: 15px 0;">';
            echo '<h3>' . htmlspecialchars($currentSubcategory) . '</h3>';
            echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" 
                     alt="' . htmlspecialchars($currentSubcategory) . '" 
                     style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">';
            echo '</div>';

            // Display the table headers for items and price
            echo '<div class="menu-table" style="margin-bottom: 10px;">';
            echo '<div style="display: flex; font-weight: bold; border-bottom: 1px solid #000; padding: 5px 0;">';
            echo '<div style="flex: 1; text-align: left;">Item Name</div>';
            echo '<div style="flex: 0.2; text-align: right;">Price</div>';
            echo '</div>';
        }

        // Display each menu item in a row with separate styles for name and price
        echo '<div class="menu-item-row" 
                  style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ddd;">';
        echo '<div class="item-name" style="flex: 1; text-align: left;">' . htmlspecialchars($row['item_name']) . '</div>';
        echo '<div class="item-price" style="flex: 0.2; text-align: right;">$' . htmlspecialchars($row['price']) . '</div>';
        echo '</div>';
    }

    echo '</div>'; // Close menu-container
} else {
    echo "<p>No menu items available.</p>";
}

// Close the connection
$conn->close();
?>
