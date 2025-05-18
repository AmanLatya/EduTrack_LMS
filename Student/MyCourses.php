<?php
include './StudentData.php';
include './StudentNavBar.php';

if (isset($_SESSION['is_stuLogin']) && isset($_SESSION['stuLoginEmail'])) {
    $sql = "SELECT * FROM student WHERE Stu_Email = '{$_SESSION['stuLoginEmail']}'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stu_id = $row['Stu_id']; // Get the student's ID
    }

    // Fetch purchased courses from payments table
    $paymentSql = "SELECT course_id FROM payments WHERE student_id = '$stu_id'";
    $paymentResult = $connection->query($paymentSql);
    $purchasedCourses = [];

    if ($paymentResult->num_rows > 0) {
        while ($paymentRow = $paymentResult->fetch_assoc()) {
            $purchasedCourses[] = $paymentRow['course_id'];
        }
    }

    // Fetch course details for purchased courses
    if (!empty($purchasedCourses)) {
        $courseIds = implode(',', $purchasedCourses);
        $courseSql = "SELECT * FROM courses WHERE course_id IN ($courseIds)";
        $courseResult = $connection->query($courseSql);
    }
} else {
    echo "<script> location.href='../'; </script>";
    exit();
}
?>

<style>
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .course-card img {
        object-fit: cover;
        height: 80px;
        width: 80px;
        border-radius: 50%;
    }
</style>

<div class="container mt-5 shadow p-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="fs-4 fw-bold mb-4">My Courses</h2>
            <a href="../allCourses.php" class="btn btn-outline-primary mb-3">Buy Courses</a>

            <div class="mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search your courses...">
            </div>

            <div class="row" id="coursesContainer">
                <?php
                if (isset($courseResult) && $courseResult->num_rows > 0) {
                    while ($courseRow = $courseResult->fetch_assoc()) {
                        $courseId = $courseRow['course_id'];

                        // Total assignments for the course (from assignments table)
                        $totalQuery = "SELECT COUNT(*) AS total FROM assignment WHERE course_id = '$courseId'";
                        $totalResult = $connection->query($totalQuery);
                        $totalAssignments = ($totalResult && $totalResult->num_rows > 0) ? $totalResult->fetch_assoc()['total'] : 0;

                        // Assignments submitted by this student (from assignmentssubmission table)
                        $submittedQuery = "SELECT COUNT(*) AS submitted FROM assignmentssubmission WHERE course_id = '$courseId' AND Stu_id = '$stu_id'";
                        $submittedResult = $connection->query($submittedQuery);
                        $submittedAssignments = ($submittedResult && $submittedResult->num_rows > 0) ? $submittedResult->fetch_assoc()['submitted'] : 0;

                        // Progress calculation
                        $progressPercent = ($totalAssignments > 0) ? round(($submittedAssignments / $totalAssignments) * 100) : 0;
                ?>
                        <div class="col-md-6 mb-3 course-item" data-title="<?php echo strtolower($courseRow['course_name']); ?>">
                            <div class="d-flex align-items-center bg-light p-3 rounded course-card">
                                <img src="<?php echo $courseRow['course_img']; ?>" alt="<?php echo $courseRow['course_name']; ?>" class="me-3">
                                <div class="flex-grow-1">
                                    <p class="fw-bold mb-0"><?php echo $courseRow['course_name']; ?></p>
                                    <p class="text-secondary mb-2">Guided by <?php echo $courseRow['course_author']; ?></p>
                                    <a href="./EnrolledCourse.php?enrolledCourse_id=<?php echo $courseId ?>" class="btn btn-outline-primary btn-sm">Lectures</a>
                                    <a href="./CourseAssignment.php?assignmentCourse_id=<?php echo $courseId ?>" class="btn btn-primary btn-sm ms-2">Assignments</a>

                                    <!--Assignment Progress -->
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted"><?php echo "$submittedAssignments of $totalAssignments Assignments Submitted"; ?></small>
                                            <small class="text-muted"><?php echo $progressPercent . "%"; ?></small>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progressPercent; ?>%;" aria-valuenow="<?php echo $progressPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <?php
                                    //Total lessons
                                    $totalLessonsQuery = "SELECT COUNT(*) AS total FROM lesson WHERE course_id = '$courseId'";
                                    $totalLessonsResult = $connection->query($totalLessonsQuery);
                                    $totalLessons = ($totalLessonsResult && $totalLessonsResult->num_rows > 0) ? $totalLessonsResult->fetch_assoc()['total'] : 0;

                                    //Lessons watched by student
                                    $watchedLessonsQuery = "SELECT COUNT(*) AS watched FROM lessonprogress WHERE course_id = '$courseId' AND Stu_id = '$stu_id'";
                                    $watchedLessonsResult = $connection->query($watchedLessonsQuery);
                                    $watchedLessons = ($watchedLessonsResult && $watchedLessonsResult->num_rows > 0) ? $watchedLessonsResult->fetch_assoc()['watched'] : 0;

                                    //Calculate lecture progress
                                    $lectureProgressPercent = ($totalLessons > 0) ? round(($watchedLessons / $totalLessons) * 100) : 0;
                                    ?>

                                    <!--Lecture Progress -->
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted"><?php echo "$watchedLessons of $totalLessons Lectures Watched"; ?></small>
                                            <small class="text-muted"><?php echo $lectureProgressPercent . "%"; ?></small>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: <?php echo $lectureProgressPercent; ?>%;"
                                                aria-valuenow="<?php echo $lectureProgressPercent; ?>"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                <?php
                    }
                } else {
                    echo "<p class='text-center text-muted'>You haven't enrolled in any courses yet.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Search filter
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const courseItems = document.querySelectorAll('.course-item');

        courseItems.forEach(item => {
            const title = item.getAttribute('data-title');
            if (title.includes(searchValue)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

<?php include '../layout/adminFooter.php' ?>