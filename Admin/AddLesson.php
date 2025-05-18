<?php

include './AdminHeader.php';
include '../ConnectDataBase.php';

$msg = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['addTopic'])) {
    if (empty($_REQUEST['courseId']) || empty($_REQUEST['lessonNum']) || empty($_REQUEST['topicName']) || empty($_REQUEST['topicDesc']) || !isset($_FILES['lectureLink']) || $_FILES['lectureLink']['error'] != 0) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        // Sanitize input
        $courseId = trim($_REQUEST['courseId']);
        $lessonNum = trim($_REQUEST['lessonNum']);
        $topicName = trim($_REQUEST['topicName']);
        $topicDesc = trim($_REQUEST['topicDesc']);
        
        // File upload handling
        $lectureLink = $_FILES['lectureLink']['name'];
        $lectureLinkTemp = $_FILES['lectureLink']['tmp_name'];
        $lectureFolder = '../lectureVedios/' . $lectureLink;

        if (move_uploaded_file($lectureLinkTemp, $lectureFolder)) {
            // Check if courseId exists in the courses table
            $sql = "SELECT course_id FROM courses WHERE course_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $courseId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Course exists, insert the topic
                $insertQuery = "INSERT INTO lesson (lesson_num, lesson_name, lesson_desc, lesson_link, course_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($insertQuery);
                $stmt->bind_param("isssi", $lessonNum, $topicName, $topicDesc, $lectureFolder, $courseId);

                if ($stmt->execute()) {
                    $msg = '<div class="alert alert-success text-center">Topic Added Successfully!</div>';
                } else {
                    $msg = '<div class="alert alert-danger text-center">Error Adding Topic. Try Again.</div>';
                }
            } else {
                // Course ID not found
                $msg = '<div class="alert alert-warning text-center">Invalid Course ID. Please enter a valid Course ID.</div>';
            }
            $stmt->close();
        } else {
            $msg = '<div class="alert alert-danger text-center">Error uploading file. Try again.</div>';
        }
    }
    $connection->close();
}
?>

<title>EDUTRACK - Add Topic</title>
<div class="container d-flex justify-content-center align-items-center my-3">
    <div class="form-container shadow p-5">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Add New Topic
            <a href="./lessons.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>
        </h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Course Id</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="number" class="form-control" name="courseId" placeholder="Enter Course ID" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Lesson No.</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="number" class="form-control" name="lessonNum" placeholder="Enter Lesson No." required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Topic Name</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="topicName" placeholder="Enter Topic name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Topic Description</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                    <textarea class="form-control" name="topicDesc" rows="3" placeholder="About Topic" required></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload lecture link</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control" name="lectureLink" accept="video/*" required>
                </div>
            </div>

            <div class="mb-3 text-center">
                <button type="submit" name="addTopic" class="btn btn-primary custom-btn-primary">
                    <i class="fas fa-plus-circle"></i> Add Topic
                </button>
            </div>
            <?php
            if (!empty($msg)) {
                echo $msg;
            }
            ?>
        </form>
    </div>
</div>


<?php include '../layout/adminFooter.php'; ?>
