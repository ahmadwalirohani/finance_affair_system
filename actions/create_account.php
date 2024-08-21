<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];


    try {
        $stmt = $conn->prepare("INSERT INTO accounts (name, type) VALUES (:name, :type)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);

        if ($stmt->execute()) {
            $_SESSION['account_message'] = "عملیه په بریا سره اجرا سول";
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

    header('Location: ../treasure.php');
    exit;
}
