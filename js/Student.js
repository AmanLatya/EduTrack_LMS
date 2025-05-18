<script>
    $(document).ready(function () {
        $('#forgotPassForm').submit(function (e) {
            e.preventDefault();

            $("#getOtpButton").prop("disabled", true).text("OTP Sending...");
            $("#Loader").show();

            let formData = {
                email: $('#forgotEmail').val(),
            };
            $.post('../API/process_forgotPass.php', formData, function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        window.location.href = '../API/verify_forgotPass_otp.php?email=' + formData.email;
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
            }).fail(function () {
                alert("Error occurred. Please try again.");
                $("#getOtpButton").prop("disabled", false).text("OTP Sent");
                $("#Loader").hide();
            });
        })
    })
</script>