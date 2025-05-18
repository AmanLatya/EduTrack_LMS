<!-- NavBar -->
<?php
include './StudentData.php';
$msg = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitFeedback'])) {
    if (empty($_POST['message'])) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $f_msg = $_POST['message'];

        // Prepare and bind statement to prevent SQL injection and syntax errors
        $stmt = $connection->prepare("INSERT INTO feedback (f_msg, Stu_id) VALUES (?, ?)");
        $stmt->bind_param("si", $f_msg, $id); // "s" = string, "i" = integer

        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success text-center">Feedback Posted!</div>';
        } else {
            $msg = '<div class="alert alert-warning text-center">Something went wrong!</div>';
        }

        $stmt->close();
    }
}
include './StudentNavBar.php';
?>

<div class="container p-5 mt-5 shadow">
    <h2 class="feedback-title">FEEDBACK</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label"><i class="fas fa-comment"></i> Message</label>
            <textarea class="form-control" name="message" rows="4" placeholder="Type Message...." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="submitFeedback"><i class="fas fa-paper-plane"></i> Submit</button>
        <?php if (!empty($msg)) {
            echo $msg;
        } ?>
    </form>
</div>

<?php include '../layout/adminFooter.php' ?>
