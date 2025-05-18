<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('../ConnectDataBase.php');
include('../layout/htmlHeadLinks.php');

if (isset($_SESSION['is_stuLogin']) && isset($_SESSION['stuLoginEmail'])) {
    $sql = "SELECT * FROM student WHERE Stu_Email = '{$_SESSION['stuLoginEmail']}'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Stu_Name'];
        $id = $row['Stu_id'];
        $image = $row['Stu_Profile'];
        $proffesion = $row['Stu_Proffesion'];
        $email = $row['Stu_Email'];
        $phone = $row['Stu_Phone'];
        $address = $row['Stu_Address'];
        $password = $row['Stu_Pass'];
    }
}
else {
    echo "<script> location.href='../'; </script>";
}
?>
