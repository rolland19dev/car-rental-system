<?php include 'header.php'; ?>

<?php
// Receiving Data
$pickup_location = $_GET['pickup_location'] ?? '';
$return_location = $_GET['return_location'] ?? '';
$pickup_date = $_GET['pickup_date'] ?? '';
$pickup_time = $_GET['pickup_time'] ?? '';
$return_date = $_GET['return_date'] ?? '';
$return_time = $_GET['return_time'] ?? '';
?>

<!-- Display user input -->
<section style="padding: 20px 0; text-align: center;">
  <h2>Showing cars from <b><?= $pickup_location ?></b> to <b><?= $return_location ?></b></h2>
  <p>
    Pick-up: <?= $pickup_date ?> <?= $pickup_time ?> |
    Return: <?= $return_date ?> <?= $return_time ?>
  </p>
</section>

  <form method="GET" action="cars_list.php" style="padding: 30px; background: #f4f8fb; border-radius: 12px; max-width: 900px; margin: 0 auto 40px auto; box-shadow: 0 0 12px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; align-items: center;">
  
  
  <!-- 隐藏传回之前的数据 -->
  <input type="hidden" name="pickup_location" value="<?= $pickup_location ?>">
  <input type="hidden" name="return_location" value="<?= $return_location ?>">
  <input type="hidden" name="pickup_date" value="<?= $pickup_date ?>">
  <input type="hidden" name="pickup_time" value="<?= $pickup_time ?>">
  <input type="hidden" name="return_date" value="<?= $return_date ?>">
  <input type="hidden" name="return_time" value="<?= $return_time ?>">

  <!-- Car Type -->
  <div style="display: flex; flex-direction: column;">
    <label>Car Type</label>
    <select name="car_type" style="padding: 10px; border-radius: 6px; width: 160px;">
      <option value="">All</option>
      <option value="SUV" <?= (isset($_GET['car_type']) && $_GET['car_type'] == 'SUV') ? 'selected' : '' ?>>SUV</option>
      <option value="Sedan" <?= (isset($_GET['car_type']) && $_GET['car_type'] == 'Sedan') ? 'selected' : '' ?>>Sedan</option>
      <option value="Hatchback" <?= (isset($_GET['car_type']) && $_GET['car_type'] == 'Hatchback') ? 'selected' : '' ?>>Hatchback</option>
    </select>
  </div>

  <!-- Transmission -->
  <div style="display: flex; flex-direction: column;">
    <label>Transmission</label>
    <select name="transmission" style="padding: 10px; border-radius: 6px; width: 160px;">
      <option value="">Any</option>
      <option value="Automatic" <?= (isset($_GET['transmission']) && $_GET['transmission'] == 'Automatic') ? 'selected' : '' ?>>Automatic</option>
      <option value="Manual" <?= (isset($_GET['transmission']) && $_GET['transmission'] == 'Manual') ? 'selected' : '' ?>>Manual</option>
    </select>
  </div>

  <!-- Seats -->
  <div style="display: flex; flex-direction: column;">
    <label>Seats</label>
    <select name="seats" style="padding: 10px; border-radius: 6px; width: 160px;">
      <option value="">Any</option>
      <option value="5" <?= (isset($_GET['seats']) && $_GET['seats'] == '4') ? 'selected' : '' ?>>4 Seats</option>
      <option value="7" <?= (isset($_GET['seats']) && $_GET['seats'] == '7') ? 'selected' : '' ?>>7 Seats</option>
	  <option value="8" <?= (isset($_GET['seats']) && $_GET['seats'] == '8') ? 'selected' : '' ?>>8 Seats</option>
    </select>
  </div>

  <div>
    <button type="submit" style="margin-top: 25px; padding: 10px 20px; background: #007BFF; color: white; border: none; border-radius: 6px;">Filter Cars</button>
  </div>
</form>



<?php
include 'includes/config.php'; // 连接数据库

// 默认筛选条件
$where = "WHERE status = 'Available'";

// 加上 filter 条件
if (!empty($_GET['car_type'])) {
    $car_type = $_GET['car_type'];
    $where .= " AND car_type = '$car_type'";
}

if (!empty($_GET['transmission'])) {
    $transmission = $_GET['transmission'];
    $where .= " AND transmission = '$transmission'";
}

if (!empty($_GET['seats'])) {
    $seats = $_GET['seats'];
    $where .= " AND capacity = '$seats'";
}

// 查询车辆
$query = "SELECT * FROM cars $where";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<section class='listings'><div class='wrapper'><ul class='properties_list'>";
    while ($row = $result->fetch_assoc()) {
        echo "
        <li>
            <a href='book_car.php?id={$row['car_id']}'>
				<img class='thumb' src='cars/{$row['image']}' width='300' height='200'>
			</a>
            <span class='price'>RM {$row['hire_cost']}</span>
            <div class='property_details'>
                <h1><a href='book_car.php?id={$row['car_id']}'>Car: {$row['car_name']}</a></h1>
                <h2>Type: <span class='property_size'>{$row['car_type']}</span></h2>
                <h2>Seats: <span class='property_size'>{$row['capacity']}</span></h2>
                <h2>Transmission: <span class='property_size'>{$row['transmission']}</span></h2>
            </div>
        </li>";
    }
    echo "</ul></div></section>";
} else {
    echo "<p style='text-align:center; font-weight:bold; padding: 30px;'>No cars found matching your filter criteria.</p>";
}
?>


<?php include 'footer.php'; ?>
