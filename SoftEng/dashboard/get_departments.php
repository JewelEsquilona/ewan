<?php
session_start();
include('../connection.php');

if (isset($_GET['college'])) {
    $college = $_GET['college'];
    $query = "SELECT DISTINCT department FROM courses WHERE college = :college";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':college', $college);
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($departments);
}
?>
