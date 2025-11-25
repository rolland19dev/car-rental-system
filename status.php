<?php
session_start();
include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Booking Status | RNR Drive</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/responsive.css">
	<style>
		.status-box {
			border: 1px solid #ccc;
			padding: 15px;
			margin: 15px 0;
			border-radius: 8px;
			background-color: #f9f9f9;
		}
		.status-box strong {
			color: #333;
		}
	</style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="caption">
	<h2 class="caption" style="text-align: center">Find Your Dream Car For Hire</h2>
	<h3 class="properties" style="text-align: center">Drive Bold. Drive RNR.</h3>
</section>

<section class="listings">
	<div class="wrapper">
		<h2 style="text-decoration: underline;">Your Booking Status</h2>

		<?php
		if (isset($_SESSION['email'])) {
			$email = $conn->real_escape_string($_SESSION['email']);

			// Get client_id from client table
			$client_sql = "SELECT client_id FROM client WHERE email = '$email' LIMIT 1";
			$client_result = $conn->query($client_sql);

			if ($client_result && $client_result->num_rows > 0) {
				$client_row = $client_result->fetch_assoc();
				$client_id = $client_row['client_id'];

				// Get hire info
				$hire_sql = "SELECT h.hire_id, h.status, h.start_date, h.end_date, c.car_name, c.car_type
							FROM hire h
							JOIN cars c ON h.car_id = c.car_id
							WHERE h.client_id = '$client_id'";
				$hire_result = $conn->query($hire_sql);

				if ($hire_result && $hire_result->num_rows > 0) {
					while ($row = $hire_result->fetch_assoc()) {
						echo "<div class='status-box'>
							<p><strong>Car:</strong> " . htmlspecialchars($row['car_type']) . " - " . htmlspecialchars($row['car_name']) . "</p>
							<p><strong>Booking Period:</strong> " . htmlspecialchars($row['start_date']) . " to " . htmlspecialchars($row['end_date']) . "</p>
							<p><strong>Status:</strong> <span style='color: red;'>" . htmlspecialchars($row['status']) . "</span></p>
						</div>";
					}
				} else {
					echo "<p>No bookings found for this account.</p>";
				}
			} else {
				echo "<p>Email not found in client database.</p>";
			}
		} else {
			echo "<p>Please <a href='account.php'>login</a> to view your booking status.</p>";
		}
		?>
	</div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
