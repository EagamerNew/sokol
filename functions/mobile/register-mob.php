<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$password = $form_data->password;
$id = (int)$form_data->id;
$type = $form_data->type;

$data = array();
if($type == "student"){
    $query = "UPDATE participant SET password='$password' WHERE id=$id";
}else if($type == "teacher"){
    $query = "UPDATE main SET password='$password' WHERE id=$id";
}
$statement = $connect->prepare($query);
$hell = $statement->execute($data);
if($hell)
{
    $message = 'Data Inserted';
}else{

    $message = "Error".$hell;
}

$temp = $statement->fetch(PDO::FETCH_ASSOC);
echo ($temp);
//echo ($connect->lastInsertId());
?>
    