<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

// -----------------------------------------------------Update Student------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_detail'])) {
    if (
        empty($_POST['stuName']) || empty($_POST['stuEmail']) || empty($_POST['gaurdianEmail']) || 
        empty($_POST['stuProffesion']) || empty($_FILES['stuProfile']['name']) || 
        empty($_POST['stuAddress']) || empty($_POST['stuPhone'])
    ) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $stuId = $_POST['stuId'];
        $stuName = $_POST['stuName'];
        $stuEmail = $_POST['stuEmail'];
        $gaurdianEmail = $_POST['gaurdianEmail'];
        $stuProffesion = $_POST['stuProffesion'];
        $stuAddress = $_POST['stuAddress'];
        $stuPhone = $_POST['stuPhone'];
        $stuProfile = $_FILES['stuProfile']['name'];
        $stuProfileTemp = $_FILES['stuProfile']['tmp_name'];
        $stuImgFolder = '../images/studentImages/' . $stuProfile;
        move_uploaded_file($stuProfileTemp, $stuImgFolder);

        // Use prepared statement to prevent SQL injection
        $stmt = $connection->prepare("UPDATE student 
                                      SET Stu_Name = ?, Stu_Email = ?, Alter_Email = ?, Stu_Proffesion = ?, 
                                          Stu_Address = ?, Stu_Phone = ?, Stu_Profile = ? 
                                      WHERE Stu_id = ?");
        
        $stmt->bind_param("sssssssi", $stuName, $stuEmail, $gaurdianEmail, $stuProffesion, $stuAddress, $stuPhone, $stuImgFolder, $stuId);

        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success text-center">Student Updated Successfully!</div>';
            echo "
                <script>
                setTimeout(function(){
                    window.location.href = './Student.php';
                },800);
                </script>
            ";
        } else {
            $msg = '<div class="alert alert-danger text-center">Update Failed!</div>';
        }

        $stmt->close();
    }
}
?>

<title>EDUTRACK - Edit Student</title>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="form-container">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Add New Student <a href="./Student.php" class="btn btn-primary ml-3">
                <i class="fas fa-times"></i>
            </a></h3>
        <!-- <div class="text-center"> -->

        <!-- </div> -->

        <?php
        if (isset($_REQUEST['edit'])) {
            $sql = "SELECT * FROM student WHERE Stu_id = {$_REQUEST['id']}";

            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
        }

        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 d-none">
                <label class="form-label">Student ID</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="stuId" value="<?php if (isset($row['Stu_id'])) {
                                                                                        echo $row['Stu_id'];
                                                                                    } ?>" placeholder="Enter Student Id" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Student Name</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="text" class="form-control" name="stuName" value="<?php if (isset($row['Stu_Name'])) {
                                                                                        echo $row['Stu_Name'];
                                                                                    } ?>" placeholder="Enter student name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Student Email</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <input type="email" class="form-control" name="stuEmail" value="<?php if (isset($row['Stu_Email'])) {
                                                                                        echo $row['Stu_Email'];
                                                                                    } ?>" placeholder="Enter student email" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gaurdian Email</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="email" class="form-control" name="gaurdianEmail" value="<?php if (isset($row['Alter_Email'])) {
                                                                                                echo $row['Alter_Email'];
                                                                                            } ?>" placeholder="Enter gaurdianEmail " required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Proffession</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-dollagaurdianEmailr-sign"></i></span>
                    <input type="text" class="form-control" name="stuProffesion" value="<?php if (isset($row['Stu_Proffesion'])) {
                                                                                            echo $row['Stu_Proffesion'];
                                                                                        } ?>" placeholder="Enter Proffession" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">New Address</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                    <textarea class="form-control" name="stuAddress" rows="3" placeholder="Address" required><?php if (isset($row['Stu_Address'])) {
                                                                                                                    echo $row['Stu_Address'];
                                                                                                                } ?></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile Number</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="number" class="form-control" name="stuPhone" value="<?php if (isset($row['Stu_Phone'])) {
                                                                                            echo $row['Stu_Phone'];
                                                                                        } ?>" placeholder="Enter Mobile Number" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Profile</label>
                <img src="<?php if (isset($row['Stu_Profile'])) {
                                echo $row['Stu_Profile'];
                            } ?>" alt="" class="w-25">
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control" name="stuProfile" accept="image/*" required onchange="previewImage(event)">
                </div>
                <div class="preview-container">
                    <img id="preview" src="#" alt="Preview Image">
                </div>
            </div>

            <div class="mb-3 text-center">
                <button type="submit" name="update_detail" id="update_detail" class="btn btn-primary custom-btn-primary">
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