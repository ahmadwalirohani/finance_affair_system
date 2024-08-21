<?php
session_start();
require '../utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['account_message'] = "یوزر ډیلیت سول";
            $_SESSION['account_msg_type'] = "success";
        } else {
            $_SESSION['account_message'] = "Error: " . $stmt->errorInfo()[2];
            $_SESSION['account_msg_type'] = "danger";
        }
    } catch (PDOException $e) {
        $_SESSION['account_message'] = "Error: " . $e->getMessage();
        $_SESSION['account_msg_type'] = "danger";
    }

    $conn = null; // Close the database connection

    header('Location: ../user.php');
    exit;
} else {
    $_SESSION['account_message'] = "Invalid account ID.";
    $_SESSION['account_msg_type'] = "error";
    header('Location: ../user.php');
    exit;
}
