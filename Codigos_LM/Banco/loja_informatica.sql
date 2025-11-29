CREATE DATABASE IF NOT EXISTS `loja_informatica` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `loja_informatica`;

CREATE TABLE IF NOT EXISTS `adm` (
  `id_adm` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_adm`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `adm` (`nome`, `email`, `senha`) VALUES
('Administrador', 'adminLM@gmail.com', 'Admin2025.');

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `nome_categoria` (`nome_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `telefone` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `estoque` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `preco_venda` decimal(10,2) DEFAULT NULL,
  `preco_custo` decimal(10,2) DEFAULT 0.00,
  `status` enum('disponivel','esgotado','descontinuado') DEFAULT NULL,
  `fk_id_categoria` int(11) DEFAULT NULL,
  `fk_adm_id_adm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `FK_estoque_adm` (`fk_adm_id_adm`),
  KEY `fk_estoque_categoria` (`fk_id_categoria`),
  CONSTRAINT `FK_estoque_adm` FOREIGN KEY (`fk_adm_id_adm`) REFERENCES `adm` (`id_adm`),
  CONSTRAINT `fk_estoque_categoria` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categorias` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE IF NOT EXISTS `itens_venda` (
  `id_itens_vendas` int(11) NOT NULL AUTO_INCREMENT,
  `quantidade_vendida` int(11) DEFAULT NULL,
  `precounitario_venda` decimal(10,2) DEFAULT NULL,
  `fk_vendas_id_venda` int(11) DEFAULT NULL,
  `fk_estoque_id_produto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_itens_vendas`),
  KEY `FK_itens_venda_vendas` (`fk_vendas_id_venda`),
  KEY `FK_itens_venda_estoque` (`fk_estoque_id_produto`),
  CONSTRAINT `FK_itens_venda_estoque` FOREIGN KEY (`fk_estoque_id_produto`) REFERENCES `estoque` (`id_produto`),
  CONSTRAINT `FK_itens_venda_vendas` FOREIGN KEY (`fk_vendas_id_venda`) REFERENCES `vendas` (`id_vendas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `ordem_servico` (
  `id_ordem` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `status` enum('aberto','em_andamento','concluido','cancelado') NOT NULL DEFAULT 'aberto',
  `prazo` datetime DEFAULT NULL,
  `fk_cliente_id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ordem`),
  KEY `FK_ordem_servico_cliente` (`fk_cliente_id_cliente`),
  CONSTRAINT `FK_ordem_servico_cliente` FOREIGN KEY (`fk_cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `relatorio` (
  `id_relatorio` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('pendente','abertos','encerrados') DEFAULT NULL,
  `vendas` varchar(255) DEFAULT NULL,
  `grafico_vendas` varchar(255) DEFAULT NULL,
  `trocas` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_relatorio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DELIMITER //
CREATE PROCEDURE `sp_comparativo_custo_venda`()
BEGIN
    SELECT 
        MONTH(v.data_venda) AS mes,
        SUM(e.preco_custo * iv.quantidade_vendida) AS custo_total,
        SUM(iv.precounitario_venda * iv.quantidade_vendida) AS venda_total
    FROM vendas v
    JOIN itens_venda iv 
        ON v.id_vendas = iv.fk_vendas_id_venda
    JOIN estoque e 
        ON iv.fk_estoque_id_produto = e.id_produto
    GROUP BY MONTH(v.data_venda)
    ORDER BY mes ASC;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `sp_status_chamados`()
BEGIN
    SELECT 
        CASE 
            WHEN status = 'aberto' THEN 'abertos'
            WHEN status = 'em_andamento' THEN 'pendente'
            WHEN status = 'concluido' THEN 'encerrados'
            WHEN status = 'cancelado' THEN 'cancelado'
        END AS status,
        COUNT(*) AS qtd
    FROM ordem_servico
    GROUP BY status;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `sp_vendas_por_mes`(
	IN `ano` INT
)
BEGIN
    SELECT 
        MONTH(data_venda) AS mes,
        SUM(valor_total)  AS total
    FROM vendas
    WHERE YEAR(data_venda) = ano
    GROUP BY MONTH(data_venda)
    ORDER BY mes ASC;
END//
DELIMITER ;