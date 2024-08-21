<?php
session_start();
require '../utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM dedicated_items WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "جنس ډیلیت سول";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->errorInfo()[2];
            $_SESSION['msg_type'] = "danger";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    $conn = null; // Close the database connection

    header('Location: ../item_dedication.php');
    exit;
} else {
    $_SESSION['message'] = "Invalid account ID.";
    $_SESSION['msg_type'] = "error";
    header('Location: ../item_dedication.php');
    exit;
}
