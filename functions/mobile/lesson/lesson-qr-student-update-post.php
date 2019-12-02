<?php

include('../../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$studentId= (int)$form_data->studentId;
$qrText= $form_data->qrText;
$time = $form_data->time;


$query = "SELECT * from lesson where qrText = '$qrText'";

$statement = $connect->prepare($query);
$data = array();
if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    if($data){
        $lessonId = (int)$data[0]["id"];
        $query = "
            UPDATE attendance SET status= 'attend', time= '$time' WHERE studentId = $studentId AND lessonId = $lessonId 
          ";
        $statement = $connect->prepare($query);
        $message = '';
        if($statement->execute())
        {
            $message = '{"answer":"Data Inserted"}';
        }else{

            $message = "{'answer':'Error'}";
        }
    }
}
echo json_encode($message);
?>
