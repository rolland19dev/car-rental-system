<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : 0;

    $fname    = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lname    = mysqli_real_escape_string($conn, $_POST['lastname']);
    $country  = mysqli_real_escape_string($conn, $_POST['country']);
    $subject  = mysqli_real_escape_string($conn, $_POST['subject']);

    $messageContent = "$fname $lname ($country): $subject";

    $sql = "INSERT INTO message (client_id, message, status, time)
            VALUES ('$client_id', '$messageContent', 'Unread', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thank you $fname! Your message has been received.');</script>";
    } else {
        echo "<script>alert('Oops! Message failed to send.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact Us | RNR Drive</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

	<style>
		body { font-family: Arial, Helvetica, sans-serif; }

		.page-title {
			text-align: center;
			font-size: 28px;
			margin-top: 30px;
			margin-bottom: 20px;
			font-weight: bold;
			color: #444;
		}

		input[type=text], select, textarea {
			width: 100%;
			padding: 12px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 6px;
			margin-bottom: 16px;
			resize: vertical;
		}

		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type=submit]:hover {
			background-color: #45a049;
		}

		.container {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
			max-width: 800px;
			margin: auto;
			margin-bottom: 40px;
		}
	</style>
</head>
<body>

<?php include 'header.php'; ?>

<h3 class="page-title">Contact Us</h3>

<div class="container">
  <form method="POST" action="contact.php">
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name.." required>

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name.." required>

    <label for="country">Country</label>
    <select id="country" name="country" required>
      <option value="">--Select Country--</option>
      <option value="Australia">Australia</option>
      <option value="Canada">Canada</option>
      <option value="USA">USA</option>
      <option value="Malaysia">Malaysia</option>
    </select>

    <label for="subject">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px" required></textarea>

    <input type="submit" value="Submit">
  </form>
</div>

</body>
</html>
