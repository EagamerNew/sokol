<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$id = $form_data->id;

$data = array();
$message = "";
$query = "DELETE FROM education_graphic  WHERE id=".$id."  ";
$message = $message." del;";

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