<?php
    session_start();

    include "../config/db.php";

    if(isset($_POST['login-btn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $fetch = "SELECT * FROM `admins` WHERE `email` = ?";
        $stmt = $connect->prepare($fetch);
        $stmt->bind_param('s', $email);


        $stmt->execute();

        $result = $stmt->get_result();
        $fetch_admin = $result->fetch_assoc();

        if($fetch == 0) {
            $error_msg = "Not authorized";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../admin/login.php?error=$encoded_error_msg");
            exit();
        }

        if (empty($email) || empty($password)) {
            $error_msg = "All fields must be filled";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../admin/login.php?error=$encoded_error_msg");
            exit();
        } elseif(!password_verify($password, $fetch_admin['password'])) {
            $error_msg = "Incorrect credentials";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../admin/login.php?error=$encoded_error_msg");
            exit();
        } else {
            $_SESSION['id'] = $fetch_admin['admin_id'];

            $success_msg = "Logged in successfully";
            $encoded_success_msg = urlencode($success_msg);
            header("location: ../admin/manage.php?success=$encoded_success_msg");
            exit();

        }
    }