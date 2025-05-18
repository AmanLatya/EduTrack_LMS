<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,PUT,PATCH,DELETE');
header("Content-Type: application/json");
header("Accept: application/json");
header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Access-Control-Allow-Methods,Content-Type');

include '../ConnectDataBase.php';

if (isset($_POST['action']) && $_POST['action'] == 'payOrder') {
    $razorpay_mode = 'test';
    $razorpay_test_key = 'rzp_test_BtfSVspdJewRgL';
    $razorpay_test_secret_key = 'qvjpPATU0kvkb4lPiLP1Co5D';

    $razorpay_key = $razorpay_test_key;
    $authAPIkey = "Basic " . base64_encode($razorpay_test_key . ":" . $razorpay_test_secret_key);

    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $billing_name = $_POST['billing_name'];
    $billing_mobile = $_POST['billing_mobile'];
    $billing_email = $_POST['billing_email'];
    $payAmount = $_POST['payAmount'];

    $postdata = array(
        "amount" => $payAmount * 100,
        "currency" => "INR",
        "receipt" => "Payment of Rs. " . $payAmount,
        "notes" => array(
            "notes_key_1" => "Payment of Rs. " . $payAmount,
            "notes_key_2" => "EDUTRACK",
            "student_id" => $student_id,
            "course_id" => $course_id
        )
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postdata),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: ' . $authAPIkey
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $orderRes = json_decode($response);

    if (isset($orderRes->id)) {
        echo json_encode([
            'res' => 'success',
            'rpay_order_id' => $orderRes->id,
            'razorpay_key' => $razorpay_key,
            'amount' => $payAmount,
            'name' => $billing_name,
            'email' => $billing_email,
            'mobile' => $billing_mobile,
            'student_id' => $student_id,
            'course_id' => $course_id
        ]);
    } else {
        echo json_encode(['res' => 'error', 'info' => 'Unable to create Razorpay order']);
    }
}
?>
