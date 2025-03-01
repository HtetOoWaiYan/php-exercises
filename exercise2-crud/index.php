<?php
// Include the database configuration file that establishes the connection
require_once "../config.php";

// Delete Operation: Check if a delete request has been made through GET parameter
if(isset($_GET['delete'])) {
    // Prepare a DELETE query with a placeholder to prevent SQL injection
    $statement = $connection->prepare("DELETE FROM tasks WHERE id = ?");
    // Execute the query with the task ID from the URL
    $statement->execute([$_GET['delete']]);
    // Redirect back to the index page after deletion
    header("Location: index.php");
    exit();
}

// Read Operation: Fetch all tasks from the database
// Using query() since we don't have any user input in this query
// ORDER BY created_at DESC shows newest tasks first
$statement = $connection->query("SELECT * FROM tasks ORDER BY created_at DESC");
// Fetch all rows as an associative array
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        /* Basic CSS for layout and styling */
        body { font-family: Arial; margin: 40px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .btn { display: inline-block; padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
        .btn-add { background: #4CAF50; }
        .btn-edit { background: #2196F3; }
        .btn-delete { background: #f44336; }
    </style>
</head>
<body>
    <main>
        <header>
            <h1>Task Manager</h1>
            <!-- Link to the form for creating new tasks -->
            <a href="task_form.php" class="btn btn-add">Add New Task</a>
        </header>

        <section>
            <!-- Table to display all tasks -->
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): ?>
                    <tr>
                        <!-- htmlspecialchars prevents XSS attacks by escaping special characters -->
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                        <td>
                            <!-- Edit link passes task ID in URL -->
                            <a href="task_form.php?id=<?php echo $task['id']; ?>" class="btn btn-edit">Edit</a>
                            <!-- Delete link with JavaScript confirmation -->
                            <a href="index.php?delete=<?php echo $task['id']; ?>" class="btn btn-delete" 
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>