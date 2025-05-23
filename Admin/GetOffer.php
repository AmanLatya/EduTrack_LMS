<?php
include '../ConnectDataBase.php';
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Offer"])) {
        $Offer = (float)$_POST["Offer"];

        if (isset($_POST['course_id'])) {
            // Apply offer to a specific course
            $course_id = (int)$_POST["course_id"];
            $sql = "UPDATE courses 
                    SET course_price = course_original_price - (course_original_price * ? / 100) 
                    WHERE course_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("di", $Offer, $course_id);
        } else {
            // Apply offer to all courses
            $sql = "UPDATE courses 
                    SET course_price = course_original_price - (course_original_price * ? / 100)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("d", $Offer);
        }

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = isset($course_id)
                ? "✅ {$Offer}% discount applied to course ID {$course_id}."
                : "✅ {$Offer}% discount applied to all courses.";
        } else {
            $response["message"] = "❌ Database error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response["message"] = "❌ 'Offer' value is missing.";
    }
} else {
    $response["message"] = "❌ Invalid request method.";
}

echo json_encode($response);
?>
