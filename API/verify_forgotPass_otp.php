<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Forgot Password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter OTP</h2>
        <form id="otpForm">
            <input type="text" id="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
            <p id="errorMsg" class="error"></p>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#otpForm').submit(function(e) {
                e.preventDefault();
                let otpValue = $('#otp').val().trim();

                if (otpValue === "") {
                    $('#errorMsg').text("Please enter OTP.");
                    return;
                }

                $.ajax({
                    url: './verify_forgotPass_email.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { otp: otpValue },
                    success: function(response) {
                        if (response.success) {
                            alert("OTP Verified Successfully!");
                            window.location.href = '../Student/forgotPass.php';
                        } else {
                            $('#errorMsg').text(response.message);
                        }
                    },
                    error: function() {
                        $('#errorMsg').text("An error occurred. Please try again.");
                    }
                });
            });
        });
    </script>
</body>
</html>

