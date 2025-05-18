<?php
if (!isset($_SESSION)) {
    session_start();
}
include('./ConnectDataBase.php');

require "C:/xampp/htdocs/EduTrack/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // if you're inside /API
$dotenv->load();
$client = new Google\Client;

$client->setClientId($_ENV['GOOGLE_STU_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_STU_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_STU_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
?>

<style>
    /* Custom Styling for the Login Modal */
    .modal-content {
        border: none;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<section>
    <div class="modal fade" id="StudentLoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="StudentLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 animate-modal shadow p-4">
                <div class="modal-header border-bottom-0">
                    <h1 class="modal-title fs-4 fw-bold">LOGIN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="StudentLoginForm">
                        <div class="mb-3">
                            <label for="StudentLoginEmail" class="form-label d-flex align-items-center">
                                <i class="fas fa-user me-2"></i> Username
                            </label>
                            <input type="email" class="form-control rounded-pill border-2 shadow-sm" id="StudentLoginEmail" name="email" required autocomplete="username">
                        </div>
                        <div class="mb-4">
                            <label for="StudentLoginPassword" class="form-label d-flex align-items-center">
                                <i class="fas fa-lock me-2"></i> Password
                            </label>
                            <input type="password" id="StudentLoginPassword" class="form-control rounded-pill border-2 shadow-sm" name="password" required autocomplete="current-password">
                        </div>
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary rounded-pill" id="StudentLoginBtn">Login Now</button>
                        </div>
                        <div class="d-grid gap-2 mb-4">
                            <a href="<?php echo $url; ?>" class="btn btn-light border rounded-pill d-flex align-items-center justify-content-center">
                                <i class="fab fa-google me-2"></i> Login with Google
                            </a>
                        </div>
                        <div class="d-grid gap-2 mb-4">
                            <a class="btn btn-outline-info px-3 py-1" href="#" data-bs-toggle="modal" data-bs-target="#forgotPassModal"><i class="fas fa-lock"></i> Forgot Password</a>
                        </div>
                        <div class="mt-3 text-center">
                            <span id="StudentLoginFailedMsg" class="text-danger fw-bold"></span>
                            <span id="StudentLoginSuccessMsg" class="text-success fw-bold"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php


?>

<section>
    <div class="modal fade" id="forgotPassModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="forgotPassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content animate-modal rounded-4 shadow p-4">
                <div class="modal-header border-bottom-0">
                    <h1 class="modal-title fs-4 fw-bold" id="forgotPassModalLabel">Forgot Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="forgotPassForm">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" name="forgotEmail" id="forgotEmail" class="form-control rounded-pill border-2 shadow-sm " required>
                            <span id="emailError" class="text-danger small"></span>
                        </div>

                        <div class="d-grid mb-3" id="getOtpSection">
                            <button type="submit" id="getOtpButton" name="getOtp" class="btn btn-primary rounded-pill shadow-sm">
                                <i class="fas fa-user-check me-1"></i> Get OTP
                            </button>
                        </div>
                    </form>


                    <!-- Spinner shown while processing -->
                    <div id="Loader" class="text-center mt-3" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                        <p class="mt-2">Processing your request...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $('#StudentLoginModal').on('hidden.bs.modal', function(e) {
        $('#StudentSignUpModal').modal('hide');
    });

    $(document).ready(function() {
        $('#forgotPassForm').submit(function(e) {
            e.preventDefault();

            $("#getOtpButton").prop("disabled", true).text("OTP Sending...");
            $("#Loader").show();

            let formData = {
                email: $('#forgotEmail').val(),
            };
            $.post('./API/process_forgotPass.php', formData, function(response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        window.location.href = './API/verify_forgotPass_otp.php?email=' + formData.email;
                    } else {
                        alert(data.message || "Something went wrong.");
                        $("#getOtpButton").prop("disabled", false).text("Sign Up");
                        $("#Loader").hide();
                    }
                } catch (error) {
                    alert("Unexpected response. Please try again.");
                    $("#getOtpButton").prop("disabled", false).text("Get OTP");
                    $("#Loader").hide();
                }
            }).fail(function() {
                alert("Error occurred. Please try again.");
                $("#getOtpButton").prop("disabled", false).text("OTP Sent");
                $("#Loader").hide();
            });
        })
    })
</script>