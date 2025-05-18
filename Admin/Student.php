<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

$sql = "SELECT * FROM student";
$result = $connection->query($sql);
?>
<title>EDUTRACK - Student Management</title>

<div class="mt-5 container" id="admin-student">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">List of Students</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search students by ID, Name, Email, or Phone...">
            </div>

            <?php if ($result->num_rows > 0) { ?>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered align-middle table-hover">
                        <thead class="table-light sticky-top bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Personal Email</th>
                                <th>Guardian Email</th>
                                <th>Profile</th>
                                <th>Address</th>
                                <th>Mobile Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody">
                            <?php while ($row = $result->fetch_assoc()) {
                                echo '<tr class="student-row" 
                                        data-id="' . $row['Stu_id'] . '" 
                                        data-name="' . strtolower($row['Stu_Name']) . '" 
                                        data-email="' . strtolower($row['Stu_Email']) . '" 
                                        data-phone="' . $row['Stu_Phone'] . '" 
                                        id="studentRow_' . $row['Stu_id'] . '">
                                    <td><strong>' . $row['Stu_id'] . '</strong></td>
                                    <td>' . $row['Stu_Name'] . '</td>
                                    <td>' . $row['Stu_Email'] . '</td>
                                    <td>' . $row['Alter_Email'] . '</td>
                                    <td><img src="' . $row['Stu_Profile'] . '" alt="Student Image" class="img-thumbnail" style="max-width: 80px; height: auto;" loading="lazy"></td>
                                    <td>' . $row['Stu_Address'] . '</td>
                                    <td>' . $row['Stu_Phone'] . '</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <form action="editStudent.php" method="POST" class="m-0">
                                            <input type="hidden" name="id" value="' . $row["Stu_id"] . '">
                                            <button type="submit" class="btn btn-primary btn-sm m-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-danger btn-sm m-1 deleteStudent" data-id="' . $row["Stu_id"] . '" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else {
                echo "<p class='text-center text-muted'>No student records found.</p>";
            } ?>
        </div>
    </div>
</div>

<?php include '../layout/adminFooter.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const studentRows = document.querySelectorAll('.student-row');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();

            studentRows.forEach(row => {
                const id = row.getAttribute('data-id');
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const phone = row.getAttribute('data-phone');

                if (id.includes(searchTerm) || name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
