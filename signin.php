<?php

 $jsonRequestText = $_POST["jsonRequestText"];
 
$phpRequestObject = json_decode($jsonRequestText);


$mobile = $phpRequestObject->mobile;

$password = $phpRequestObject->password;

//$mobile=0754022599;
//$password=123;

$connection=new mysqli("localhost","root","S@T25P!H80p#*&","calculator_chat");
$table = $connection->query("SELECT * FROM `user` WHERE 
`mobile`='".$mobile."' AND `password`='" . $password . "' ORDER BY `id` ASC");

$phpResponseObject = new stdClass();

if ($table->num_rows == 0) {

    $phpResponseObject->msg = "Error";
    $jsonResponseText = json_encode($phpResponseObject);
    echo($jsonResponseText);

} else {

    $phpResponseObject->msg = "Success";

    $row = $table->fetch_assoc();

    $phpResponseObject->user = $row;


    $jsonResponseText = json_encode($phpResponseObject);
    echo($jsonResponseText);
 
}
?>