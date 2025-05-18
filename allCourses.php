<?php
include('./layout/htmlHeadLinks.php');
include('./layout/header.php');
?>

<div class="container my-5 py-4" id="free-courses">
    <h2 class="text-center py-3">Courses</h2>

    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
    </div>

    <div class="row g-4" id="coursesContainer">
        <?php
        $sql = "SELECT * FROM courses";
        $result = $connection->query($sql);
        include './Courses.php';
        ?>
    </div>
</div>

<?php
include('./layout/footer.php');
include('./layout/htmlFooterLinks.php');
?>