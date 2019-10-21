<?php

include('../../database_connection.php');

header("Content-Type: application/json; charset=UTF-8");

$query = "SELECT st.surname as surname, st.name as name,
 st.lastname as lastname, ac.status as status 
 FROM participant st, attendance ac WHERE st.id = ac.studentId AND ac.lessonId = ".$_GET['lessonId']." AND ac.status='attend'";


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