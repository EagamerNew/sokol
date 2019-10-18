<?php

include('../database_connection.php');

$query = "SELECT * FROM participant WHERE id = ".$_GET['id']." ORDER BY id";

$statement = $connect->prepare($query);

if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }

    echo json_encode($data);
}

?>