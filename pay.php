<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'includes/config.php';

$booking_id = $_GET['booking_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Car Rental - Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/responsive.css">
  <script src="js/jquery.js"></script>
  <script src="js/main.js"></script>
</head>
<body>

<?php include 'header.php'; ?>

<section class="caption">
  <h2 class="caption" style="text-align: center">Find Your Dream Cars For Hire</h2>
  <h3 class="properties" style="text-align: center">Range Rovers - Mercedes Benz - Landcruisers</h3>
</section>

<section class="listings">
  <div class="wrapper">
    <div style="width: 600px; margin: 0 auto; font-family: Arial;">
      <h3 style="text-decoration: underline;">Make Payment via Online Banking (FPX)</h3>
      <p>Please use any Malaysian online banking and transfer to:</p>
      <p><strong>Bank:</strong> Maybank</p>
      <p><strong>Account Name:</strong> RNR Drive</p>
      <p><strong>Account Number:</strong> 512345678901</p>
      <p><strong>Reference:</strong> Use your Booking ID (e.g. RC2025-001)</p>
      <p><strong>Amount:</strong> Based on selected car</p>

      <hr>
      <p><strong>After completing the transfer, submit your transaction ID below:</strong></p>

      <form method="post" enctype="multipart/form-data">
        <table style="width: 100%;">
          <tr>
            <td>Booking ID:</td>
            <td><input type="text" name="booking_id" value="<?php echo $booking_id; ?>" readonly style="width: 100%; padding: 6px;"></td>
          </tr>
          <tr>
            <td>Transaction ID:</td>
            <td><input type="text" name="trx_id" required style="width: 100%; padding: 6px;"></td>
          </tr>
          <tr>
            <td>Upload Proof:</td>
            <td><input type="file" name="proof" accept="image/*" required style="width: 100%; padding: 6px;"></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: right;">
              <input type="submit" name="pay" value="Submit Payment" style="padding: 8px 20px;">
            </td>
          </tr>
        </table>
      </form>

<?php
if (isset($_POST['pay'])) {
  $booking_id = $_POST['booking_id'];
  $trx_id     = $_POST['trx_id'];

  $upload_dir = 'uploads/';
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
  }

  $proof_name = basename($_FILES['proof']['name']);
  $proof_tmp  = $_FILES['proof']['tmp_name'];
  $proof_path = $upload_dir . time() . '_' . $proof_name;

  if (move_uploaded_file($proof_tmp, $proof_path)) {
    // 1. 更新 client 表
    $qry = "UPDATE client 
            SET transaction_id = '$trx_id',
                status = 'Paid',
                proof_image = '$proof_path'
            WHERE booking_id = '$booking_id'";

    if ($conn->query($qry) && $conn->affected_rows > 0) {
      // 2. 查询 client_id 和 car_id
      $clientQry = "SELECT client_id, car_id FROM client WHERE booking_id = '$booking_id'";
      $res = $conn->query($clientQry);
      if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $client_id = $row['client_id'];
        $car_id = $row['car_id'];

        // 3. 插入 hire 表
        $insertHire = "INSERT INTO hire (client_id, car_id, status) 
                       VALUES ('$client_id', '$car_id', 'Pending')";
        $conn->query($insertHire);
      }

      echo "<script>alert('✅ Payment submitted successfully! Wait for admin approval.'); window.location='wait.php';</script>";
    } else {
      echo "<script>alert('❌ Booking ID not found or payment already submitted.');</script>";
    }
  } else {
    echo "<script>alert('❌ Failed to upload payment screenshot.');</script>";
  }
}
?>

    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
