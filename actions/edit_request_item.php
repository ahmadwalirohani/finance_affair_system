<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $item = $_POST['item'];
    $department = $_POST['department'];
    $consumer = $_POST['consumer'];
    $quantity = $_POST['quantity'];
    $remarks = $_POST['remarks'];
    $id = $_GET['id'];


    try {
        $stmt = $conn->prepare("UPDATE request_items SET item_id = :item, department_id = :department,consumer = :consumer, request_quantity = :quantity , remarks = :remarks WHERE id = :id");
        $stmt->bindParam(':id', $id);
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
