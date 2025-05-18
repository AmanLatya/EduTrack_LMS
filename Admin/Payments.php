<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

$sql = "SELECT p.*, s.Stu_Name, s.Stu_Email, c.course_name 
        FROM payments p 
        JOIN student s ON p.student_id = s.Stu_id 
        JOIN courses c ON p.course_id = c.course_id 
        ORDER BY p.purchase_time DESC";
$result = $connection->query($sql);
?>

<title>EDUTRACK - Payment Management</title>
<div class="mt-5 container shadow" id="admin-student">
    <div class="card-header bg-dark text-white">
        <h3 class="mb-3 p-3 rounded">Payment Records</h3>
    </div>
    <div class="card-body">

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Payment ID, Student Name, Course, or Email...">
        </div>
        <?php if ($result->num_rows > 0) { ?>
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-bordered align-middle table-hover">
                    <thead class="table-light sticky-top bg-light">
                        <tr>
                            <th>Payment ID</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Amount (₹)</th>
                            <th>Purchase Date</th>
                            <th>Purchase Time</th>
                        </tr>
                    </thead>
                    <tbody id="paymentsTableBody">
                        <?php while ($row = $result->fetch_assoc()) {
                            $purchaseDate = date("Y-m-d", strtotime($row['purchase_time']));
                            $purchaseTime = date("h:i A", strtotime($row['purchase_time']));
                            echo '<tr class="payment-row"
                                    data-id="' . $row['id'] . '"
                                    data-name="' . strtolower($row['Stu_Name']) . '"
                                    data-email="' . strtolower($row['Stu_Email']) . '"
                                    data-course="' . strtolower($row['course_name']) . '">
                                <td><strong>' . $row['id'] . '</strong></td>
                                <td>' . $row['Stu_Name'] . '</td>
                                <td>' . $row['Stu_Email'] . '</td>
                                <td>' . $row['course_name'] . '</td>
                                <td>₹' . $row['amount'] . '</td>
                                <td>' . $purchaseDate . '</td>
                                <td>' . $purchaseTime . '</td>
                            </tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php } else {
            echo "<p class='text-center text-muted'>No payment records found.</p>";
        } ?>
    </div>
</div>
<?php include '../layout/adminFooter.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const paymentRows = document.querySelectorAll('.payment-row');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            paymentRows.forEach(row => {
                const id = row.getAttribute('data-id');
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const course = row.getAttribute('data-course');

                if (id.includes(searchTerm) || name.includes(searchTerm) || email.includes(searchTerm) || course.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>