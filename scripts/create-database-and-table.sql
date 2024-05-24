CREATE DATABASE IF NOT EXISTS `inscripcion`;

USE inscripcion;

CREATE TABLE forms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    mail VARCHAR(255),
    region VARCHAR(255),
    comuna VARCHAR(255)
);

DESCRIBE forms;