<?php

include('../../database_connection.php');
$form_data = json_decode(file_get_contents("php://input"));
header("Content-Type: application/json; charset=UTF-8");

$teacherId = (int)$form_data->teacherId;
$day = (int)$form_data->day;
$hour = (int)$form_data->hour;
$created = $form_data->created;

$data = array();
$educGraph = array();
$educGraphId = 0;
$educProgId = 0;
$type = "created";
$selectEducGraph = "SELECT * FROM education_graphic 
    WHERE userId = $teacherId AND dayId = $day AND (timeStartId = $hour OR timeStartId > $hour) LIMIT 1";
$statement = $connect->prepare($selectEducGraph);
if($statement->execute()){
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    if($data){
        $educGraph = $data[0];
        $educGraphId = (int)$data[0]['id'];
        $educProgId = (int)$data[0]['educProgId'];
        $data = array();
        $specTitleText = "";
        $timeStartId = (int)$educGraph['timeStartId'];
        $timeEndId = (int)$educGraph['timeEndId'];
        $lessons = array();
//        echo json_encode($educGraph);
        // check if we have lesson
        $selectLesson = "SELECT * FROM lesson WHERE educGraphId=$educGraphId AND teacherId=$teacherId AND created = '$created' LIMIT 1";
        $statement = $connect->prepare($selectLesson);
        if($statement->execute()){
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $lessons[] = $row;
            }

            // get spec name by educProgId
            $selectSpecTitle = "SELECT us.title title FROM user_spec us WHERE us.id = (SELECT specId FROM education_program WHERE id = $educProgId)";
            $statement = $connect->prepare($selectSpecTitle);
            if($statement->execute()){
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $specTitle[] = $row;
                }
                if($specTitle){
                    $specTitleText = $specTitle[0]["title"];
                }
            }
//            echo 'spectitlequery:'.$selectSpecTitle;
//            echo ';timeStart:'.json_encode($specTitle);
//            echo '      ';
//            echo json_encode($educGraph);
            if($lessons){
                $type = "current";
                $lessons[0]['type'] = $type;
                $lessons[0]['timeStartId'] = $timeStartId;
                $lessons[0]['timeEndId'] = $timeEndId;
                /*$lessons[0]['title'] = $specTitleText;*/
                $lessons[0]['name'] = $specTitleText;
                /*$lessons[0]['title'] = "математик";*/
                echo json_encode($lessons[0]);
            }else{
                // we haven't lesson and create lesson
                $createLesson = "INSERT INTO lesson(teacherId, educGraphId,status,created, qrText, mil)
                    VALUE($teacherId, $educGraphId, 'started', '$created', '','')";
                $statement = $connect->prepare($createLesson);
                $statement->execute();
                $statement->fetch(PDO::FETCH_ASSOC);
                $resLessonId = $connect->lastInsertId();
//                echo json_encode($res);
//                echo 'asldfajsldfk';
                // create attendance for all students
                // first, get all student ids
                $students = array();
                $studentId = 0;
                $selectStudents = "SELECT id FROM participant WHERE qualId = $educProgId";
                $statement = $connect->prepare($selectStudents);
//                echo $selectStudents;
                if($statement->execute()){
                    $count = 0;
//                    echo $resLessonId;
                    while($row = $statement->fetch(PDO::FETCH_ASSOC))
                    {
                        $students[] = $row;
                        $count++;
                    }
//                    echo 'count: '.$count;
                    $i = 0;
                    while($i < $count){
                        $studentId = (int) $students[$i]["id"];
                        $createStudentAttendance = "INSERT INTO attendance(studentId, lessonId,status)
                            VALUE ($studentId, $resLessonId, '')";
                        $statement = $connect->prepare($createStudentAttendance);
                        $statement->execute();
                        $i++;
                    }
                    $type = "created";
                    /*print_r ('{"id":'.$resLessonId.', "type":"'.$type.'", "timeStartId": '.$timeStartId.', "timeEndId":'.$timeEndId.', "title":"'.$specTitleText.'"}');*/
                    print_r ('{"id":'.$resLessonId.', "type":"'.$type.'", "timeStartId": '.$timeStartId.', "timeEndId":'.$timeEndId.', "name":"'.$specTitleText.'"}');
                    if(!$students) {
                        echo '--STUDENTS_NOT_FOUND--';
                    }
                }
            }
        }

    }else{
        echo json_encode([]);
//        echo $selectEducGraph;
    }
}
//$query = "SELECT * FROM participant WHERE id = ".$_GET['id']." ORDER BY id";
//
//$statement = $connect->prepare($query);
//
//if($statement->execute())
//{
//    while($row = $statement->fetch(PDO::FETCH_ASSOC))
//    {
//        $data[] = $row;
//    }
//
//    echo json_encode($data);
//}
//
//echo date('w') + 1;
//$date = strtotime("15:00");
//echo "\n";
//echo date('H', $date);
//echo ' ';
//echo date('Y-m-d H:i:s');
?>