<?php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

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
$created=$form_data->created;

$data = array();
$query = "
    INSERT INTO participant 
    (
        userId,name,lastname,surname,email,
        idn,phone, regionId,
        specId,qualId,educId,skills,created,
        attend,absent
    ) VALUES 
    (
        ".$userId.",'".$name."', '".$lastname."' , '".$surname."','".$email."', 
        '".$idn."' ,'".$phone."' ,".$regionId." ,
        ".$specId." ,".$qualId." , ".$educId.", '".$skills."', '$created',
        0,0
    )
";
$statement = $connect->prepare($query);
$hell = $statement->execute($data);
if($hell)
{
    $message = 'Data Inserted';
}else{

    $message = "Error".$hell;
}


$to = $email;
$subject = "Регистрация прошла успешно";
$txt = "Привет $name! Вас внесли как учащегося на портале Digital Control.Скачайте мобильное приложение чтобы отмечать свою посещаемость!\nДля Android: [link]\nДля iOS: [link]";
$headers = "From: no-reply@digitalcontrol.kz";

//mail($to,$subject,$txt,$headers);
$fio = "$surname $name $lastname";
$message = "Привет $fio! Вас внесли как учащегося на портале Digital Control.Скачайте мобильное приложение чтобы отмечать свою посещаемость!\nДля Android: [link]\nДля iOS: [link]";
list($sms_id, $sms_cnt, $cost, $balance) = send_sms('7'.$phone, $message, 0);


$temp = $statement->fetch(PDO::FETCH_ASSOC);
echo ($connect->lastInsertId());
?>
    