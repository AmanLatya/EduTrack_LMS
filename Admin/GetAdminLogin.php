<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once '../ConnectDataBase.php';

if (!isset($_SESSION['is_AdminLogin'])) {
    if (isset($_POST['checkAdminLogin']) && isset($_POST['AdminLoginEmail']) && isset($_POST['AdminPassword'])) {
        $AdminLoginEmail = $_POST['AdminLoginEmail'];
        $AdminPassword = $_POST['AdminPassword'];

        $sql = "SELECT Admin_Email, Admin_Pass FROM admin WHERE Admin_Email = '" . $AdminLoginEmail . "' and Admin_Pass = '" . $AdminPassword . "'";

        $result = $connection->query($sql);
        if ($result) {
            $row = $result->num_rows;
            echo $row;
            if ($row == 1) {
                $_SESSION['is_AdminLogin'] = true;
                $_SESSION['AdminLoginEmail'] = $AdminLoginEmail;
            }
        } else {
            echo "Invalid Email";
        }
    }
} else {
    echo "Already LoggedIn";
}
