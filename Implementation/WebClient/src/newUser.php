<?php
    include(__DIR__ . "/../components/checks.php");
    include_once(__DIR__ . "/../config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: src/logout.php");
        exit;
    }

    if(!isset($_POST["username"])
        || !isset($_POST["password"])
        || !isset($_POST["firstName"])
        || !isset($_POST["firstName"])
        || !isset($_POST["lastName"])
        || !isset($_POST["fiscalCode"])
        || !isset($_POST["email"])
    )
    {
        header("location: createUser.php?error");
        exit;
    }

    $photo = base64_encode(file_get_contents($_FILES["photo"]["tmp_name"]));

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint."/web/accounts/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
        http_build_query(
            array(
                "username" => $_COOKIE["username"],
                "password" => $_COOKIE["password"],
                "newusername" => $_POST["username"],
                "newpassword" => $_POST["password"],
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "fiscalCode" => $_POST["fiscalCode"],
                "email" => $_POST["email"],
                "documentPhoto" => '"'. $photo .'"'
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
            header("location: ../editUser.php?fc=".$_POST["fiscalCode"]."&created");
            exit;
        }
        else
        {
            header("location: ../create.php?fc=".$_POST["fc"]."&error=".$response->result."&cause=API");
            exit; 
        }
    }
    else
    {
        header("location: ../create.php?fc=".$_POST["fc"]."&error=".$httpcode."&cause=HTTP");
        exit;
    }

?>