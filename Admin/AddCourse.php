<!-- Header Links -->
<?php

// use Google\Service\SQLAdmin\Resource\Connect;
include './AdminHeader.php';
include '../ConnectDataBase.php';

$msg = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    if (
        empty($_POST['courseName']) || empty($_POST['courseDescription']) || empty($_POST['author']) ||
        empty($_POST['courseDuration']) || empty($_POST['originalPrice']) || empty($_POST['sellingprice']) ||
        empty($_FILES['courseImage']['name'])
    ) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $courseName = $_POST['courseName'];
        $courseDescription = $_POST['courseDescription'];
        $author = $_POST['author'];
        $courseDuration = $_POST['courseDuration'];
        $originalPrice = $_POST['originalPrice'];
        $sellingprice = $_POST['sellingprice'];
        $courseImage = $_FILES['courseImage']['name'];
        $courseImageTemp = $_FILES['courseImage']['tmp_name'];
        $imgFolder = '../images/courseImages/' . $courseImage;
        move_uploaded_file($courseImageTemp, $imgFolder);

        $sql = "INSERT INTO courses (course_name,course_description, course_author, course_img,course_duration,course_price,course_original_price) VALUES ('$courseName','$courseDescription','$author','$imgFolder','$courseDuration','$sellingprice','$originalPrice')";

        if ($connection->query($sql) == TRUE) {
            $msg = '<div class="alert alert-success text-center">Course Added !</div>';
        } else {
            $msg = '<div class="alert alert-danger text-center">unable Added</div>';
        }
    }
}
?>

<title>EDUTRACK - Add Courses</title>
<div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh;">
    <div class="form-container shadow p-5">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Add New Course

            <a href="./Courses.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>

        </h3>
        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="courseName" placeholder="Enter course name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Description</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                    <textarea class="form-control" name="courseDescription" rows="3" placeholder="Enter course description" required></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="author" placeholder="Enter author name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Duration</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    <input type="text" class="form-control" name="courseDuration" placeholder="Enter course duration" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Original Price</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input type="number" class="form-control" name="originalPrice" placeholder="Enter original price" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Selling Price</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="number" class="form-control" name="sellingprice" placeholder="Enter selling price" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Course Image</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control" name="courseImage" accept="image/*" required onchange="previewImage(event)">
                </div>
                <div class="preview-container w-50">
                    <img id="preview" src="#" alt="Preview Image">
                </div>
            </div>

            <div class="mb-3 text-center">
                <button type="submit" name="add_course" class="btn btn-primary custom-btn-primary">
                    <i class="fas fa-plus-circle"></i> Add Course
                </button>
            </div>

            <?php 
            if(isset($msg)){
                echo $msg; 
            }
            ?>
        </form>
    </div>
</div>

<?php include '../layout/adminFooter.php'; ?>