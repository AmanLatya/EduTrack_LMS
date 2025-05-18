<?php
include_once('../ConnectDataBase.php');

$sql = "SELECT * FROM admin WHERE Admin_Email = '{$_SESSION['AdminLoginEmail']}'";
$result = $connection->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $adminName = $row['Admin_Name'];
    $adminEmail = $row['Admin_Email'];
}
?>