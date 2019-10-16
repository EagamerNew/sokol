<?php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$name = $form_data->name;
$surname= $form_data->surname;
$lastname= $form_data->lastname;
$email= $form_data->email;
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
$strSpecializations=$form_data->strSpecializations;
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
        name,lastname,surname,email,password,
        uchcenter,bin, fact_address,
        project_vmest,srokObuch,specialization,
        language,lessons,groups,specializations,
        file_ustav, file_rekvisity,file_uchdocs

    ) VALUES 
    (
        '".$name."', '".$lastname."' , '".$surname."','".$email."', '".$password."',
        '".$uchcenter."' ,'".$bin."' ,'".$fact_address."' ,
        '".$project_vmest."' ,'".$srokObuch."' , '".$specialization."',
        '".$language."' ,'".$lessons."' ,'".$groups."' ,'".$strSpecializations."',
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
$txt = "Здравствуйте! Спасибо за регистрацию в нашу систему.\nВаши данные для входа:\n\tЛогин:".$email."\n\tПароль:".$password;
$headers = "From: no-reply@digitalcontrol.kz";

mail($to,$subject,$txt,$headers);

$temp = $statement->fetch(PDO::FETCH_ASSOC);
echo ($connect->lastInsertId());

?>
    