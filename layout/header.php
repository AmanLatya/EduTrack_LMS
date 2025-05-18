<?php
include __DIR__ . '/../ConnectDataBase.php';

if (!isset($_SESSION)) {
    session_start();
}
?>
<header class="sticky-top">
    <nav class="navbar navbar-expand-sm shadow bg-white p-4">
        <div class="container-fluid nav-header">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand fs-4 fw-bold active" href="/EduTrack">
                <i class="fas fa-graduation-cap"></i> EduTrack
            </a>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">EduTrack</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php
                        if (isset($_SESSION['is_AdminLogin']) && isset($_SESSION['AdminLoginEmail'])) {
                            $sql = "SELECT * FROM admin WHERE Admin_Email = '{$_SESSION['AdminLoginEmail']}'";
                            $result = $connection->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo '
                                <li class="nav-item fs-5 px-2">
                                    <a class="nav-link" href="./Admin">
                                        <i class="fas fa-book-open"></i> ' . $row['Admin_Name'] . '
                                    </a>
                                </li>
                                <li class="nav-item fs-5 p-2">
                                    <a class="btn btn-info px-3 py-1 text-dark fw-bold" href="./Logout.php">
                                        <i class="fas fa-sign-in-alt"></i> Logout
                                    </a>
                                </li>
                                ';
                            }
                        } else if (isset($_SESSION['is_stuLogin']) && isset($_SESSION['stuLoginEmail'])) {
                            $sql = "SELECT * FROM student WHERE Stu_Email = '{$_SESSION['stuLoginEmail']}'";
                            $result = $connection->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo '
                                <li class="nav-item fs-5 px-2">
                                    <a class="nav-link" href="./Student/StudentDashBoard.php">
                                        <i class="fas fa-user"></i> My DashBoard
                                    </a>
                                </li>
                                <li class="nav-item fs-5 p-2">
                                    <a class="btn btn-info px-3 py-1 text-dark fw-bold" href="./Logout.php">
                                        <i class="fas fa-sign-in-alt"></i> Logout
                                    </a>
                                </li>
                                ';
                            }
                        } else {
                            echo '
                            <li class="nav-item fs-5 px-2">
                                <a class="nav-link" href="/EduTrack/allCourses.php">
                                    <i class="fas fa-book-open"></i> Courses
                                </a>
                            </li>
                            <li class="nav-item fs-5 p-2">
                                <a class="btn btn-outline-info px-3 py-1" href="#" data-bs-toggle="modal" data-bs-target="#StudentSignUpModal">
                                    <i class="fas fa-user-plus"></i> Sign Up
                                </a>
                            </li>
                            <li class="nav-item fs-5 p-2">
                                <a class="btn btn-info px-3 py-1 text-dark fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#StudentLoginModal">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                            ';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<?php include('./Forms/StudentLogin.php') ?>
<?php include('./Forms/StudentSignUp.php') ?>