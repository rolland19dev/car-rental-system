<!DOCTYPE html>
<html lang="en">
<head>
	<title>Car Rental</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap 5 CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Your Custom CSS -->
	<link rel="stylesheet" href="css/responsive.css">
</head>
<body>

	<?php include 'header.php'; ?>

	<!-- 🔍 Search Banner Section -->
	<section class="bg-dark text-white text-center d-flex flex-column justify-content-center align-items-center w-100" 
	style="background: url('img/banner.png') no-repeat center center / cover; height: 70vh; margin: 0; padding: 0;">
	
	<div class="container">
		<h1 class="mb-4">Find Your Dream Car and Enjoy Trip</h1>
		<form method="GET" action="cars_list.php" class="row g-2 justify-content-center">

		<!-- 🔸 Row 1: Pick-up Details -->
		<div class="col-12 col-md-3">
			<select name="pickup_location" class="form-select" required>
				<option value="">Pick-up Location</option>
				<option>Kuching Airport</option>
				<option>Kuching Central</option>
			</select>
		</div>
		<div class="col-6 col-md-2">
			<input type="date" name="pickup_date" class="form-control" required>
		</div>
		<div class="col-6 col-md-2">
			<input type="time" name="pickup_time" class="form-control" required>
		</div>

		<!-- 🔸 Row 2: Return Details -->
		<div class="w-100"></div> <!-- Line Break Between Rows -->

		<div class="col-12 col-md-3">
			<select name="return_location" class="form-select" required>
				<option value="">Return Location</option>
				<option>Kuching Airport</option>
				<option>Kuching Central</option>
			</select>
		</div>
		<div class="col-6 col-md-2">
			<input type="date" name="return_date" class="form-control" required>
		</div>
		<div class="col-6 col-md-2">
			<input type="time" name="return_time" class="form-control" required>
		</div>

		<!-- 🔍 Search Button -->
		<div class="col-12 mt-3 text-center">
			<button type="submit" class="btn btn-warning fw-bold px-4">Search ➤</button>
		</div>

		</form>

	</div>
</section>


	<!-- 🚗 Listings Section -->
	<section class="py-5">
		<div class="container">
			<div class="row">
				<?php
				include 'includes/config.php';
				$sel = "SELECT * FROM cars WHERE status = 'Available'";
				$rs = $conn->query($sel);
				while ($rws = $rs->fetch_assoc()) {
				?>
					<div class="col-sm-6 col-md-4 mb-4">
						<div class="card h-100">
							<img src="cars/<?php echo $rws['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;" alt="Car Image">
							<div class="card-body">
								<h5 class="card-title"><?php echo $rws['car_type']; ?></h5>
								<p class="card-text">
									Model: <?php echo $rws['car_name']; ?><br>
									Price: <strong>RM<?php echo $rws['hire_cost']; ?></strong>
								</p>
								<a href="book_car.php?id=<?php echo $rws['car_id']; ?>" class="btn btn-primary w-100">Book Now</a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<?php include 'footer.php'; ?>

</body>
</html>
