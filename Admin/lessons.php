<?php
if (!isset($_SESSION)) {
    session_start();
}

include './AdminHeader.php';
include '../ConnectDataBase.php';
$msg = "";

?>
<title>EDUTRACK - About Course</title>
<div class="my-5 container shadow p-3" id="">
    <a href="./AddLesson.php" class="text-decoration-none text-light">
        <button class="btn btn-danger add-btn my-3" id="add-lesson-btn">
            <i class="fas fa-plus"></i> Add New Topic
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
                    <a href="./AddCourse.php" class="text-decoration-none text-light ">
                        <button class="btn btn-danger add-btn m-3" id="add-course-btn">
                            <i class="fas fa-plus"></i>
                        </button>
                    </a>
                </div>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Topic Name</th>
                            <th>Topic Description</th>
                            <th>Lecture Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="lessonTable">
                        <?php
                        $sql = "SELECT * FROM lesson WHERE course_id = $courseId";
                        $result = $connection->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <tr id="lessonRow_' . $row['lesson_id'] . '">
                                <td><strong>' . $row['lesson_num'] . '</strong></td>
                                <td>' . $row['lesson_name'] . '</td>
                                <td>' . $row['lesson_desc'] . '</td>
                                <td>
                                    <a href="' . $row['lesson_link'] . '" target="_blank">Link</a>
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <form action="editLesson.php" method="POST">
                                        <input type="hidden" name="l_id" value="' . $row["lesson_id"] . '">
                                        <button class="btn btn-info btn-sm m-1" name="editLesson" value="editLesson">
                                            <i class="fas fa-pen m-1"></i>
                                        </button>
                                    </form>

                                    <button class="btn btn-secondary btn-sm m-1 deleteLesson" data-id="' . $row["lesson_id"] . '">
                                        <i class="fas fa-trash m-1"></i>
                                    </button>
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

<?php include '../layout/adminFooter.php'; ?>