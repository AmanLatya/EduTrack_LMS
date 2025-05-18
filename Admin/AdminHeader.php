<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['is_AdminLogin'])) {
    echo "<script> location.href='../'; </script>";
}
include('./AdminData.php');
include('../layout/htmlHeadLinks.php');
?>

<style>
    .desktop-nav {
        display: none;
    }

    @media (min-width: 768px) {
        .desktop-nav {
            display: flex;
        }
    }

    .nav-item {
        margin-right: 10px;
    }
</style>

<header class="sticky-top">
    <nav class="navbar navbar-expand-sm shadow bg-white px-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand fs-4 fw-bold active" href="../">
                    <i class="fas fa-graduation-cap"></i> EduTrack
                </a>

                <div class="desktop-nav">
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary" href="./">
                        <i class="fas fa-home me-3"></i>Home
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary" href="./Payments.php">
                        <i class="fas fa-home me-3"></i>Sales
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary" href="./Courses.php">
                        <i class="fas fa-book me-3"></i> Courses
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary" href="./Student.php">
                        <i class="fas fa-users me-3"></i> Students
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary" href="./lessons.php">
                        <i class="fas fa-book me-3"></i> Course Topics
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary" href="./Assignment.php">
                        <i class="fas fa-chart-line me-3"></i> Assignments
                    </a>
                    <div class="dropdown m-2">
                        <a class="nav-link d-flex align-items-center text-decoration-none text-secondary" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v me-3"></i> More
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="./ChangePassword.php"><i class="fas fa-cog me-3"></i> Change Password</a></li>
                            <li><a class="dropdown-item" href="../Logout.php"><i class="fas fa-sign-out-alt me-3"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
    aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">EduTrack</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled mt-5">
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary" href="./">
                    <i class="fas fa-home me-3"></i> Admin Dashboard
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary" href="./Courses.php">
                    <i class="fas fa-book me-3"></i> Courses
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary" href="./Student.php">
                    <i class="fas fa-users me-3"></i> Students
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary" href="./lessons.php">
                    <i class="fas fa-book me-3"></i> Course Topics
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary" href="./Assignment.php">
                    <i class="fas fa-chart-line me-3"></i> Assignments
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary" href="../Logout.php">
                    <i class="fas fa-sign-out-alt me-3"></i> Log out
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    // Add click event listener to the dropdown button
    document.getElementById('adminDropdown').addEventListener('click', function() {
        this.parentElement.classList.toggle('show');
    });

    // Close the dropdown when clicking outside
    window.addEventListener('click', function(event) {
        if (!event.target.matches('#adminDropdown')) {
            var dropdowns = document.getElementsByClassName("dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    });
</script>

<?php include '../layout/htmlFooterLinks.php' ?>