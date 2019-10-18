<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$id = $form_data->id;
$userId = $form_data->userId;
$dayId= $form_data->dayId;
$specId= $form_data->specId;
$themeId= $form_data->themeId;

$data = array();
$message = "";
if($id == -1){
    $query = "
    INSERT INTO education_program  
    (
        userId,dayId,themeId,specId

    ) VALUES 
    (
        ".$userId.", ".$dayId." , ".$themeId.",".$specId."
    )
    ";
    $message = $message." add;";
}else{
    $query = "
    UPDATE education_program  
    SET themeId=".$themeId.", dayId=".$dayId.",specId=".$specId."  WHERE id=".$id."  ";
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