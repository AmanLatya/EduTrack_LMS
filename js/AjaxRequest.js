$(document).ready(function () {
    function validateForm() {
        let email = $("#email").val().trim();
        let guardianEmail = $("#guardianEmail").val().trim();
        let password = $("#password").val();
        let confirmPassword = $("#confirmPassword").val();

        let valid = true;

        if (email === guardianEmail) {
            $("#guardianEmailError").text("Guardian email cannot be the same as your email.");
            valid = false;
        } else {
            $("#guardianEmailError").text("");
        }

        let passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordRegex.test(password)) {
            $("#passwordError").text("Password must be 8+ characters, include a number, an uppercase letter, and a special character.");
            valid = false;
        } else if (password !== confirmPassword) {
            $("#passwordError").text("Passwords do not match.");
            valid = false;
        } else {
            $("#passwordError").text("");
        }

        $("#signupButton").prop("disabled", !valid);
        return valid;
    }

    let emailCheckTimer;
    $("#email").on("input", function () {
        clearTimeout(emailCheckTimer);
        let email = $(this).val().trim();
        if (email) {
            emailCheckTimer = setTimeout(function () {
                $.post("Forms/check_email.php", { stuEmail: email }, function (data) {
                    if (data == "1") {
                        $("#emailError").text("Email already registered.");
                        $("#signupButton").prop("disabled", true);
                    } else {
                        $("#emailError").text("");
                        validateForm();
                    }
                });
            }, 500);
        }
    });

    $("#signupForm input").on("input", validateForm);

    $("#signupForm").submit(function (e) {
        e.preventDefault();
        if (!validateForm()) return;

        $("#signupButton").prop("disabled", true).text("Signing up...");
        $("#signupLoader").show();

        let formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            guardianEmail: $('#guardianEmail').val(),
            password: $('#password').val()
        };

        $.post('API/process_signup.php', formData, function (response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    window.location.href = 'API/verify_otp.php?email=' + formData.email;
                } else {
                    alert(data.message || "Something went wrong.");
                    $("#signupButton").prop("disabled", false).text("Sign Up");
                    $("#signupLoader").hide();
                }
            } catch (error) {
                alert("Unexpected response. Please try again.");
                $("#signupButton").prop("disabled", false).text("Sign Up");
                $("#signupLoader").hide();
            }
        }).fail(function () {
            alert("Error occurred. Please try again.");
            $("#signupButton").prop("disabled", false).text("Sign Up");
            $("#signupLoader").hide();
        });
    });
});

// $(document).ready(function () {
//     $('#SignUpSubmitBtn').click(function (e) {
//         e.preventDefault(); // Prevent form submission

//         // Get form data
//         const name = $('#StudentSignUpName').val();
//         const email = $('#StudentSignUpEmail').val();
//         const password = $('#StudentSignUpPassword').val();

//         // Send data to a PHP script for processing
//         $.ajax({
//             url: 'API/process_signup.php',
//             type: 'POST',
//             contentType: 'application/x-www-form-urlencoded',
//             data: {
//                 name: name,
//                 email: email,
//                 password: password
//             },
//             success: function (data) {
//                 // Handle response from PHP script (e.g., show success message)
//                 alert(data); // For testing, replace with better UI
//             }
//         });
//     });
// });


// -----------------------------Same User Can't Register again--------------------------------

// $("#StudentSignUpEmail").on("blur", function () {
//     var email = $("#StudentSignUpEmail");
//     var mailMsg = $("#mailMsg");
//     $.ajax({
//         url: "API/process_signup.php",
//         method: "POST",
//         data: {  // Make sure the parameters are correct
//             checkMail: "CheckMail", // Checking the email existence
//             stuEmail: email.val()  // Sending email value
//         },
//         success: function (checkdata) {
//             console.log("Row:", checkdata);  // Debug to see if the data is coming correctly
//             if (checkdata != 0) {  // If row count is not 0, it means email exists
//                 mailMsg.text('Email Already Exist!').show();
//                 email.focus();
//                 $("#SignUpSubmitBtn").prop("disabled", true);
//                 return false;
//             }
//             else {
//                 $("#SignUpSubmitBtn").prop("disabled", false);
//                 $('#mailMsg').html("");
//             }
//         },
//         error: function () {
//             console.log("Error in AJAX request");
//         }
//     });
// });

// -----------------------------Same User Can't Register again--------------------------------

// ----------x------------------------x--------------------------x--------------------------x-------------------------x--------------------

// ---------------------------------Start Student SignUp Code---------------------------------
// $("#SignUpSubmitBtn").click(function () {
//     // console("Btn Clicked");
//     var name = $("#StudentSignUpName");
//     var email = $("#StudentSignUpEmail");
//     var gaurdianEmail = $("#GaurdianEmail");
//     var password = $("#StudentSignUpPassword");
//     var confirmPassword = $("#StudentCnfPassword");

//     var nameMsg = $("#nameMsg");
//     var mailMsg = $("#mailMsg");
//     var gaurdianMailMsg = $("#gaurdianMailMsg");
//     var passMsg = $("#passMsg");
//     var cnfPassMsg = $("#cnfPassMsg");

//     // Validate email format
//     // var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
//     var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

//     // Function to hide error messages when input is filled
//     function hideErrorOnInput(inputField, errorMsg) {
//         inputField.on("input", function () {
//             if (inputField.val().trim() !== "") {
//                 errorMsg.hide();
//             }
//         });
//     }

