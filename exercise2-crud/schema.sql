-- Only run DROP if you want to reset the database
DROP TABLE IF EXISTS tasks;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add sample tasks
INSERT INTO tasks (title, description, status) VALUES 
('Complete homework', 'Finish math assignment', 'pending'),
('Buy groceries', 'Milk, eggs, bread', 'completed'),
('Call dentist', 'Schedule annual checkup', 'pending');