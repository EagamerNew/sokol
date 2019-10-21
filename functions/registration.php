<?php

include('database_connection.php');
include_once "smsc_api.php";

$form_data = json_decode(file_get_contents("php://input"));

$name = $form_data->name;
$surname= $form_data->surname;
$lastname= $form_data->lastname;
$email= $form_data->email;
$phone= $form_data->phone;
$password= $form_data->password;
$uchcenter= $form_data->uchcenter;
$bin= $form_data->bin;
$fact_address= $form_data->fact_address;
$project_vmest= $form_data->project_vmest;
$specialization= $form_data->specialization;
$srokObuch= $form_data->srokObuch;
$language= $form_data->language;
$lessons= $form_data->lessons;
$groups= $form_data->groups;
//$strSpecializations=$form_data->strSpecializations;
$file_ustav = $form_data->file_ustav;
$file_rekvisity = $form_data->file_rekvisity;
$file_uchdocs = $form_data->file_uchdocs;
// $imgData = addslashes(file_get_contents($uchDocs));

$data = array(
    ':name'  => $name,
    ':surname'  => $surname,
    ':lastname'  => $lastname,
    ':email'  => $email,
    ':password'  => $password
  
);
  // ':bin'  => $bin
    // ':fact_address'  => $fact_address
    // ':project_vmest'  => $project_vmest
    // ':specialization'  => $specialization
    // ':srokObuch'  => $srokObuch
    // ':language'  => $language
    // ':lessons'  => $lessons
    // ':groups'  => $groups
    // ':specializations'  => $specializations
$query = "
    INSERT INTO main 
    (
        name,lastname,surname,email,phone,password,
        uchcenter,bin, fact_address,
        project_vmest,srokObuch,specialization,
        language,lessons,groups,
        file_ustav, file_rekvisity,file_uchdocs

    ) VALUES 
    (
        '".$name."', '".$lastname."' , '".$surname."','".$email."','".$phone."', '".$password."',
        '".$uchcenter."' ,'".$bin."' ,'".$fact_address."' ,
        '".$project_vmest."' ,'".$srokObuch."' , '".$specialization."',
        '".$language."' ,'".$lessons."' ,'".$groups."' ,
        '".$file_ustav."' ,'".$file_rekvisity."' ,'".$file_uchdocs."' 
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
$txt = "Привет $name! Вы зарегистрировались на digitalcontrol.kz, скачайте приложение для дальнейшей работы.\nAndroid: скачать\niOS: скачать";
$headers = "From: no-reply@digitalcontrol.kz";

mail($to,$subject,$txt,$headers);
$fio = "$surname $name $lastname";
$message = "Здравствуйте, $fio, Вы зарегистрировались на портале Digital Control. Скачайте мобильное приложение чтобы отмечать посещаемость своих учеников!\nДля Android: [link]\nДля iOS: [link]";
//list($sms_id, $sms_cnt, $cost, $balance) = send_sms('7'.$phone, $message, 1);

$temp = $statement->fetch(PDO::FETCH_ASSOC);
echo ($connect->lastInsertId());

?>
    