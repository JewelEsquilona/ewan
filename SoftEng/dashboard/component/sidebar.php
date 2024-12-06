<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Logout logic
if (isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to the landing page
    header("Location: ../landing page/index.php");
    exit;
}

include_once 'user_privileges.php';
?>

<div class="bg-sidebar vh-100 w-50 position-fixed">
    <div class="log d-flex justify-content-between">
        <h1 class="E-classe text-start ms-3 ps-1 mt-3 h6 fw-bold">Welcome</h1>
        <i class="far fa-times h4 me-3 close align-self-end d-md-none"></i>
    </div>
    <div class="img-admin d-flex flex-column align-items-center text-center gap-2">
        <img class="rounded-circle" src="../assets/img/default.png" alt="img-admin" height="100" width="100">
        <span class="h7 admin-color"><?= isset($_SESSION['user_role']) ? htmlspecialchars($_SESSION['user_role']) : 'Guest'; ?></span>
    </div>
    <div class="bg-list d-flex flex-column align-items-center fw-bold gap-2 mt-4">
        <ul class="d-flex flex-column list-unstyled">
            <li class="h7"><a class="nav-link text-dark" href="home.php"><i class="fal fa-home-lg-alt me-2"></i> <span>Home</span></a></li>
            <?php if (hasAccess('courses.php')): ?>
                <li class="h7"><a class="nav-link text-dark" href="course.php"><i class="fal fa-bookmark me-2"></i> <span>Course</span></a></li>
            <?php endif; ?>
            <?php if (hasAccess('alumni_list.php')): ?>
                <li class="h7"><a class="nav-link text-dark" href="alumni_list.php"><i class="far fa-graduation-cap me-2"></i> <span>Alumni</span></a></li>
            <?php endif; ?>
            <?php if (hasAccess('staffs.php')): ?>
                <li class="h7"><a class="nav-link text-dark" href="staffs.php"><i class="fal fa-file-chart-line me-2"></i> <span>Staffs</span></a></li>
            <?php endif; ?>
            <?php if (hasAccess('settings.php')): ?>
                <li class="h7"><a class="nav-link text-dark" href="settings.php"><i class="fal fa-sliders-v-square me-2"></i> <span>Settings</span></a></li>
            <?php endif; ?>
        </ul>
        <ul class="logout d-flex justify-content-start list-unstyled">
            <li class="h7"><a class="nav-link text-dark" href="?logout=true"><span>Logout</span><i class="fal fa-sign-out-alt ms-2"></i></a></li>
        </ul>
    </div>
</div>
