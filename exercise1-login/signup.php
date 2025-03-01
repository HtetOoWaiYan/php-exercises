<?php
// Start the session
session_start();

// If already logged in, redirect to dashboard
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Include database configuration
require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        try {
            $statement = $connection->prepare($sql);
            $statement->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Execute the prepared statement
            $statement->execute();
            
            if($statement->rowCount() > 0) {
                $username_err = "This username is already taken.";
            } else {
                $username = trim($_POST["username"]);
            }
        } catch(PDOException $e) {
            echo "Something went wrong. Please try again later.";
        }
    }
    
    // Validate password - simplified to just check if empty
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if($password != $confirm_password) {
            $confirm_password_err = "Passwords did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        try {
            $statement = $connection->prepare($sql);
            $statement->bindParam(":username", $param_username, PDO::PARAM_STR);
            $statement->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Execute the prepared statement
            $statement->execute();
            
            // Redirect to login page
            header("location: login.php");
        } catch(PDOException $e) {
            echo "Something went wrong. Please try again later.";
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            <h1>Sign Up</h1>
            <p>Please fill this form to create an account.</p>
        </header>
        
        <section>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
                    <?php if(!empty($username_err)): ?>
                        <span class="error" role="alert"><?php echo $username_err; ?></span>
                    <?php endif; ?>
                </div>    
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <?php if(!empty($password_err)): ?>
                        <span class="error" role="alert"><?php echo $password_err; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <?php if(!empty($confirm_password_err)): ?>
                        <span class="error" role="alert"><?php echo $confirm_password_err; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" value="Submit">
                </div>
                <footer>
                    <p>Already have an account? <a href="login.php">Login here</a>.</p>
                </footer>
            </form>
        </section>
    </main>
</body>
</html>