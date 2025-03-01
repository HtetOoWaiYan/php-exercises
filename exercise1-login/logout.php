<?php
// Start the session to access session variables
session_start();

// Clear all session data
$_SESSION = array(); // Reset the session array
session_destroy();   // Destroy the session completely

// Redirect user back to login page
header("location: login.php");
// Terminate script execution
exit;
?>
