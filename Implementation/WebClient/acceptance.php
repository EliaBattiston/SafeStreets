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
    <title>SafeStreets User acceptance</title>
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
        <?php
            if(isset($_GET["error"]))
            {
        ?>

            <div class="ui tertiary inverted red segment">
                <?php echo $_GET["cause"] ?> error <?php echo $_GET["error"] ?> when trying to accept the user
            </div>
            
        <?php
            }
        ?>

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
                        if($user->acceptedTimestamp == NULL)
                        {
                            echo "<tr><a name='".$user->fiscalCode."'>";
                            echo "<td>".$user->username."</td>";
                            echo "<td>".$user->fiscalCode."</td>";
                            echo "<td>".$user->firstName."</td>";
                            echo "<td>".$user->lastName."</td>";
                            echo '<td class="center aligned"><a class="ui blue icon button" href="'.$user->documentPhoto.'"><i class="linkify icon"></i></a></td>';
                            echo "<td>".$user->roleDesc."</td>";
                            echo '<td class="center aligned"><a class="ui green labeled icon button" href="src/acceptUser.php?username='. $user->username .'"><i class="check icon"></i>Accept</a></td>';
                            echo "</a></tr>";
                        }
                    }
                }
            ?>
        </table>
    </div>

</body>

</html>