<?php
include('./layout/htmlHeadLinks.php');
include('./layout/header.php');
include('./ConnectDataBase.php');
include('./API/APIConfig.php');
?>

<div class="container text-center mt-5">
    <div class="card shadow p-4">
        <div class="card-body">
            <div class="success-icon mb-3">
                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
            </div>
            <h2 class="fw-bold text-success">Registration Successful!</h2> <span><?php echo $_SESSION['is_stuLogin'] ?></span>
            <p class="text-muted">Thank you for signing up. Your account has been successfully created.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="./Student/StudentDashBoard.php" class="btn btn-primary">Go to Dashboard</a>
                <a href="./index.php" class="btn btn-outline-secondary">Return Home</a>
            </div>
        </div>
    </div>
</div>

<!-- Start Footer Courses -->
<?php include('./layout/footer.php') ?>
<!-- End Footer Courses -->

<!-- Html Footer Links -->
<?php include('./layout/htmlFooterLinks.php') ?>