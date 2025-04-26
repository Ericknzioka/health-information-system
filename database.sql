CREATE DATABASE IF NOT EXISTS health_system;
USE health_system;

-- Clients table
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Programs table
CREATE TABLE programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    program_name VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Enrollments table (many-to-many relationship)
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    program_id INT,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE
);
