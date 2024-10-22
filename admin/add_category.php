<?php
// Include the database connection
include('../conn/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $category_name = $_POST['category_name'];

    // Prepare the SQL insert query for the category
    $query = "INSERT INTO category (category_name) VALUES (?)";

    // Prepare and bind
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters
        $stmt->bind_param("s", $category_name);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p>Category added successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
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
    <title>Add Category - Cafe Order System</title>
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
            max-width: 400px;
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

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

<h2>Add Category</h2>
<form action="add_category.php" method="POST">
    <label for="category_name">Category Name:</label>
    <input type="text" id="category_name" name="category_name" required>

    <input type="submit" value="Add Category">
</form>

</body>
</html>
