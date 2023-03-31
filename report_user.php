<?php

$jsonRequestText = $_POST["jsonRequestText"];

$phpRequestObject = json_decode($jsonRequestText);

$reporttoid = $phpRequestObject->reportto;
$reportfromid = $phpRequestObject->reportfrom;
$complain = $phpRequestObject->complain;

$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");

$table = $connection->query("INSERT INTO report (`report`, `user_report_from_id`, `user_id1`) VALUES ('$complain', '$reportfromid', '$reporttoid')");

if ($table) {
  echo "Record inserted successfully.";
} else {
  echo "Error inserting record:";
}


?>
