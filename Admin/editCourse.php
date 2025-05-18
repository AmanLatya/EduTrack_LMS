<!-- Header Links -->
<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

// ----------------------------------------Update Course------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_course'])) {
    if (
        empty($_POST['courseName']) || empty($_POST['courseDescription']) || empty($_POST['author']) ||
        empty($_POST['courseDuration']) || empty($_POST['originalPrice']) || empty($_POST['sellingprice']) ||
        empty($_FILES['courseImage']['name'])
    ) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $courseId = $_POST['courseId'];
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

        $sql = "UPDATE courses SET course_id = '$courseId', course_name = '$courseName', course_description = '$courseDescription', course_author = '$author', course_duration = '$courseDuration', course_price = '$sellingprice', course_original_price = '$originalPrice', course_img = '$imgFolder' WHERE course_id = '$courseId'";

        if ($connection->query($sql) == TRUE) {
            $msg = '<div class="alert alert-success text-center">Course Updated !</div>';
        } else {
            $msg = '<div class="alert alert-danger text-center">Updation Falied !</div>';
        }
    }
}

?>

<title>EDUTRACK - Edit Courses</title>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="form-container">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Update Course Details <a href="./Courses.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>
        </h3>

        <?php
        if (isset($_REQUEST['edit'])) {
            $sql = "SELECT * FROM courses WHERE course_id = {$_REQUEST['id']}";

            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
        }

        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 d-none">
                <label class="form-label">Course ID</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="courseId" value="<?php if (isset($row['course_id'])) {
                                                                                        echo $row['course_id'];
                                                                                    } ?>" placeholder="Enter course Id" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="courseName" value="<?php if (isset($row['course_name'])) {
                                                                                            echo $row['course_name'];
                                                                                        } ?>" placeholder="Enter course name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Description</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                    <textarea class="form-control" name="courseDescription" rows="3" placeholder="Enter course description" required><?php if (isset($row['course_description'])) {
                                                                                                                                            echo $row['course_description'];
                                                                                                                                        } ?></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="author" value="<?php if (isset($row['course_author'])) {
                                                                                        echo $row['course_author'];
                                                                                    } ?>" placeholder="Enter author name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Duration</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    <input type="text" class="form-control" name="courseDuration" value="<?php if (isset($row['course_duration'])) {
                                                                                                echo $row['course_duration'];
                                                                                            } ?>" placeholder="Enter course duration" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Original Price</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input type="number" class="form-control" name="originalPrice" value="<?php if (isset($row['course_original_price'])) {
                                                                                                echo $row['course_original_price'];
                                                                                            } ?>" placeholder="Enter original price" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Selling Price</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="number" class="form-control" name="sellingprice" value="<?php if (isset($row['course_price'])) {
                                                                                                echo $row['course_price'];
                                                                                            } ?>" placeholder="Enter selling price" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Course Image</label>
                <img src="<?php if (isset($row['course_img'])) {
                                echo $row['course_img'];
                            } ?>" alt="" class="w-50">
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control" name="courseImage" accept="image/*" required onchange="previewImage(event)">
                </div>
                <div class="preview-container">
                    <img id="preview" src="#" alt="Preview Image">
                </div>
            </div>

            <div class="mb-3 text-center">
                <button type="submit" name="update_course" id="update_course" class="btn btn-primary custom-btn-primary">
                    <i class="fas fa-plus-circle"></i> Update
                </button>
            </div>

            <?php if (isset($msg)) {
                echo $msg;
            } ?>
        </form>
    </div>
</div>




<?php include '../layout/adminFooter.php'; ?>