<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$id = $form_data->id;
$userId = $form_data->userId;
$dayId= $form_data->dayId;
$timeStartId= $form_data->timeStartId;
$timeEndId= $form_data->timeEndId;
$educProgId= $form_data->educProgId;

$data = array();
$message = "";
if($id == -1){
    $query = "
    INSERT INTO education_graphic 
    (
        userId,dayId,timeStartId,timeEndId,educProgId

    ) VALUES 
    (
        ".$userId.", ".$dayId." , ".$timeStartId.", ".$timeEndId.",".$educProgId."
    )
    ";
    $message = $message." add;";
}else{
    $query = "
    UPDATE education_graphic 
    SET timeStartId=".$timeStartId.",timeEndId=".$timeEndId.", dayId=".$dayId.",educProgId=".$educProgId."  WHERE id=".$id."  ";
    $message = $message." edit;";

}
$statement = $connect->prepare($query);
$hell = $statement->execute($data);
if($hell)
{
    $message = 'Data Inserted';
}else{

    $message = "Error".$hell;
}
$message = $message." ".$hell;

// $temp = $statement->fetch(PDO::FETCH_ASSOC);
echo ($message);

?>