CREATE DATABASE loja_virtual;

USE loja_virtual;

CREATE TABLE usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255),
    auth_provider VARCHAR(20) DEFAULT 'email',
    provider_id VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE tokens_recuperacao (
    id INT(11) NOT NULL AUTO_INCREMENT,
    usuario_id INT(11) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    data_expiracao TIMESTAMP NOT NULL,
    utilizado TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);


-- Tabela de categorias de produtos (ex: Computador, Monitor)
CREATE TABLE categorias (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de produtos
CREATE TABLE produtos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    marca VARCHAR(100),
    estoque INT DEFAULT 0,
    imagem_url TEXT,
    categoria_id BIGINT UNSIGNED,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);


-- Tabela de especificações técnicas
CREATE TABLE especificacoes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produto_id BIGINT UNSIGNED NOT NULL,
    chave VARCHAR(100) NOT NULL,
    valor TEXT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);


-- Tabela de avaliações de produtos
CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,
    produto_id BIGINT UNSIGNED REFERENCES produtos(id) ON DELETE CASCADE,
    nome_usuario VARCHAR(100),
    nota INT CHECK (nota >= 1 AND nota <= 5),
    comentario TEXT,
    data_avaliacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Tabela de filtros (como marcas ou características para buscas)
CREATE TABLE filtros (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Relacionamento entre produtos e filtros (ex: Produto X tem "RTX 3060")
CREATE TABLE produto_filtro (
    produto_id BIGINT UNSIGNED,
    filtro_id BIGINT UNSIGNED,
    PRIMARY KEY (produto_id, filtro_id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (filtro_id) REFERENCES filtros(id) ON DELETE CASCADE
) ENGINE=InnoDB;


---------------------- Exemplo ----------------------

-- Inserir categoria
INSERT INTO categorias (nome) VALUES ('Computador');

-- Inserir produto
INSERT INTO produtos (nome, descricao, preco, marca, estoque, imagem_url, categoria_id)
VALUES (
    'Computador Gamer Dell', 
    'Computador gamer com processador Intel i7, 16GB RAM, 512GB SSD, placa de vídeo NVIDIA RTX 3060.', 
    3999.99, 
    'DELL', 
    10, 
    'imgs_prods/pc.png', 
    (SELECT id FROM categorias WHERE nome = 'Computador')
);

-- Inserir especificações
INSERT INTO especificacoes (produto_id, chave, valor) 
VALUES
    ((SELECT id FROM produtos WHERE nome = 'Computador Gamer XYZ'), 'Processador', 'Intel i7'),
    ((SELECT id FROM produtos WHERE nome = 'Computador Gamer XYZ'), 'Memória RAM', '16GB'),
    ((SELECT id FROM produtos WHERE nome = 'Computador Gamer XYZ'), 'Armazenamento', '512GB SSD'),
    ((SELECT id FROM produtos WHERE nome = 'Computador Gamer XYZ'), 'Placa de Vídeo', 'NVIDIA RTX 3060');

-- Inserir avaliação
INSERT INTO avaliacoes (produto_id, nome_usuario, nota, comentario)
VALUES (
    (SELECT id FROM produtos WHERE nome = 'Computador Gamer XYZ'),
    'João Silva',
    5,
    'Excelente computador, ótimo para jogos!'
);

-- Inserir filtro
INSERT INTO filtros (nome) VALUES ('RTX 3060');

-- Associar produto ao filtro
INSERT INTO produto_filtro (produto_id, filtro_id)
VALUES (
    (SELECT id FROM produtos WHERE nome = 'Computador Gamer XYZ'),
    (SELECT id FROM filtros WHERE nome = 'RTX 3060')
);



