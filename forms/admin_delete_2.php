<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db_con.php'; // Adjust the path if necessary

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare and execute the delete statement
    $stmt = $db_con->prepare("DELETE FROM password_reset_requests WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User Request deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting user request.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

$db_con->close();

header('Location: /Ai-Street-Food-Web-App-System/dashboard/admin/controls.php');
exit();
?>
