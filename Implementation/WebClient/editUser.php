<?php
    include(__DIR__ . "/components/checks.php");
    include_once(__DIR__ . "/config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: src/logout.php");
        exit;
    }

    if(!isset($_GET["fc"]))
    {
        header("location: accounts.php");
        exit;
    }

    $ch = curl_init();

    $query = http_build_query(
        array(
            "username" => $_COOKIE["username"],
            "password" => $_COOKIE["password"],
            "userFiscalCode" => $_GET["fc"]
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
</head>
<body>
    <?php include("components/menu.php") ?>

    <div class="ui container" style="padding-top:90px;">
        <?php
            if($response->result == 200)
            {
                $content = $response->content;
                ?>
                    
                    <?php
                        if(isset($_GET["created"]))
                        {
                    ?>

                        <div class="ui tertiary inverted green segment">
                            User insertion succesful
                        </div>

                    <?php
                        }
                    ?>

                    <div class="ui segment">
                        <form method="POST" action="src/changeRole.php">
                            <!-- Start hidden request parameters -->
                            <input type="hidden" name="roleUsername" value="<?php echo $content->username ?>">
                            <input type="hidden" name="fc" value="<?php echo $_GET["fc"] ?>">
                            <!-- End hidden request paramters -->

                            <h3 class="ui header">
                                <?php echo $content->username; ?>
                            </h3>
                            <table class="ui definition table" style="margin-top: 10px; margin-bottom: 10px;">
                                <tr>
                                    <td>Username</td>
                                    <td><?php echo $content->username; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $content->email; ?></td>
                                </tr>
                                <tr>
                                    <td>Fiscal code</td>
                                    <td><?php echo $content->fiscalCode; ?></td>
                                </tr>
                                <tr>
                                    <td>Fist name</td>
                                    <td><?php echo $content->firstName; ?></td>
                                </tr>
                                <tr>
                                    <td>Last name</td>
                                    <td><?php echo $content->lastName; ?></td>
                                </tr>
                                <tr>
                                    <td>Suspended</td>
                                    <td><?php
                                        if($content->suspended)
                                        {
                                            echo '<i class="check circle icon"></i>';
                                            echo $content->suspendedTimestamp;
                                        }
                                        else
                                        {
                                            echo '<i class="times circle icon"></i> ';
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Accepted</td>
                                    <td><?php
                                        if($content->acceptedTimestamp != NULL)
                                        {
                                            echo '<i class="check circle icon"></i> ';
                                            echo $content->acceptedTimestamp;
                                        }
                                        else
                                        {
                                            echo '<i class="times circle icon"></i>';
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td>
                                        <?php
                                            if($content->roleCode < 4)
                                            {
                                        ?>
                                            <select class="ui right floated selection dropdown" name="roleLevel" onchange='$("#saveBtn").attr("style", "display:none"); $("#regBtn").attr("style", "");'>
                                                <option value="1" <?php if($content->roleCode == 1) echo "selected"; ?>>Regular</option>
                                                <option value="2" <?php if($content->roleCode == 2) echo "selected"; ?>>Officer</option>
                                                <option value="3" <?php if($content->roleCode == 3) echo "selected"; ?>>Administrator</option>
                                            </select>
                                            
                                            <button id="savedBtn" class="ui right labeled right floated green icon button" type="submit" id="saved" <?php if(!isset($_GET["saved"])) echo "style='display:none'" ?>>
                                                <i class="right check icon"></i>
                                                Saved
                                            </button>

                                            <button id="regBtn" class="ui right labeled right floated blue icon button" type="submit" id="saved" <?php if(isset($_GET["saved"])) echo "style='display:none'" ?>>
                                                <i class="right save icon"></i>
                                                Save
                                            </button>
                                        <?php
                                            }
                                            else
                                            {
                                                echo $content->roleDesc;
                                            }
                                        ?>

                                        <br>

                                        <?php
                                            if(isset($_GET["error"]))
                                            {
                                                ?>
                                            <div class="ui tertiary inverted red segment" style="margin-top: 10px;">
                                                <?php echo $_GET["cause"] ?> error <?php echo $_GET["error"] ?> when trying to change the role
                                            </div>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <?php
                            if(!isset($content->documentPhoto))
                            {
                                ?>
            
                                <div class="ui tertiary inverted red segment" style="margin-top: 10px;">
                                    No photo for user <?php echo $_GET["fc"] ?>
                                </div>
            
                                <?php
                            }
                            else
                            {
                                echo '<a href="'. $content->documentPhoto .'"><img class="ui small bordered image" src="'. $content->documentPhoto .'"></a>';
                            }
                        ?>
                    </div>

                <?php
            }
            else
            {
                ?>

                    <div class="ui tertiary inverted red segment" style="margin-top: 10px;">
                        User with fiscal code <?php echo $_GET["fc"] ?> doesn't exist
                    </div>

                <?php
            }
        ?>

        <a class="ui left labeled icon button" href="accounts.php#<?php echo $_GET["fc"] ?>" style="margin-top: 10px;">
            <i class="left arrow icon"></i>
            Back
        </a>
    </div>
</body>

</html>