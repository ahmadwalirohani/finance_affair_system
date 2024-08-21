<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $teacher = $_POST['teacher'];
    $salary = $_POST['salary'];
    $total_hours = $_POST['total_hours'];
    $present_days = $_POST['present_days'];
    $absent_days = $_POST['absent_days'];
    $overtime_salary = $_POST['overtime_salary'];
    $net_salary = $_POST['net_salary'];
    $remarks = $_POST['remarks'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $id = $_GET['id'];


    try {
        $stmt = $conn->prepare("UPDATE payrolls SET teacher_id = :teacher, salary = :salary,total_hours = :total_hours,present_days = :present_days,net_salary = :net_salary,absent_days = :absent_days,overtime_salary = :overtime_salary,remarks = :remarks,year = :year,month= :month WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':teacher', $teacher);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':total_hours', $total_hours);
        $stmt->bindParam(':present_days', $present_days);
        $stmt->bindParam(':net_salary', $net_salary);
        $stmt->bindParam(':absent_days', $absent_days);
        $stmt->bindParam(':overtime_salary', $overtime_salary);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);

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

    header('Location: ../payroll.php');
    exit;
}
