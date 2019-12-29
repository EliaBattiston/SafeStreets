<?php
    if(!isset($_COOKIE["username"]) || !isset($_COOKIE["password"]))
    {
        header("location: src/logout.php");
        exit;
    }
?>