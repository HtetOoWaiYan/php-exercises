-- Only run this if you want to reset the database
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS users;

-- Complete schema for the final todo application
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Add a test user (password: password123)
INSERT INTO users (username, password) VALUES 
('testuser', '$2y$10$uOo6D3NUrentL/FFv2GAPuvd9.pSZxYX/SOYjTW/1UnzilI9HDkLa');

-- Add sample tasks with dates for reporting
INSERT INTO tasks (user_id, title, description, priority, status, completed_at) VALUES 
(1, 'Complete PHP assignment', 'Finish the search exercise', 'high', 'pending', NULL),
(1, 'Review PHP syntax', 'Go through basic PHP concepts', 'medium', 'completed', '2025-01-20 10:00:00'),
(1, 'Practice MySQL queries', 'Work on SELECT and WHERE clauses', 'medium', 'pending', NULL),
(1, 'Buy groceries', 'Milk, eggs, bread', 'low', 'pending', NULL),
(1, 'Call doctor', 'Schedule annual checkup', 'high', 'pending', NULL),
(1, 'Fix login bug', 'Debug the authentication issue', 'high', 'in_progress', NULL),
(1, 'Plan vacation', 'Research destinations and budget', 'medium', 'pending', NULL),
(1, 'Read a book', 'Finish reading the current novel', 'low', 'completed', '2025-02-25 15:30:00');
