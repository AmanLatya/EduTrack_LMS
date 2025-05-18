<?php
include './StudentData.php';

if (isset($_SESSION['is_stuLogin'], $_SESSION['stuLoginEmail'], $_GET['lesson_id'], $_GET['course_id'])) {
    $email = $_SESSION['stuLoginEmail'];
    $lesson_id = $_GET['lesson_id'];
    $course_id = $_GET['course_id'];

    $stuSql = "SELECT Stu_id FROM student WHERE Stu_Email = '$email'";
    $stuResult = $connection->query($stuSql);
    if ($stuResult->num_rows > 0) {
        $stu_id = $stuResult->fetch_assoc()['Stu_id'];

        $insertSql = "INSERT IGNORE INTO lessonprogress (Stu_id, course_id, lesson_id)
                      VALUES ('$stu_id', '$course_id', '$lesson_id')";
        $connection->query($insertSql);
    }
}
?>
