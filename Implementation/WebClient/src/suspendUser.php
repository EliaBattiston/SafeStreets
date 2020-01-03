<?php
    include(__DIR__ . "/../components/checks.php");
    include_once(__DIR__ . "/../config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: ../src/logout.php");
        exit;
    }

    if(!isset($_GET["username"]) || !isset($_GET["action"]))
    {
        header("location: ../editUser.php");
        exit;
    }

    if(!isset($_GET["fc"]))
    {
        header("location: ../accounts.php");
        exit;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint."/web/accounts/suspension/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
        http_build_query(
            array(
                "username" => $_COOKIE["username"],
                "password" => $_COOKIE["password"],
                "suspendedUser" => $_GET["username"],
                "action" => $_GET["action"]
            )
        )
    );
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);

    if($httpcode==200)
    {
        if($response->result==200)
        {
            header("location: ../editUser.php?fc=".$_GET["fc"]);
            exit;
        }
        else
        {
            header("location: ../editUser.php?fc=".$_GET["fc"]."&error=".$response->result."&cause=API&action=suspend");
            exit; 
        }
    }
    else
    {
        header("location: ../editUser.php?fc=".$_GET["fc"]."&error=".$httpcode."&cause=HTTP&action=suspend");
        exit;
    }

?>