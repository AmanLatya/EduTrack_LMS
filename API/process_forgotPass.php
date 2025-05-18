<?php
session_start();
include_once '../ConnectDataBase.php';
require "C:/xampp/htdocs/EduTrack/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // if ($email == $_SESSION['stuLoginEmail']) {
    // For Student forgot password
    $stuQuery = $connection->prepare("SELECT Stu_Email FROM student WHERE Stu_Email = ?");
    $stuQuery->bind_param("s", $email);
    $stuQuery->execute();
    $stuQuery->store_result();

    // For Admin forgot password
    $adminQuery = $connection->prepare("SELECT Admin_Email FROM admin WHERE Admin_Email = ?");
    $adminQuery->bind_param("s", $email);
    $adminQuery->execute();
    $adminQuery->store_result();

    if ($stuQuery->num_rows > 0 || $adminQuery->num_rows > 0) {
        $otp = rand(100000, 999999);
        $_SESSION['forgotPass_otp'] = $otp;
        $_SESSION['forgotPass_Email'] = $email;

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
            $mail->Body = "This mail is for changing your password. Your OTP Code is: <b style='background-color:rgb(99, 99, 99); padding: 5px;'>$otp</b>";


            $mail->send();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'OTP could not be sent.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Mail Not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Mail Not found.']);
}
// }
