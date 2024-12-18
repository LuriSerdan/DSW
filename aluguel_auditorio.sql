-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/12/2024 às 03:48
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
-- Banco de dados: `aluguel_auditorio`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `login` varchar(30) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`login`, `senha`, `primeiro_acesso`) VALUES
('admin', '123456', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(50) NOT NULL,
  `DATA` date NOT NULL,
  `HORARIO` time NOT NULL,
  `OBS` varchar(200) DEFAULT NULL,
  `STATUS` enum('APROVADO','REPROVADO') DEFAULT NULL,
  `qtd_convidados` int(11) DEFAULT NULL,
  `auditorio` enum('Auditório 1','Auditório 2','Auditório 3') DEFAULT NULL,
  `id_usuario` varchar(11) DEFAULT NULL,
  `mensagem_adm` varchar(500) DEFAULT NULL,
  `STATUS_ATIVO` enum('ATIVO','INATIVO','A CONFIRMAR') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamento`
--

INSERT INTO `agendamento` (`ID`, `TITULO`, `DATA`, `HORARIO`, `OBS`, `STATUS`, `qtd_convidados`, `auditorio`, `id_usuario`, `mensagem_adm`, `STATUS_ATIVO`) VALUES
(0, 'Título', '2025-05-30', '14:30:00', 'Teste OBS', 'APROVADO', 23, 'Auditório 1', '46135893', 'TESTE 3', 'INATIVO'),
(1, 'Título 2', '2027-05-30', '14:45:00', 'Teste 2', 'APROVADO', 31, 'Auditório 3', '1235069870', 'TESTE 1', 'INATIVO'),
(2, 'Novo Agendamento', '2022-12-13', '00:05:00', 'B', 'APROVADO', 55, 'Auditório 3', '2147483647', 'TESTE 2', 'INATIVO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_comum`
--

CREATE TABLE `usuario_comum` (
  `nome` varchar(30) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_comum`
--

INSERT INTO `usuario_comum` (`nome`, `sobrenome`, `cpf`, `telefone`, `email`, `username`, `senha`) VALUES
('janette', 'Capovila', '25698', '19991487402', '', 'janette', '$2y$10$Ci52MajWKTLP5'),
('mariele', 'Capovila', '46135893', '19991487402', '', 'mari', '$2y$10$jNobqAMetzm3B'),
('lucas', 'Capovila', '79842301', '19991487402', '', 'lu', '$2y$10$wysMZVK83PEZB'),
('Joana', 'Capovila', '1235069870', '19991456870', '', 'joana', '$2y$10$uLsQGN6VptHVT'),
('Leticia', 'Capovila', '2147483647', '19991487402', '', 'leticia', '$2y$10$Ui7Y4auQNdd.D'),
('Nicolas', 'Lutero', '47038496824', '19999836350', '', 'Lutero123', '$2y$10$/vB1863Kacn2G72V4Xxfmehakl0lkMXhYzNdjGeaFT.Rkoj8B0tzy');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`login`);

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
