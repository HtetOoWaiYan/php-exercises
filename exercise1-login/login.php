<?php
// Start the session to maintain user state
session_start();

// Redirect if user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Include database configuration
require_once "config.php";

// Initialize variables for form data and error messages
$username = $password = "";
$errorMsg = "";

// Process form submission when method is POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate that both fields are filled
    if(empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        $errorMsg = "Please enter both username and password.";
    } else {
        // Sanitize and store input values
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        
        try {
            // Prepare and execute query using the connection from config.php
            $statement = $connection->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $statement->execute([$username]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            
            // Simple authentication check
            if($user && password_verify($password, $user['password'])) {
                // Credentials verified - create session and redirect
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                
                header("location: dashboard.php");
                exit;
            } else {
                // Authentication failed
                $errorMsg = "Invalid username or password.";
            }
            
        } catch (PDOException $e) {
            // Log the error and show a generic message
            error_log($e->getMessage());
            $errorMsg = "An error occurred during login. Please try again later.";
        }
    }
}
?>
   
<!DOCTYPE html>
<html lang="en">
<head>       
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .wrapper { width: 360px; margin: 0 auto; padding: 20px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin: 5px 0; }
        .btn { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <main class="wrapper">
        <header>
            <h1>Login</h1>
        </header>
        
        <?php if(!empty($errorMsg)){ echo '<section class="error" role="alert">' . $errorMsg . '</section>'; } ?>
        
        <section>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>">
                </div>    
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" value="Login">
                </div>
                <footer>
                    <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
                </footer>
            </form>
        </section>
    </main>
</body>
</html>
