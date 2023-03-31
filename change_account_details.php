<?php

// Establish database connection
$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user data from the POST request

$discription = $_POST['discription'];
$userJsonText = $_POST['userJSONText'];
$user = json_decode($userJsonText);

//$firstname = 'stoophoop'; $lastname = "jorge"; $profile_url = "upload/0702193383.jpeg"; $discription = 'discription';

// Construct the SQL update query
$table = "UPDATE `user` SET 
        `first_name` = '$user->first_name',
        `last_name`= '$user->last_name',
        `profile_url`= '$user->profile_url',
        `discription` = '$discription'
        WHERE id = '$user->id'";

// Execute the SQL update query
if (mysqli_query($connection, $table)) {
    echo "ok";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close database connection
mysqli_close($connection);

?>
