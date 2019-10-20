<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$userId= (int)$form_data->userId;
$file1= $form_data->fileUchet;
$file2= $form_data->fileSchet;
$file3= $form_data->fileAkt;

$data = array();

$query = "
    INSERT INTO tabulation
    (
        userId, fileUchet,fileSchet,fileAkt

    ) VALUES ($userId, '$file1', '$file2', '$file3')
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