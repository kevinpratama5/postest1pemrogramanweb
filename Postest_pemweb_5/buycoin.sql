CREATE DATABASE buycoin;

USE buycoin;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    investasi DECIMAL(10, 2) NOT NULL,
    pengalaman ENUM('Pemula', 'Menengah', 'Pakar') NOT NULL
);