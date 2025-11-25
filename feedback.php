<?php
session_start();
include 'includes/config.php';

// 确保用户已登录
if (!isset($_SESSION['client_id'])) {
    echo "<script>alert('Please log in to leave feedback.'); window.location='login.php';</script>";
    exit();
}

$client_id = $_SESSION['client_id'];

// 查询用户成功租赁的订单（已被 Admin 批准）
$orders = $conn->query("SELECT h.hire_id, c.car_name FROM hire h JOIN cars c ON h.car_id = c.car_id WHERE h.client_id = $client_id AND h.status = 'Approved'");

// 提交反馈
if (isset($_POST['submit'])) {
    $hire_id = $_POST['hire_id'];
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $insert = "INSERT INTO feedback (hire_id, client_id, rating, comment) VALUES ('$hire_id', '$client_id', '$rating', '$comment')";

    if ($conn->query($insert) === TRUE) {
        echo "<script>alert('Thank you for your feedback!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Failed to submit feedback.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Leave Feedback</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="hire_id" class="form-label">Select Rental</label>
            <select name="hire_id" id="hire_id" class="form-select" required>
                <option value="">-- Choose --</option>
                <?php while ($row = $orders->fetch_assoc()) { ?>
                    <option value="<?php echo $row['hire_id']; ?>">
                        <?php echo "#{$row['hire_id']} - {$row['car_name']}"; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating (1 to 5)</label>
            <input type="number" name="rating" min="1" max="5" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Comment</label>
            <textarea name="comment" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-success">Submit Feedback</button>
    </form>
</body>
</html>
