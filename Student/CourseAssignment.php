<?php
include '../ConnectDataBase.php'; // Database Connection File
include './StudentData.php';
include './StudentNavBar.php';

$stuId = $id;

if (isset($_GET['assignmentCourse_id'])) {
    $assignmentCourseId = $_GET['assignmentCourse_id'];
} else {
    echo "<script> location.href='./StudentDashboard.php'; </script>";
    exit();
}
?>

<div class="container mt-5 shadow p-5">
    <h3 class="fw-bold">Course Assignments</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Submission Date</th>
                <th>Download</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM assignment WHERE course_id = '$assignmentCourseId'";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ass_id = $row['ass_id'];
                    $ass_num = $row['ass_num'];

                    // Check if the student has already submitted this assignment
                    $checkSubmission = "SELECT * FROM assignmentsSubmission WHERE course_id='$assignmentCourseId' AND ass_num='$ass_num' AND Stu_id = '$stuId'";
                    $submissionResult = $connection->query($checkSubmission);
                    date_default_timezone_set("Asia/Kolkata");
                    $currentDateTime = new DateTime();
                    $submissionDeadline = new DateTime($row['ass_subDate']);

                    echo "<tr>
                            <td>{$row['ass_subDate']}</td>
                            <td><a href='{$row['ass_file']}' target='_blank' class='btn btn-info btn-sm'>View</a></td>";

                    if ($submissionResult->num_rows > 0) {
                        $submissionRow = $submissionResult->fetch_assoc();
                        $submittedFile = $submissionRow['ass_file'];

                        echo "<td>
                                <span class='text-success fw-bold'>Submitted</span>
                                <a href='$submittedFile' target='_blank' class='btn btn-primary btn-sm ms-2'>View</a>
                            ";

                        if ($currentDateTime <= $submissionDeadline) {
                            echo "<a href='uploadAssignment.php?edit=1&ass_id={$ass_id}&course_id={$assignmentCourseId}&ass_num={$ass_num}' class='btn btn-warning btn-sm ms-2'>Edit</a>";
                        }

                        echo "</td>";
                    } else {
                        if ($currentDateTime > $submissionDeadline) {
                            echo "<td><span class='text-danger fw-bold'>Submission Closed</span></td>";
                        } else {
                            echo "<td><a href='uploadAssignment.php?ass_id={$ass_id}&course_id={$assignmentCourseId}&ass_num={$ass_num}' class='btn btn-success btn-sm'>Submit</a></td>";
                        }
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No assignments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../layout/adminFooter.php'; ?>