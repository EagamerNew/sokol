<?php

include('../database_connection.php');

$query = "SELECT * FROM education_program WHERE userId = ".$_GET['userId']." ORDER BY id";

$statement = $connect->prepare($query);

if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    if(is_null($data)){
        echo json_encode("");
    }else{
        echo json_encode($data);
    }
}

?>