<?php
include '../ConnectDataBase.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $query = "SELECT p.*, s.Stu_Name, c.course_name 
              FROM payments p 
              JOIN student s ON p.student_id = s.Stu_ID 
              JOIN courses c ON p.course_id = c.course_id 
              WHERE p.order_id = ?";
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payment = $result->fetch_assoc();

    if (!$payment) {
        echo "Payment record not found!";
        exit;
    }

    $stmt->close();
} else {
    echo "No order ID provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment Success</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom Styles -->
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .success-container {
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .success-icon {
      font-size: 50px;
      color: #28a745;
      margin-bottom: 20px;
    }
    .btn-primary {
      border-radius: 50px;
      padding: 10px 30px;
      font-weight: bold;
    }
    .info-row {
      text-align: left;
      margin-bottom: 15px;
    }
    .info-label {
      font-weight: 600;
      color: #555;
    }
    .info-value {
      color: #333;
    }
  </style>
</head>
<body>

  <div class="success-container">
    <div class="success-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    <h2 class="mb-4 text-success">Payment Successful</h2>

    <div class="info-row"><span class="info-label">Student Name:</span> <span class="info-value"><?php echo htmlspecialchars($payment['Stu_Name']); ?></span></div>
    <div class="info-row"><span class="info-label">Course Name:</span> <span class="info-value"><?php echo htmlspecialchars($payment['course_name']); ?></span></div>
    <div class="info-row"><span class="info-label">Order ID:</span> <span class="info-value"><?php echo htmlspecialchars($payment['order_id']); ?></span></div>
    <div class="info-row"><span class="info-label">Amount Paid:</span> <span class="info-value">₹<?php echo htmlspecialchars($payment['amount']); ?></span></div>
    <div class="info-row"><span class="info-label">Purchase Time:</span> <span class="info-value"><?php echo htmlspecialchars($payment['purchase_time']); ?></span></div>

    <a href="../Student/MyCourses.php" class="btn btn-primary mt-4">
      <i class="fas fa-arrow-right me-2"></i> Go to My Courses
    </a>
  </div>

</body>
</html>
