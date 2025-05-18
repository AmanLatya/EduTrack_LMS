<?php
include '../ConnectDataBase.php';

if (isset($_POST['student_id'], $_POST['course_id'], $_POST['rpay_order_id'], $_POST['payAmount'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $order_id = $_POST['rpay_order_id'];
    $amount = $_POST['payAmount'];

    $stmt = $connection->prepare("INSERT INTO payments (student_id, course_id, order_id, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisd", $student_id, $course_id, $order_id, $amount);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
