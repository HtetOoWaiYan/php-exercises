-- Only run this if you want to reset the database
DROP TABLE IF EXISTS tasks;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add sample tasks with categories
INSERT INTO tasks (title, description, priority, status) VALUES 
('Complete PHP assignment', 'Finish the search exercise', 'high', 'pending'),
('Review PHP syntax', 'Go through basic PHP concepts', 'medium', 'completed'),
('Practice MySQL queries', 'Work on SELECT and WHERE clauses', 'medium', 'pending'),
('Buy groceries', 'Milk, eggs, bread', 'low', 'pending'),
('Call doctor', 'Schedule annual checkup', 'high', 'pending'),
('Fix login bug', 'Debug the authentication issue', 'high', 'in_progress'),
('Plan vacation', 'Research destinations and budget', 'medium', 'pending'),
('Read a book', 'Finish reading the current novel', 'low', 'completed');