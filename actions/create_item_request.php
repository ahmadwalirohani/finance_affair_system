<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = $_POST['item'];
    $department = $_POST['department'];
    $consumer = $_POST['consumer'];
    $quantity = $_POST['quantity'];
    $remarks = $_POST['remarks'];


    try {
        $stmt = $conn->prepare("INSERT INTO request_items (item_id, department_id,consumer,request_quantity,remarks) VALUES (:item, :department,:consumer,:quantity,:remarks)");
        $stmt->bindParam(':item', $item);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':consumer', $consumer);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':remarks', $remarks);

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

    header('Location: ../item_request.php');
    exit;
}
