<?php
if (!isset($_SESSION)) {
    session_start();
}
include('./ConnectDataBase.php');
// require "C:/xampp/htdocs/EduTrack/vendor/autoload.php";

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // if you're inside /API
// $dotenv->load();
// $client = new Google\Client;

// $client->setClientId($_ENV['GOOGLE_Instructor_CLIENT_ID']);
// $client->setClientSecret($_ENV['GOOGLE_Instructor_CLIENT_SECRET']);
// $client->setRedirectUri($_ENV['GOOGLE_Instructor_REDIRECT_URI']);

// $client->addScope("email");
// $client->addScope("profile");

// $InstructorUrl = $client->createAuthUrl();

?>

<section>
  <div class="modal fade" id="InstructorLoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="InstructorLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 animate-modal shadow p-4">
        <div class="modal-header border-bottom-0">
          <h1 class="modal-title fs-4 fw-bold" id="InstructorLoginModalLabel">FACULTY LOGIN</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Instructor Login Form -->
          <form method="POST" id="InstructorLoginForm">
            <div class="mb-3">
              <label for="InstructorPassKey" class="form-label d-flex align-items-center">
                <i class="fas fa-user-shield me-2"></i> Instructor PassKey
              </label>
              <input type="text" class="form-control rounded-pill border-0 shadow-sm" id="InstructorPassKey" name="email" required autocomplete="username">
            </div>
            <div class="mb-4">
              <label for="InstructorPassword" class="form-label d-flex align-items-center">
                <i class="fas fa-lock me-2"></i> Password
              </label>
              <input type="password" id="InstructorPassword" class="form-control rounded-pill border-0 shadow-sm" name="password" required autocomplete="current-password">
            </div>
            <div class="d-grid mb-4">
              <button type="button" class="btn btn-primary rounded-pill" id="InstructorLoginBtn">Login Now</button>
            </div>
            <div class="mt-3 text-center">
              <span id="InstructorLoginFailedMsg" class="text-danger fw-bold"></span>
              <span id="InstructorLoginSuccessMsg" class="text-success fw-bold"></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
