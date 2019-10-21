<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$id = $form_data->id;
$name = $form_data->name;
$userId = $form_data->userId;
$surname= $form_data->surname;
$lastname= $form_data->lastname;
$email= $form_data->email;
$idn= $form_data->idn;
$phone= $form_data->phone;
$regionId = $form_data->regionId;
$specId= $form_data->specId;
$qualId= $form_data->qualId;
$educId=$form_data->educId;
$skills=$form_data->skills;

$data = array(
    ':name'  => $name,
    ':surname'  => $surname,
    ':lastname'  => $lastname,
    ':email'  => $email
);
$query = "
    UPDATE participant SET name = '$name', surname='$surname', lastname='$lastname',
                           email='$email', idn='$idn', phone='$phone', regionId='$regionId',
                           specId='$specId', qualId='$qualId', educId='$educId', skills='$skills'
                           WHERE id = $id
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

?>
    