<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('../database_connection.php');


$form_data = json_decode(file_get_contents("php://input"));

//$userId = $form_data->userId;
//$title= $form_data->title;
$values= $form_data->specValues;

$data = array();

$query = "
    INSERT INTO user_spec
    (
        userId,title

    ) VALUES $values
";
$statement = $connect->prepare($query);
$hell = $statement->execute($data);
if($hell)
{
    $message = 'Data Inserted';
}else{

    $message = "Error".$hell;
}

$temp = $statement->fetch(PDO::FETCH_ASSOC);
echo ($connect->lastInsertId());
//echo $specializations;
?>