<?php
// Database configuration constants
define('DB_SERVER', 'localhost');   // Database server address
define('DB_USERNAME', 'root');      // Database username
define('DB_PASSWORD', '');          // Database password (empty for default XAMPP)
define('DB_NAME', 'php-exercises'); // Database name

// PDO connection - more modern approach
try {
    $connection = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, terminate script and display error
    die("Connection failed: " . $e->getMessage());
}
?>
