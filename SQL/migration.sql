-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 21/11/2024 às 21:42
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `axeyfu72_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Agendamentos`
--

CREATE TABLE `Agendamentos` (
  `agendamento_id` int(11) NOT NULL,
  `avaliacao` int(11) DEFAULT NULL,
  `id_agendas` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `data_agenda` date NOT NULL,
  `hora_prestacao` time NOT NULL,
  `servico_descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Agendas`
--

CREATE TABLE `Agendas` (
  `agenda_id` int(11) NOT NULL,
  `prestador` int(11) NOT NULL,
  `data_agenda` date NOT NULL,
  `data_final` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Avaliacoes`
--

CREATE TABLE `Avaliacoes` (
  `avaliacao_id` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `agendamento` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `comentario` text,
  `prestador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Banners`
--

CREATE TABLE `Banners` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `legenda` varchar(255) NOT NULL,
  `data_inicial` date NOT NULL,
  `data_final` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Categorias`
--

CREATE TABLE `Categorias` (
  `categoria_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `titulo_categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_categoria` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Clientes`
--

CREATE TABLE `Clientes` (
  `cliente_id` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `nome_social` varchar(100) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(145) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `celular` varchar(15) NOT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `cep` varchar(9) NOT NULL,
  `uf` char(2) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(80) DEFAULT NULL,
  `logradouro` varchar(145) NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token_temp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Documentos`
--

CREATE TABLE `Documentos` (
  `id` int(11) NOT NULL,
  `nome_documento` varchar(255) NOT NULL,
  `data_atualizacao` date NOT NULL,
  `caminho_arquivo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `LinksUteis`
--

CREATE TABLE `LinksUteis` (
  `link_id` int(11) NOT NULL,
  `titulo_link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_link` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Planos`
--

CREATE TABLE `Planos` (
  `plano_id` int(11) NOT NULL,
  `plano_preco` decimal(10,2) NOT NULL,
  `quantidade_anuncios` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade_destaques` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_pagamento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Prestadores`
--

CREATE TABLE `Prestadores` (
  `prestador_id` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `cliente` int(11) DEFAULT NULL,
  `plano` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `nome_social` varchar(100) DEFAULT NULL,
  `nome_resp_legal` varchar(100) DEFAULT NULL,
  `nome_fantasia` varchar(100) DEFAULT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `categoria` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(145) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `celular` varchar(15) NOT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `cep` varchar(9) NOT NULL,
  `uf` char(2) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(80) DEFAULT NULL,
  `logradouro` varchar(145) NOT NULL,
  `agenda` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '3',
  `url_foto` varchar(250) DEFAULT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token_temp` varchar(255) DEFAULT NULL,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inativacao` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Produtos`
--

CREATE TABLE `Produtos` (
  `produto_id` int(11) NOT NULL,
  `prestador` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `tipo_produto` int(1) NOT NULL,
  `status_destaque` int(1) NOT NULL DEFAULT '1',
  `nome_produto` varchar(130) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_produto` decimal(10,2) DEFAULT NULL,
  `descricao_produto` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo_recusa` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem_produto` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_produto` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `UsuariosAdm`
--

CREATE TABLE `UsuariosAdm` (
  `usuarioAdm_id` int(11) NOT NULL,
  `tipo_usuario` varchar(15) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '1',
  `nome` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf` varchar(11) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `logradouro` varchar(145) DEFAULT NULL,
  `token_temp` varchar(255) NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Agendamentos`
--
ALTER TABLE `Agendamentos`
  ADD PRIMARY KEY (`agendamento_id`),
  ADD KEY `produto` (`produto`),
  ADD KEY `cliente` (`cliente`);

--
-- Índices de tabela `Agendas`
--
ALTER TABLE `Agendas`
  ADD PRIMARY KEY (`agenda_id`),
  ADD KEY `prestador` (`prestador`) USING BTREE;

--
-- Índices de tabela `Avaliacoes`
--
ALTER TABLE `Avaliacoes`
  ADD PRIMARY KEY (`avaliacao_id`),
  ADD KEY `produto` (`produto`),
  ADD KEY `agendamento` (`agendamento`),
  ADD KEY `fk_prestador` (`prestador`);

--
-- Índices de tabela `Banners`
--
ALTER TABLE `Banners`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `Categorias`
--
ALTER TABLE `Categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Índices de tabela `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`cliente_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `Documentos`
--
ALTER TABLE `Documentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `LinksUteis`
--
ALTER TABLE `LinksUteis`
  ADD PRIMARY KEY (`link_id`);

--
-- Índices de tabela `Planos`
--
ALTER TABLE `Planos`
  ADD PRIMARY KEY (`plano_id`);

--
-- Índices de tabela `Prestadores`
--
ALTER TABLE `Prestadores`
  ADD PRIMARY KEY (`prestador_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `cliente` (`cliente`),
  ADD KEY `plano` (`plano`),
  ADD KEY `agenda` (`agenda`) USING BTREE,
  ADD KEY `categoria` (`categoria`) USING BTREE;

--
-- Índices de tabela `Produtos`
--
ALTER TABLE `Produtos`
  ADD PRIMARY KEY (`produto_id`),
  ADD KEY `prestador` (`prestador`),
  ADD KEY `categoria` (`categoria`);

--
-- Índices de tabela `UsuariosAdm`
--
ALTER TABLE `UsuariosAdm`
  ADD PRIMARY KEY (`usuarioAdm_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Agendamentos`
--
ALTER TABLE `Agendamentos`
  MODIFY `agendamento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Agendas`
--
ALTER TABLE `Agendas`
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Avaliacoes`
--
ALTER TABLE `Avaliacoes`
  MODIFY `avaliacao_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Banners`
--
ALTER TABLE `Banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Categorias`
--
ALTER TABLE `Categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Documentos`
--
ALTER TABLE `Documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `LinksUteis`
--
ALTER TABLE `LinksUteis`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Planos`
--
ALTER TABLE `Planos`
  MODIFY `plano_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Prestadores`
--
ALTER TABLE `Prestadores`
  MODIFY `prestador_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Produtos`
--
ALTER TABLE `Produtos`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `UsuariosAdm`
--
ALTER TABLE `UsuariosAdm`
  MODIFY `usuarioAdm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Agendamentos`
--
ALTER TABLE `Agendamentos`
  ADD CONSTRAINT `Agendamentos_ibfk_1` FOREIGN KEY (`produto`) REFERENCES `Produtos` (`produto_id`),
  ADD CONSTRAINT `Agendamentos_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `Clientes` (`cliente_id`);

--
-- Restrições para tabelas `Avaliacoes`
--
ALTER TABLE `Avaliacoes`
  ADD CONSTRAINT `Avaliacoes_ibfk_1` FOREIGN KEY (`produto`) REFERENCES `Produtos` (`produto_id`),
  ADD CONSTRAINT `Avaliacoes_ibfk_2` FOREIGN KEY (`agendamento`) REFERENCES `Agendamentos` (`agendamento_id`),
  ADD CONSTRAINT `fk_prestador` FOREIGN KEY (`prestador`) REFERENCES `Prestadores` (`prestador_id`);

--
-- Restrições para tabelas `Prestadores`
--
ALTER TABLE `Prestadores`
  ADD CONSTRAINT `Prestadores_ibfk_1` FOREIGN KEY (`agenda`) REFERENCES `Agendas` (`agenda_id`),
  ADD CONSTRAINT `Prestadores_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `Clientes` (`cliente_id`),
  ADD CONSTRAINT `Prestadores_ibfk_3` FOREIGN KEY (`plano`) REFERENCES `Planos` (`plano_id`);

--
-- Restrições para tabelas `Produtos`
--
ALTER TABLE `Produtos`
  ADD CONSTRAINT `Produtos_ibfk_1` FOREIGN KEY (`prestador`) REFERENCES `Prestadores` (`prestador_id`),
  ADD CONSTRAINT `Produtos_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `Categorias` (`categoria_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
