<?php
session_start();
require '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id = $_GET['id'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["photo"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }



    try {



        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Move the uploaded file to the server directory
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // Prepare the SQL statement to insert the file path into the database

                $image_path = substr($target_file, 3);
                $stmt = $conn->prepare("UPDATE users SET  name = :name, email = :email, password = :password, photo = :photo WHERE id = :id");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':photo', $image_path);


                if ($stmt->execute()) {
                    $_SESSION['message'] = "عملیه په بریا سره اجرا سول";
                    $_SESSION['msg_type'] = "success";
                } else {

                    $_SESSION['message'] = "Error: " . $stmt->errorInfo()[2];
                    $_SESSION['msg_type'] = "danger";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } catch (PDOException $e) {

        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    $conn = null; // Close the database connection

    header('Location: ../user.php');
    exit;
}
