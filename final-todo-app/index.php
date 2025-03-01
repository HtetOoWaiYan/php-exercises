<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

require_once "../config.php";

$username = $password = "";
$errorMsg = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        $errorMsg = "Please enter both username and password.";
    } else {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        
        try {
            $statement = $connection->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $statement->execute([$username]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            
            if($user && password_verify($password, $user['password'])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                
                header("location: dashboard.php");
                exit;
            } else {
                $errorMsg = "Invalid username or password.";
            }
            
        } catch (PDOException $e) {
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
    <title>Todo App - Login</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .wrapper { width: 360px; margin: 0 auto; padding: 20px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin: 5px 0; }
        .btn { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <main class="wrapper">
        <header>
            <h1>Todo App Login</h1>
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
                <p>Don't have an account? <a href="signup.php">Sign up now</a></p>
            </form>
        </section>
    </main>
</body>
</html>