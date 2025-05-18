<?php
include_once('../ConnectDataBase.php');
include './StudentData.php';
$msg = ""; // Initialize message variable

// Fetch student ID from session or database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveProfile'])) {
    if (empty($_POST['stuName']) || empty($_POST['stuPhone']) || empty($_POST['stuProffession']) || empty($_POST['stuAddress'])) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $stuName = mysqli_real_escape_string($connection, $_POST['stuName']);
        $stuPhone = mysqli_real_escape_string($connection, $_POST['stuPhone']);
        $stuProffession = mysqli_real_escape_string($connection, $_POST['stuProffession']);
        $stuAddress = mysqli_real_escape_string($connection, $_POST['stuAddress']);

        // Handle Image Upload
        if (!empty($_FILES['stuProfile']['name'])) {
            $targetDir = "../images/studentImages/"; // Folder where images will be saved
            $fileName = time() . "_" . basename($_FILES["stuProfile"]["name"]); // Unique file name
            $targetFilePath = $targetDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Allowed image formats
            $allowedTypes = array("jpg", "jpeg", "png", "gif");
            if (in_array($fileType, $allowedTypes)) {
                // Move file to uploads folder
                if (move_uploaded_file($_FILES["stuProfile"]["tmp_name"], $targetFilePath)) {
                    // Update database with image path
                    $sql = "UPDATE student SET Stu_Name = '$stuName', Stu_Phone = '$stuPhone', Stu_Proffesion = '$stuProffession', Stu_Address = '$stuAddress', Stu_Profile = '$targetFilePath' WHERE Stu_id = '$id'";
                } else {
                    $msg = '<div class="alert alert-danger text-center">Image upload failed.</div>';
                }
            } else {
                $msg = '<div class="alert alert-warning text-center">Only JPG, JPEG, PNG, and GIF files are allowed.</div>';
            }
        } else {
            // Update without image
            $sql = "UPDATE student SET Stu_Name = '$stuName', Stu_Phone = '$stuPhone', Stu_Proffesion = '$stuProffession', Stu_Address = '$stuAddress' WHERE Stu_id = '$id'";
        }

        if ($connection->query($sql)) {
            $msg = '<div class="alert alert-success text-center">Profile Updated Successfully!</div>';
        } else {
            $msg = '<div class="alert alert-danger text-center">Update Failed!</div>';
        }
    }
}

// Fetch updated profile image for preview
$query = "SELECT Stu_Profile FROM student WHERE Stu_id = '$id'";
$result = $connection->query($query);
$row = $result->fetch_assoc();
$image = !empty($row['Stu_Profile']) ? $row['Stu_Profile'] : "../images/default-profile.png";
?>

<!-- NavBar -->
<?php include './StudentNavBar.php' ?>
<div class="container shadow p-5">
    <!-- Header -->
    <div class="header-bg mb-4">
        <h1 class="text-3xl font-weight-bold text-white">Edit Profile</h1>
        <span class="text-light">Update your personal information and preferences</span>
        <span><?php if (isset($msg)) {
                    echo $msg;
                } ?> </span>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <!-- Profile Form -->
        <div class="profile-card p-4 rounded-lg relative">
            <!-- Profile Photo Section -->
            <div class="mb-4 text-center">
                <h2 class="text-xl font-weight-bold mb-3">Profile Photo</h2>
                <div class="d-flex flex-column align-items-center">
                    <label for="profileImageInput" class="cursor-pointer">
                        <img id="profileImage" alt="Student Image" class="rounded-circle mb-3" height="150" width="150" src="<?php echo $image ?>" />
                    </label>
                    <p class="text-muted">Student ID: <span><?php echo $id ?></span></p>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="mb-4">
                <h2 class="text-xl font-weight-bold mb-3">Personal Information</h2>
                <div class="form-row">
                    <div class="form-group col d-inline-block">
                        <!-- File Input for Profile Image -->
                        <label for="stuProfile">Upload Image:</label>
                        <input type="file" class="form-control" id="stuProfile" name="stuProfile" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <br>
                    <div class="form-group col d-inline-block">
                        <label class="text-gray-600">Full Name</label>
                        <input type="text" class="input-field form-control" name="stuName" placeholder="Enter your full name" value="<?php echo $name ?>" required />
                    </div>
                    <div class="form-group col d-inline-block">
                        <label class="text-gray-600">Phone</label>
                        <input type="tel" class="input-field form-control" name="stuPhone" placeholder="Enter your phone number" value="<?php echo $phone ?>" required />
                    </div>
                    <div class="form-group col d-inline-block">
                        <label class="text-gray-600">Profession</label>
                        <input type="text" class="input-field form-control" name="stuProffession" placeholder="Enter your profession" value="<?php echo $proffesion ?>" required />
                    </div>
                    <div class="form-group col d-inline-block">
                        <label class="text-gray-600">Address</label>
                        <input type="text" class="input-field form-control" name="stuAddress" placeholder="Enter your address" value="<?php echo $address ?>" required />
                    </div>
                </div>
            </div>

            <!-- Save and Cancel Buttons -->
            <div class="d-flex justify-content-end gap-3">
                <button class="btn btn-secondary">Cancel</button>
                <button type="submit" class="save-btn btn" name="saveProfile">Save Changes</button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>

</body>

</html>

<?php include '../layout/adminFooter.php' ?>