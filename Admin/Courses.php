<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

$sql = "SELECT * FROM courses";
$result = $connection->query($sql);
?>
<title>EDUTRACK - Courses</title>

<div class="mt-5 container" id="admin-courses">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">List of Courses</h3>
            <a href="./AddCourse.php" class="text-decoration-none">
                <button class="btn btn-danger" id="add-course-btn" title="Add New Course">
                    <i class="fas fa-plus"></i>
                </button>
            </a>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
            </div>

            <?php if ($result->num_rows > 0) { ?>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered align-middle table-hover">
                        <thead class="table-light sticky-top bg-light">
                            <tr>
                                <th>Course ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Original Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="coursesTableBody">
                            <?php while ($row = $result->fetch_assoc()) {
                                echo '<tr class="course-row" data-title="' . strtolower($row['course_name']) . '" id="courseRow_' . $row['course_id'] . '">
                                    <td><strong>' . $row['course_id'] . '</strong></td>
                                    <td><strong>' . $row['course_name'] . '</strong></td>
                                    <td>' . $row['course_description'] . '</td>
                                    <td>' . $row['course_author'] . '</td>
                                    <td><img src="' . $row['course_img'] . '" alt="Course Image" class="img-thumbnail" style="max-width: 80px; height: auto;" loading="lazy"></td>
                                    <td>' . $row['course_duration'] . '</td>
                                    <td>₹' . $row['course_price'] . '</td>
                                    <td>₹' . $row['course_original_price'] . '</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <form action="editCourse.php" method="POST" class="m-0">
                                            <input type="hidden" name="id" value="' . $row["course_id"] . '">
                                            <button class="btn btn-info btn-sm m-1" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-danger btn-sm m-1 deleteCourse" data-id="' . $row["course_id"] . '" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else {
                echo "<p class='text-center text-muted'>No courses found.</p>";
            } ?>
        </div>
    </div>
</div>

<?php include '../layout/adminFooter.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const courseRows = document.querySelectorAll('.course-row');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            courseRows.forEach(row => {
                const title = row.getAttribute('data-title');
                row.style.display = title.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
