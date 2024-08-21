<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $code = $_POST['code'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $address = $_POST['address'];
    $job = $_POST['job'];
    $id = $_GET['id'];


    try {
        $stmt = $conn->prepare("UPDATE teachers SET name = :name, father_name = :father_name,code = :code, address = :address, position = :position , job = :job , salary = :salary WHERE id = :id");
        $stmt->bindParam(':id', $id);
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
