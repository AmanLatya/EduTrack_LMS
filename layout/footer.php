<!-- Start Footer -->
<footer class="bg-dark text-white py-4 mt-5">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
    <p class="mb-2 mb-md-0">&copy; 2025 | All Rights Reserved</p>

    <?php
    if (!isset($_SESSION['is_AdminLogin']) && !isset($_SESSION['is_stuLogin']) && !isset($_SESSION['is_InstructorLogin'])) {
      echo '
        <a href="#" id="AdminLogin" class="text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#AdminLoginModal">
          <i class="fas fa-user-shield me-1"></i> Admin Login
        </a>
        <a href="#" id="InstructorLogin" class="text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#InstructorLoginModal">
          <i class="fas fa-user-shield me-1"></i> Instructor Login
        </a>
      ';
    }
    ?>
  </div>
</footer>
<!-- End Footer -->

<!-- Start Admin Modal -->
<?php 
include('./Forms/AdminLogin.php') ;
include('./Forms/InstructorLogin.php') ;
?>
<!-- End Admin Modal -->
