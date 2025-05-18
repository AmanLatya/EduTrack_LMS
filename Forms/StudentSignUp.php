<section>
  <div class="modal fade" id="StudentSignUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
       aria-labelledby="StudentSignUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content animate-modal rounded-4 shadow p-4">
        <div class="modal-header border-bottom-0">
          <h1 class="modal-title fs-4 fw-bold" id="StudentSignUpModalLabel">Sign Up</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="signupForm">
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold"><i class="fas fa-user me-1"></i> Name</label>
              <input type="text" id="name" class="form-control rounded-pill border-2 shadow-sm" placeholder="Enter your name here" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold"><i class="fas fa-envelope me-1"></i> Email</label>
              <input type="email" id="email" class="form-control rounded-pill border-2 shadow-sm" placeholder="Enter your email here" required>
              <span id="emailError" class="text-danger small"></span>
            </div>
            <div class="mb-3">
              <label for="guardianEmail" class="form-label fw-semibold"><i class="fas fa-user-shield me-1"></i> Guardian Email</label>
              <input type="email" id="guardianEmail" class="form-control rounded-pill border-2 shadow-sm" placeholder="Enter your guardian email here" required>
              <span id="guardianEmailError" class="text-danger small"></span>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold"><i class="fas fa-lock me-1"></i> Password</label>
              <input type="password" id="password" class="form-control rounded-pill border-2 shadow-sm" placeholder="Enter your password here" required>
            </div>
            <div class="mb-4">
              <label for="confirmPassword" class="form-label fw-semibold"><i class="fas fa-lock me-1"></i> Confirm Password</label>
              <input type="password" id="confirmPassword" class="form-control rounded-pill border-2 shadow-sm" placeholder="Confirm your password here" required>
              <span id="passwordError" class="text-danger small"></span>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" id="signupButton" class="btn btn-primary rounded-pill shadow-sm" disabled>
                <i class="fas fa-user-check me-1">a</i> Sign Up
              </button>
            </div>
            <p class="text-center mb-3">Already have account? 
              <a href="#" data-bs-toggle="modal" data-bs-target="#StudentLoginModal">
                <i class="fas fa-sign-in-alt me-1"></i> Login
              </a>
            </p>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="updatesCheckbox" required>
              <label class="form-check-label" for="updatesCheckbox">
                By signing up you agree to receive updates and special offers.
              </label>
            </div>
          </form>

          <!-- Spinner shown while processing -->
          <div id="signupLoader" class="text-center mt-3" style="display: none;">
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

<style>
  .animate-modal {
    animation: fadeIn 0.5s ease-in-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0.9);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .input-animate {
    transition: all 0.3s ease-in-out;
  }

  .input-animate:focus {
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    transform: scale(1.02);
  }

  .btn-animate {
    transition: all 0.3s ease-in-out;
  }

  .btn-animate:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
  }
</style>
