<?php
// Include the database configuration file
require_once "../config.php";

// Get filter values from GET parameters with default values if not set
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$priority = isset($_GET['priority']) ? $_GET['priority'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Build the SQL query dynamically based on filters
$sql = "SELECT * FROM tasks WHERE 1=1"; // 1=1 allows easy filter concatenation
$params = []; // Array to store parameters for prepared statement

// Add search condition if search term exists
if ($search) {
    $sql .= " AND (title LIKE ? OR description LIKE ?)";
    $searchTerm = "%$search%"; // Add wildcards for partial matching
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Add priority filter if selected
if ($priority) {
    $sql .= " AND priority = ?";
    $params[] = $priority;
}

// Add status filter if selected
if ($status) {
    $sql .= " AND status = ?";
    $params[] = $status;
}

// Add sorting to show newest tasks first
$sql .= " ORDER BY created_at DESC";

// Prepare and execute the query
$statement = $connection->prepare($sql);
$statement->execute($params);
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Search</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .filters { 
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .filters input, .filters select { 
            padding: 8px;
            margin-right: 10px;
        }
        table { 
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td { 
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .priority-high { color: #f44336; }
        .priority-medium { color: #ff9800; }
        .priority-low { color: #4CAF50; }
    </style>
</head>
<body>
    <main>
        <header>
            <h1>Task Search</h1>
        </header>

        <!-- Search and filter form -->
        <section class="filters">
            <form method="get">
                <input type="text" name="search" placeholder="Search tasks..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                       
                <select name="priority">
                    <option value="">All Priorities</option>
                    <option value="high" <?php echo $priority === 'high' ? 'selected' : ''; ?>>High</option>
                    <option value="medium" <?php echo $priority === 'medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="low" <?php echo $priority === 'low' ? 'selected' : ''; ?>>Low</option>
                </select>

                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="in_progress" <?php echo $status === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>

                <input type="submit" value="Filter">
                <?php if($search || $priority || $status): ?>
                    <a href="index.php">Clear Filters</a>
                <?php endif; ?>
            </form>
        </section>

        <!-- Results table -->
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                        <td class="priority-<?php echo $task['priority']; ?>">
                            <?php echo htmlspecialchars($task['priority']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>