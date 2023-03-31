<?php
$userJSONText = $_POST["userJsonText"];
$userPHPObject = json_decode($userJSONText);

$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");

// Escape the user id to prevent SQL injection
$userId = $connection->real_escape_string($userPHPObject->id);

// Use prepared statement to avoid SQL injection
$statement = $connection->prepare("SELECT * FROM `user` WHERE `id` = ?");
$statement->bind_param("i", $userId);
$statement->execute();
$table = $statement->get_result();

$phpResponseArray = array();

for ($x = 0; $x < $table->num_rows; $x++) {
    $phpArrayItemObject = new stdClass();

    $user = $table->fetch_assoc();
    $phpArrayItemObject->pic = $user["profile_url"];
    $phpArrayItemObject->first_name = $user["first_name"];
    $phpArrayItemObject->last_name = $user["last_name"];
    $phpArrayItemObject->id = $user["id"];
    $phpArrayItemObject->mobile = $user["mobile"];
    $phpArrayItemObject->discription = $user["discription"];

    array_push($phpResponseArray, $phpArrayItemObject);
}

$jsonResponceText = json_encode($phpResponseArray);
echo $jsonResponceText;
?>
