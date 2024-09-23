<?php
session_start(); 


if (isset($_SESSION['logged_in'])) {

    session_unset();

    session_destroy();

    header("Location: ../frontend/auth/login.php");
    exit();
} else {

    header("Location: ../index.php");
    exit();
}
