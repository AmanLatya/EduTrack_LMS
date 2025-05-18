<?php

include './StudentData.php';
$msg = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changePass'])) {
    $currentPass = $_POST['currentPass'];
    $newPass = $_POST['newPass'];

    // Verify current password
    if (password_verify($currentPass, $password)) {
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE student SET Stu_Pass = ? WHERE Stu_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $hashedNewPass, $id);

        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success text-center">Password updated successfully!</div>';
        } else {
            $msg = '<div class="alert alert-danger text-center">Error updating password.</div>';
        }
    } else {
        $msg = '<div class="alert alert-danger text-center">Current password is incorrect.</div>';
    }
}

include './StudentNavBar.php';
?>
<div class="container shadow p-5 mt-5">
    <!-- Change Password Form -->
    <h2 class="feedback-title">Change Password</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="currentPass" class="form-label"><i class="fas fa-lock"></i> Current Password</label>
            <input type="password" class="form-control" name="currentPass" placeholder="Enter current password" required>
        </div>
        <div class="mb-3">
            <label for="newPass" class="form-label"><i class="fas fa-key"></i> New Password</label>
            <input type="password" class="form-control" name="newPass" placeholder="Enter new password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="changePass"><i class="fas fa-paper-plane"></i> Submit</button>
        <?php echo $msg; ?>
    </form>

    <br>
    <a class="btn btn-outline-info px-3 py-1" href="#" data-bs-toggle="modal" data-bs-target="#forgotPassModal"><i class="fas fa-lock"></i> Forgot Password</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php 
include '../layout/adminFooter.php';
include './forgotPassModal.php';

?>

<?php  include '../js/Student.js';?>
