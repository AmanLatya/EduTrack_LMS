<?php
include './StudentData.php';
$stuId = $id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = mysqli_real_escape_string($connection, $_POST['assignmentCourseId']);
    $ass_num = mysqli_real_escape_string($connection, $_POST['assignmentNumber']);

    if (isset($_FILES['assignmentFile']) && $_FILES['assignmentFile']['error'] == 0) {
        $file_name = basename($_FILES['assignmentFile']['name']);
        $file_tmp = $_FILES['assignmentFile']['tmp_name'];
        $upload_dir = "uploads/assignments/";

        // Ensure upload directory exists
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . time() . "_" . $file_name; // Unique filename

        // Move file to upload directory
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Insert into database using prepared statements
            $uploadDate = date("Y-m-d H:i:s");
            $submissionDate = date("Y-m-d H:i:s", strtotime("+7 days")); // 7-day deadline

            $stmt = $connection->prepare("INSERT INTO assignmentsSubmission (ass_uploadDate, ass_subDate, ass_file, course_id, ass_num, Stu_id) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiii", $uploadDate, $submissionDate, $file_path, $course_id, $ass_num, $stuId);

            if ($stmt->execute()) {
                echo "<script>alert('Assignment uploaded successfully!'); location.href='CourseAssignment.php';</script>";
            } else {
                echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('File upload failed!');
            location.href='AssignmentSubmission.php?assignmentCourse_id=$course_id';
            </script>";
        }
    } else {
        echo "<script>alert('No file selected or file upload error!');
        location.href='AssignmentSubmission.php?assignmentCourse_id=$course_id';
        </script>";
    }
}
