<?php

header("Access-Control-Allow-Origin: *");
include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$email = $form_data->email;
$phone = $form_data->phone;
$type = "teacher";

$querySelect = "SELECT id FROM main WHERE email='$email' && phone='$phone'";
$statement = $connect->prepare($querySelect);
$data = array();
if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    if(!$data){
        $querySelect = "SELECT id FROM participant WHERE email='$email' && phone='$phone'";
        $statement = $connect->prepare($querySelect);
        $type = "student";

        if($statement->execute()) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            $data[0]["type"] = $type;
            if(!$data){
                echo '{"id":null}';
            }else{
                echo json_encode($data[0]);
            }
        }
    }else{
        $data[0]["type"] = $type;
        echo json_encode($data[0]);
    }
}
?>
