<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - RNR Drive</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Bootstrap & Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>
<body>

<!-- ✅ Unified Header -->
<?php include 'header.php'; ?>

<!-- ✅ Banner / Caption -->
<section class="text-center mt-4">
    <h2 class="fw-bold">Find You Dream Cars For Hire</h2>
    <h4 class="text-muted">Range Rovers - Mercedes Benz - Landcruisers</h4>
</section>

<!-- ✅ Admin Login Form -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4 class="mb-0">Admin Login Area</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="uname" class="form-label">Username</label>
                                <input type="text" name="uname" id="uname" class="form-control" placeholder="Enter Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Password</label>
                                <input type="password" name="pass" id="pass" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-primary">Login Here</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['login'])) {
                            include 'includes/config.php';

                            $uname = $_POST['uname'];
                            $pass = $_POST['pass'];

                            $query = "SELECT * FROM admin WHERE uname = '$uname' AND pass = '$pass'";
                            $rs = $conn->query($query);
                            $num = $rs->num_rows;
                            $rows = $rs->fetch_assoc();
                            if ($num > 0) {
                                session_start();
                                $_SESSION['uname'] = $rows['uname'];
                                $_SESSION['pass'] = $rows['pass'];
                                echo "<script type='text/javascript'>
                                        alert('Login Successful. Welcome To Our System');
                                        window.location = 'admin/index.php';
                                      </script>";
                            } else {
                                echo "<script type='text/javascript'>
                                        alert('Login Failed. Try Again...');
                                        window.location = 'login.php';
                                      </script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ✅ Footer -->
<footer class="bg-dark text-white text-center py-3">
    &copy; <?php echo date("Y"); ?> Simple Car Rental System
</footer>

</body>
</html>
