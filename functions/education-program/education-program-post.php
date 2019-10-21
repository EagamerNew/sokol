<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$id = $form_data->id;
$userId = $form_data->userId;
$total= $form_data->total;
$busy= $form_data->busy;
$specId= $form_data->specId;
$theme= $form_data->theme;

$data = array();
$message = "";
if($id == -1){
    $query = "
    INSERT INTO education_program  
    (
        userId,theme,specId, total,busy

    ) VALUES 
    (
        ".$userId.", '$theme',".$specId.", ".$total.", ".$busy."
    )
    ";
    $message = $message." add;";
}else{
    $query = "
    UPDATE education_program  
    SET theme='$theme', total=".$total.",busy=".$busy.",specId=".$specId."  WHERE id=".$id."  ";
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