window.onload = function () {
    if (!window.location.hash.includes("#reloaded")) {
        window.location = window.location + "#reloaded";
        window.location.reload();
    }
};

// ---------------------------------Start Admin Login Code--------------------------------
$('#AdminLoginBtn').click(function () {
    // Get email and password values from the form
    let AdminLoginEmail = $('#AdminLoginEmail').val();
    let AdminPassword = $('#AdminPassword').val();

    let AdminLoginFailedMsg = $('#AdminLoginFailedMsg');
    let AdminLoginSuccessMsg = $('#AdminLoginSuccessMsg');

    $.ajax({
        url: 'Admin/GetAdminLogin.php',
        method: "POST",
        data: {
            checkAdminLogin: "checkAdminLogin",
            AdminLoginEmail: AdminLoginEmail,
            AdminPassword: AdminPassword,
        },

        success: function (response) {
            // console.log("row", response);
            if (response == 1) {
                AdminLoginSuccessMsg.text("Login Success").fadeIn();
                // Append loading screen to body
                $("body").append(`
                        <div id="loading-screen" class="loading-overlay">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Redirecting...</p>
                        </div>
                    `);

                // Wait for 2 seconds before redirecting
                setTimeout(function () {
                    // Hide the loading screen and redirect to the dashboard
                    $("#loading-screen").fadeOut("slow", function () {
                        window.location.href = "./Admin";
                    });
                }, 1200);
            }
            else {
                AdminLoginFailedMsg.text("Invalid Email or Password").fadeIn();
            }
        }
    })

});

// ---------------------------------Start Admin Login Code--------------------------------

// ---------------------------------Start Instructor Login Code--------------------------------
$('#InstructorLoginBtn').click(function () {
    // Get email and password values from the form
    let InstructorPassKey = $('#InstructorPassKey').val();
    let InstructorPassword = $('#InstructorPassword').val();

    let InstructorLoginFailedMsg = $('#InstructorLoginFailedMsg');
    let InstructorLoginSuccessMsg = $('#InstructorLoginSuccessMsg');

    $.ajax({
        url: 'Instructor/GetInstructorLogin.php',
        method: "POST",
        data: {
            checkInstructorLogin: "checkInstructorLogin",
            InstructorPassKey: InstructorPassKey,
            InstructorPassword: InstructorPassword,
        },

        success: function (response) {
            // console.log("row", response);
            if (response == 1) {
                console.log("Login Success");
                InstructorLoginSuccessMsg.text("Login Success").fadeIn();
                // Append loading screen to body
                $("body").append(`
                        <div id="loading-screen" class="loading-overlay">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Redirecting...</p>
                        </div>
                    `);

                // Wait for 2 seconds before redirecting
                setTimeout(function () {
                    // Hide the loading screen and redirect to the dashboard
                    $("#loading-screen").fadeOut("slow", function () {
                        window.location.href = "./Instructor/index.php";
                    });
                }, 1200);
            }
            else {
                InstructorLoginFailedMsg.text("Invalid Passkey or Password").fadeIn();
            }
        }
    })

});

// ---------------------------------Start Instructor Login Code--------------------------------


// -----------------x---------------------x-------------------x---------------------x----------------------x---------------------


// ---------------------------------Start Add Course Code--------------------------------

// $('#add-course').click(function () {
//     let courseName = $('#courseName');
//     let courseDescription = $('#courseDescription');
//     let author = $('#author');
//     let courseDuration = $('#courseDuration');
//     let originalPrice = $('#originalPrice');
//     let sellingprice = $('#sellingprice');
//     let courseImage = $('#courseImage');


//     let courseNameMsg = $('#courseNameMsg');
//     let courseDescMsg = $('#courseDescMsg');
//     let courseAuthorMsg = $('#courseAuthorMsg');
//     let courseDurationMsg = $('#courseDurationMsg');
//     let courseOriginalPriceMsg = $('#courseOriginalPriceMsg');
//     let courseSellingPriceMsg = $('#courseSellingPriceMsg');
//     let courseImageMsg = $('#courseImageMsg');

//     // Function to hide error messages when input is filled
//     function hideErrorOnInput(inputField, errorMsg) {
//         inputField.on("input", function () {
//             if (inputField.val().trim() !== "") {
//                 errorMsg.hide();
//             }
//         });
//     }

