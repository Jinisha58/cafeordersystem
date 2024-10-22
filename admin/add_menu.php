<?php
include '../conn/connection.php'; // Include your connection file

// Fetch categories
$categories = [];
$result = $conn->query("SELECT * FROM category");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

if (isset($_GET['categoryId'])) {
    // Fetch subcategories based on the selected category
    $categoryId = intval($_GET['categoryId']);
    $sql = "SELECT * FROM sub_category WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    // Return subcategories as JSON
    header('Content-Type: application/json');
    echo json_encode($subcategories);
    exit(); // Stop further execution
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add menu items</title>
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
        select,
        input[type="file"] {
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

<h1>Add Menu</h1>
<form action="menu_process.php" method="POST" enctype="multipart/form-data">
    <label for="categorySelect">Category:</label>
    <select id="categorySelect" name="category_id" required>
        <option value="">Select a category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= $category['category_name']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="subcategorySelect">Subcategory:</label>
    <select id="subcategorySelect" name="subcategory_id" required>
        <option value="">Select a subcategory</option>
    </select>

    <label for="item_name">Menu:</label>
    <input type="text" id="item_name" name="item_name" required>


    <label for="price">Price:</label>
    <input type="text" id="price" name="price" required>
    
    <input type="submit" value="Add  Menu">
</form>

<script>
    // Event listener for category selection
    document.getElementById('categorySelect').addEventListener('change', function() {
        const selectedCategoryId = this.value;
        console.log("Selected Category ID:", selectedCategoryId); // Debugging output
        fetchSubcategories(selectedCategoryId);
    });

    // Fetch subcategories based on selected category
    function fetchSubcategories(categoryId) {
        if (!categoryId) {
            document.getElementById('subcategorySelect').innerHTML = '<option value="">Select a subcategory</option>';
            return;
        }

        fetch(`?categoryId=${categoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log("Fetched Subcategories:", data); // Debugging output
                const subcategorySelect = document.getElementById('subcategorySelect');
                subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>'; // Clear previous options
                if (data.length === 0) {
                    console.log("No subcategories found for this category.");
                }
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id; // Ensure this matches your sub_category table
                    option.textContent = subcategory.subcategory_name; // Ensure this matches your sub_category table
                    subcategorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }
</script>

</body>
</html>
