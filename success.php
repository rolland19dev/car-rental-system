<!DOCTYPE html>
<html lang="en">
<head>
	<title>Car Rental</title>
	<meta charset="utf-8">
	<meta name="author" content="RNR Drive">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<style>
		/* Success Message Styling */
		.success-message {
			text-align: center;
			color: red;
			font-size: 20px;
			font-family: monospace;
			line-height: 1.8;
			margin: 60px auto;
			max-width: 800px;
			padding: 20px;
			background-color: #f9f9f9;
			border-radius: 12px;
			box-shadow: 0 4px 8px rgba(0,0,0,0.1);
		}

		/* Avoid overlap with header */
		.caption {
			padding-top: 120px;
			text-align: center;
		}
	</style>
</head>
<body>

	<!-- Header Include -->
	<?php include 'header.php'; ?>

	<!-- Caption / Title -->
	<section class="caption">
		<h2 class="caption">Find Your Dream Cars For Hire</h2>
		<h3 class="properties">Range Rovers - Mercedes Benz - Landcruisers</h3>
	</section>

	<!-- Success Message Section -->
	<section class="listings">
		<div class="wrapper">
			<div class="success-message">
				<p>Thank you for sending a request to our Team. We will get back to you<br>
				once we verify your payment.</p>
				<p>You can login to view the processing status of your request using your<br>
				email and the National ID Number as password.</p>
			</div>
		</div>
	</section>

	<!-- Footer Section -->
	<footer>
		<div class="wrapper footer">
			<ul>
				<li class="links">
					<ul>
						<li>OUR COMPANY</li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Policy</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
				</li>
				<li class="links">
					<ul>
						<li>OTHERS</li>
						<li><a href="#">...</a></li>
						<li><a href="#">...</a></li>
						<li><a href="#">...</a></li>
						<li><a href="#">...</a></li>
					</ul>
				</li>
				<li class="links">
					<ul>
						<li>OUR CAR TYPES</li>
						<li><a href="#">Mercedes</a></li>
						<li><a href="#">Range Rover</a></li>
						<li><a href="#">Landcruisers</a></li>
						<li><a href="#">Others</a></li>
					</ul>
				</li>
				<li class="about">
					<p>Our company rents cars and other vehicles to clients at lower costs.</p>
					<ul>
						<li><a href="http://facebook.com/codeprojectsdotorg/" class="facebook" target="_blank"></a></li>
						<li><a href="http://twitter.com/" class="twitter" target="_blank"></a></li>
						<li><a href="http://plus.google.com/" class="google" target="_blank"></a></li>
						<li><a href="#" class="skype"></a></li>
					</ul>
				</li>
			</ul>
		</div>

		<div class="copyrights wrapper">
			Copyright &copy; <?php echo date("Y"); ?> Simple Car Rental System
		</div>
	</footer>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
