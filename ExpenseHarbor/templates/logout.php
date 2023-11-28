<?php
    include_once "../init.php";
    $getFromU->logout();
    header("Location: 2-sign-up.php"); // Redirects to the signup page
    exit(); // Ensure that no further code is executed after the redirect
?>
