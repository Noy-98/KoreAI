<?php
session_start();
require_once __DIR__ . '../db_con.php'; // Adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters long.';
        header('Location: ../new_password.php');
        exit();
    }

    // Validate the passwords
    if ($password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Assuming user_id is stored in session when user is directed to this page
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Update the password in the users table
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $db_con->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $user_id);

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Your password has been successfully changed.';
                header('Location: ../login.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to update the password. Please try again.';
                header('Location: ../new_password.php');
                exit();
            }

            $stmt->close();
        } else {
            $_SESSION['error'] = 'User session not found. Please log in again.';
            header('Location: ../login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Passwords do not match. Please try again.';
        header('Location: ../new_password.php');
        exit();
    }

    $db_con->close();
}
?>
