CREATE SCHEMA IF NOT EXISTS `axey_db`;

USE `axey_db`;

CREATE TABLE Avaliacoes (
    `idAvaliacao` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `pontualidade` INT NOT NULL,
    `qualidade_servico` INT NOT NULL,
    `observacao` VARCHAR(255),
    `create_avalicao` TIMESTAMP,
    `altera_avalicao` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Planos (
    `idPlano` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `preco_planos` DECIMAL(10, 2) NOT NULL,
    `quantidade_fotos` VARCHAR(4),
    `quantidade_video` VARCHAR(4),
    `data_assinatura` TIMESTAMP,
    `data_altera_assinatura` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Prestadores (
    `idVendedor` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Avaliacoes_idAvaliacao` INT NOT NULL,
    `Enderecos_idEndereco` INT NOT NULL,
    `Planos_idPlano` INT NOT NULL,
    `nome_resp_legal` VARCHAR(100) NOT NULL,
    `nome_fantasia` VARCHAR(100) NOT NULL,
    `razao_social` VARCHAR(255) NOT NULL,
    `cpnj` VARCHAR(15) NOT NULL,
    `descricao_negocio` LONGTEXT NOT NULL,
    `cpf_prestadores` VARCHAR(11) NOT NULL,
    `email_prestadores` VARCHAR(145) NOT NULL,
    `senha_prestadores` VARCHAR(255) NOT NULL,
    `celular` VARCHAR(14) NOT NULL,
    `telefone` VARCHAR(14),
    `create_prestadores` TIMESTAMP,
    `altera_prestadores` TIMESTAMP,
    `data_inativacao` TIMESTAMP,
    FOREIGN KEY (Avaliacoes_idAvaliacao) REFERENCES Avaliacoes (idAvaliacao),
    FOREIGN KEY (Planos_idPlano) REFERENCES Planos (idPlano)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Enderecos (
    `idEndereco` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uf` CHAR(2) NOT NULL,
    `cidade` VARCHAR(45) NOT NULL,
    `bairro` VARCHAR(100) NOT NULL,
    `rua` VARCHAR(100) NOT NULL,
    `numero` INT(10) NOT NULL,
    `complemento` VARCHAR(255),
    `cep` VARCHAR(8),
    `logradouro` VARCHAR(145) NOT NULL,
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Clientes (
    `idCliente` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `create_clientes` TIMESTAMP NULL,
    `nome_cliente` VARCHAR(100) NOT NULL,
    `nome_social` VARCHAR(100) NOT NULL,
    `data_nascimento` TIMESTAMP NOT NULL,
    `email` VARCHAR(145) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `Enderecos_idEndereco` INT NOT NULL,
    `celular` VARCHAR(14) NOT NULL,
    `telefone` VARCHAR(14),
    `altera_clientes` TIMESTAMP,
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Categorias (
    `idCategoria` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `titulo_categoria` VARCHAR(100) NOT NULL,
    `descricao_categoria` LONGTEXT NOT NULL,
    `create_categoria` TIMESTAMP,
    `altera_categoria` TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Produtos (
    `idProduto` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Vendedores_idVendedor` INT NOT NULL,
    `Categorias_idCategoria` INT NOT NULL,
    `nome_produto` VARCHAR(130) NOT NULL,
    `valor_produto` VARCHAR(9) NOT NULL,
    `descricao_produto` VARCHAR(255) NOT NULL,
    `imagem_produto` LONGTEXT NOT NULL,
    `video_produto` LONGTEXT NOT NULL,
    `preco_produto` DECIMAL(10, 2) NOT NULL,
    `alter_TIMESTAMP` TIMESTAMP,
    `create_TIMESTAMP` TIMESTAMP,
    FOREIGN KEY (Vendedores_idVendedor) REFERENCES Prestadores (idVendedor),
    FOREIGN KEY (Categorias_idCategoria) REFERENCES Categorias (idCategoria)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Usuarios (
    `idUsuarios` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tipos_usuario` VARCHAR(1) NULL,
    `nome_usuario` VARCHAR(100) NOT NULL,
    `email_usuario` VARCHAR(45) NOT NULL,
    `cpf` VARCHAR(16) NOT NULL,
    `imagem_adm` LONGTEXT NULL,
    `celular` VARCHAR(11) NOT NULL,
    `telefone` VARCHAR(11),
    `create_usuario` TIMESTAMP,
    `altera_usuario` TIMESTAMP,
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE Agendas (
    `idAgenda` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Clientes_idCliente` INT NOT NULL,
    `Prestadores_idVendedor` INT NOT NULL,
    `Prestadores_Avaliacoes_idAvaliacao` INT NOT NULL,
    `Prestadores_Enderecos_idEndereco` INT NOT NULL,
    `titulo` VARCHAR(255) NOT NULL,
    `data_Agenda` TIMESTAMP NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_final` TIME NOT NULL,
    `data_create_Agenda` TIMESTAMP,
    `data_altera_Agenda` TIMESTAMP,
    FOREIGN KEY (Clientes_idCliente) REFERENCES Clientes (idCliente),
    FOREIGN KEY (
        Prestadores_idVendedor,
        Prestadores_Avaliacoes_idAvaliacao,
        Prestadores_Enderecos_idEndereco
    ) REFERENCES Prestadores (
        idVendedor,
        Avaliacoes_idAvaliacao,
        Enderecos_idEndereco
    )
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;