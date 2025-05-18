<?php 
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
echo '
<div class="col-lg-4 col-md-6 col-sm-12 course-item" data-title="' . strtolower($row['course_name']) . '">
    <div class="course-card shadow p-3 h-100">
        <div class="course-img-container">
            <a href="courseDetail.php?course_id=' . $row['course_id'] . '">
                <img src="' . str_replace('..', '.', $row['course_img']) . '" alt="' . $row['course_name'] . '" class="img-fluid" loading="lazy">
            </a>
        </div>
        <h4><i class="fas fa-robot"></i> ' . $row['course_name'] . '</h4>
        <p><i class="fas fa-user-tie"></i> Instructor: ' . $row['course_author'] . '</p>
        <div class="row px-2">
            <div class="col-12 mb-2"><i class="fas fa-clock"></i> Duration: <strong>' . $row['course_duration'] . '</strong></div>
            <div class="col-12 mb-3">
                <i class="fas fa-tag"></i> Price:
                <strong class="text-danger">₹' . $row['course_original_price'] . '</strong>
            </div>
        </div>
        <a class="btn btn-enroll mt-auto" href="courseDetail.php?course_id=' . $row['course_id'] . '">
            <i class="fas fa-rocket"></i> Enroll Now
        </a>
    </div>
</div>
';
}
} else {
echo '<div class="col-12 text-center py-5">
    <h4>No courses available at the moment</h4>
</div>';
}

?>