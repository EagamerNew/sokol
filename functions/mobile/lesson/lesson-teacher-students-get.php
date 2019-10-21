<?php

include('../../database_connection.php');

header("Content-Type: application/json; charset=UTF-8");

$id = (int)$_GET['lessonId'];
$query = "SELECT st.surname as surname, st.name as name,
 st.lastname as lastname, ac.status as status 
 FROM participant st, attendance ac WHERE st.id = ac.studentId AND ac.lessonId = ".$id."";


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