<?php

include('../../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$lessonId= (int)$form_data->lessonId;// qrcode
$qrText= $form_data->qrText;//studentId

$data = array();
$query = "
    UPDATE lesson SET qrText= '$qrText' WHERE id = $lessonId
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
echo json_encode('{"status":"success"}');

?>
    
