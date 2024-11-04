<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}


if (isset($_SESSION['logged_in'])) {

    session_unset();

    session_destroy();

    header("Location: ../../frontend/auth/login.php");
    exit();
} else {

    header("Location: ../../index.php");
    exit();
}
