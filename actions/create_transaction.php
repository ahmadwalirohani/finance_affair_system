<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account = $_POST['account'];
    $treasure = $_POST['treasure'];
    $department = $_POST['department']  ?? null;
    $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];

    $credit  = 0;
    $debit = 0;

    // get type of account to clearify credit and debit 

    $TransactionType  = $conn->prepare("SELECT type FROM accounts WHERE id = " . $account);
    $TransactionType->execute();
    $TransactionType = $TransactionType->fetchAll(PDO::FETCH_ASSOC);

    if ($TransactionType[0]['type'] == 'مصرف')
        $debit = $amount;
    else
        $credit = $amount;



    //retrive treasure last balance  
    $treasureBalance = $conn->prepare("SELECT balance FROM treasures WHERE id = :id");
    $treasureBalance->bindParam(':id', $treasure);
    $treasureBalance->execute();
    $treasureBalance = $treasureBalance->fetchAll(PDO::FETCH_ASSOC);
    $treasureBalance = $TransactionType[0]['type'] == 'مصرف'
        ? floatval($treasureBalance[0]['balance']) - floatval($amount)
        : floatval($treasureBalance[0]['balance']) + floatval($amount);

    // update the treasure balance according to transaction
    $treasureUpdate = $conn->prepare("UPDATE treasures SET balance = :balance WHERE id = :id");
    $treasureUpdate->bindParam(':balance', $treasureBalance);
    $treasureUpdate->bindParam(':id', $treasure);
    $treasureUpdate->execute();



    try {
        $stmt = $conn->prepare("INSERT INTO transactions (treasure_id, account_id, department_id, credit, debit, remarks) VALUES (:treasure, :account,:department, :credit, :debit, :remarks)");
        $stmt->bindParam(':treasure', $treasure);
        $stmt->bindParam(':account', $account);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':credit', $credit);
        $stmt->bindParam(':debit', $debit);
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

    header('Location: ../transaction.php');
    exit;
}
