<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../connection.php'; 

function checkUserPrivileges($userRole) {
    switch ($userRole) {
        case 'Admin':
            return ['home.php', 'alumni_list.php', 'courses.php']; // Admin can access all
        case 'Registrar':
            return ['home.php', 'alumni_list.php', 'courses.php']; // Registrar access
        case 'Dean':
            return ['dean_list.php']; // Dean access
        case 'Program Chair':
            return ['programchair_list.php']; // Program Chair access
        case 'Alumni':
                return ['alumni_home.php', 'edit_form.php'];
        default:
            return []; // No access
    }
}

function setUserSession($userData) {
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['user_role'] = $userData['role'];
    $_SESSION['name'] = $userData['name']; 
}

function hasAccess($page) {
    $userRole = $_SESSION['user_role'] ?? null;
    $privileges = checkUserPrivileges($userRole);
    return in_array($page, $privileges);
}
