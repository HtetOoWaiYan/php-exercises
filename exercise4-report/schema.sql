-- Only run DROP if you want to reset the database
DROP TABLE IF EXISTS tasks;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add sample tasks with dates for reporting
INSERT INTO tasks (title, description, priority, status, completed_at) VALUES 
('Complete PHP assignment', 'Finish the search exercise', 'high', 'pending', NULL),
('Review PHP syntax', 'Go through basic PHP concepts', 'medium', 'completed', '2025-01-20 10:00:00'),
('Practice MySQL queries', 'Work on SELECT and WHERE clauses', 'medium', 'pending', NULL),
('Buy groceries', 'Milk, eggs, bread', 'low', 'pending', NULL),
('Call doctor', 'Schedule annual checkup', 'high', 'pending', NULL),
('Fix login bug', 'Debug the authentication issue', 'high', 'in_progress', NULL),
('Plan vacation', 'Research destinations and budget', 'medium', 'pending', NULL),
('Read a book', 'Finish reading the current novel', 'low', 'completed', '2025-02-25 15:30:00');