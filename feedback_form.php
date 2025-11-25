<?php
session_start();
include 'includes/config.php';

// 1️⃣ 拿登录用户 email
$client_email = $_SESSION['email']; // 要确保你有做 login + session

// 2️⃣ 找出对应 client_id
$get_client = "SELECT client_id FROM client WHERE email = '$client_email' LIMIT 1";
$res_client = $conn->query($get_client);
$client_data = $res_client->fetch_assoc();
$client_id = $client_data['client_id'];

// 3️⃣ 查询该用户的租用记录
$hire_sql = "SELECT h.hire_id, c.car_name FROM hire h 
             JOIN cars c ON h.car_id = c.car_id 
             WHERE h.client_id = '$client_id'";
$hire_res = $conn->query($hire_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
</head>
<body>
    <h2>Submit Your Feedback</h2>

    <form method="POST">
        <!-- 显示客户编号（只显示，不可编辑） -->
        <p>Your Client ID: <strong><?php echo $client_id; ?></strong></p>
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">

        <label for="hire_id">Select Your Hire:</label>
        <select name="hire_id" required>
            <option value="">-- Select Hire --</option>
            <?php
            while ($row = $hire_res->fetch_assoc()) {
                echo "<option value='{$row['hire_id']}'>Hire ID: {$row['hire_id']} - Car: {$row['car_name']}</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="rating">Rating (1 to 5):</label>
        <input type="number" name="rating" min="1" max="5" required>
        <br><br>

        <label for="comment">Your Comment:</label><br>
        <textarea name="comment" rows="5" cols="40" required></textarea>
        <br><br>

        <input type="submit" name="submit_feedback" value="Submit Feedback">
    </form>

    <?php
    if (isset($_POST['submit_feedback'])) {
        $hire_id = $_POST['hire_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        // 插入 feedback（client_id 已关联在 hire 表中）
        $insert = "INSERT INTO feedback (hire_id, rating, comment) 
                   VALUES ('$hire_id', '$rating', '$comment')";
        $result = $conn->query($insert);

        if ($result) {
            echo "<p style='color: green;'>Feedback submitted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Failed to submit feedback. Please try again.</p>";
        }
    }
    ?>
</body>
</html>
