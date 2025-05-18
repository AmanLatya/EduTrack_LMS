<?php
session_start();
include '../ConnectDataBase.php';

$msg = "";

// Redirect if no session email is set
if (!isset($_SESSION['forgotPass_Email'])) {
    echo "<script>location.href='../';</script>";
    exit;
}

$email = $_SESSION['forgotPass_Email'];

// Fetch student ID from email
$stmt = $connection->prepare("SELECT Stu_id FROM student WHERE Stu_Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id = $row['Stu_id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changePass'])) {
    $newPass = $_POST['newPass'];
    $cnfPass = $_POST['cnfPass'];

    if ($newPass === $cnfPass) {
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);
        // Check Student Email is Present or not Database
        $stuQuery = $connection->prepare("SELECT Stu_Email FROM student WHERE Stu_Email = ?");
        $stuQuery->bind_param("s", $email);
        $stuQuery->execute();
        $stuQuery->store_result();

        // Check Admin Email is Present or not Database
        $adminQuery = $connection->prepare("SELECT Admin_Email FROM admin WHERE Admin_Email = ?");
        $adminQuery->bind_param("s", $email);
        $adminQuery->execute();
        $adminQuery->store_result();
        if ($stuQuery->num_rows > 0) {
            $updateStuQuery = $connection->prepare("UPDATE student SET Stu_Pass = ? WHERE Stu_id = ?");
            $updateStuQuery->bind_param("si", $hashedNewPass, $id);
            if ($updateStuQuery->execute()) {
                $msg = '<div class="alert alert-success text-center mt-3">✅ Password updated successfully!</div>';
                unset($_SESSION['forgotPass_Email']);
            } else {
                $msg = '<div class="alert alert-danger text-center mt-3">❌ Error updating password.</div>';
            }
        } else if ($adminQuery->num_rows > 0) {
            $updateAdminQuery = $connection->prepare("UPDATE admin SET Admin_Pass = ? WHERE Admin_Email = ?");
            $updateAdminQuery->bind_param("ss", $hashedNewPass, $email);
            if ($updateAdminQuery->execute()) {
                $msg = '<div class="alert alert-success text-center mt-3">✅ Password updated successfully!</div>';
                unset($_SESSION['forgotPass_Email']);
            } else {
                $msg = '<div class="alert alert-danger text-center mt-3">❌ Error updating password.</div>';
            }
        }
    } else {
        $msg = '<div class="alert alert-danger text-center mt-3">⚠️ Passwords do not match.</div>';
    }
}
?>

<!-- Password Reset Page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - EduTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #f1f5f9;
        }

        .reset-box {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }

        .feedback-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6 position-relative reset-box p-4 shadow rounded bg-white">
            <!-- Close Button at Top-Right -->
            <a href="../index.php" class="btn-close position-absolute top-0 end-0 m-3"
                aria-label="Close" onclick="return confirm('Are you sure you want to cancel password reset and go back to home?');"></a>

            <h2 class="text-center feedback-title mb-4">🔒 Set New Password</h2>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-key me-2"></i>New Password</label>
                    <input type="password" class="form-control" name="newPass" placeholder="Enter new password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-key me-2"></i>Confirm Password</label>
                    <input type="password" class="form-control" name="cnfPass" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="changePass">
                    <i class="fas fa-check-circle me-2"></i>Reset Password
                </button>
                <?php echo $msg; ?>
            </form>
        </div>
    </div>


    <!-- Bootstrap JS for optional features -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>