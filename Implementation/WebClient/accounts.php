<?php 
    include("components/checks.php");

    if(!isset($_COOKIE["admin"]))
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

    <div class="ui container">
        <table class="ui celled table" style="margin-top: 50px;">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Second name</th>
                    <th>Fiscal code</th>
                    <th>ID photo</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>Authority</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>Authority</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>Authority</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>Admin</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>Admin</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr><tr>
                <td>mario.rossi@mailprovider.com</td>
                <td>marioRossi99</td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>RSSMRA80A01F205X</td>
                <td class="center aligned">
                    <button class="ui blue icon button">
                        <i class="linkify icon"></i>
                    </button>
                </td>
                <td>User</td>
                <td class="center aligned">
                    <button class="ui labeled icon button">
                        <i class="edit icon"></i>
                        Edit
                    </button>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>