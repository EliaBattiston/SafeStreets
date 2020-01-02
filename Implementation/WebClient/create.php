<?php 
    include("components/checks.php");
    include_once(__DIR__ . "/config.php");

    if(!isset($_COOKIE["admin"]))
    {
        header("location: src/logout.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets User creation</title>
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
                <?php echo $_GET["cause"] ?> error <?php echo $_GET["error"] ?> when trying to create the user
            </div>
            
        <?php
            }
        ?>

        <div class="ui segment" style="margin-top: 10px;">
            <form method="POST" enctype="multipart/form-data" autocomplete="off" action="src/newUser.php" class="ui form">
                <div class="fields">
                    <div class="eight wide field">
                        <label>Username</label>
                        <div class="ui input" style="width: 100%;"> <input type="text" name="username" required> </div>
                    </div>
                    <div class="eight wide field">
                        <label>Password</label>
                        <div class="ui input" style="width: 100%;"> <input type="text" name="password" required> </div>
                    </div>
                </div>
                <div class="fields">
                    <div class="eight wide field">
                        <label>First name</label>
                        <div class="ui input" style="width: 100%;"> <input type="text" name="firstName" required> </div>
                    </div>
                    <div class="eight wide field">
                        <label>Last name</label>
                        <div class="ui input" style="width: 100%;"> <input type="text" name="lastName" required> </div>
                    </div>
                </div>
                <div class="fields">
                    <div class="eight wide field">
                        <label>Fiscal code</label>
                        <div class="ui input" style="width: 100%;"> <input type="text" name="fiscalCode" pattern="[A-Z0-9]{16}" onkeyup="this.value = this.value.toUpperCase();" required> </div>
                    </div>
                    <div class="eight wide field">
                        <label>Email address</label>
                        <div class="ui input" style="width: 100%;"> <input type="email" name="email" required> </div>
                    </div>
                </div>
                <div class="fields">
                    <div class="sixteen wide field">
                        <label>Document photo</label>
                        <div class="ui input" style="width: 100%;"> <input type="file" name="photo" required> </div>
                    </div>
                </div>
                <button type="submit" class="ui labeled blue icon button" style="margin-top: 10px;">
                    <i class="save icon"></i>
                    Create
                </button>
            </form>
        </div>
    </div>

</body>

</html>