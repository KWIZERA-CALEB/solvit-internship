<?php
    include '../config/db.php';

    if (isset($_POST['add-admin-btn'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $fetch = "SELECT * FROM `admins` WHERE `email` = ?";
        $stmt = $connect->prepare($fetch);
        $stmt->bind_param('s', $email);


        $stmt->execute();

        $result = $stmt->get_result();
        $fetch_admin = $result->fetch_assoc();

        if(empty($name) || empty($email) || empty($password)) {
            $error_msg = "All fields must be filled";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../admin/add-admin.php?error=$encoded_error_msg");
            exit();
        } elseif(!preg_match('/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $error_msg = "Invalid email";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../admin/add-admin.php?error=$encoded_error_msg");
            exit();
        } elseif($fetch_admin['email'] === $email) {
            $error_msg = "Admin already exists";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../admin/add-admin.php?error=$encoded_error_msg");
            exit();
        } else {
            $add_admin = "INSERT INTO `admins`(`name`, `email`,`password`) VALUES(?,?,?)";

            $stmt = $connect->prepare($add_admin);
            $stmt->bind_param('sss', $name, $email, $hashed_password);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success_msg = "Admin added";
                $encoded_success_msg = urlencode($success_msg);
                header("location: ../admin/manage.php?success=$encoded_success_msg");
                exit();
            } else {
                $error_msg = "Something went wrong";
                $encoded_error_msg = urlencode($error_msg);
                header("location: ../admin/add-admin.php?error=$encoded_error_msg");
                exit();
            }
        }
    }