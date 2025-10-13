-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/10/2025 às 17:56
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_informatica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adm`
--

CREATE TABLE `adm` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id`, `email`, `senha`, `endereco`, `numero`, `bairro`, `cep`, `cpf`) VALUES
(1, 'xaulinmatadordeporco@gmail.com', 'ramdamdamdamda', '', '', '', '13606317', ''),
(2, 'xaulinmatadordeporco@gmail.com', 'ramdamdamdamda', 'Rua do seu zé', '7089', 'Aspirigueta', '13606317', '12345678901'),
(3, 'Pedroexemplo@gmail.com', 'Brendonostoso', 'Rua de teste', '512', 'Parque industrial', '13660412', '12345678901'),
(4, 'Pedroexemplo@gmail.com', 'Brendonostoso', 'Rua de teste', '512', 'Parque industrial', '13660412', '12345678901'),
(5, 'Galheguimfofo@gmail.com', '12345', 'Rua do Gilberto Azevedo ', '512', 'Limoeiro', '13606512', '15234743456'),
(6, 'rafaelcerqueira2505@gmail.com', 'rasadasda', 'Rua do Eletricista Casa Nº 592', '592', 'José ometto 1', '13606 - ', '41252341623412');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fazem_parte`
--

CREATE TABLE `fazem_parte` (
  `fk_vendas_id` int(11) DEFAULT NULL,
  `fk_itens_venda_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `precounitario` float DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `assunto` enum('orçamento','duvida','reclamacao','elogio') DEFAULT NULL,
  `servico` enum('notebook','desktop','internet','outro') DEFAULT NULL,
  `mensagem` varchar(255) DEFAULT NULL,
  `fk_cliente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `possui`
--

CREATE TABLE `possui` (
  `fk_itens_venda_id` int(11) DEFAULT NULL,
  `fk_produtos_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome_produto` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `precounitario` float DEFAULT NULL,
  `status` enum('disponivel','esgotado','descontinuado') DEFAULT NULL,
  `fk_adm_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `data_venda` date DEFAULT NULL,
  `fk_cliente_id` int(11) DEFAULT NULL,
  `fk_adm_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fazem_parte`
--
ALTER TABLE `fazem_parte`
  ADD KEY `FK_fazem_parte_1` (`fk_vendas_id`),
  ADD KEY `FK_fazem_parte_2` (`fk_itens_venda_id`);

--
-- Índices de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mensagem_2` (`fk_cliente_id`);

--
-- Índices de tabela `possui`
--
ALTER TABLE `possui`
  ADD KEY `FK_possui_1` (`fk_itens_venda_id`),
  ADD KEY `FK_possui_2` (`fk_produtos_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_produtos_2` (`fk_adm_id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_vendas_2` (`fk_cliente_id`),
  ADD KEY `FK_vendas_3` (`fk_adm_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `fazem_parte`
--
ALTER TABLE `fazem_parte`
  ADD CONSTRAINT `FK_fazem_parte_1` FOREIGN KEY (`fk_vendas_id`) REFERENCES `vendas` (`id`),
  ADD CONSTRAINT `FK_fazem_parte_2` FOREIGN KEY (`fk_itens_venda_id`) REFERENCES `itens_venda` (`id`);

--
-- Restrições para tabelas `mensagem`
--
ALTER TABLE `mensagem`
  ADD CONSTRAINT `FK_mensagem_2` FOREIGN KEY (`fk_cliente_id`) REFERENCES `cliente` (`id`);

--
-- Restrições para tabelas `possui`
--
ALTER TABLE `possui`
  ADD CONSTRAINT `FK_possui_1` FOREIGN KEY (`fk_itens_venda_id`) REFERENCES `itens_venda` (`id`),
  ADD CONSTRAINT `FK_possui_2` FOREIGN KEY (`fk_produtos_id`) REFERENCES `produtos` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `FK_produtos_2` FOREIGN KEY (`fk_adm_id`) REFERENCES `adm` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `FK_vendas_2` FOREIGN KEY (`fk_cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `FK_vendas_3` FOREIGN KEY (`fk_adm_id`) REFERENCES `adm` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
