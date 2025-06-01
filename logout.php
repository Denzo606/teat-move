<?php
session_start();
include('./db_connect.php');

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page with a success parameter
header("location: login.php?logout=success");
exit;
?>
