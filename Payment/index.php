<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>

    <?php
    include '../Student/StudentData.php';
    if (isset($_GET['orderCourse_id']) && isset($_GET['StuEmail'])) {
        $stu_id = $id;
        $course_id = $_GET['orderCourse_id'];
        $StuEmail = $_GET['StuEmail'];


        // check data is present or not in payments table same student can't buy the same course
        $paymentSql = "SELECT * FROM payments WHERE course_id = $course_id AND student_id = $stu_id";
        $paymentResult = $connection->query($paymentSql);
        if ($paymentResult->num_rows > 0) {
    ?>
            <div class="container my-auto">
                <h1>You Already Enrolled!</h1>
                <h5><a href="../Student/EnrolledCourse.php">Go to My Courses</a></h5>
            </div>
        <?php
            exit();
        }
        ?>
    <?php
        // Fetch student details
        $stuSql = "SELECT * FROM student WHERE Stu_Email = '$StuEmail'";
        $stuResult = $connection->query($stuSql);
        $student = $stuResult->fetch_assoc();

        // Fetch course details
        $sql = "SELECT * FROM courses WHERE course_id = '$course_id'";
        $result = $connection->query($sql);
        $course = $result->fetch_assoc();
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="panel">
                    <div class="panel-heading">
                        Course : <?php echo $course['course_id']; ?>
                        Student : <?php echo $student['Stu_id']; ?>
                        <h1 class="fw-bold text-center">EDUTRACK - Course: <h3><?php echo $course['course_name']; ?></h3>
                        </h1>
                    </div>
                    <div class="panel-body">
                        <form id="paymentForm">
                            <input type="hidden" id="student_id" value="<?php echo $student['Stu_id']; ?>">
                            <input type="hidden" id="course_id" value="<?php echo $course['course_id']; ?>">
                            <input type="hidden" id="billing_name" value="<?php echo $student['Stu_Name']; ?>">
                            <input type="hidden" id="billing_email" value="<?php echo $student['Stu_Email']; ?>">
                            <input type="hidden" id="billing_mobile" value="<?php echo $student['Stu_Phone']; ?>">
                            <input type="hidden" id="payAmount" value="<?php echo $course['course_price']; ?>">
                            <button id="PayNow" class="btn btn-success btn-lg btn-block">Submit & Pay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/payment.js"></script>
</body>

</html>