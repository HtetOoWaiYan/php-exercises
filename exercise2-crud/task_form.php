<?php
// Include database configuration
require_once "../config.php";

// Initialize task with default values
// This prevents undefined index errors when creating a new task
$task = ['title' => '', 'description' => '', 'status' => 'pending'];

// Edit mode: If ID is provided in URL, fetch existing task
if(isset($_GET['id'])) {
    // Prepare statement to prevent SQL injection
    $statement = $connection->prepare("SELECT * FROM tasks WHERE id = ?");
    $statement->execute([$_GET['id']]);
    // Fetch task as associative array
    $task = $statement->fetch(PDO::FETCH_ASSOC);
    // Redirect to index if task not found
    if(!$task) {
        header("Location: index.php");
        exit();
    }
}

// Form submission handler
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];
    
    // Only process if title is not empty (required field)
    if(!empty($title)) {
        if(isset($_GET['id'])) {
            // Update mode: Modify existing task
            $sql = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?";
            $statement = $connection->prepare($sql);
            $statement->execute([$title, $description, $status, $_GET['id']]);
        } else {
            // Create mode: Insert new task
            $sql = "INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)";
            $statement = $connection->prepare($sql);
            $statement->execute([$title, $description, $status]);
        }
        // Redirect back to task list after save
        header("Location: index.php");
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
        }
    </style>
</head>
<body>
    <main>
        <header>
            <!-- Dynamic heading based on create/edit mode -->
            <h1><?php echo isset($_GET['id']) ? 'Edit Task' : 'New Task'; ?></h1>
        </header>

        <section>
            <!-- Form submits to itself -->
            <form method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <!-- Display existing value if editing -->
                    <input type="text" id="title" name="title" 
                           value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" 
                              rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <!-- Status dropdown with current value selected -->
                    <select id="status" name="status">
                        <option value="pending" <?php echo $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" value="Save Task">
                    <a href="index.php" style="margin-left: 10px">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>