//     // Apply function to all input fields
//     hideErrorOnInput(courseName, courseNameMsg);
//     hideErrorOnInput(courseDescription, courseDescMsg);
//     hideErrorOnInput(author, courseAuthorMsg);
//     hideErrorOnInput(courseDuration, courseDurationMsg);
//     hideErrorOnInput(originalPrice, courseOriginalPriceMsg);
//     hideErrorOnInput(sellingprice, courseSellingPriceMsg);
//     hideErrorOnInput(courseImage, courseImageMsg);


//     // Validate all fields
//     if (!courseName.val().trim()) {
//         courseNameMsg.text('Please Enter Name!').show();
//         courseName.focus();
//         return false;
//     } else if (!courseDescription.val().trim()) {
//         courseDescMsg.text('Please Enter Email!').show();
//         courseDescription.focus();
//         return false;
//     } else if (!author.val().trim()) {
//         courseAuthorMsg.text('Please Enter Gaurdian Email!').show();
//         author.focus();
//         return false;
//     } else if (!courseDuration.val().trim()) {
//         courseDurationMsg.text('Password Can\'t be empty!').show();
//         courseDuration.focus();
//         return false;
//     } else if (!originalPrice.val().trim()) {
//         courseOriginalPriceMsg.text('Confirm Password Can\'t be empty!').show();
//         originalPrice.focus();
//         return false;
//     } else if (!sellingprice.val().trim()) {
//         courseSellingPriceMsg.text('Confirm Password Can\'t be empty!').show();
//         sellingprice.focus();
//         return false;
//     } else if (!courseImage.val().trim()) {
//         courseImageMsg.text('Confirm Password Can\'t be empty!').show();
//         courseImage.focus();
//         return false;
//     }

//     else{
//         $.ajax({
//             url: 'PostData/addCourse.php',
//             method: 'POST',
//             data:{
//                 addCourse: "addCourse",
//                 courseName: courseName.val(),
//                 courseDescription: courseDescription.val(),
//                 author: author.val(),
//                 courseDuration: courseDuration.val(),
//                 originalPrice: originalPrice.val(),
//                 sellingprice: sellingprice.val(),
//                 courseImage: courseImage.val(),
//             },
//             success :function(response){
//                 console.log("response" ,response);
//             }
//         })
//     }

// })

// ---------------------------------End Add Course Code--------------------------------





// -------------X-------------------------X----------------------X-------------------------X--------------------------X-----




