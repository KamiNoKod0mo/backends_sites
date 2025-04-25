CREATE DATABASE CursoDB;
USE CursoDB;

CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    img VARCHAR(255) NOT NULL,
    total_aulas INT NOT NULL,
    aulas_concluidas INT NOT NULL,
    modulos JSON NOT NULL
);

-- Exemplo de inserção de um curso
INSERT INTO cursos (titulo, img,total_aulas, aulas_concluidas, modulos) 
VALUES (
    'Segurança Cibernética', 
    '/cursos/Seguranca_Cibernetica/cover-seguranca.png',
    4, 
    1, 
    '[
        {"modulo": "Introdução", "aulas": [
            {"nome": "Conceitos básicos", "endereco": "/cursos/Seguranca_Cibernetica/Introducao/aula1.mp4"},
            {"nome": "História da segurança", "endereco": "/cursos/Seguranca_Cibernetica/Introducao/aula2.mp4"}
        ]},
        {"modulo": "Ataques e Defesas", "aulas": [
            {"nome": "Tipos de ataques", "endereco": "/cursos/Seguranca_Cibernetica/Ataque_e_Defesa/aula1.mp4"},
            {"nome": "Proteção de sistemas", "endereco": "/cursos/Seguranca_Cibernetica/Ataque_e_Defesa/aula2.mp4"}
        ]}
    ]'
);


INSERT INTO cursos (titulo, img,total_aulas, aulas_concluidas, modulos) 
VALUES (
    'Marketing Digital', 
    '/cursos/Marketing_Digital/cover-marketing.png',
    7, 
    1, 
    '[
        {"modulo": "Introdução", "aulas": [
            {"nome": "Conceitos básicos", "endereco": "/cursos/Marketing_Digital/Introducao/aula1.mp4"},
            {"nome": "História do Marketing", "endereco": "/cursos/Marketing_Digital/Introducao/aula2.mp4"}
        ]},
        {"modulo": "Branding", "aulas": [
            {"nome": "Marca", "endereco": "/cursos/Marketing_Digital/Branding/aula1.mp4"},
            {"nome": "Nome", "endereco": "/cursos/Marketing_Digital/Branding/aula2.mp4"},
            {"nome": "Como captar Cleintes", "endereco": "/cursos/Marketing_Digital/Branding/aula1.mp4"},
            {"nome": "Tipos de empresas", "endereco": "/cursos/Marketing_Digital/Branding/aula1.mp4"}
        ]},
        {"modulo": "Redes sociais", "aulas": [
            {"nome": "Contruindo uma pagina", "endereco": "/cursos/Marketing_Digital/Introducao/aula1.mp4"}
        ]}
    ]'
);

INSERT INTO cursos (titulo, img,total_aulas, aulas_concluidas, modulos) 
VALUES (
    'Curso de PHP completo', 
    '/cursos/Curso_de_PHP_completo/cover-php.png',
    6, 
    1, 
    '[
        {"modulo": "Introdução", "aulas": [
            {"nome": "Conceitos básicos", "endereco": "/cursos/Curso_de_PHP_completo/Introducao/aula1.mp4"},
            {"nome": "História do Marketing", "endereco": "/cursos/Curso_de_PHP_completo/Introducao/aula2.mp4"}
        ]},
        {"modulo": "Iniciante", "aulas": [
            {"nome": "Sintaxe", "endereco": "/cursos/Curso_de_PHP_completo/Iniciante/aula1.mp4"},
            {"nome": "Variaveis", "endereco": "/cursos/Curso_de_PHP_completo/Iniciante/aula2.mp4"}
        ]},
        {"modulo": "Intermediario", "aulas": [
            {"nome": "Funções", "endereco": "/cursos/Curso_de_PHP_completo/Intermediario/aula1.mp4"},
            {"nome": "Contruindo uma pagina", "endereco": "/cursos/Curso_de_PHP_completo/Intermediario/aula1.mp4"}
        ]}
    ]'
);