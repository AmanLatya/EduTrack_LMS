<?php
session_start();
include_once '../ConnectDataBase.php';
require "C:/xampp/htdocs/EduTrack/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $guardianEmail = $_POST['guardianEmail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32));

    $stmt = $connection->prepare("SELECT Stu_Email FROM student WHERE Stu_Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
    } else {
        $stmt = $connection->prepare("INSERT INTO pending_students (name, email, guardian_email, password, verification_token) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $guardianEmail, $password, $token);

        if ($stmt->execute()) {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['signup_data'] = compact('name', 'email', 'guardianEmail', 'password');

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'amanlatya832@gmail.com';
                $mail->Password = 'xwwi tukx okhu hvkx'; // App password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('amanlatya832@gmail.com', 'EduTrack');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP Code is: <b>$otp</b>";

                $mail->send();
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'OTP could not be sent.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Could not insert pending signup.']);
        }
    }
}
?>
