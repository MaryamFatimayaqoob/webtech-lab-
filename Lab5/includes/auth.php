<?php
// includes/auth.php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "Please login to access this page";
        header("Location: ../login.php");
        exit;
    }
}

function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == $role;
}

function requireAdmin() {
    requireLogin();
    if (!hasRole('admin')) {
        $_SESSION['error'] = "Access denied. Admin privileges required.";
        header("Location: ../dashboard.php");
        exit;
    }
}
?>