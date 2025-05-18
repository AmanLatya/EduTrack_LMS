<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once '../ConnectDataBase.php';

if (!isset($_SESSION['is_InstructorLogin'])) {
    if (isset($_POST['checkInstructorLogin']) && isset($_POST['InstructorPassKey']) && isset($_POST['InstructorPassword'])) {
        $InstructorPassKey = $_POST['InstructorPassKey'];
        $InstructorPassword = $_POST['InstructorPassword'];

        $sql = "SELECT Inst_PassKey, Inst_Pass FROM instructor WHERE Inst_PassKey = '" . $InstructorPassKey . "' and Inst_Pass = '" . $InstructorPassword . "'";

        $result = $connection->query($sql);
        if ($result) {
            $row = $result->num_rows;
            echo $row;
            if ($row == 1) {
                $_SESSION['is_InstructorLogin'] = true;
                $_SESSION['InstructorPassKey'] = $InstructorPassKey;
            }
        } else {
            echo "Invalid Email";
        }
    }
} else {
    echo "Already LoggedIn";
}
