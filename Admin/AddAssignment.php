<?php

include './AdminHeader.php';
include '../ConnectDataBase.php';

$msg = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['addAssignment'])) {
    if (empty($_REQUEST['courseId']) || empty($_REQUEST['assName']) || empty($_REQUEST['upDate']) || empty($_REQUEST['subDate']) || !isset($_FILES['pdfLink']) || $_FILES['pdfLink']['error'] != 0) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        // Sanitize input
        $courseId = trim($_REQUEST['courseId']);
        // $courseName = trim($_REQUEST['courseName']);
        $assName = trim($_REQUEST['assName']);
        $upDate = trim($_REQUEST['upDate']);
        $subDate = trim($_REQUEST['subDate']);

        // File upload handling
        $pdfLink = $_FILES['pdfLink']['name'];
        $pdfLinkTemp = $_FILES['pdfLink']['tmp_name'];
        $assignmentFolder = '../assignmentFolder/' . $pdfLink;

        if (move_uploaded_file($pdfLinkTemp, $assignmentFolder)) {
            // Check if courseId exists in the courses table
            $sql = "SELECT course_id FROM courses WHERE course_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $courseId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Course exists, Upload the Assignment
                $insertQuery = "INSERT INTO assignment (ass_num, ass_uploadDate, ass_subDate, ass_file, course_id) VALUES ('$assName','$upDate','$subDate','$assignmentFolder','$courseId')";

                if ($connection->query($insertQuery) == TRUE) {
                    $msg = '<div class="alert alert-success text-center">Assignment Added Successfully!</div>';
                } else {
                    $msg = '<div class="alert alert-danger text-center">Error Adding Assignment. Try Again.</div>';
                }
            } else {
                // Course ID not found
                $msg = '<div class="alert alert-warning text-center">Invalid Course ID. Please enter a valid Course ID.</div>';
            }
        } else {
            $msg = '<div class="alert alert-danger text-center">Error uploading file. Try again.</div>';
        }
    }
}
?>

<title>EDUTRACK - Add Assignment</title>
<div class="container d-flex justify-content-center align-items-center my-3">
    <div class="form-container shadow p-5">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Add New Assignment
            <a href="./Assignment.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>
        </h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 ">
                <label class="form-label">Course Name</label>
                <input type="number" name="courseId" value="<?php echo $_GET['course_id'] ?>" hidden>
                <div class="input-group custom-input-group">
                    <?php
                    $course_id = $_GET['course_id'];
                    $sql = "SELECT course_name FROM courses WHERE course_id = $course_id";
                    $result = $connection->query($sql); // ❌ This happens after $connection->close()

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    ?>
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                        <input type="text" class="form-control"
                            value="<?php
                                    echo $row['course_name'];
                                } ?>" name="courseName" placeholder="Enter Course ID" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Assignment Name</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="assName" placeholder="Enter Assignment Name" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Date & Time</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <input type="datetime-local" class="form-control" name="upDate" id="uploadDateTime" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Submission Date & Time</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <input type="datetime-local" class="form-control" name="subDate" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Assignment PDF</label>
                <div id="dropZone" class="input-group custom-input-group text-center p-4 border border-primary rounded">
                    <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
                    <p class="m-0">Drag & Drop your PDF here or <span class="text-primary">click to upload</span></p>
                    <input type="file" class="form-control d-none" name="pdfLink" id="pdfInput" accept="application/pdf" required>
                </div>
                <div id="fileInfo" class="mt-2 text-muted"></div>
                <div id="fileError" class="text-danger mt-2"></div>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" name="addAssignment" class="btn btn-primary custom-btn-primary">
                    <i class="fas fa-plus-circle"></i> Save
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

<?php
$connection->close();
include '../layout/adminFooter.php';
?>