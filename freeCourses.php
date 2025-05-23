<div class="container my-5 py-4" id="free-courses">
    <h2 class="text-center py-3">Courses</h2>
    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM courses WHERE course_price = 0";
        $result = $connection->query($sql);
        include './Courses.php';
        ?>
    </div>

    <div class="text-center mt-5">
        <a class="btn btn-lg" href="allCourses.php" id="all-courses">
            <i class="fas fa-book-open me-2"></i> View All Courses
        </a>
    </div>
</div>