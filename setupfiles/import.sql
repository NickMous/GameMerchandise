CREATE DATABASE merchstore;

USE merchstore;

CREATE TABLE gamemerch (
    naam VARCHAR(100) NOT NULL,
    game VARCHAR(100) NOT NULL,
    prijs FLOAT NOT NULL,
    voorraad INT NOT NULL,
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL
);

USE sdhmerchstore;

CREATE TABLE userdata (
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);