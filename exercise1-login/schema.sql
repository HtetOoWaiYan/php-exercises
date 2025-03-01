CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add a test user (password: password123)
INSERT INTO users (username, password) VALUES 
('testuser', '$2y$10$uOo6D3NUrentL/FFv2GAPuvd9.pSZxYX/SOYjTW/1UnzilI9HDkLa');