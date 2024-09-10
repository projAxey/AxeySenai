USE `axeyfu72_db`;

CREATE TABLE Agendas (
    `agenda_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `data_agenda` DATE NOT NULL,
    `dia_semana` TINYINT NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_final` TIME NOT NULL,
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Clientes (
    `cliente_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cpf` VARCHAR(11) NOT NULL, 
    `nome` VARCHAR(100) NOT NULL,
    `nome_social` VARCHAR(100) NULL,
    `data_nascimento` DATE NOT NULL,
    `email` VARCHAR(145) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `celular` VARCHAR(11) NOT NULL,
    `telefone` VARCHAR(10) NULL,
    `status` TINYINT(1),
    `cep` VARCHAR(8) NOT NULL,
    `uf` CHAR(2) NOT NULL,
    `cidade` VARCHAR(45) NOT NULL,
    `bairro` VARCHAR(100) NOT NULL,
    `numero` VARCHAR(20) NOT NULL,
    `complemento` VARCHAR(80) NULL,
    `logradouro` VARCHAR(145) NOT NULL,
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Planos (
    `plano_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `plano_preco` DECIMAL(10, 2) NOT NULL,
    `quantidade_anuncios` VARCHAR(4) NOT NULL,
    `quantidade_destaques` VARCHAR(4) NOT NULL,
    `descricao` LONGTEXT NOT NULL,
    `tipo_pagamento` VARCHAR(255),
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Categorias (
    `categoria_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `titulo_categoria` VARCHAR(100) NOT NULL,
    `descricao_categoria` LONGTEXT NOT NULL,
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Usuarios (
    `usuario_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tipo_usuario` VARCHAR(1) NOT NULL,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `celular` VARCHAR(11) NOT NULL,
    `telefone` VARCHAR(11),
    `cep` VARCHAR(8) NOT NULL,
    `uf` CHAR(2) NOT NULL,
    `cidade` VARCHAR(45) NOT NULL,
    `bairro` VARCHAR(100) NOT NULL,
    `rua` VARCHAR(100) NOT NULL,
    `numero` VARCHAR(20) NOT NULL,
    `complemento` VARCHAR(255) NULL,
    `logradouro` VARCHAR(145) NOT NULL,
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Prestadores (
    `prestador_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cliente` INT NULL,
    `plano` INT NOT NULL,
    `nome_resp_legal` VARCHAR(100) NULL,
    `nome_fantasia` VARCHAR(100) NULL,
    `razao_social` VARCHAR(255) NULL,
    `data_nascimento` DATE NULL,
    `cpnj` VARCHAR(14) NULL,
    `cpf` VARCHAR(11) NULL,
    `email` VARCHAR(145) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `celular` VARCHAR(14) NOT NULL,
    `telefone` VARCHAR(14) NULL,
    `cep` VARCHAR(8) NOT NULL,
    `uf` CHAR(2) NOT NULL,
    `cidade` VARCHAR(45) NOT NULL,
    `bairro` VARCHAR(100) NOT NULL,
    `numero` VARCHAR(20) NOT NULL,
    `complemento` VARCHAR(80) NULL,
    `logradouro` VARCHAR(145) NOT NULL,
    `agenda` INT NOT NULL,
    `status` TINYINT(1),
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP,
    `inativacao` TIMESTAMP,
    FOREIGN KEY (`agenda`) REFERENCES Agendas(`agenda_id`),
    FOREIGN KEY (`cliente`) REFERENCES Clientes(`cliente_id`),
    FOREIGN KEY (`plano`) REFERENCES Planos(`plano_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Produtos (
    `produto_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `prestador` INT NOT NULL,
    `categoria` INT NOT NULL,
    `nome_produto` VARCHAR(130) NOT NULL,
    `valor_produto` DECIMAL(10, 2) NOT NULL,
    `descricao_produto` VARCHAR(255) NOT NULL,
    `imagem_produto` LONGTEXT NOT NULL,
    `video_produto` LONGTEXT NULL,
    `status` TINYINT(1),
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP,
    FOREIGN KEY (`prestador`) REFERENCES Prestadores(`prestador_id`),
    FOREIGN KEY (`categoria`) REFERENCES Categorias(`categoria_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE OrdemServicos (
    `servico_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `produto` INT NOT NULL,
    `cliente` INT NOT NULL,
    `data_agenda` DATE NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_final` TIME NOT NULL,
    `status` TINYINT(1),
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP,
    FOREIGN KEY (`produto`) REFERENCES Produtos(`produto_id`),
    FOREIGN KEY (`cliente`) REFERENCES Clientes(`cliente_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Agendamentos (
    `agendamento_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `produto` INT NOT NULL,
    `cliente` INT NOT NULL,
    `data_agenda` DATE NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_final` TIME NOT NULL,
    `status` TINYINT(1),
    `criacao` TIMESTAMP,
    `alteracao` TIMESTAMP,
    FOREIGN KEY (`produto`) REFERENCES Produtos(`produto_id`),
    FOREIGN KEY (`cliente`) REFERENCES Clientes(`cliente_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Avaliacoes (
    `avaliacao_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `servico` INT NOT NULL,
    `cliente` INT NOT NULL,
    `descricao` VARCHAR(130) NOT NULL,
    `nota` INT NOT NULL,
    `observacao` VARCHAR(255),
    `criacao` TIMESTAMP,
    FOREIGN KEY (`servico`) REFERENCES OrdemServicos(`servico_id`),
    FOREIGN KEY (`cliente`) REFERENCES Clientes(`cliente_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;