<?php
    setcookie("username", "", time() - 3600, "/");
    setcookie("password", "", time() - 3600, "/");
    setcookie("admin", "", time() - 3600, "/");

    header("location: ../index.php");
    exit;
?>