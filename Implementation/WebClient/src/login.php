<?php
    include_once(__DIR__ . "/../config.php");

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint."/accounts/login/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
        http_build_query(
            array(
                "username" => $_POST["username"],
                "password" => $_POST["password"]
            )
        )
    );
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);

    echo $httpcode;

    if($httpcode < 400)
    {
        if($response->result == 200)
        {
            //Check if the user has a sufficent role to use the website
            $role = $response->content->roleCode;
            if($role > 1) //More than a regular user
            {
                //Set credentials cookie
                setcookie("username", $_POST["username"], time() + 86400 /*Lasts 1 day*/, "/");
                setcookie("password", $_POST["password"], time() + 86400 /*Lasts 1 day*/, "/");
                
                //Check if the user has more permissions than an officer (administrator or system)
                if($role > 2)
                {
                    setcookie("admin", "1", time() + 86400 /*Lasts 1 day*/, "/");
                }
                
                //Send to the reports page
                header("location: ../reports.php");
                exit;
            }
            else{
                header("location: ../index.php?error=403&message=Insufficent permissions: unauthorized");
                exit;
            }            
        }
        else
        {
            header("location: ../index.php?error=". $response->result . "&message=". $response->message);
            exit;
        }
    }
    else{
        //Error 0: request to the API unsiccesful
        header("location: ../index.php?error=0&message=API request error");
        exit;
    }
?>