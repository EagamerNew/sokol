<?php

include('../../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$educGraphId = $form_data->educGraphId;
$teacherId= $form_data->teacherId;
$status= 'created';
$created=$form_data->created;

$qrText = '';
$mil = '';

$educProgId = 0;

$data = array();
$querySelect = "SELECT * FROM education_graphic WHERE id='$educGraphId'";
$statement = $connect->prepare($querySelect);
if($statement->execute()){
    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    if($data) {
        $educProgId = (int)$data[0]["educProgId"];
//        echo json_encode($data[0]); have this get
    }
}
$query = "
    INSERT INTO lesson 
    (
        teacherId, educGraphId, qrText,mil,
        status,created
    ) VALUES 
    (
        $teacherId, $educGraphId, '$qrText', '$mil', 
        '$status', '$created'
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

$temp = $statement->fetch(PDO::FETCH_ASSOC);
$lesson = array('');
echo ($connect->lastInsertId());
?>
