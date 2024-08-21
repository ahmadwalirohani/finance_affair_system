<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $balance = $_POST['balance'];


    try {
        $stmt = $conn->prepare("INSERT INTO treasures (name, balance) VALUES (:name, :balance)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':balance', $balance);

        if ($stmt->execute()) {
            $_SESSION['message'] = "عملیه په بریا سره اجرا سول";
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
}
