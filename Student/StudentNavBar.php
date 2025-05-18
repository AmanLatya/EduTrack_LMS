<?php
if (!isset($_SESSION['is_stuLogin'])) {
    echo "<script> location.href='../'; </script>";
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        left: -250px;
        top: 0;
        background: white;
        transition: 0.3s ease-in-out;
        z-index: 1000;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar.show {
        left: 0;
        height: 94vh;
    }

    .toggle-btn {
        border: none;
        cursor: pointer;
        z-index: 1100;
        background: transparent;
    }

    .sidebar ul li a {
        transition: background-color 0.3s ease, color 0.3s ease;
        padding: 10px 15px;
        border-radius: 5px;
        display: block;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active {
        background-color: #f0f0f0;
        color: #007bff;
        font-weight: bold; /* Make active link bold */
    }

    @media (min-width: 768px) {
        .toggle-btn {
            display: none;
        }

        .sidebar {
            display: none; /* Hide sidebar on desktop */
        }
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        float: left;
        min-width: 10rem;
        padding: .5rem 0;
        margin: .125rem 0 0;
        font-size: 1rem;
        color: #212529;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: .25rem;
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: .25rem 1rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }

    .dropdown-item:hover,
    .dropdown-item.active {
        background-color: #f0f0f0;
        color: #007bff;
        font-weight: bold; /* Make active link bold */
    }

    /* Remove hover effect from dropdown */
    .dropdown:hover .dropdown-menu {
        display: none;
    }

    .dropdown.show .dropdown-menu {
        display: block;
    }

    .desktop-nav {
        display: none;
    }

    @media (min-width: 768px) {
        .desktop-nav {
            display: flex;
        }
    }

    .user-image{
        display: none;
    }
    @media (max-width: 768px) {
        .user-image {
            display: block;
        }
    }
    .nav-item{
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
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'StudentDashBoard.php') ? 'active' : ''; ?>" href="./StudentDashBoard.php">
                        <i class="fas fa-home me-3"></i> Home
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'StudentProfile.php') ? 'active' : ''; ?>" href="./StudentProfile.php">
                        <i class="fas fa-user me-3"></i> Profile
                    </a>
                    <a class="nav-item d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'MyCourses.php') ? 'active' : ''; ?>" href="./MyCourses.php">
                        <i class="fas fa-tasks me-3"></i> Enrolled Courses
                    </a>
                    <div class="dropdown m-2">
                        <a class="nav-link d-flex align-items-center text-decoration-none text-secondary" href="#" id="dropdownMenuButton"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v me-3"></i> More
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item <?php echo ($currentPage == 'StudentFeedback.php') ? 'active' : ''; ?>" href="./StudentFeedback.php"><i class="fas fa-calendar-alt me-3"></i> Feedback</a></li>
                            <li><a class="dropdown-item <?php echo ($currentPage == 'StudentSetting.php') ? 'active' : ''; ?>" href="./StudentSetting.php"><i class="fas fa-cog me-3"></i> Setting</a></li>
                            <li><a class="dropdown-item" href="../Logout.php"><i class="fas fa-sign-out-alt me-3"></i> Log out</a></li>
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
            <li class="m-3 user-image">
                <img src="<?php echo $image ?>" alt="User" class="w-75 rounded-circle shadow-sm">
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'StudentDashBoard.php') ? 'active' : ''; ?>" href="./StudentDashBoard.php">
                    <i class="fas fa-home me-3"></i> Home
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'StudentProfile.php') ? 'active' : ''; ?>" href="./StudentProfile.php">
                    <i class="fas fa-user me-3"></i> Profile
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'MyCourses.php') ? 'active' : ''; ?>" href="./MyCourses.php">
                    <i class="fas fa-tasks me-3"></i> Enrolled Courses
                </a>
            </li>
            <li class="m-3">
                 <a class="d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'StudentFeedback.php') ? 'active' : ''; ?>" href="./StudentFeedback.php">
                    <i class="fas fa-calendar-alt me-3"></i> Feedback
                </a>
            </li>
            <li class="m-3">
                <a class="d-flex align-items-center text-decoration-none text-secondary <?php echo ($currentPage == 'StudentSetting.php') ? 'active' : ''; ?>" href="./StudentSetting.php">
                    <i class="fas fa-cog me-3"></i> Setting
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
    document.getElementById('dropdownMenuButton').addEventListener('click', function() {
        this.parentElement.classList.toggle('show');
    });

    // Close the dropdown when clicking outside
    window.addEventListener('click', function(event) {
        if (!event.target.matches('#dropdownMenuButton')) {
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