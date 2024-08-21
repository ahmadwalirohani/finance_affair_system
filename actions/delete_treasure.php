<?php
session_start();
require '../utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM treasures WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "خزانه ډیلیت سول";
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

    header('Location: ../treasure.php');
    exit;
} else {
    $_SESSION['message'] = "Invalid account ID.";
    $_SESSION['msg_type'] = "error";
    header('Location: ../treasure.php');
    exit;
}
