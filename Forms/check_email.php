<?php
include_once '../ConnectDataBase.php';

if (isset($_POST['stuEmail'])) {
    $email = $_POST['stuEmail'];

    $stmt = $connection->prepare("SELECT Stu_Email FROM student WHERE Stu_Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    echo ($stmt->num_rows > 0) ? "1" : "0";
    $stmt->close();
}
?>
