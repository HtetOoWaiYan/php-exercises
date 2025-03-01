<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../config.php";

// Get filter values
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$priority = isset($_GET['priority']) ? $_GET['priority'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Get report data
$totalQuery = "SELECT COUNT(*) as total FROM tasks WHERE user_id = ?";
$statement = $connection->prepare($totalQuery);
$statement->execute([$_SESSION['id']]);
$totalResult = $statement->fetch(PDO::FETCH_ASSOC);
$totalTasks = $totalResult['total'];

$completedQuery = "SELECT COUNT(*) as completed FROM tasks WHERE user_id = ? AND status = 'completed'";
$statement = $connection->prepare($completedQuery);
$statement->execute([$_SESSION['id']]);
$completedResult = $statement->fetch(PDO::FETCH_ASSOC);
$completionRate = $totalTasks > 0 ? round(($completedResult['completed'] / $totalTasks) * 100) : 0;

// Build search query
$sql = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$_SESSION['id']];

if ($search) {
    $sql .= " AND (title LIKE ? OR description LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

if ($priority) {
    $sql .= " AND priority = ?";
    $params[] = $priority;
}

if ($status) {
    $sql .= " AND status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";
$statement = $connection->prepare($sql);
$statement->execute($params);
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Dashboard</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            margin-bottom: 20px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .report-card { 
            border: 1px solid #ddd; 
            padding: 20px;
            background: white;
        }
        .completion-rate {
            font-size: 24px;
            color: #4CAF50;
        }
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
        }
        th, td { 
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .priority-high { color: #f44336; }
        .priority-medium { color: #ff9800; }
        .priority-low { color: #4CAF50; }
        .actions { 
            display: flex; 
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #4CAF50; color: white; }
        .btn-logout { background: #f44336; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Todo Dashboard</h1>
        <div class="actions">
            <a href="task_form.php" class="btn btn-primary">New Task</a>
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </div>

    <div class="grid-container">
        <div class="report-card">
            <div class="report-title">Total Tasks</div>
            <div><?php echo $totalTasks; ?></div>
        </div>
        <div class="report-card">
            <div class="report-title">Completion Rate</div>
            <div class="completion-rate"><?php echo $completionRate; ?>%</div>
        </div>
    </div>

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

            <input type="submit" value="Filter" class="btn btn-primary">
            <?php if($search || $priority || $status): ?>
                <a href="dashboard.php">Clear Filters</a>
            <?php endif; ?>
        </form>
    </section>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['description']); ?></td>
                <td class="priority-<?php echo $task['priority']; ?>">
                    <?php echo ucfirst($task['priority']); ?>
                </td>
                <td><?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?></td>
                <td class="actions">
                    <a href="task_form.php?id=<?php echo $task['id']; ?>" 
                       class="btn btn-primary">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>