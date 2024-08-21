<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $faculty = $_POST['faculty'];


    try {
        $stmt = $conn->prepare("INSERT INTO departments (name, faculty_name) VALUES (:name, :faculty_name)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':faculty_name', $faculty);

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

    header('Location: ../departments.php');
    exit;
}
