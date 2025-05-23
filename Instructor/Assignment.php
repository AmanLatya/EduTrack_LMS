<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../layout/htmlHeadLinks.php';
include '../layout/htmlFooterLinks.php';
include './Header.php';
include '../ConnectDataBase.php';
$msg = "";

?>
<title>EDUTRACK - Assignments</title>
<div class="my-5 container shadow p-3" id="">
    <a href="./AddAssignment.php" class="text-decoration-none text-light">
        <button class="btn btn-danger add-btn my-3" id="add-assignment-btn">
            <i class="fas fa-plus"></i> Add New Assignment
        </button>
    </a>
    <form action="" method="POST" class="d-print-none">
        <div class="form-group mb-3">
            <label for="checkId">Enter Course ID :</label>
            <input type="text" class="form-control w-25 ml-3" id="checkId" name="checkId">
        </div>
        <button type="submit" id="searchCourse" class="btn btn-danger">Search</button>
    </form>

    <?php
    if (isset($_REQUEST['checkId'])) {
        $courseId = intval($_REQUEST['checkId']);
        $sql = "SELECT * FROM courses WHERE course_id = $courseId";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['courseId'] = $row['course_id'];
            $_SESSION['courseName'] = $row['course_name'];
    ?>
            <div class="card mt-3">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <h3 class="card-header bg-dark text-white">
                        Course Id: <?php echo $row['course_id']; ?>
                        Course Name: <?php echo $row['course_name']; ?>
                    </h3>
                    <!-- <a href="./AddAssignment.php?course_id=<?php echo $row['course_id'] ?>" class="text-decoration-none text-light ">
                        <button class="btn btn-danger add-btn m-3" id="add-course-btn">
                            <i class="fas fa-plus"></i>
                        </button>
                    </a> -->
                </div>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Upload Date & Time</th>
                            <th>Submission Date & Time</th>
                            <th>Assignment Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="assignmentTable">
                        <?php
                        $sql = "SELECT * FROM assignment WHERE course_id = $courseId";
                        $result = $connection->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <tr id="assignmentRow_' . $row['ass_num'] . '">
                                <td><strong>' . $row['ass_num'] . '</strong></td>
                                <td>' . $row['ass_uploadDate'] . '</td>
                                <td>' . $row['ass_subDate'] . '</td>
                                <td>
                                    <a href="' . $row['ass_file'] . '" target="_blank">Link</a>
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <form action="editAssignment.php" method="POST">
                                        <input type="hidden" name="l_id" value="' . $row["ass_num"] . '">
                                        <button class="btn btn-info btn-sm m-1" name="editAssignment" value="editAssignment">
                                        </button>
                                        <i class="fas fa-pen m-1"></i>
                                    </form>

                                    <button class="deleteAssignment btn btn-danger" data-id="' . $row["ass_num"] . '"><i class="fas fa-trash m-1"></i></button>

                                </td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    <?php
        } else {
            echo '<div class="alert alert-warning text-center">Course Not Found</div>';
        }
    }
    ?>

</div>


<?php
include '../layout/adminFooter.php';
?>