<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_con.php'; // Adjust the path if necessary

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

// Fetch user data from the database
$sql = "SELECT id, p_picture, p_name, p_price, p_pcs FROM products";
$result = $db_con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>
                    <img src='".htmlspecialchars($row['p_picture'])."'>
                </td>
                <td>".htmlspecialchars($row['p_name'])."</td>
                <td>".htmlspecialchars($row['p_price'])."</td>
                <td>".htmlspecialchars($row['p_pcs'])."</td>
                <td>
                    <a href='../../forms/user_delete_products.php?id=".urlencode($row['id'])."' onclick='return confirm(\"Are you sure you want to delete this products?\");'>
                        <span class='status pending'>Delete</span>
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No products found</td></tr>";
}
$db_con->close();
?>
