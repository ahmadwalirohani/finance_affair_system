<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $code = $_POST['code'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $address = $_POST['address'];
    $job = $_POST['job'];


    try {
        $stmt = $conn->prepare("INSERT INTO teachers (name, father_name,code,position,salary,address,job) VALUES (:name, :father_name,:code,:position,:salary,:address,:job)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':father_name', $father_name);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':job', $job);

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

    header('Location: ../teachers.php');
    exit;
}
