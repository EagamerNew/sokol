<?php

header("Access-Control-Allow-Origin: *");
include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$email = $form_data->email;
$password = $form_data->password;

$querySelect = "SELECT id FROM main WHERE email='$email' && password='$password'";
$statement = $connect->prepare($querySelect);
$data = array();
if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    if(!$data){
        echo '{"id":null}';
    }else{
        echo json_encode($data[0]);
    }
}
?>
