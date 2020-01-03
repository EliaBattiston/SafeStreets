<?php

include 'modules/common.php';

$_SERVER["REQUEST_METHOD"] = "POST";
unset($_GET);
unset($_POST);
$_POST["username"] = "userWithReports1";
$_POST["password"] = "test";
$_POST["plate"] = "BB999BB";
$_POST["violationType"] = "1";
$_POST["latitude"] = 45.4312;
$_POST["longitude"] = 9.12584;
$_POST["pictures"] = "[".$picture1.", ".$picture2."]";

echo "username=".$_POST['username']."&password=".$_POST['password']."&plate=".$_POST['plate']."&violationType=".$_POST['violationType']."&latitude=".$_POST['latitude']."&longitude=".$_POST['longitude']."&pictures=".$_POST['pictures'];
?>