<?php

$mobile = $_POST["mobile"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$password = $_POST["password"];
$verifypassword = $_POST["verifypassword"];
$city = $_POST["city"];
$profile_picture_location = $_FILES["profile_Image"]["tmp_name"];


$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");

$table = $connection->query("SELECT `id` FROM `city` where `name`='" . $city . "'");

$row = $table->fetch_assoc();
$city_id = $row["id"];

$table = $connection->query("INSERT INTO `user`(`mobile`,`first_name`,`last_name`,`password`,`profile_url`,`city_id`)
VALUES ('" . $mobile . "','" . $firstname . "','" . $lastname . "','" . $password . "','upload/" . $mobile . ".jpeg','" . $city_id . "')
");


move_uploaded_file($profile_picture_location, "./upload/" . $mobile . ".jpeg");

?>