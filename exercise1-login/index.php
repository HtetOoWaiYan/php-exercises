<?php
// Start the PHP session to enable session variables
session_start();

// Direct user to appropriate page based on login status
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // If user is already logged in, redirect to dashboard
    header("location: dashboard.php");
} else {
    // If user is not logged in, redirect to login page
    header("location: login.php");
}
// Terminate script execution after redirection
exit;
?>
