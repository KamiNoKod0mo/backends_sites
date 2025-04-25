-- Criação do banco de dados
CREATE DATABASE tarefas_db;

-- Selecionar o banco de dados
USE tarefas_db;

-- Criação da tabela 'usuario'
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Criação da tabela 'tasks'
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    a_fazer JSON DEFAULT '[]',
    fazendo JSON DEFAULT '[]',
    feito JSON DEFAULT '[]',
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);
