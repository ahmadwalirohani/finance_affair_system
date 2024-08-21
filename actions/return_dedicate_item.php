<?php
session_start();
require '../utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get item request quantity to add into item inventory quantity
    $request_item = $conn->prepare("SELECT * FROM dedicated_items WHERE id = :id");
    $request_item->bindParam(':id', $id);
    $request_item->execute();
    $request_item = $request_item->fetchAll(PDO::FETCH_ASSOC)[0];

    try {
        $stmt = $conn->prepare("UPDATE dedicated_items SET is_returned = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $item = $conn->prepare('SELECT * FROM items WHERE id = :id');
        $item->bindParam(':id', $request_item['item_id']);
        $item->execute();
        $item = $item->fetchAll(PDO::FETCH_ASSOC)[0];

        $item_inventory = $conn->prepare("UPDATE items SET quantity  = :quantity WHERE id = :id");
        $quantity = floatval($request_item['quantity']) + floatval($item['quantity']);
        $item_inventory->bindParam(':quantity', $quantity);
        $item_inventory->bindParam(':id', $request_item['item_id']);
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
