<?php
    include("components/checks.php");
    include_once(__DIR__ . "/config.php");

    if(!isset($_GET["id"]))
    {
        header("location: reports.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets Reports</title>
    <?php include("components/header.php") ?>
</head>
<body>
    <?php include("components/menu.php") ?>

    <div class="ui container">
        <a class="ui left labeled icon button" href="reports.php#<?php echo $_GET["id"] ?>" style="margin-top: 10px;">
            <i class="left arrow icon"></i>
            Back
        </a>
        <?php
            $ch = curl_init();

            $query = http_build_query(
                array(
                    "username" => $_COOKIE["username"],
                    "password" => $_COOKIE["password"],
                    "reportID" => $_GET["id"]
                )
            );
            curl_setopt($ch, CURLOPT_URL, $endpoint."/web/reports/?".$query);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = json_decode(curl_exec($ch));
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);

            if($response->result == 200)
            {
                if(!isset($response->content->pictures) || count($response->content->pictures) == 0)
                {
                    ?>

                    <div class="ui tertiary inverted red segment" style="margin-top: 10px;">
                        No photos found for report <?php echo $_GET["id"] ?>
                    </div>

                    <?php
                }
                else
                {
                    echo '<div class="ui stackable four column grid" style="margin-top: 10px;">';
                    foreach($response->content->pictures as $img)
                    {
                        echo '<div class="column">';
                        echo '<a href="'. $img .'"><img class="ui small bordered image" src="'. $img .'"></a>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            else
            {
                ?>

                    <div class="ui tertiary inverted red segment" style="margin-top: 10px;">
                        Report <?php echo $_GET["id"] ?> doesn't exist
                    </div>

                <?php
            }
        ?>
    </div>
</body>

</html>