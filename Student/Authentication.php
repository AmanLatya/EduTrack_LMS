<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once('../ConnectDataBase.php');

// if (!isset($_SESSION['is_stuLogin'])) {
//     echo "<script> location.href='../'; </script>";
// }


// ------------------------------Student Login------------------------------

if (!isset($_SESSION['is_stuLogin'])) {
    if (isset($_POST['checkLogin']) && isset($_POST['stuLoginEmail']) && isset($_POST['stuLoginPass'])) {
        $stuLoginEmail = $_POST['stuLoginEmail'];
        $stuLoginPass = $_POST['stuLoginPass'];

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT Stu_Email, Stu_Pass FROM Student WHERE Stu_Email = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $stuLoginEmail); // "s" indicates a string parameter
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows != 0) {
                $row = $result->fetch_assoc();
                $hashedPasswordFromDB = $row['Stu_Pass'];

                // Verify the password using password_verify()
                if (password_verify($stuLoginPass, $hashedPasswordFromDB)) {
                    $_SESSION['is_stuLogin'] = true;
                    $_SESSION['stuLoginEmail'] = $stuLoginEmail;
                    echo 1; // Indicate successful login
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }

            $stmt->close();
        } else {
            echo "Prepared statement failed: " . $connection->error;
            error_log("Prepared statement error: " . $connection->error);
        }
    } else {
        echo "Missing login credentials";
    }
} else {
    echo "Already Logged In";
}
