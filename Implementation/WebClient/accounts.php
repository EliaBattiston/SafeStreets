<?php 
    include("components/checks.php");
    include_once(__DIR__ . "/config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: src/logout.php");
        exit;
    }

    $ch = curl_init();

    $query = http_build_query(
        array(
            "username" => $_COOKIE["username"],
            "password" => $_COOKIE["password"]
        )
    );
    curl_setopt($ch, CURLOPT_URL, $endpoint."/web/accounts/?".$query);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);

    if($response->result == 401)
    {
        header("location: src/logout.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets Accounts</title>
    <?php include("components/header.php") ?>
    <script>
        $(document).ready(function() {
            $('#data').DataTable();
        });
    </script>
</head>
<body>
    <?php include("components/menu.php") ?>

    <div class="ui container" style="padding-top:90px;">
        <table id="data" class="ui celled table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Fiscal code</th>
                    <th>First name</th>
                    <th>Second name</th>
                    <th>ID photo</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <?php
                if($response->result == 200)
                {
                    foreach($response->content as $user)
                    {
                        echo "<tr>";
                        echo "<td>".$user->username."</td>";
                        echo "<td>".$user->fiscalCode."</td>";
                        echo "<td>".$user->firstName."</td>";
                        echo "<td>".$user->lastName."</td>";
                        echo '<td class="center aligned"><a class="ui blue icon button" href="#"><i class="linkify icon"></i></a></td>';
                        echo "<td>".$user->roleDesc."</td>";
                        echo '<td class="center aligned"><a class="ui labeled icon button" href="editUser.php?name='. $user->username .'"><i class="edit icon"></i>Edit</a></td>';
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>

</body>

</html>