<?php
// Start the session to access user session data
session_start();

// Security check: Redirect to login if not logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .wrapper { width: 600px; margin: 0 auto; padding: 20px; }
        .btn { background-color: #f44336; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Display personalized welcome message using session data -->
        <h1>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>Welcome to your dashboard.</p>
        <!-- Logout button links to the logout script -->
        <a href="logout.php" class="btn">Sign Out</a>
    </div>
</body>
</html>
