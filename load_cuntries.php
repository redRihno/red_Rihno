<?php

$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");

$table = $connection->query("SELECT * FROM `city`");

$city_array=array();

for($x=0;$x<$table->num_rows;$x++){

$row=$table->fetch_assoc();
array_push($city_array,$row["name"]);

}

$json =  json_encode($city_array);

echo($json);

?>