CREATE DATABASE GODeyeDB;

USE GODeyeDB;

CREATE TABLE user_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    latitude DECIMAL(10, 6),
    longitude DECIMAL(10, 6),
    last_online TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO user_logs (username, ip_address, latitude, longitude) 
VALUES 
('CarlosFarias', '192.168.1.10', -23.550520, -46.633308),
('UsuarioTeste', '203.0.113.42', 37.774929, -122.419416),
('Anonimo123', '8.8.8.8', 40.712776, -74.005974);

UPDATE user_logs SET last_online = NOW() WHERE username = 'CarlosFarias';
UPDATE user_logs SET ip_address = '::1' WHERE username = 'CarlosFarias';

UPDATE user_logs SET latitude = ?,longitude = ?, last_online = NOW() WHERE username = 'CarlosFarias';