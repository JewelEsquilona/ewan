<?php
session_start();
include('../connection.php');

if (isset($_GET['department'])) {
    $department = $_GET['department'];
    $query = "SELECT DISTINCT section FROM courses WHERE department = :department";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':department', $department);
    $stmt->execute();
    $sections = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($sections);
}
?>
