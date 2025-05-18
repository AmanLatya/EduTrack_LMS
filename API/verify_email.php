<?php

session_start();
include('../ConnectDataBase.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['otp']) || empty($_POST['otp'])) {
        echo json_encode(['success' => false, 'message' => 'OTP is required.']);
        exit;
    }

    if (!isset($_SESSION['otp']) || !isset($_SESSION['signup_data'])) {
        echo json_encode(['success' => false, 'message' => 'Session expired. Please try again.']);
        exit;
    }

    $userOtp = trim($_POST['otp']); // Remove any accidental whitespace
    $sessionOtp = $_SESSION['otp']; // Stored OTP from session

    if ($userOtp == $sessionOtp) {
        $data = $_SESSION['signup_data'];

        // Prepare the INSERT statement securely
        $stmt = $connection->prepare("INSERT INTO student (Stu_Name, Stu_Email, Alter_Email, Stu_Pass) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
            exit;
        }
        $stmt->bind_param("ssss", $data['name'], $data['email'], $data['guardianEmail'], $data['password']);

        if ($stmt->execute()) {
            // Secure DELETE statement using prepared statements
            $deleteStmt = $connection->prepare("DELETE FROM pending_students WHERE email = ?");
            $deleteStmt->bind_param("s", $data['email']);
            $deleteStmt->execute();

            // Unset OTP session data after successful registration
            unset($_SESSION['otp'], $_SESSION['signup_data']);

            // Set session variables for logged-in user
            $_SESSION['is_stuLogin'] = true;
            $_SESSION['stuLoginEmail'] = $data['email'];

            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to register user. Try again later.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP. Please try again.']);
        exit;
    }
}
?>