// ---------------------------------------START STUDENT MANAGEMENT---------------------------------
// This is the code for delete student data from the student table with the help of Student.php file
$(".deleteStudent").on("click", function () {
    alert("Are you sure?");
    let StuId = $(this).data("id");

    if (confirm("Are you taking responsibility for this deletion process of the student data?")) {
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: { Stu_id: StuId },
            dataType: "json",
            success: function (data) {
                if (data) {
                    $("#studentRow_" + StuId).remove();
                    setTimeout(function () {
                        location.reload(); // Reload the page after 2 seconds
                    }, 800);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
});


// ---------------------------------------END STUDENT MANAGEMENT---------------------------------


// -------------X-------------------------X----------------------X-------------------------X--------------------------X-----
// ---------------------------------------START COURSE MANAGEMENT---------------------------------
// This is the code for delete course data from the course table with the help of Courses.php file
$(".deleteCourse").on("click", function () {
    alert("Are You sure ?");
    let CourseId = $(this).data("id");
    if (confirm("Are you take the responsiblity for this deletion process of the Course Data ?")) {
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: { course_id: CourseId },
            dataType: "json",
            success: function (data) {
                if (data) {
                    $("#courseRow_" + CourseId).remove();
                    $("#lessonRow_" + CourseId).remove();
                    setTimeout(function () {
                        location.reload(); // Reload the page after 2 seconds
                    }, 800);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
});

// ---------------------------------------END COURSE MANAGEMENT---------------------------------

// -------------X-------------------------X----------------------X-------------------------X--------------------------X-----

// ---------------------------------------START LESSON MANAGEMENT---------------------------------
// This is the code for delete lesson from the lesson table with the help of lesson.php file
$(document).ready(function () {
    $(".deleteLesson").on("click", function () {
        alert("Are You sure ?");
        let ass_num = $(this).data("id");
        if (confirm("Are you sure you want to delete this lesson?")) {
            $.ajax({
                url: "delete.php",
                type: "POST",
                data: { l_id: ass_num },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        $("#lessonRow_" + ass_num).remove();
                    } else {
                        alert("Error: " + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }
    });
});

// ---------------------------------------END LESSON MANAGEMENT---------------------------------


// -------------X-------------------------X----------------------X-------------------------X--------------------------X-----


// ---------------------------------------START ASSIGNMENT MANAGEMENT---------------------------------
// This is the code for delete lesson from the ASSIGNMENT table with the help of Assignment.php file
$(document).ready(function () {
    $(".deleteAssignment").on("click", function () {
        let ass_num = $(this).data("id");
        if (confirm("Are you sure you want to delete this ASSIGNMENT?")) {
            $.ajax({
                url: "delete.php",
                type: "POST",
                data: { ass_num: ass_num },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        alert(data.message); // ✅ FIXED
                        $("#assignmentRow_" + ass_num).remove();
                    } else {
                        alert("Error: " + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("AJAX request failed.");
                }
            });
        }
    });
});



// Upload Current date and time
document.addEventListener("DOMContentLoaded", function () {
    let now = new Date();

    // Get local date and time in YYYY-MM-DDTHH:MM format
    let year = now.getFullYear();
    let month = String(now.getMonth() + 1).padStart(2, '0'); // Add leading zero if needed
    let day = String(now.getDate()).padStart(2, '0');
    let hours = String(now.getHours()).padStart(2, '0');
    let minutes = String(now.getMinutes()).padStart(2, '0');

    let formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById("uploadDateTime").value = formattedDateTime;
});



// Upload file via drag and drop option
document.addEventListener("DOMContentLoaded", function () {
    const dropZone = document.getElementById("dropZone");
    const fileInput = document.getElementById("pdfInput");
    const fileInfo = document.getElementById("fileInfo");
    const fileError = document.getElementById("fileError");

    // Click event to open file dialog
    dropZone.addEventListener("click", () => fileInput.click());

    // Drag over event
    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZone.classList.add("bg-light");
    });

    // Drag leave event
    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("bg-light");
    });

    // Drop event
    dropZone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropZone.classList.remove("bg-light");

        let file = e.dataTransfer.files[0];
        handleFile(file);
    });

    // File input change event
    fileInput.addEventListener("change", (e) => {
        let file = e.target.files[0];
        handleFile(file);
    });

    function handleFile(file) {
        fileError.innerHTML = "";
        fileInfo.innerHTML = "";

        if (!file) return;

        // Validate file type
        if (file.type !== "application/pdf") {
            fileError.innerHTML = "❌ Only PDF files are allowed!";
            fileInput.value = "";
            return;
        }

        // Validate file size (1MB = 1048576 bytes)
        if (file.size > 1048576) {
            fileError.innerHTML = "❌ File size must be less than 1MB!";
            fileInput.value = "";
            return;
        }

        fileInfo.innerHTML = `✅ Selected file: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
    }
});
// ---------------------------------------END ASSIGNMENT MANAGEMENT---------------------------------
// -------------X-------------------------X----------------------X-------------------------X--------------------------X-----


// ---------------------------------------START APPLY OFFER---------------------------------
// 
// ----------------------Offer To All------------

$('#ApplyOfferAtAllForm').submit(function (e) {
    e.preventDefault(); // Prevent default form submission
    let Offer = $('#OfferValue').val().trim();

    if (Offer === "" || isNaN(Offer) || Offer < 0) {
        alert("Please enter a valid offer percentage.");
        return;
    }

    if (confirm(`Are you sure you want to apply a ${Offer}% discount to all courses?`)) {
        $.ajax({
            url: "GetOffer.php",
            type: "POST",
            data: { Offer: Offer },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Refresh the course list
                } else {
                    alert("Error: " + data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong while applying the offer.");
            }
        });
    }
});

// ----------------------Offer To All------------

// ----------------------Offer To One------------

$('#ApplyOfferAtOneForm').submit(function (e) {
    e.preventDefault(); // Prevent default form submission
    let Offer = $('#OfferValue').val().trim();
    let course_id = $('#course_id').val().trim();

    if (Offer === "" || isNaN(Offer) || Offer < 0 || course_id === "") {
        alert("Please enter a valid offer percentage and select a course.");
        return;
    }

    if (confirm(`Are you sure you want to apply a ${Offer}% discount to this course?`)) {
        $.ajax({
            url: "GetOffer.php",
            type: "POST",
            data: {
                Offer: Offer,
                course_id: course_id
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Refresh the course list
                } else {
                    alert("Error: " + data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong while applying the offer.");
            }
        });
    }
});

// ----------------------Offer To One------------


// ---------------------------------------END APPLY OFFER---------------------------------
// 