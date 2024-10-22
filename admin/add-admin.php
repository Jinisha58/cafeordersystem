<section id="admins" class="hidden">
    <h2>Manage Admins</h2>
    <form action="add_admin.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="superadmin">Superadmin</option>
        </select>
        <br>
        <button type="submit">Add Admin</button>
    </form>
</section>

<table>
    <thead>
        <tr>
            <th>Admin ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM admins";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['role']}</td>
            <td>
                <button onclick=\"deleteAdmin({$row['id']})\">Delete</button>
            </td>
        </tr>";
    }
    ?>
    </tbody>
</table>


<?php
// add_admin.php
session_start();
if ($_SESSION['role'] != 'superadmin') {
    die("Access denied. Only superadmins can add admins.");
}

// Database connection
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $role = $_POST['role'];

    // Insert into database
    $sql = "INSERT INTO admins (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "New admin added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

