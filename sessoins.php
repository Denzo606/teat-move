<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['login_type'])) {
    header('Location: login.php');
    exit();
}

// Redirect based on user role
if ($_SESSION['login_type'] == 1) {
    header('Location: index.php');
} elseif ($_SESSION['login_type'] == 2) {
    header('Location: billing/index.php');
} elseif ($_SESSION['login_type'] == 3) {
    header('Location: index.php');
} else {
    // Handle invalid role or redirect to a default page
    header('Location: index.php');
}

exit();
