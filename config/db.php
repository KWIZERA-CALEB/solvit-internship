<?php
    $host_name = "localhost";
    $user = "root";
    $password = "";
    $db_name = "user_feedback_system";

    $connect = mysqli_connect($host_name, $user, $password, $db_name);

    if (!$connect) {
        echo "Database not connected well";
    }