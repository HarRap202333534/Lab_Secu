CREATE DATABASE mydatabase;
USE mydatabase;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO `utilisateurs`(`username`, `password`) 
VALUES ('user_standard','cegep123'),('user_super','cegep123');