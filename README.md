# PHP Exercises

This repository contains practice exercises for PHP using XAMPP, and SQL.

## Development Environment Setup

### Installing XAMPP
1. Download XAMPP from [Apache Friends](https://www.apachefriends.org/index.html)
2. Install with default settings, selecting Apache, MySQL, PHP, and phpMyAdmin
3. Launch XAMPP Control Panel and start Apache and MySQL
  - If you encounter port conflicts (common with ports 80, 443, or 3306):
    - Click on "Config" for the service
    - Change the port numbers (e.g., Apache from 80 to 8080)
    - Or close conflicting applications (e.g., Skype, IIS)
4. Verify installation: visit `http://localhost/` and `http://localhost/phpmyadmin/` on browser

### Project Setup
1. Clone or download this repository
2. Place files in `C:\xampp\htdocs\php-exercises\`
3. Create a database called `php-exercises` in phpMyAdmin
   - Click "New" on the left sidebar in phpMyAdmin
   - Enter "php-exercises" as database name
   - Click "Create"
4. Set up database tables for each exercise:
   - Each exercise folder has its own `schema.sql`
   - You need to run the schema.sql for any exercise before working on it
   - Copy-paste the content of schema.sql into phpMyAdmin's SQL tab
5. Open the project in any code editor (Notepad++ or VS Code recommended)

### Testing Your Setup
- Open your browser and navigate to `http://localhost/php-exercises/test-setup.php`
- You should see the PHP configuration information
- If you see errors:
  - Make sure both Apache and MySQL are running (green in XAMPP Control Panel)
  - Check if files are in the correct folder
  - Verify database name is exactly "php-exercises"

## Repository Contents

Each exercise focuses on different topics:

1. **User Authentication (exercise1-login)** 
   - Login/signup system
   - Session handling
   - Basic security practices
   - URL: http://localhost/php-exercises/exercise1-login

2. **CRUD Operations (exercise2-crud)** 
   - Create, read, update, delete tasks
   - Form handling
   - Database operations
   - URL: http://localhost/php-exercises/exercise2-crud

3. **Search Functionality (exercise3-search)** 
   - Database searching
   - SQL LIKE queries
   - Filter implementation
   - URL: http://localhost/php-exercises/exercise3-search

4. **Reporting (exercise4-report)** 
   - Data aggregation
   - Simple analytics
   - Report generation
   - URL: http://localhost/php-exercises/exercise4-report

5. **Complete Practice Exam (final-todo-app)** 
   - Combines all previous concepts
   - Full TodoList application
   - URL: http://localhost/php-exercises/final-todo-app

## Common Issues & Solutions

1. **Can't access localhost**
   - Check if Apache is running
   - Try using `127.0.0.1` instead of `localhost`

2. **Database connection fails**
   - Verify MySQL is running
   - Check if database name is correct
   - Default username is "root" with no password

3. **PHP code shows instead of executing**
   - Make sure Apache is running
   - Files must be in XAMPP's htdocs folder
   - Access through `localhost`, not by opening files directly

## Exam Preparation Tips

1. Try each exercise in order - they build upon each other
2. Understanding session management and CRUD operations is crucial
3. Practice the final todo app multiple times - it combines all important concepts
4. Check the schema.sql in each folder to understand database structure
5. Focus on:
   - Form handling and validation
   - Database operations
   - Session management
   - Basic security practices

## PHP Syntax Cheatsheet

### Basic Syntax
```php
<?php                    // PHP opening tag
// Single line comment
/* Multi-line
   comment */
echo "Hello";           // Output text
$variable = "value";    // Variable declaration
?>                      // PHP closing tag (optional at file end)
```

### Variables & Data Types
```php
$string = "text";              // String
$integer = 42;                 // Integer
$float = 3.14;                // Float
$boolean = true;              // Boolean
$array = ["item1", "item2"];  // Array
$null = null;                 // Null value

// Array operations
$array[] = "new item";        // Add to array
$associative = [              // Associative array
    "key" => "value",
    "name" => "John"
];
```

### Control Structures
```php
// If statement
if ($condition) {
    // code
} elseif ($other_condition) {
    // code
} else {
    // code
}

// Loops
foreach ($array as $value) {
    // code
}
foreach ($array as $key => $value) {
    // code
}

while ($condition) {
    // code
}

for ($i = 0; $i < 10; $i++) {
    // code
}
```

### Functions & Include
```php
// Include files
require_once "file.php";      // Fatal error if file missing
include "file.php";           // Warning if file missing

// Function definition
function functionName($parameter) {
    return $parameter;
}

// Arrow function (PHP 7.4+)
$fn = fn($x) => $x + 1;
```

### Database (PDO)
```php
// Connection
$connection = new PDO(
    "mysql:host=$host;dbname=$db",
    $username,
    $password
);

// Prepared statement
$stmt = $connection->prepare(
    "SELECT * FROM table WHERE id = ?"
);
$stmt->execute([$id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Insert data
$stmt = $connection->prepare(
    "INSERT INTO table (column) VALUES (?)"
);
$stmt->execute([$value]);
```

### Sessions & Cookies
```php
session_start();              // Start session
$_SESSION['key'] = 'value';  // Set session variable
unset($_SESSION['key']);     // Remove session variable
session_destroy();           // Destroy session

setcookie("name", "value", time() + 3600);  // Set cookie
```

### Form Handling
```php
// Check form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['field'];    // Get POST data
}

// Get URL parameters
$id = $_GET['id'];              // Get query parameter

// Form security
$safe = htmlspecialchars($input);  // Prevent XSS
$trim = trim($input);             // Remove whitespace
```

### Error Handling
```php
try {
    // code that might throw exception
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    // always executed
}

error_log("Error message");    // Log error
die("Error message");         // Stop execution
```

### Common String Functions
```php
strlen($str);                // String length
str_replace("old", "new", $str);  // Replace text
substr($str, 0, 5);         // Get substring
strtolower($str);           // Convert to lowercase
strtoupper($str);           // Convert to uppercase
```

### Date and Time
```php
date("Y-m-d H:i:s");        // Format date
time();                     // Unix timestamp
strtotime("+1 day");       // Convert to timestamp
```

### Constants
```php
define('CONSTANT_NAME', 'value');  // Define constant
const CONSTANT = 'value';          // Alternative syntax