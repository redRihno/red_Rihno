<?php

$newpwd = $_POST["newpwd"];
$id=$_POST["id"];

//$newpwd=258;
//$id=5;

$connection=new mysqli("localhost","root","S@T25P!H80p#*&","calculator_chat");

$table=$connection->query("UPDATE `user` SET `password` = $newpwd WHERE `id`=$id");

echo("password changed")

?>