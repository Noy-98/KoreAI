<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../login.php');
    exit();
}
require_once __DIR__ . '../db_con.php'; // Adjust the path if necessary

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_pcs = $_POST['product_pcs'];
    $product_color_code = $_POST['product_color_code'];

    // Update user data in the database
    $sql_update = "UPDATE products SET p_name = ?, p_price = ?, p_pcs = ?, p_color_code = ? WHERE p_id = ?";
    $stmt_update = $db_con->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $product_name, $product_price, $product_pcs, $product_color_code, $product_id);
    if ($stmt_update->execute()) {
        $_SESSION['success'] = "Products updated successfully.";
        header('Location: ../dashboard/user/products.php');
    } else {
        $_SESSION['error'] = "Error updating profile.";
        header('Location: ../dashboard/user/products.php');
    }
    $stmt_update->close();
}
$db_con->close();

header('Location: ../dashboard/user/products.php');
exit();
?>


