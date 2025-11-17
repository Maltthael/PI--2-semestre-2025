-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para loja_informatica
CREATE DATABASE IF NOT EXISTS `loja_informatica` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `loja_informatica`;

-- Copiando estrutura para tabela loja_informatica.adm
CREATE TABLE IF NOT EXISTS `adm` (
  `id_adm` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_adm`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.adm: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela loja_informatica.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.cliente: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela loja_informatica.estoque
CREATE TABLE IF NOT EXISTS `estoque` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `precounitario` float DEFAULT NULL,
  `status` enum('disponivel','esgotado','descontinuado') DEFAULT NULL,
  `fk_adm_id_adm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `FK_estoque_adm` (`fk_adm_id_adm`),
  CONSTRAINT `FK_estoque_adm` FOREIGN KEY (`fk_adm_id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.estoque: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela loja_informatica.itens_venda
CREATE TABLE IF NOT EXISTS `itens_venda` (
  `id_itens_vendas` int(11) NOT NULL AUTO_INCREMENT,
  `quantidade_vendida` int(11) DEFAULT NULL,
  `precounitario_venda` decimal(10,2) DEFAULT NULL,
  `fk_vendas_id_venda` int(11) DEFAULT NULL,
  `fk_estoque_id_estoque` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_itens_vendas`),
  KEY `FK_itens_venda_vendas` (`fk_vendas_id_venda`),
  KEY `FK_itens_venda_estoque` (`fk_estoque_id_estoque`),
  CONSTRAINT `FK_itens_venda_estoque` FOREIGN KEY (`fk_estoque_id_estoque`) REFERENCES `estoque` (`id_produto`),
  CONSTRAINT `FK_itens_venda_vendas` FOREIGN KEY (`fk_vendas_id_venda`) REFERENCES `vendas` (`id_vendas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.itens_venda: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela loja_informatica.ordem_servico
CREATE TABLE IF NOT EXISTS `ordem_servico` (
  `id_ordem` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `acao` enum('excluir','cancelar') DEFAULT NULL,
  `prazo` datetime DEFAULT NULL,
  `fk_cliente_id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ordem`),
  KEY `FK_ordem_servico_cliente` (`fk_cliente_id_cliente`),
  CONSTRAINT `FK_ordem_servico_cliente` FOREIGN KEY (`fk_cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.ordem_servico: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela loja_informatica.relatorio
CREATE TABLE IF NOT EXISTS `relatorio` (
  `id_relatorio` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('pendente','abertos','encerrados') DEFAULT NULL,
  `vendas` varchar(255) DEFAULT NULL,
  `grafico_vendas` varchar(255) DEFAULT NULL,
  `trocas` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_relatorio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.relatorio: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela loja_informatica.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id_vendas` int(11) NOT NULL AUTO_INCREMENT,
  `data_venda` date DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `fk_cliente_id_cliente` int(11) DEFAULT NULL,
  `fk_adm_id_adm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vendas`),
  KEY `FK_vendas_cliente` (`fk_cliente_id_cliente`),
  KEY `FK_vendas_adm` (`fk_adm_id_adm`),
  CONSTRAINT `FK_vendas_adm` FOREIGN KEY (`fk_adm_id_adm`) REFERENCES `adm` (`id_adm`),
  CONSTRAINT `FK_vendas_cliente` FOREIGN KEY (`fk_cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela loja_informatica.vendas: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
