-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS loja_informatica
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE loja_informatica;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `adm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100),
  `email` varchar(100) NOT NULL UNIQUE,
  `senha` varchar(255),
  `endereco` varchar(255),
  `numero` varchar(20),
  `bairro` varchar(100),
  `cidade` varchar(100),
  `estado` varchar(2),
  `cep` varchar(10),
  `cpf` varchar(14),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantidade` int(11) DEFAULT NULL,
  `precounitario` float DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `precounitario` float DEFAULT NULL,
  `status` enum('disponivel','esgotado','descontinuado') DEFAULT NULL,
  `fk_adm_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_produtos_2` (`fk_adm_id`),
  CONSTRAINT `FK_produtos_2` FOREIGN KEY (`fk_adm_id`) REFERENCES `adm` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_venda` date DEFAULT NULL,
  `fk_cliente_id` int(11) DEFAULT NULL,
  `fk_adm_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendas_2` (`fk_cliente_id`),
  KEY `FK_vendas_3` (`fk_adm_id`),
  CONSTRAINT `FK_vendas_2` FOREIGN KEY (`fk_cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `FK_vendas_3` FOREIGN KEY (`fk_adm_id`) REFERENCES `adm` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `fazem_parte` (
  `fk_vendas_id` int(11) DEFAULT NULL,
  `fk_itens_venda_id` int(11) DEFAULT NULL,
  KEY `FK_fazem_parte_1` (`fk_vendas_id`),
  KEY `FK_fazem_parte_2` (`fk_itens_venda_id`),
  CONSTRAINT `FK_fazem_parte_1` FOREIGN KEY (`fk_vendas_id`) REFERENCES `vendas` (`id`),
  CONSTRAINT `FK_fazem_parte_2` FOREIGN KEY (`fk_itens_venda_id`) REFERENCES `itens_venda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `possui` (
  `fk_itens_venda_id` int(11) DEFAULT NULL,
  `fk_produtos_id` int(11) DEFAULT NULL,
  KEY `FK_possui_1` (`fk_itens_venda_id`),
  KEY `FK_possui_2` (`fk_produtos_id`),
  CONSTRAINT `FK_possui_1` FOREIGN KEY (`fk_itens_venda_id`) REFERENCES `itens_venda` (`id`),
  CONSTRAINT `FK_possui_2` FOREIGN KEY (`fk_produtos_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mensagem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `assunto` enum('orçamento','duvida','reclamacao','elogio') DEFAULT NULL,
  `servico` enum('notebook','desktop','internet','outro') DEFAULT NULL,
  `mensagem` varchar(255) DEFAULT NULL,
  `fk_cliente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mensagem_2` (`fk_cliente_id`),
  CONSTRAINT `FK_mensagem_2` FOREIGN KEY (`fk_cliente_id`) REFERENCES `cliente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
