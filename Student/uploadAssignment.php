<?php
include '../ConnectDataBase.php';
include './StudentData.php';

$stuId = $id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = mysqli_real_escape_string($connection, $_POST['course_id']);
    $ass_id = mysqli_real_escape_string($connection, $_POST['ass_id']);
    $ass_num = mysqli_real_escape_string($connection, $_POST['ass_num']);

    $getDeadline = "SELECT ass_subDate FROM assignment WHERE ass_id = '$ass_id'";
    $result = $connection->query($getDeadline);
    $row = $result->fetch_assoc();

    date_default_timezone_set("Asia/Kolkata");
    $currentTime = new DateTime();
    $deadline = new DateTime($row['ass_subDate']);

    if ($currentTime > $deadline) {
        die("Submission deadline has passed. You cannot upload this assignment.");
    }

    if (isset($_FILES['assignmentFile']) && $_FILES['assignmentFile']['error'] == 0) {
        $file_name = basename($_FILES['assignmentFile']['name']);
        $file_tmp = $_FILES['assignmentFile']['tmp_name'];
        $upload_dir = "uploads/assignments/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . time() . "_" . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $uploadDate = date("Y-m-d H:i:s");
            // Check if record already exists
            $checkSql = "SELECT * FROM assignmentsSubmission WHERE ass_id = ? AND course_id = ? AND ass_num = ? AND Stu_id = ?";
            $checkStmt = $connection->prepare($checkSql);
            $checkStmt->bind_param("isii", $ass_id, $course_id, $ass_num, $stuId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Update existing record
                $stmt = $connection->prepare("UPDATE assignmentsSubmission SET ass_file = ?, ass_subDate = ? WHERE ass_id = ? AND course_id = ? AND ass_num = ? AND Stu_id = ?");
                $stmt->bind_param("ssiisi", $file_path, $uploadDate, $ass_id, $course_id, $ass_num, $stuId);
            } else {
                // Insert new record
                $stmt = $connection->prepare("INSERT INTO assignmentsSubmission (ass_id, ass_subDate, ass_file, course_id, ass_num, Stu_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issisi", $ass_id, $uploadDate, $file_path, $course_id, $ass_num, $stuId);
            }
            if ($stmt->execute()) {
                echo "<script>alert('Assignment uploaded successfully!'); location.href='CourseAssignment.php?assignmentCourse_id=$course_id';</script>";
            } else {
                echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('File upload failed!'); location.href='uploadAssignment.php?ass_id=$ass_id&course_id=$course_id&ass_num=$ass_num';</script>";
        }
    } else {
        echo "<script>alert('No file selected or file upload error!'); location.href='uploadAssignment.php?ass_id=$ass_id&course_id=$course_id&ass_num=$ass_num';</script>";
    }
}
?>

<!-- Upload Form (if request is GET) -->
<?php if ($_SERVER["REQUEST_METHOD"] != "POST" && isset($_GET['ass_id'], $_GET['course_id'], $_GET['ass_num'])): ?>
    <?php
    $ass_id = $_GET['ass_id'];
    $course_id = $_GET['course_id'];
    $ass_num = $_GET['ass_num'];
    ?>
    <div class="container mt-5 shadow p-4">
        <h3 class="fw-bold mb-4">Upload Assignment</h3>
        <form action="uploadAssignment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ass_id" value="<?= $ass_id ?>">
            <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <input type="hidden" name="ass_num" value="<?= $ass_num ?>">

            <div class="mb-3">
                <label class="form-label">Upload Assignment PDF</label>
                <input type="file" class="form-control" name="assignmentFile" accept="application/pdf" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Submit Assignment</button>
            </div>
        </form>
    </div>
<?php endif; ?>