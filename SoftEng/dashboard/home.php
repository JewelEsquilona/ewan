<?php
session_start();
include 'user_privileges.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../landing page/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Alumni System</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous" />
</head>
<body class="bg-content">
        <div class="container-fluid px">
            <?php include "component/nav.php"; ?>

            <div class="cards row gap-3 justify-content-center mt-5">
                <!-- Total Alumni Card -->
                <div class="card__items card__items--blue col-md-3 position-relative">
                    <div class="card__alumni d-flex flex-column gap-2 mt-3">
                        <i class="far fa-graduation-cap h3"></i>
                        <span>Alumni</span>
                    </div>
                    <div class="card__nbr-alumni">
                        <span class="h5 fw-bold nbr">
                            <?php
                            include '../connection.php';
                            $nbr_alumni = $con->query("SELECT COUNT(*) FROM `2024-2025`")->fetchColumn();
                            echo $nbr_alumni;
                            ?>
                        </span>
                    </div>
                </div>
                
                <!-- Total Courses Card -->
                <div class="card__items card__items--rose col-md-3 position-relative">
                    <div class="card__Course d-flex flex-column gap-2 mt-3">
                        <i class="fal fa-bookmark h3"></i>
                        <span>Course</span>
                    </div>
                    <div class="card__nbr-course">
                        <span class="h5 fw-bold nbr">
                            <?php
                            $nbr_courses = $con->query("SELECT COUNT(*) FROM courses")->fetchColumn();
                            echo $nbr_courses;
                            ?>
                        </span>
                    </div>
                </div>
                
                <!-- Total Staff Card -->
                <div class="card__items card__items--yellow col-md-3 position-relative">
                    <div class="card__payments d-flex flex-column gap-2 mt-3">
                        <i class="fal fa-users h3"></i>
                        <span>Users</span>
                    </div>
                    <div class="card__nbr-course">
                        <span class="h5 fw-bold nbr">
                            <?php
                            $nbr_courses = $con->query("SELECT COUNT(*) FROM users")->fetchColumn();
                            echo $nbr_courses;
                            ?>
                        </span>
                    </div>
                </div>

    <script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>
