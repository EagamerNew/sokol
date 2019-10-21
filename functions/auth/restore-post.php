<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
header("Access-Control-Allow-Origin: *");
include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$email = $form_data->email;
$type = "no";
$id = 0;
$password = "";

$querySelect = "SELECT id, password FROM main WHERE email='$email'";
$statement = $connect->prepare($querySelect);
$data = array();
if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    if(!$data){
        $querySelect = "SELECT id,password FROM participant WHERE email='$email'";
        $statement = $connect->prepare($querySelect);

        if($statement->execute()) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            if(!$data){
                $type = 'no';
            }else{
                $type = 'participant';
                $id = (int)$data[0]["id"];
                $password = $data[0]["password"];
            }
        }
    }else{
        $type = 'main';
        $id = (int)$data[0]["id"];
        $password = $data[0]["password"];
    }

    if($type == "main" || $type == "participant"){
        $to = $email;
        $subject = "Данные о входе";
        $txt = "Здравствуйте! Вы запросили свои данные для входа в digitalcontrol.kz\nВаши данные:\nЛогин:$email\nПароль:$password";
        $headers = "From: no-reply@digitalcontrol.kz";

        $rs = mail($to,$subject,$txt,$headers);
//        echo "{'id':$id}";
        echo $id.'asdf';
    }else{
        echo null;
    }
}
?>