//     // Apply function to all input fields
//     hideErrorOnInput(name, nameMsg);
//     hideErrorOnInput(email, mailMsg);
//     hideErrorOnInput(gaurdianEmail, gaurdianMailMsg);
//     hideErrorOnInput(password, passMsg);
//     hideErrorOnInput(confirmPassword, cnfPassMsg);

//     // Validate all fields
//     if (!name.val().trim()) {
//         nameMsg.text('Please Enter Name!').show();
//         name.focus();
//         return false;
//     } else if (!email.val().trim()) {
//         mailMsg.text('Please Enter Email!').show();
//         email.focus();
//         return false;
//     } else if (!emailPattern.test(email.val())) {
//         mailMsg.text('Please Enter a Valid Email!').show();
//         email.focus();
//         return false;
//     }
//     else if (!gaurdianEmail.val().trim()) {
//         gaurdianMailMsg.text('Please Enter Gaurdian Email!').show();
//         gaurdianEmail.focus();
//         return false;
//     }
//     else if (!emailPattern.test(gaurdianEmail.val())) {
//         gaurdianMailMsg.text('Please Enter Valid Email!').show();
//         gaurdianEmail.focus();
//         return false;
//     } else if (!password.val()) {
//         passMsg.text('Password Can\'t be empty!').show();
//         password.focus();
//         return false;
//     } else if (!confirmPassword.val()) {
//         cnfPassMsg.text('Confirm Password Can\'t be empty!').show();
//         confirmPassword.focus();
//         return false;
//     }

//     // Check Email match
//     else if (email.val() === gaurdianEmail.val()) {
//         gaurdianMailMsg.text('Email must be different!').show();
//         gaurdianEmail.focus();
//         return false;
//     }

//     // Validate password length
//     else if (password.val().length < 6) {
//         passMsg.text('Password length must be at least 6 characters').show();
//         password.focus();
//         return false;
//     }

//     // Check if passwords match
//     else if (password.val() !== confirmPassword.val()) {
//         cnfPassMsg.text('Passwords do not match!').show();
//         confirmPassword.focus();
//         return false;
//     } 
//     // else {
//     //     // Send AJAX request
//     //     $.ajax({
//     //         url: 'Student/Authentication.php',
//     //         method: 'POST',
//     //         data: {
//     //             stuSignUp: "SignUp",
//     //             stuName: name.val(),
//     //             stuEmail: email.val(),
//     //             AltEmail: gaurdianEmail.val(),
//     //             stuPass: password.val()
//     //         },
//     //         success: function (response) {
//     //             if (response) {
//     //                 setTimeout(function () {
//     //                     location.reload(); // Reload the page after 2 seconds
//     //                 }, 2000);
//     //             }
//     //         },
//     //         error: function (xhr, status, error) {
//     //             console.error("AJAX Error:", error);
//     //         }
//     //     });
//     // }

//     // Disable button to prevent multiple clicks
//     $("#SignUpSubmitBtn").prop("disabled", true);
//     $("#successMsg").text("Registration Successful");
//     $('#nameMsg').html("");
//     $('#mailMsg').html("");
//     $('#gaurdianMailMsg').html("");
//     $('#passMsg').html("");
//     $('#cnfPassMsg').html("");
//     $("#SignUpForm").trigger("reset");
// });


// ---------------------------------End Student SignUp Code--------------------------------

// ----------x------------------------x--------------------------x--------------------------x-------------------------x--------------------

// ---------------------------------Start Student Login Code--------------------------------



$("#StudentLoginForm").submit(function (e) {
    e.preventDefault();
    let stuLoginEmail = $('#StudentLoginEmail').val();
    let stuLoginPass = $('#StudentLoginPassword').val();

    $.ajax({
        url: "Student/Authentication.php",
        method: "POST",
        data: {
            checkLogin: "checkLogin",
            stuLoginEmail: stuLoginEmail,
            stuLoginPass: stuLoginPass
        },
        success: function (response) {
            console.log("Row", response);

            if (response == 1) {
                // Show success message
                $("#StudentLoginFailedMsg").text("").fadeIn();

                // Improved loading screen
                $("body").append(`
                    <div id="loading-screen" class="loading-overlay d-flex flex-column align-items-center justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Logging in... Please wait</p>
                    </div>
                `);

                setTimeout(function () {
                    $("#loading-screen").fadeOut("slow", function () {
                        // window.location.href = "index.php"; // Redirect to index page
                        location.reload();
                    });
                }, 1000);
            } else {
                $("#StudentLoginFailedMsg").text("Invalid Credentials").fadeIn();
            }
        }
    });
});


// ---------------------------------End Student Login Code--------------------------------


// ------x----------------x--------------------x--------------------x-------------------x------------------

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var img = document.getElementById("preview");
        img.src = reader.result;
        img.style.display = "block";
    }
    reader.readAsDataURL(event.target.files[0]);
}

// ---------------------SEARCH BAR-------------------------
// document.addEventListener('DOMContentLoaded', function () {
const searchInput = document.getElementById('searchInput');
const courseItems = document.querySelectorAll('.course-item');

searchInput.addEventListener('input', function () {
    const searchTerm = searchInput.value.toLowerCase();
    courseItems.forEach(item => {
        const title = item.getAttribute('data-title');
        if (title.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
// });
// ---------------------SEARCH BAR-------------------------


// ---------------------Student Forgot Password-------------------------





// ---------------------Student Forgot Password-------------------------