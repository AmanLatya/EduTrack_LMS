<?php session_start();
include('../ConnectDataBase.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_POST['otp']) || empty($_POST['otp'])) {
        echo json_encode(['success' => false, 'message' => 'OTP is required.']);
        exit;
    }

    if (!isset($_SESSION['forgotPass_otp']) || !isset($_SESSION['forgotPass_Email'])) {
        echo json_encode(['success' => false, 'message' => 'Session expired. Please try again.']);
        exit;
    }
    $userOtp = trim($_POST['otp']);
    $sessionOtp = $_SESSION['forgotPass_otp'];

    if ($userOtp == $sessionOtp) {
        // Unset OTP session data after successful registration
        unset($_SESSION['forgotPass_otp']);

        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP. Try again later.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP. Please try again.']);
    exit;
}
