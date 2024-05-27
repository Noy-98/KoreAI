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
$sql = "SELECT id, p_picture, user_color_code, p_name, p_price, p_pcs, p_color_code, total_price FROM tusok_list";
$result = $db_con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>
                    <img src='".htmlspecialchars($row['p_picture'])."'>
                </td>
                <td>".htmlspecialchars($row['user_color_code'])."</td>
                <td>".htmlspecialchars($row['p_name'])."</td>
                <td>".htmlspecialchars($row['p_price'])."</td>
                <td>".htmlspecialchars($row['p_pcs'])."</td>
                <td>".htmlspecialchars($row['p_color_code'])."</td>
                <td>".htmlspecialchars($row['total_price'])."</td>
                <td>
                    <a href='../../forms/user_delete_automation.php?id=".urlencode($row['id'])."' onclick='return confirm(\"Are you sure you want to delete this list?\");'>
                        <span class='status pending'>Delete</span>
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No list found</td></tr>";
}
$db_con->close();
?>
