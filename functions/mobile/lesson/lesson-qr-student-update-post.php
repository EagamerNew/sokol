<?php

include('../../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$studentId= (int)$form_data->studentId;
$qrText= $form_data->qrText;


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
            UPDATE attendance SET status= 'attend' WHERE studentId = $studentId AND lessonId = $lessonId 
          ";
        $statement = $connect->prepare($query);
        $message = '';
        if($statement->execute())
        {
            $message = '{"answer":"Data Inserted"}';
        }else{

            $message = "Error".$hell;
        }
    }
}
echo $message;
?>
