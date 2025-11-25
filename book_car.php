<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book Car | RNR Drive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/responsive.css">
  <script src="js/jquery.js"></script>
  <script src="js/main.js"></script>
</head>

<body>

<?php include 'header.php'; ?>

<section class="caption">
  <h2 class="caption" style="text-align: center">Find Your Dream Car For Hire</h2>
  <h3 class="properties" style="text-align: center">Drive Bold. Drive RNR.</h3>
</section>

<section class="search" style="background: #cde1f0; padding: 30px 0;">
  <div class="wrapper">
    <?php
      include 'includes/config.php';
      $car_id = $_GET['id'];
      $sel = "SELECT * FROM cars WHERE car_id = '$car_id'";
      $rs = $conn->query($sel);
      $rws = $rs->fetch_assoc();
    ?>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
      <h2 style="text-align:center; color: #333;">Proceed to Hire <strong><?php echo $rws['car_name']; ?></strong></h2>
      <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; align-items: center; justify-content: center;">
        <img src="cars/<?php echo $rws['image']; ?>" alt="Car" style="max-width: 300px; height: auto; border-radius: 6px;">
        <div>
          <p><strong>Make:</strong> <?php echo $rws['car_type']; ?></p>
          <p><strong>Model:</strong> <?php echo $rws['car_name']; ?></p>
          <p><strong>Price:</strong> RM<?php echo $rws['hire_cost']; ?></p>
        </div>
      </div>

      <hr style="margin: 30px 0;">

      <?php if (!isset($_SESSION['email'])) { ?>
        <form method="post">
          <h3 style="text-align:center; margin-bottom:15px;">Fill in your details to proceed</h3>
          <table align="center">
            <tr><td>Full Name:</td><td><input type="text" name="fname" required></td></tr>
            <tr><td>Phone Number:</td><td><input type="text" name="phone" required></td></tr>
            <tr><td>Email:</td><td><input type="email" name="email" required></td></tr>
            <tr><td>ID Number:</td><td><input type="text" name="id_no" required></td></tr>
            <tr><td>Gender:</td><td>
              <select name="gender">
                <option> Select Gender </option>
                <option> Male </option>
                <option> Female </option>
              </select></td></tr>
            <tr><td>Location:</td><td><input type="text" name="location" required></td></tr>
            <tr><td colspan="2" style="text-align:right"><input type="submit" name="save" value="Submit Details"></td></tr>
          </table>
        </form>
      <?php } else { ?>
        <form method="post" style="text-align:center; margin-top:20px;">
          <input type="submit" name="hire_now" value="Click to Book" class="btn btn-primary">
        </form>
      <?php } ?>

      <?php
      if (isset($_POST['save'])) {
        $fname = $_POST['fname'];
        $id_no = $_POST['id_no'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];
        $year = date("Y");
        $random = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $booking_id = "RC" . $year . "-" . $random;

        $qry = "INSERT INTO client (booking_id, fname, id_no, gender, email, phone, location, car_id, status)
                VALUES ('$booking_id', '$fname', '$id_no', '$gender', '$email', '$phone', '$location', '$car_id', 'Pending')";
        if ($conn->query($qry) === TRUE) {
          echo "<script>alert('Booking successful! Your Booking ID is $booking_id'); window.location='pay.php?booking_id=$booking_id';</script>";
        } else {
          echo "<script>alert('Booking failed. Try again.');</script>";
        }
      }

      if (isset($_POST['hire_now'])) {
        $email = $_SESSION['email'];
        $get_client = "SELECT client_id, booking_id FROM client WHERE email = '$email' ORDER BY client_id DESC LIMIT 1";
        $res = $conn->query($get_client);
        if ($res->num_rows > 0) {
          $row = $res->fetch_assoc();
          $booking_id = $row['booking_id'];
          echo "<script>alert('Proceed to payment. Your Booking ID is $booking_id'); window.location='pay.php?booking_id=$booking_id';</script>";
        } else {
          echo "<script>alert('Client record not found.');</script>";
        }
      }
      ?>
    </div>
  </div>
</section>

<section class="listings">
  <div class="wrapper">
    <h2 style="margin-top: 30px;">What Others Say About This Car:</h2>
    <?php
    $sql_fb = "SELECT f.rating, f.comment, c.fname, f.created_at
                FROM feedback f
                JOIN hire h ON f.hire_id = h.hire_id
                JOIN client c ON h.client_id = c.client_id
                WHERE h.car_id = '$car_id'
                ORDER BY f.created_at DESC";
    $result_fb = $conn->query($sql_fb);
    if ($result_fb->num_rows > 0) {
      while ($row_fb = $result_fb->fetch_assoc()) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-top:10px;'>
              <strong>{$row_fb['fname']}</strong> rated <strong>{$row_fb['rating']}/5</strong><br>
              <em>{$row_fb['comment']}</em><br>
              <small>{$row_fb['created_at']}</small>
            </div>";
      }
    } else {
      echo "<p>No reviews yet. Be the first to book and leave feedback!</p>";
    }
    ?>
  </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
