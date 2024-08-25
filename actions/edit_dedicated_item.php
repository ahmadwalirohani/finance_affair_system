<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $item = $_POST['item'];
    $department = $_POST['department'];
    $consumer = $_POST['consumer'];
    $quantity = $_POST['quantity'];
    $remarks = $_POST['remarks'];
    $period = $_POST['period'];
    $id = $_GET['id'];


    try {
        $stmt = $conn->prepare("UPDATE dedicated_items SET item_id = :item, department_id = :department,consumer = :consumer, quantity = :quantity , remarks = :remarks , period = :period WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':item', $item);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':consumer', $consumer);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->bindParam(':period', $period);

        // decrease item quantity from getting item inventory
        $itemModel = $conn->prepare("SELECT * FROM items WHERE id = :id");
        $itemModel->bindParam(':id', $item);
        $itemModel->execute();
        $itemModel = $itemModel->fetchAll(PDO::FETCH_ASSOC)[0];

        $item_inventory = $conn->prepare("UPDATE items SET quantity  = :quantity WHERE id = :id");
        $new_quantity = floatval($itemModel['quantity']) - floatval($quantity);
        $item_inventory->bindParam(':quantity', $new_quantity);
        $item_inventory->bindParam(':id', $item);
        $item_inventory->execute();

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

    header('Location: ../item_dedication.php');
    exit;
}
