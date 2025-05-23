<?php
include '../ConnectDataBase.php';
if (!isset($_SESSION)) {
    session_start();
}
$Stu_Email = $_SESSION['stuLoginEmail'];

// Sanitize email for query
$Stu_Email = mysqli_real_escape_string($connection, $Stu_Email);

// Corrected query with quotes for email
$sql1 = "SELECT Stu_id FROM student WHERE Stu_Email = '$Stu_Email'";
$result1 = $connection->query($sql1);

$Stu_id = null;
if ($result1 && $result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $Stu_id = $row1['Stu_id'];
    // echo $Stu_id;
}

?>

<style>
    .notification-card {
        border-left: 5px solid #6f42c1;
        padding: 1rem;
        background-color: white;
        margin-bottom: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }

    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 10px;
    }

    .dropdown-toggle {
        cursor: pointer;
        font-weight: bold;
    }

    .category-heading {
        margin: 1rem 0 0.5rem;
        font-size: 1.1rem;
    }
</style>

<section>
    <div class="modal fade" id="NotificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="NotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 animate-modal shadow p-2">
                <div class="modal-header border-bottom-0">
                    <h3 class="">Notifications</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">

                        <!-- Assignments Section -->
                        <div class="category-heading">
                            <a class="dropdown-toggle text-decoration-none" data-bs-toggle="collapse" href="#assignmentsCollapse" role="button" aria-expanded="true" aria-controls="assignmentsCollapse">
                                📘 Pending Assignment
                            </a>
                        </div>
                        <div class="collapse show" id="assignmentsCollapse">
                            <?php
                            if ($Stu_id) {
                                // Fetch assignments NOT submitted AND whose due date is today or in the future
                                $sqlPendingAssignments = "
                                    SELECT a.ass_id, a.ass_Name, a.ass_subDate, a.course_id, c.course_name
                                    FROM assignment a
                                    INNER JOIN payments p ON a.course_id = p.course_id
                                    INNER JOIN courses c ON a.course_id = c.course_id
                                    WHERE p.student_id = $Stu_id
                                    AND a.ass_subDate >= NOW()
                                    AND a.ass_id NOT IN (
                                        SELECT ass_id FROM assignmentsSubmission WHERE Stu_id = $Stu_id
                                    )
                                    ORDER BY a.ass_subDate ASC
                                ";

                                $resultPending = $connection->query($sqlPendingAssignments);

                                if ($resultPending && $resultPending->num_rows > 0) {
                                    while ($assignment = $resultPending->fetch_assoc()) {
                                        $subDate = date("M d, Y", strtotime($assignment['ass_subDate']));
                                        $subTime = date("h:i A", strtotime($assignment['ass_subDate']));
                                        $course_id = $assignment['course_id'];
                                        $course_name = htmlspecialchars($assignment['course_name']);
                            ?>
                                        <div class="notification-card">
                                            <i class="fas fa-hourglass-half text-warning me-2"></i>
                                            <strong>Due Assignment:</strong> "<?php echo htmlspecialchars($assignment["ass_Name"]); ?>" of (<?php echo $course_name; ?>) is due <strong><?php echo $subDate; ?></strong> at <strong><?php echo $subTime; ?></strong>
                                            <div class="text-muted small">
                                                <a href="./CourseAssignment.php?assignmentCourse_id=<?php echo $course_id ?>"><span class="text-success fw-bold">Submission Open</span></a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="notification-card">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>All caught up!</strong>
                                        <div class="text-muted small">You have no pending assignments.</div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <!-- Payments Section -->
                        <div class="category-heading">
                            <a class="dropdown-toggle text-decoration-none" data-bs-toggle="collapse" href="#paymentsCollapse" role="button" aria-expanded="true" aria-controls="paymentsCollapse">
                                💰 Payment Notifications
                            </a>
                        </div>
                        <div class="collapse show" id="paymentsCollapse">
                            <?php
                            // Prepare payment result
                            if ($Stu_id) {
                                $sql2 = "SELECT * FROM payments WHERE student_id = $Stu_id ORDER BY purchase_time DESC";
                                $result2 = $connection->query($sql2);
                                if ($result2 && $result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        $purchaseDate = date("M d, Y", strtotime($row['purchase_time']));
                                        $purchaseTime = date("h:i A", strtotime($row['purchase_time']));
                                        $course_id = $row['course_id'];

                                        // Secure fetch course name
                                        $stmt = $connection->prepare("SELECT course_name FROM courses WHERE course_id = ?");
                                        $stmt->bind_param("i", $course_id);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        $course_name = ($res && $res->num_rows > 0) ? $res->fetch_assoc()['course_name'] : "Unknown Course";
                                        $stmt->close();
                            ?>
                                        <div class="notification-card">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <strong>Payment Successful:</strong> You have successfully purchased the "<b><?php echo htmlspecialchars($course_name); ?></b>" course.
                                            <div class="text-muted small">On <?php echo $purchaseDate . " at " . $purchaseTime; ?></div>
                                        </div>
                                    <?php }
                                } else {
                                    ?>
                                    <div class="notification-card">
                                        <i class="fas fa-info-circle text-secondary me-2"></i>
                                        <strong>No payments found.</strong>
                                        <div class="text-muted small">You haven't purchased any courses yet.</div>
                                    </div>

                            <?php
                                }
                            }
                            ?>
                        </div>
                        <!-- Uploads Section -->
                        <!-- <div class="category-heading">
                            <a class="dropdown-toggle text-decoration-none" data-bs-toggle="collapse" href="#uploadsCollapse" role="button" aria-expanded="true" aria-controls="uploadsCollapse">
                                ⬆️ New Uploads
                            </a>
                        </div>
                        <div class="collapse show" id="uploadsCollapse">
                            <div class="notification-card">
                                <i class="fas fa-upload text-primary me-2"></i>
                                <strong>New Assignment:</strong> "Compiler Design - Lexical Analysis" uploaded.
                                <div class="text-muted small">1 day ago</div>
                            </div>
                            <div class="notification-card">
                                <i class="fas fa-upload text-primary me-2"></i>
                                <strong>New Material:</strong> "Unit 3 Notes - DBMS" uploaded.
                                <div class="text-muted small">3 days ago</div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>