<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../config.php";

$task = ['title' => '', 'description' => '', 'status' => 'pending', 'priority' => 'medium'];

if(isset($_GET['id'])) {
    $statement = $connection->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $statement->execute([$_GET['id'], $_SESSION['id']]);
    $task = $statement->fetch(PDO::FETCH_ASSOC);
    if(!$task) {
        header("Location: dashboard.php");
        exit();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    
    if(!empty($title)) {
        if(isset($_GET['id'])) {
            $sql = "UPDATE tasks SET title = ?, description = ?, status = ?, priority = ? WHERE id = ? AND user_id = ?";
            $statement = $connection->prepare($sql);
            $statement->execute([$title, $description, $status, $priority, $_GET['id'], $_SESSION['id']]);
        } else {
            $sql = "INSERT INTO tasks (user_id, title, description, status, priority) VALUES (?, ?, ?, ?, ?)";
            $statement = $connection->prepare($sql);
            $statement->execute([$_SESSION['id'], $title, $description, $status, $priority]);
        }
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? 'Edit Task' : 'New Task'; ?></title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], textarea, select { 
            width: 100%; 
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .btn { 
            background: #4CAF50; 
            color: white; 
            padding: 10px 15px; 
            border: none; 
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancel {
            background: #f44336;
        }
    </style>
</head>
<body>
    <main>
        <header>
            <h1><?php echo isset($_GET['id']) ? 'Edit Task' : 'New Task'; ?></h1>
        </header>

        <section>
            <form method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" 
                           value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" 
                              rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority">
                        <option value="low" <?php echo $task['priority'] == 'low' ? 'selected' : ''; ?>>Low</option>
                        <option value="medium" <?php echo $task['priority'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="high" <?php echo $task['priority'] == 'high' ? 'selected' : ''; ?>>High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="pending" <?php echo $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" value="Save Task">
                    <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>