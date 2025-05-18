<?php
if (!isset($_SESSION)) {
    session_start();
}

include './AdminHeader.php';
include '../ConnectDataBase.php';

// if (!isset($_SESSION['is_AdminLogin']) || !isset($_SESSION['AdminLoginEmail'])) {
//     echo '<script> window.location.href = "./index.php"; </script>';
//     exit();
// }

$AdminLoginEmail = $_SESSION['AdminLoginEmail'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['savePass'])) {
    if (empty($_POST['oldPass']) || empty($_POST['newPass'])) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $oldPass = $_POST['oldPass'];
        $newPass = $_POST['newPass'];

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT Admin_Pass FROM admin WHERE Admin_Email = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $AdminLoginEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($oldPass === $row['Admin_Pass']) {
                // Hash new password before updating
                $updateSQL = "UPDATE admin SET Admin_Pass = ? WHERE Admin_Email = ?";
                $updateStmt = $connection->prepare($updateSQL);
                $updateStmt->bind_param("ss", $newPass, $AdminLoginEmail);

                if ($updateStmt->execute()) {
                    $msg = '<div class="alert alert-success text-center">Password Updated Successfully!</div>';
                } else {
                    $msg = '<div class="alert alert-danger text-center">Update Failed!</div>';
                }
            } else {
                $msg = '<div class="alert alert-danger text-center">Old Password is Incorrect!</div>';
            }
        }
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="form-container shadow p-5">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i>
            Update Password
            <a href="./index.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>
        </h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="oldPass" placeholder="Enter Old Password" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="newPass" placeholder="Enter New Password" required>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mb-3 text-center">
                <button type="submit" name="savePass" id="savePass" class="btn btn-primary custom-btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
            <a class="btn btn-outline-info px-3 py-1" href="#" data-bs-toggle="modal" data-bs-target="#forgotPassModal"><i class="fas fa-lock"></i> Forgot Password</a>

            <?php if (isset($msg)) {
                echo $msg;
            } ?>
        </form>
    </div>
</div>


<?php 
include '../layout/adminFooter.php';
include '../Student/forgotPassModal.php';
include '../js/Student.js';
?>