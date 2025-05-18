<?php
include '../ConnectDataBase.php';
// -------------------------------START DELETE STUDENT-----------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Stu_id'])) {
    $StuId = intval($_POST['Stu_id']);
    
    $sql = "DELETE FROM student WHERE Stu_id = '$StuId'";
    if ($connection->query($sql) == TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete Student"]);
    }
    $connection->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

// -------------------------------END DELETE STUDENT-----------------------


// -------------------------------START DELETE COURSE-----------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $courseId = intval($_POST['course_id']);
    
    $sql1 = "DELETE FROM lesson WHERE course_id = '$courseId'";
    $sql2 = "DELETE FROM courses WHERE course_id = '$courseId'";
    if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete course"]);
    }
    $connection->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
// -------------------------------END DELETE LESSON-----------------------

// -------------------------------START DELETE LESSON-----------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['l_id'])) {
    $lessonId = intval($_POST['l_id']);
    
    $sql = "DELETE FROM lesson WHERE lesson_id = '$lessonId'";
    if ($connection->query($sql) == TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete lesson"]);
    }
    $connection->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
// -------------------------------END DELETE LESSON-----------------------


// -------------------------------START DELETE ASSIGNMENT-----------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ass_id'])) {
    $assignmentId = intval($_POST['ass_id']);
    
    $sql = "DELETE FROM assignment WHERE ass_id = '$assignmentId'";
    if ($connection->query($sql) == TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete assignment"]);
    }
    $connection->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
// -------------------------------END DELETE ASSIGNMENT-----------------------
?>
