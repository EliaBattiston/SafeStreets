<?php
    include(__DIR__ . "/../components/checks.php");
    include_once(__DIR__ . "/../config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: ../src/logout.php");
        exit;
    }

    if(!isset($_GET["username"]))
    {
        header("location: ../accpetance.php");
        exit;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint."/web/accounts/acceptance/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
        http_build_query(
            array(
                "username" => $_COOKIE["username"],
                "password" => $_COOKIE["password"],
                "acceptedUser" => $_GET["username"]
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
            header("location: ../acceptance.php");
            exit;
        }
        else
        {
            header("location: ../acceptance.php?error=".$response->result."&cause=API");
            exit; 
        }
    }
    else
    {
        header("location: ../acceptance.php?error=".$httpcode."&cause=HTTP");
        exit;
    }

?>