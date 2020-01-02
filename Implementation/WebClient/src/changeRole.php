<?php
    include(__DIR__ . "/../components/checks.php");
    include_once(__DIR__ . "/../config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: ../src/logout.php");
        exit;
    }

    if(!isset($_POST["roleUsername"]) || !isset($_POST["roleLevel"]) || !isset($_POST["fc"]))
    {
        header("location: ../accounts.php");
        exit;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint."/web/accounts/role/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
        http_build_query(
            array(
                "username" => $_COOKIE["username"],
                "password" => $_COOKIE["password"],
                "roleUsername" => $_POST["roleUsername"],
                "roleLevel" => $_POST["roleLevel"]
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
            header("location: ../editUser.php?fc=".$_POST["fc"]."&saved");
            exit;
        }
        else
        {
            header("location: ../editUser.php?fc=".$_POST["fc"]."&error=".$response->result."&cause=API");
            exit; 
        }
    }
    else
    {
        header("location: ../editUser.php?fc=".$_POST["fc"]."&error=".$httpcode."&cause=HTTP");
        exit;
    }

?>