<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_NOTICE);
?>

<!-- ✅ Bootstrap Navbar -->
<header class="bg-light shadow-sm">
    <div class="container d-flex flex-wrap justify-content-between align-items-center py-3">
        <h1 class="fs-4 text-dark m-0"><?php echo "RNR Drive"; ?></h1>

        <nav>
            <ul class="nav">
                <?php if (!isset($_SESSION['email']) || !isset($_SESSION['pass'])) { ?>
                    <li class="nav-item"><a href="index.php" class="nav-link px-3">Home</a></li>
                    <li class="nav-item"><a href="index.php" class="nav-link px-3">Rent Cars</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link px-3">Contact</a></li>
                    <li class="nav-item"><a href="account.php" class="nav-link px-3">Client Login</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link px-3">Admin Login</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a href="index.php" class="nav-link px-3">Home</a></li>
                    <li class="nav-item"><a href="status.php" class="nav-link px-3">View Status</a></li>
                    <li class="nav-item"><a href="message_admin.php" class="nav-link px-3">Message Admin</a></li>
                    <li class="nav-item nav-link px-3 text-success fw-bold">
                        Welcome, <?php echo ucwords(strtolower($_SESSION['fname'])); ?>!
                    </li>
                    <li class="nav-item"><a href="admin/logout.php" class="nav-link px-3 text-danger">Logout</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>
