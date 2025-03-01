<?php
// Include database configuration
require_once "../config.php";

// Get total tasks count
$totalQuery = "SELECT COUNT(*) as total FROM tasks";
$totalResult = $connection->query($totalQuery)->fetch(PDO::FETCH_ASSOC);
$totalTasks = $totalResult['total'];

// Get completion rate
$completedQuery = "SELECT COUNT(*) as completed FROM tasks WHERE status = 'completed'";
$completedResult = $connection->query($completedQuery)->fetch(PDO::FETCH_ASSOC);
$completionRate = $totalTasks > 0 ? round(($completedResult['completed'] / $totalTasks) * 100) : 0;

// Get tasks by status
$statusQuery = "SELECT status, COUNT(*) as count FROM tasks GROUP BY status";
$statusResult = $connection->query($statusQuery)->fetchAll(PDO::FETCH_ASSOC);

// Get tasks by priority
$priorityQuery = "SELECT priority, COUNT(*) as count FROM tasks GROUP BY priority";
$priorityResult = $connection->query($priorityQuery)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Report</title>
    <style>
        body { 
            font-family: Arial; 
            margin: 40px; 
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .report-card { 
            border: 1px solid #ddd; 
            padding: 20px;
            background: white;
        }
        .report-title { 
            font-weight: bold;
            margin-bottom: 10px;
        }
        .report-list {
            list-style: none;
            padding: 0;
        }
        .report-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .completion-rate {
            font-size: 24px;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>Task Report</h1>

    <div class="grid-container">
        <!-- Total Tasks -->
        <div class="report-card">
            <div class="report-title">Total Tasks</div>
            <div><?php echo $totalTasks; ?></div>
        </div>

        <!-- Completion Rate -->
        <div class="report-card">
            <div class="report-title">Completion Rate</div>
            <div class="completion-rate"><?php echo $completionRate; ?>%</div>
        </div>

        <!-- Tasks by Status -->
        <div class="report-card">
            <div class="report-title">Tasks by Status</div>
            <ul class="report-list">
                <?php foreach($statusResult as $status): ?>
                    <li>
                        <?php echo ucfirst(str_replace('_', ' ', $status['status'])); ?>: 
                        <?php echo $status['count']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tasks by Priority -->
        <div class="report-card">
            <div class="report-title">Tasks by Priority</div>
            <ul class="report-list">
                <?php foreach($priorityResult as $priority): ?>
                    <li>
                        <?php echo ucfirst($priority['priority']); ?>: 
                        <?php echo $priority['count']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>