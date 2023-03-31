
<?php

$userJSONText = $_POST["userJSONText"];
$userPHPObject = json_decode($userJSONText);

$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");

// Escape the user id to prevent SQL injection
$userId = $connection->real_escape_string($userPHPObject->id);

// Use prepared statement to avoid SQL injection
$statement = $connection->prepare("SELECT * FROM `user` WHERE `id` != '$userId' AND (`first_name` LIKE '%" . $_POST["text"] . "%' OR `last_name` LIKE '%" . $_POST["text"] . "%')");
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

    $statement2 = $connection->prepare("SELECT * FROM `chat` WHERE (`user_from_id`='$userId' 
    AND `user_to_id`='" . $user["id"] . "') OR (`user_from_id`='" . $user["id"] . "' AND `user_to_id`='$userId') ORDER BY `date_time` DESC");
    $statement2->execute();
    $table2 = $statement2->get_result();

    if ($table2->num_rows == 0) {
        $phpArrayItemObject->msg = "";
        $phpArrayItemObject->time = "";
        $phpArrayItemObject->count = "0";
    } else {
        //unseen chat count
        $unseenChatCount = 0;

        //first row
        $lastChatRow = $table2->fetch_assoc();

        if ($lastChatRow["status_id"] == 2) {
            $unseenChatCount++;
        }

        $phpArrayItemObject->msg = $lastChatRow["message"];

        $phpDateTimeObject = strtotime($lastChatRow["date_time"]); // fix typo
        $timeStr = date('h:i a', $phpDateTimeObject);

        $phpArrayItemObject->time = $timeStr;

        for ($i = 1; $i < $table2->num_rows; $i++) {
            //other rows
            $newChatRows = $table2->fetch_assoc();
            if ($newChatRows["status_id"] == 2) {
                $unseenChatCount++;
            }
        }

        $phpArrayItemObject->count = $unseenChatCount; // fix assigning zero to count
    }

    array_push($phpResponseArray, $phpArrayItemObject);

}

$jsonResponceText = json_encode($phpResponseArray);
echo $jsonResponceText;



/*



$userJSONText = $_POST["userJSONText"];
$userPHPObject = json_decode($userJSONText);

$connection = new mysqli("localhost", "root", "S@T25P!H80p#*&", "calculator_chat");

//$table = $connection->query("SELECT * FROM `user` WHERE `id` !='" . $userPHPObject->id . "'");

$table = $connection->query("SELECT * FROM `user` WHERE 
`id` !='" . $userPHPObject->id . "'
");



$phpResponseArray = array();

for ($x=0; $x < $table->num_rows; $x++) {

    $phpArrayItemObject = new stdClass();

    $user = $table->fetch_assoc();
    $phpArrayItemObject->pic = $user["profile_url"];
    $phpArrayItemObject->first_name = $user["first_name"];
    $phpArrayItemObject->id = $user["id"];

    $table2 = $connection->query("SELECT * FROM `chat` WHERE
`user_from_id`='" . $userPHPObject->id . "' AND `user_to_id`='" . $user["id"] . "'
OR `user_from_id`='" . $user["id"] . "' AND `user_to_id`='" . $userPHPObject->id . "'
ORDER BY `date_time` DESC");

    if ($table2->num_rows == 0) {
        $phpArrayItemObject->msg = "";
        $phpArrayItemObject->time = "";
        $phpArrayItemObject->count = "0";
        $phpArrayItemObject->id="";
    } else {
        // unseen chat count
        $unseenChatCount = 0;

        // first row
        $lastChatRow = $table2->fetch_assoc();

        if ($lastChatRow["status_id"] == 2) {
            $unseenChatCount++;
        }

        $phpArrayItemObject->msg = $lastChatRow["message"];

        $phpDateTimeObject = strtotime($lastChatRow["date_time"]);
        $timeStr = date('h:i a', $phpDateTimeObject);

        $phpArrayItemObject->time = $timeStr;

        // remaining rows
        while ($newChatRows = $table2->fetch_assoc()) {
            if ($newChatRows["status_id"] == 2) {
                $unseenChatCount++;
            }
        }

        $phpArrayItemObject->count = $unseenChatCount;
    }

    array_push($phpResponseArray, $phpArrayItemObject);
}

$jsonResponseText = json_encode($phpResponseArray);
echo ($jsonResponseText);
*/
?>

