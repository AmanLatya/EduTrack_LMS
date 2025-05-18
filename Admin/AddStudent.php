<!-- Header Links -->
<?php

// use Google\Service\SQLAdmin\Resource\Connect;
include './AdminHeader.php';
include '../ConnectDataBase.php';

$msg = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
    if (
        empty($_POST['stuName']) || empty($_POST['stuEmail']) || empty($_POST['gaurdianEmail']) ||
        empty($_POST['stuPass']) || empty($_POST['stuProffesion']) || empty($_POST['stuAddress']) || empty($_POST['stuPhone']) ||
        empty($_FILES['stuProfile']['name'])
    ) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else if ($_POST['stuEmail'] === $_POST['gaurdianEmail']) {
        $msg = '<div class="alert alert-danger text-center">Student email and Guardian email must be different!</div>';
    } else {
        $stuName = $_POST['stuName'];
        $stuEmail = $_POST['stuEmail'];
        $gaurdianEmail = $_POST['gaurdianEmail'];

        $stuPass = $_POST['stuPass'];
        $stuProffesion = $_POST['stuProffesion'];
        $stuAddress = $_POST['stuAddress'];
        $stuPhone = $_POST['stuPhone'];
        $stuProfile = $_FILES['stuProfile']['name'];
        $stuProfileTemp = $_FILES['stuProfile']['tmp_name'];
        $stuImgFolder = '../images/studentImages/' . $stuProfile;
        move_uploaded_file($stuProfileTemp, $stuImgFolder);

        $sql = "INSERT INTO student (Stu_Name,Stu_Email,Alter_Email,Stu_Pass,Stu_Proffesion,Stu_Profile,Stu_Address,Stu_Phone) VALUES ('$stuName','$stuEmail','$gaurdianEmail','$stuPass','$stuProffesion','$stuImgFolder','$stuAddress','$stuPhone')";

        if ($connection->query($sql) == TRUE) {
            $msg = '<div class="alert alert-success text-center">Student Added!</div>';
        } else {
            $msg = '<div class="alert alert-danger text-center">Unable Added!</div>';
        }
    }
}
?>

<title>EDUTRACK - Add Courses</title>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="form-container shadow p-5">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Add New Student

            <a href="./Student.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>
        </h3>
        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Student Name</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="stuName" placeholder="Enter student name" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Student Email</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="email" class="form-control" name="stuEmail" placeholder="Enter student email" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gaurdian Email</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="email" class="form-control" name="gaurdianEmail" placeholder="Enter gaurdianEmail " required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Enter Password</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    <input type="password" class="form-control" name="stuPass" placeholder="Enter course duration" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Proffession</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input type="text" class="form-control" name="stuProffesion" placeholder="Enter Proffession" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Profile</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control" name="stuProfile" accept="image/*" required onchange="previewImage(event)">
                </div>
                <div class="preview-container">
                    <img id="preview" src="#" alt="Preview Image">
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label">Student Address</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                    <textarea class="form-control" name="stuAddress" rows="3" placeholder="Address" required></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile Number</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="number" class="form-control" name="stuPhone" placeholder="Enter Mobile Number" required>
                </div>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" name="add_student" class="btn btn-primary custom-btn-primary" id="SignUpSubmitBtn">
                    <i class="fas fa-plus-circle"></i> Add Student
                </button>
            </div>

            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.getElementById("preview");
            img.src = reader.result;
            img.style.display = "block";
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


<?php include '../layout/adminFooter.php'; ?>