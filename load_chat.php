<?php

$user1=$_POST["id1"];
$user2=$_POST["id2"];

//$user1=5;
//$user2=7;

$connection=new mysqli("localhost","root","S@T25P!H80p#*&","calculator_chat");
$table = $connection->query("SELECT status.name, chat.id,chat.message,chat.date_time,chat.user_from_id,chat.user_to_id FROM `chat` INNER JOIN 
`status` on `chat`.`status_id`=`status`.`id` WHERE 
(`user_from_id`='".$user1."' AND `user_to_id`='".$user2."') OR
(`user_from_id`='".$user2."' AND `user_to_id`='".$user1."') ORDER BY `date_time` ASC");

$table2=$connection->query("UPDATE `chat` SET `status_id`='2' WHERE `user_from_id`='".$user2."' AND `user_to_id`='".$user1."'");


$chatArray = array();

for($x=0;$x<$table->num_rows;$x++){
    $row=$table->fetch_assoc();
    $chatobject=new stdClass();
    $chatobject->msg=$row["message"];
    $chatobject->time=$row["date_time"];

    $chatobject->id=$row["id"];
    
    $chatobject->status=$row["name"];
    
    $phpDateTimeObject=strtotime($row["date_time"]);
    $timeStr = date('h:i a',$phpDateTimeObject);
    $chatobject->time=$timeStr; 

   if($row["user_from_id"]==$user1){
        $chatobject->side="sent";

    }else{
        $chatobject->side="seen";
    }
    //$chatobject->status=strtolower($row["last_name"]);
    $chatArray[$x]=$chatobject;
}
$responseJSON=json_encode($chatArray);
echo($responseJSON);

?>