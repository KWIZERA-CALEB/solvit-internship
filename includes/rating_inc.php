<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    include "../config/db.php";

    if (isset($_POST['submit-feedback-btn'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        if (empty($name) || empty($email) || empty($rating) || empty($comment)) {
            $error_msg = "All fields must be filled";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../rating.php?error=$encoded_error_msg");
            exit();
        } elseif(strlen($comment) > 255) {
            $error_msg = "Comment is too long";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../rating.php?error=$encoded_error_msg");
            exit();
        } elseif(!preg_match('/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $error_msg = "Invalid email";
            $encoded_error_msg = urlencode($error_msg);
            header("location: ../rating.php?error=$encoded_error_msg");
            exit();
        } else {
            $insert_feedback = "INSERT INTO `feedbacks`(`name`, `email`,`rating`,`comment`) VALUES(?,?,?,?)";

            $stmt = $connect->prepare($insert_feedback);
            $stmt->bind_param('ssss', $name, $email, $rating, $comment);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success_msg = "Feedback received";
                $encoded_success_msg = urlencode($success_msg);
                header("location: ../success-submission.php?success=$encoded_success_msg");
                exit();
            } else {
                $error_msg = "Something went wrong";
                $encoded_error_msg = urlencode($error_msg);
                header("location: ../rating.php?error=$encoded_error_msg");
                exit();
            }
        }
    }