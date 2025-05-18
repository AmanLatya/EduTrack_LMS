<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

// Total Students
$studentCountQuery = "SELECT COUNT(*) as total FROM student";
$studentResult = $connection->query($studentCountQuery);
$studentCount = $studentResult->fetch_assoc()['total'];

// Total Courses
$courseCountQuery = "SELECT COUNT(*) as total FROM courses";
$courseResult = $connection->query($courseCountQuery);
$courseCount = $courseResult->fetch_assoc()['total'];

// Total Payments
$paymentCountQuery = "SELECT COUNT(*) as total FROM payments";
$paymentResultCount = $connection->query($paymentCountQuery);
$paymentCount = $paymentResultCount->fetch_assoc()['total'];

// Recent Payment Records with JOIN to get names
$paymentQuery = "
SELECT p.id, s.Stu_Name, c.course_name, p.amount, p.purchase_time 
FROM payments p
JOIN student s ON p.student_id = s.Stu_id
JOIN courses c ON p.course_id = c.course_id
ORDER BY p.purchase_time DESC
LIMIT 10";
$paymentResult = $connection->query($paymentQuery);
?>

<!-- Main Content -->
<main class="container mt-5">
    <div class="container-fluid p-4">
        <h2 class="animate__animated animate__fadeIn mb-4">Admin Dashboard Overview</h2>
        <div class="row g-4">

            <!-- Total Students -->
            <div class="col-md-4 animate__animated animate__fadeInLeft">
                <div class="card bg-primary text-white shadow rounded-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>
                        <h3 class="card-text"><?= $studentCount ?></h3>
                    </div>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="col-md-4 animate__animated animate__fadeInLeft animate__delay-1s">
                <div class="card bg-success text-white shadow rounded-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Courses</h5>
                        <h3 class="card-text"><?= $courseCount ?></h3>
                    </div>
                </div>
            </div>

            <!-- Total Payments -->
            <div class="col-md-4 animate__animated animate__fadeInLeft animate__delay-2s">
                <div class="card bg-warning text-white shadow rounded-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Purchases</h5>
                        <h3 class="card-text"><?= $paymentCount ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments Table -->
        <div class="mt-5 animate__animated animate__fadeInUp">
            <h3 class="mb-3">Recent Payments</h3>
            <table class="table table-bordered table-hover shadow rounded-3">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course Name</th>
                        <th>Amount (₹)</th>
                        <th>Purchase Date</th>
                        <th>Purchase Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($paymentResult->num_rows > 0) {
                        while ($payment = $paymentResult->fetch_assoc()) {
                            echo "<tr>
                                <td>{$payment['id']}</td>
                                <td>{$payment['Stu_Name']}</td>
                                <td>{$payment['course_name']}</td>
                                <td>₹{$payment['amount']}</td>
                                <td>" . date('Y-m-d', strtotime($payment['purchase_time'])) . "</td>
                                <td>" . date('h:i A', strtotime($payment['purchase_time'])) . "</td>
                            </tr>";
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">No recent payments found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include '../layout/adminFooter.php'; ?>
