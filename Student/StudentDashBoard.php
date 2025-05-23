<?php
include './StudentData.php';
include './StudentNavBar.php';
include '../ConnectDataBase.php';

// Fetch enrolled courses for the student
$enrollCourse = "SELECT * FROM payments WHERE student_id = $id";
$resultCourse = $connection->query($enrollCourse);

if (!$resultCourse) {
    echo "Error fetching enrolled courses: " . $connection->error;
    exit;
}

// Total & Submitted Assignment Count
$totalAssignments = 0;
$submittedAssignments = 0;
$enrolledCourseCount = $resultCourse->num_rows;

if ($enrolledCourseCount > 0) {
    while ($course = $resultCourse->fetch_assoc()) {
        $courseId = $course['course_id'];

        // Total assignments
        $assignmentCountQuery = "SELECT COUNT(*) as count FROM assignment WHERE course_id = $courseId";
        $assignmentCountResult = $connection->query($assignmentCountQuery);
        if ($assignmentCountResult && $assignmentCountResult->num_rows > 0) {
            $totalAssignments += $assignmentCountResult->fetch_assoc()['count'];
        }

        // Submitted assignments by this student
        $submittedCountQuery = "SELECT COUNT(*) as count FROM assignmentssubmission WHERE course_id = $courseId AND Stu_id = $id";
        $submittedCountResult = $connection->query($submittedCountQuery);
        if ($submittedCountResult && $submittedCountResult->num_rows > 0) {
            $submittedAssignments += $submittedCountResult->fetch_assoc()['count'];
        }
    }
}

// Progress Percentage
$progress = ($totalAssignments > 0) ? round(($submittedAssignments / $totalAssignments) * 100) : 0;
?>

<style>
    .header-bg {
        background: linear-gradient(135deg, #6c5ce7, #8e44ad);
        color: white;
    }

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

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-5 shadow p-5">
    <div class="header-bg p-4 rounded mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div>
                <h1 class="fs-3 fw-bold text-white">Hello, <?php echo $name ?></h1>
                <p class="text-purple-200">Welcome back to your dashboard</p>
            </div>
            <div class="d-flex align-items-center mt-3 mt-md-0">
                <a class="" data-bs-toggle="modal" data-bs-target="#NotificationModal">
                    <i class="fas fa-bell text-purple-600 fs-5 me-3 Bell"></i>
                </a>
                <div class="d-flex align-items-center">
                    <div>
                        <p class="fw-bold text-white mb-0"><?php echo $name ?></p>
                        <p class="text-sm text-purple-200 mb-0">Student ID: <?php echo $id ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4" id="enrolled_courses">
        <div class="col-sm-6 col-lg-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-book text-purple-600 fs-3 me-3"></i>
                        <div>
                            <p class="text-secondary mb-0">Enrolled Courses</p>
                            <p class="fs-4 fw-bold mb-0"><?php echo $enrolledCourseCount; ?></p>
                        </div>
                    </div>
                    <canvas id="courseChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tasks text-purple-600 fs-3 me-3"></i>
                        <div>
                            <p class="text-secondary mb-0">Assignments Submitted</p>
                            <p class="fs-5 fw-bold mb-0"><?php echo "$submittedAssignments of $totalAssignments"; ?></p>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: <?php echo $progress; ?>%;"
                                    aria-valuenow="<?php echo $progress; ?>"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <small class="text-muted"><?php echo $progress; ?>% complete</small>
                        </div>
                    </div>
                    <canvas id="assignmentChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Display -->
    <div class="row mb-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="fs-4 fw-bold mb-4">My Courses</h2>
                    <div class="row">
                        <?php
                        $enrollCourse = "SELECT * FROM payments WHERE student_id = $id LIMIT 2";
                        $resultCourse = $connection->query($enrollCourse);
                        if ($resultCourse->num_rows > 0) {
                            while ($course = $resultCourse->fetch_assoc()) {
                                $courseId = $course['course_id'];
                                $courseQuery = "SELECT * FROM courses WHERE course_id = $courseId";
                                $courseResult = $connection->query($courseQuery);

                                if ($courseResult && $courseResult->num_rows > 0) {
                                    $courseData = $courseResult->fetch_assoc();
                        ?>
                                    <div class="col-md-6 mb-3 course-card">
                                        <div class="d-flex align-items-center bg-purple-100 p-3 rounded">
                                            <img src="<?php echo $courseData['course_img']; ?>" alt="<?php echo $courseData['course_name']; ?>" class="me-3">
                                            <div>
                                                <p class="fw-bold mb-0"><?php echo $courseData['course_name']; ?></p>
                                                <p class="text-secondary mb-2">Guided by <?php echo $courseData['course_author']; ?></p>
                                                <a href="./EnrolledCourse.php?enrolledCourse_id=<?php echo $courseId; ?>" class="btn btn-primary">Continue</a>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                } else {
                                    echo "<p>No data found for course ID: $courseId</p>";
                                }
                            }
                        } else {
                            echo "<p>No enrolled courses found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Setup -->
<script>
    // Assignment Chart
    const assignmentCtx = document.getElementById('assignmentChart').getContext('2d');
    new Chart(assignmentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Submitted', 'Remaining'],
            datasets: [{
                data: [<?php echo $submittedAssignments; ?>, <?php echo ($totalAssignments - $submittedAssignments); ?>],
                backgroundColor: ['#28a745', '#dee2e6'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Assignment Progress'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Course Chart
    const courseCtx = document.getElementById('courseChart').getContext('2d');
    new Chart(courseCtx, {
        type: 'doughnut',
        data: {
            labels: ['Enrolled', 'Remaining'],
            datasets: [{
                data: [<?php echo $enrolledCourseCount; ?>, 10 - <?php echo $enrolledCourseCount; ?>],
                backgroundColor: ['#007bff', '#dee2e6'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Course Enrollment'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<?php
include './NotificationModal.php';
include '../layout/adminFooter.php';
?>