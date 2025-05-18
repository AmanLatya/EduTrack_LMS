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
                        <!-- <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-1"></i> Name
                            </label>

                            <input type="text" name="forgotName" id="forgotName" class="form-control rounded-pill border-2 shadow-sm" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" name="forgotEmail" id="forgotEmail" class="form-control rounded-pill border-2 shadow-sm" required >
                            <span id="emailError" class="text-danger small"></span>
                        </div>

                        <div class="d-grid mb-3" id="getOtpSection">
                            <button type="submit" id="getOtpButton" name="getOtp" class="btn btn-primary rounded-pill shadow-sm" >
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


 