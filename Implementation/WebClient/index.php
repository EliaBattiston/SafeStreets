<?php
    //If the user is already logged in, send them to the reports page
    if(isset($_COOKIE["username"]) && isset($_COOKIE["password"]))
    {
        header("location: reports.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets Authority login</title>
    <?php include("components/header.php") ?>

    <style type="text/css">
        body {
            background-color: #33669A;
        }

        body>.grid {
            height: 100%;
        }

        .image {
            margin-top: -100px;
        }

        .column {
            max-width: 450px;
        }
    </style>
    <script>
        $(document)
            .ready(function () {
                $('.ui.form')
                    .form({
                        fields: {
                            email: {
                                identifier: 'username',
                                rules: [
                                    {
                                        type: 'empty',
                                        prompt: 'Please enter your username'
                                    }
                                ]
                            },
                            password: {
                                identifier: 'password',
                                rules: [
                                    {
                                        type: 'empty',
                                        prompt: 'Please enter your password'
                                    }
                                ]
                            }
                        }
                    })
                    ;
            })
            ;
    </script>
</head>

<body>

    <div class="ui middle aligned center aligned grid">
        <div class="ui column secondary segment">
            <h1 class="ui green image header">
                <img src="images/SafeStreets_logo.svg" class="image">
                <div class="content">
                    Authority login
                </div>
            </h1>
            <form class="ui large form <?php if(isset($_GET["error"])) echo "error" ?>" action="src/login.php" method="POST">
                <div class="ui error message">
                    <?php
                        if(isset($_GET["message"]) && $_GET["message"] != "")
                        {
                            echo $_GET["message"];
                        }
                        else if(isset($_GET["error"]))
                        {
                            switch($_GET["error"])
                            {
                                case 401:
                                    echo "The username/password pair is incorrect";
                                    break;
                                case 402:
                                    echo "Your account is suspended";
                                    break;
                                default:
                                    echo "Error " . $_GET["error"];
                                    break;
                            }
                        }
                    ?>
                </div>

                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="ui fluid large green submit button">Login</div>
                </div>
            </form>

            <div class="ui message">
                Need an institutional account? <a href="mailto:elia.battiston@mail.polimi.it">Contact us</a>
            </div>
        </div>
    </div>

</body>

</html>