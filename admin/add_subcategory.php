<?php
// Include the database connection
include('../conn/connection.php');

// Fetch categories for the dropdown
$categories = [];
$sql = "SELECT id, category_name FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $item_name = $_POST['item_name'];
    $category_id = $_POST['category_id'];
    $image_name = $_FILES['image_name']['name']; // Assuming image upload
    

    // Upload image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image_name);

    // Ensure the 'uploads' directory exists and has correct permissions
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['image_name']['tmp_name'], $target_file)) {
        // Prepare the SQL insert query for the subcategory
        $query = "INSERT INTO sub_category (subcategory_name, category_id, image) VALUES (?, ?, ?)";

        // Prepare and bind
        if ($stmt = $conn->prepare($query)) {
            // Bind parameters
            $stmt->bind_param("sis", $item_name, $category_id, $image_name);

            // Execute the query
            if ($stmt->execute()) {
                echo "<p>Subcategory added successfully!</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<p>Error preparing the statement: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Error uploading the image.</p>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subcategory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-top: 5px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Add Subcategory</h2>
<form action="add_subcategory.php" method="POST" enctype="multipart/form-data">
    <label for="category">Select Category:</label>
    <select id="category" name="category_id" required>
        <option value="">Select a category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>">
                <?php echo htmlspecialchars($category['category_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="item_name">Subcategory Name:</label>
    <input type="text" id="item_name" name="item_name" required>

    <label for="image_name">Upload Image:</label>
    <input type="file" id="image_name" name="image_name" accept="image/*" required>

   
    <input type="submit" value="Add Subcategory">
</form>

</body>
</html>
