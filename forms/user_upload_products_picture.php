<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../login.php');
    exit();
}
require_once __DIR__ . '../db_con.php'; // Adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['p_picture'])) {
    $upload_dir = '../uploads/user_profile_pictures/products_picture/';
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = basename($_FILES['p_picture']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_path = $upload_dir . '.' . $file_ext;

    // Check if file type is allowed
    if (!in_array($file_ext, $allowed_types)) {
        $_SESSION['error'] = 'Only JPG, JPEG, PNG, and GIF files are allowed.';
        header('Location: ../dashboard/user/products.php');
        exit();
    }

    // Check if file was uploaded without errors
    if ($_FILES['p_picture']['error'] == 0) {
        // Move the uploaded file to the designated directory
        if (move_uploaded_file($_FILES['p_picture']['tmp_name'], $file_path)) {
            // Update the user's profile picture in the database
            $file_path_db = str_replace('../', '../../', $file_path);
            $sql = "INSERT INTO products (p_picture) VALUES (?)";
            $stmt = $db_con->prepare($sql);
            $stmt->bind_param("s", $file_path_db);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Upload Products Picture Successfully.";
                header('Location: ../dashboard/user/products.php');
                exit();
            } else {
                $_SESSION['error'] = 'Could not update the database.';
                header('Location: ../dashboard/user/products.php');
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = 'Failed to move the uploaded file.';
            header('Location: ../dashboard/user/products.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'There was an error uploading your file.';
        header('Location: ../dashboard/user/products.php');
        exit();
    }
}

$db_con->close();
header('Location: ../dashboard/user/products.php');
exit();
?>
