CREATE DATABASE sistema_login;

USE sistema_login;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    cpf VARCHAR(14) UNIQUE,
    rg VARCHAR(20) UNIQUE,
    celular VARCHAR(20),
    senha VARCHAR(255)
);
