-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Dez-2024 às 14:41
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `healthsched`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `profissional_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `dia` date NOT NULL,
  `horario` time NOT NULL,
  `status` enum('pendente','confirmado','cancelado') NOT NULL DEFAULT 'pendente',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `profissional_id`, `usuario_id`, `dia`, `horario`, `status`, `data_criacao`) VALUES
(3127, 44, 37, '2024-11-15', '13:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3128, 45, 37, '2024-11-24', '19:00:00', 'pendente', '2024-11-14 20:30:10'),
(3129, 37, 37, '2024-11-19', '17:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3130, 44, 37, '2024-11-15', '10:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3131, 22, 37, '2024-11-29', '15:00:00', 'pendente', '2024-11-14 20:30:10'),
(3132, 37, 38, '2024-11-19', '16:00:00', 'pendente', '2024-11-14 20:30:10'),
(3133, 16, 38, '2024-11-27', '19:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3134, 27, 38, '2024-11-16', '19:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3135, 43, 38, '2024-11-29', '19:00:00', 'pendente', '2024-11-14 20:30:10'),
(3136, 31, 38, '2024-11-12', '17:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3137, 37, 39, '2024-11-19', '13:00:00', 'pendente', '2024-11-14 20:30:10'),
(3138, 23, 39, '2024-11-18', '10:00:00', 'pendente', '2024-11-14 20:30:10'),
(3139, 43, 39, '2024-11-29', '13:00:00', 'pendente', '2024-11-14 20:30:10'),
(3140, 20, 39, '2024-11-25', '16:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3141, 33, 39, '2024-11-18', '19:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3142, 38, 40, '2024-11-29', '20:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3143, 26, 40, '2024-11-27', '15:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3144, 16, 40, '2024-11-27', '10:00:00', 'pendente', '2024-11-14 20:30:10'),
(3145, 31, 40, '2024-11-12', '17:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3146, 22, 40, '2024-11-29', '10:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3147, 20, 41, '2024-11-25', '19:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3148, 42, 41, '2024-11-29', '15:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3149, 45, 41, '2024-11-24', '10:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3150, 23, 41, '2024-11-18', '20:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3151, 44, 41, '2024-11-15', '13:00:00', 'pendente', '2024-11-14 20:30:10'),
(3152, 32, 42, '2024-11-23', '20:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3153, 42, 42, '2024-11-29', '15:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3154, 29, 42, '2024-11-11', '15:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3155, 36, 42, '2024-11-15', '08:00:00', 'pendente', '2024-11-14 20:30:10'),
(3156, 16, 42, '2024-11-27', '20:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3157, 30, 43, '2024-11-16', '10:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3158, 35, 43, '2024-11-27', '18:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3159, 35, 43, '2024-11-27', '17:00:00', 'pendente', '2024-11-14 20:30:10'),
(3160, 34, 43, '2024-11-21', '10:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3161, 23, 43, '2024-11-18', '16:00:00', 'pendente', '2024-11-14 20:30:10'),
(3162, 28, 44, '2024-11-16', '15:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3163, 21, 44, '2024-11-25', '18:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3164, 25, 44, '2024-11-26', '20:00:00', 'pendente', '2024-11-14 20:30:10'),
(3165, 33, 44, '2024-11-18', '10:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3166, 41, 44, '2024-11-19', '19:00:00', 'pendente', '2024-11-14 20:30:10'),
(3167, 37, 45, '2024-11-19', '13:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3168, 43, 45, '2024-11-29', '08:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3169, 20, 45, '2024-11-25', '19:00:00', 'pendente', '2024-11-14 20:30:10'),
(3170, 46, 45, '2024-11-13', '15:00:00', 'pendente', '2024-11-14 20:30:10'),
(3171, 25, 45, '2024-11-26', '16:00:00', 'pendente', '2024-11-14 20:30:10'),
(3177, 30, 47, '2024-11-16', '19:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3178, 38, 47, '2024-11-29', '19:00:00', 'pendente', '2024-11-14 20:30:10'),
(3179, 20, 47, '2024-11-25', '15:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3180, 44, 47, '2024-11-15', '15:00:00', 'pendente', '2024-11-14 20:30:10'),
(3181, 32, 47, '2024-11-23', '19:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3182, 41, 48, '2024-11-19', '20:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3183, 23, 48, '2024-11-18', '16:00:00', 'pendente', '2024-11-14 20:30:10'),
(3184, 38, 48, '2024-11-29', '10:00:00', 'pendente', '2024-11-14 20:30:10'),
(3185, 30, 48, '2024-11-16', '20:00:00', 'pendente', '2024-11-14 20:30:10'),
(3186, 41, 48, '2024-11-19', '18:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3187, 29, 49, '2024-11-11', '15:00:00', 'confirmado', '2024-11-14 20:30:10'),
(3188, 32, 49, '2024-11-23', '13:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3189, 29, 49, '2024-11-11', '20:00:00', 'pendente', '2024-11-14 20:30:10'),
(3190, 45, 49, '2024-11-24', '18:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3191, 35, 49, '2024-11-27', '20:00:00', 'cancelado', '2024-11-14 20:30:10'),
(3192, 36, 51, '2024-11-15', '17:00:00', 'confirmado', '2024-11-14 20:53:17'),
(3194, 28, 51, '2024-11-16', '13:00:00', 'confirmado', '2024-11-14 21:30:25'),
(3196, 21, 39, '2024-11-27', '14:00:00', 'confirmado', '2024-11-27 01:14:02'),
(3197, 16, 56, '2024-11-27', '11:00:00', 'confirmado', '2024-11-27 11:57:06'),
(3198, 23, 56, '2024-11-18', '15:00:00', 'confirmado', '2024-11-27 11:57:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `areas`
--

INSERT INTO `areas` (`id`, `nome`) VALUES
(1, 'Médico'),
(2, 'Odontologia'),
(3, 'Nutricionista'),
(4, 'Fisioterapeuta'),
(5, 'Psicólogo'),
(6, 'Exames');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disponibilidade`
--

CREATE TABLE `disponibilidade` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `tipo` enum('disponivel','indisponivel') NOT NULL DEFAULT 'disponivel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `disponibilidade`
--

INSERT INTO `disponibilidade` (`id`, `data`, `horario`, `tipo`) VALUES
(406, '2024-11-20', '19:30:00', 'disponivel'),
(407, '2024-11-20', '19:00:00', 'disponivel'),
(408, '2024-11-20', '18:30:00', 'disponivel'),
(409, '2024-11-16', '20:00:00', 'disponivel'),
(410, '2024-11-16', '19:30:00', 'disponivel'),
(411, '2024-11-16', '19:00:00', 'disponivel'),
(412, '2024-11-16', '18:30:00', 'disponivel'),
(413, '2024-11-12', '18:00:00', 'disponivel'),
(414, '2024-11-12', '18:30:00', 'disponivel'),
(415, '2024-11-12', '19:00:00', 'disponivel'),
(416, '2024-11-12', '19:30:00', 'disponivel'),
(417, '2024-11-12', '20:00:00', 'disponivel'),
(418, '2024-11-12', '08:00:00', 'disponivel'),
(419, '2024-11-12', '08:30:00', 'disponivel'),
(420, '2024-11-12', '09:00:00', 'disponivel'),
(421, '2024-11-12', '09:30:00', 'disponivel'),
(422, '2024-11-13', '18:30:00', 'disponivel'),
(423, '2024-11-13', '19:00:00', 'disponivel'),
(424, '2024-11-13', '19:30:00', 'disponivel'),
(425, '2024-11-13', '20:00:00', 'disponivel'),
(426, '2024-11-12', '10:00:00', 'disponivel'),
(427, '2024-11-12', '10:30:00', 'disponivel'),
(428, '2024-11-25', '18:30:00', 'disponivel'),
(429, '2024-11-25', '19:00:00', 'disponivel'),
(430, '2024-11-25', '19:30:00', 'disponivel'),
(431, '2024-11-25', '20:00:00', 'disponivel'),
(432, '2024-11-27', '12:00:00', 'disponivel'),
(433, '2024-11-27', '12:30:00', 'disponivel'),
(434, '2024-11-21', '08:00:00', 'disponivel'),
(435, '2024-11-21', '08:30:00', 'disponivel'),
(436, '2024-11-21', '09:00:00', 'disponivel'),
(437, '2024-11-26', '18:00:00', 'disponivel'),
(438, '2024-11-26', '18:30:00', 'disponivel'),
(439, '2024-11-26', '19:00:00', 'disponivel'),
(440, '2024-11-26', '19:30:00', 'disponivel'),
(441, '2024-11-26', '20:00:00', 'disponivel'),
(442, '2024-11-26', '15:45:00', 'disponivel'),
(443, '2024-11-12', '12:30:00', 'disponivel'),
(444, '2024-11-14', '12:00:00', 'disponivel'),
(445, '2024-11-14', '12:30:00', 'disponivel'),
(446, '2024-11-14', '13:00:00', 'disponivel'),
(447, '2024-11-14', '13:30:00', 'disponivel'),
(448, '2024-11-14', '14:00:00', 'disponivel'),
(449, '2024-11-14', '15:30:00', 'disponivel'),
(450, '2024-11-13', '12:30:00', 'disponivel'),
(451, '2024-11-13', '13:00:00', 'disponivel'),
(452, '2024-11-13', '13:30:00', 'disponivel'),
(453, '2024-11-20', '08:00:00', 'disponivel'),
(454, '2024-11-20', '08:30:00', 'disponivel'),
(455, '2024-11-20', '09:00:00', 'disponivel'),
(456, '2024-11-20', '09:30:00', 'disponivel'),
(457, '2024-11-12', '11:00:00', 'disponivel'),
(458, '2024-11-12', '11:30:00', 'disponivel'),
(459, '2024-11-12', '12:00:00', 'disponivel'),
(460, '2024-11-12', '14:30:00', 'disponivel'),
(461, '2024-11-13', '08:00:00', 'disponivel'),
(462, '2024-11-13', '08:30:00', 'disponivel'),
(463, '2024-11-13', '09:00:00', 'disponivel'),
(464, '2024-11-13', '09:30:00', 'disponivel'),
(465, '2024-11-13', '10:00:00', 'disponivel'),
(466, '2024-11-13', '10:30:00', 'disponivel'),
(467, '2024-11-12', '13:00:00', 'disponivel'),
(468, '2024-11-12', '13:30:00', 'disponivel'),
(469, '2024-11-12', '14:00:00', 'disponivel'),
(470, '2024-11-20', '14:00:00', 'disponivel'),
(471, '2024-11-20', '14:30:00', 'disponivel'),
(472, '2024-11-20', '15:00:00', 'disponivel'),
(473, '2024-11-20', '15:30:00', 'disponivel'),
(474, '2024-11-20', '16:00:00', 'disponivel'),
(475, '2024-11-12', '15:00:00', 'disponivel'),
(476, '2024-11-12', '15:30:00', 'disponivel'),
(477, '2024-11-12', '16:00:00', 'disponivel'),
(478, '2024-11-16', '08:00:00', 'disponivel'),
(479, '2024-11-16', '08:30:00', 'disponivel'),
(480, '2024-11-16', '09:00:00', 'disponivel'),
(481, '2024-11-16', '09:30:00', 'disponivel'),
(482, '2024-11-16', '10:00:00', 'disponivel'),
(483, '2024-11-13', '11:00:00', 'disponivel'),
(484, '2024-11-13', '11:30:00', 'disponivel'),
(485, '2024-11-13', '12:00:00', 'disponivel'),
(486, '2024-11-13', '14:00:00', 'disponivel'),
(487, '2024-11-13', '14:30:00', 'disponivel'),
(488, '2024-11-15', '08:00:00', 'disponivel'),
(489, '2024-11-15', '08:30:00', 'disponivel'),
(490, '2024-11-15', '09:00:00', 'disponivel'),
(491, '2024-11-15', '09:30:00', 'disponivel'),
(492, '2024-11-15', '10:00:00', 'disponivel'),
(493, '2024-11-15', '10:30:00', 'disponivel'),
(494, '2024-11-15', '11:00:00', 'disponivel'),
(495, '2024-11-15', '11:30:00', 'disponivel'),
(496, '2024-11-15', '12:00:00', 'disponivel'),
(497, '2024-11-13', '15:00:00', 'disponivel'),
(498, '2024-11-13', '15:30:00', 'disponivel'),
(499, '2024-11-13', '16:00:00', 'disponivel'),
(500, '2024-11-20', '17:30:00', 'disponivel'),
(501, '2024-11-20', '18:00:00', 'disponivel'),
(502, '2024-11-20', '20:00:00', 'disponivel'),
(503, '2024-11-28', '08:00:00', 'disponivel'),
(504, '2024-11-28', '08:30:00', 'disponivel'),
(505, '2024-11-28', '09:00:00', 'disponivel'),
(506, '2024-11-28', '09:30:00', 'disponivel'),
(507, '2024-11-28', '10:00:00', 'disponivel'),
(508, '2024-11-28', '10:30:00', 'disponivel'),
(509, '2024-11-28', '11:00:00', 'disponivel'),
(510, '2024-11-29', '08:30:00', 'disponivel'),
(511, '2024-11-29', '09:00:00', 'disponivel'),
(512, '2024-11-29', '09:30:00', 'disponivel'),
(513, '2024-11-29', '10:00:00', 'disponivel'),
(514, '2024-11-29', '10:30:00', 'disponivel'),
(515, '2024-11-29', '11:00:00', 'disponivel'),
(516, '2024-11-29', '11:30:00', 'disponivel'),
(517, '2024-11-29', '12:00:00', 'disponivel'),
(518, '2024-11-19', '08:00:00', 'disponivel'),
(519, '2024-11-19', '08:30:00', 'disponivel'),
(520, '2024-11-19', '09:00:00', 'disponivel'),
(521, '2024-11-19', '09:30:00', 'disponivel'),
(522, '2024-11-19', '10:00:00', 'disponivel'),
(523, '2024-11-19', '10:30:00', 'disponivel'),
(524, '2024-11-19', '11:00:00', 'disponivel'),
(525, '2024-11-19', '11:30:00', 'disponivel'),
(526, '2024-11-19', '12:00:00', 'disponivel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disponibilidade_profissional`
--

CREATE TABLE `disponibilidade_profissional` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `tipo` enum('disponivel','reservado','indisponivel') NOT NULL,
  `profissional_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `disponibilidade_profissional`
--

INSERT INTO `disponibilidade_profissional` (`id`, `data`, `horario`, `tipo`, `profissional_id`) VALUES
(49, '2024-11-27', '08:00:00', 'disponivel', 16),
(50, '2024-11-27', '10:00:00', 'indisponivel', 16),
(51, '2024-11-27', '13:00:00', 'disponivel', 16),
(52, '2024-11-27', '15:00:00', 'indisponivel', 16),
(53, '2024-11-27', '16:00:00', 'disponivel', 16),
(54, '2024-11-27', '18:00:00', 'indisponivel', 16),
(55, '2024-11-27', '19:00:00', 'indisponivel', 16),
(56, '2024-11-27', '20:00:00', 'indisponivel', 16),
(57, '2024-11-27', '10:00:00', 'indisponivel', 18),
(58, '2024-11-27', '13:00:00', 'disponivel', 18),
(59, '2024-11-27', '15:00:00', 'indisponivel', 18),
(60, '2024-11-27', '16:00:00', 'disponivel', 18),
(61, '2024-11-27', '17:00:00', 'indisponivel', 18),
(62, '2024-11-27', '18:00:00', 'indisponivel', 18),
(63, '2024-11-27', '19:00:00', 'indisponivel', 18),
(64, '2024-11-27', '20:00:00', 'indisponivel', 18),
(65, '2024-11-15', '08:00:00', 'indisponivel', 19),
(66, '2024-11-15', '10:00:00', 'indisponivel', 19),
(67, '2024-11-15', '13:00:00', 'indisponivel', 19),
(68, '2024-11-15', '15:00:00', 'indisponivel', 19),
(69, '2024-11-15', '17:00:00', 'indisponivel', 19),
(70, '2024-11-15', '18:00:00', 'disponivel', 19),
(71, '2024-11-15', '19:00:00', 'indisponivel', 19),
(72, '2024-11-15', '20:00:00', 'indisponivel', 19),
(73, '2024-11-25', '08:00:00', 'disponivel', 20),
(74, '2024-11-25', '10:00:00', 'disponivel', 20),
(75, '2024-11-25', '13:00:00', 'disponivel', 20),
(76, '2024-11-25', '15:00:00', 'indisponivel', 20),
(77, '2024-11-25', '16:00:00', 'indisponivel', 20),
(78, '2024-11-25', '17:00:00', 'disponivel', 20),
(79, '2024-11-25', '19:00:00', 'indisponivel', 20),
(80, '2024-11-25', '20:00:00', 'disponivel', 20),
(81, '2024-11-25', '08:00:00', 'disponivel', 21),
(82, '2024-11-25', '10:00:00', 'disponivel', 21),
(83, '2024-11-25', '13:00:00', 'disponivel', 21),
(84, '2024-11-25', '15:00:00', 'indisponivel', 21),
(85, '2024-11-25', '16:00:00', 'indisponivel', 21),
(86, '2024-11-25', '18:00:00', 'indisponivel', 21),
(87, '2024-11-25', '19:00:00', 'indisponivel', 21),
(88, '2024-11-25', '20:00:00', 'disponivel', 21),
(89, '2024-11-29', '08:00:00', 'indisponivel', 22),
(90, '2024-11-29', '10:00:00', 'indisponivel', 22),
(91, '2024-11-29', '13:00:00', 'indisponivel', 22),
(92, '2024-11-29', '15:00:00', 'indisponivel', 22),
(93, '2024-11-29', '16:00:00', 'disponivel', 22),
(94, '2024-11-29', '17:00:00', 'disponivel', 22),
(95, '2024-11-29', '18:00:00', 'disponivel', 22),
(96, '2024-11-29', '20:00:00', 'indisponivel', 22),
(97, '2024-11-18', '08:00:00', 'disponivel', 23),
(98, '2024-11-18', '10:00:00', 'indisponivel', 23),
(99, '2024-11-18', '13:00:00', 'disponivel', 23),
(100, '2024-11-18', '15:00:00', 'indisponivel', 23),
(101, '2024-11-18', '16:00:00', 'indisponivel', 23),
(102, '2024-11-18', '17:00:00', 'disponivel', 23),
(103, '2024-11-18', '18:00:00', 'disponivel', 23),
(104, '2024-11-18', '20:00:00', 'indisponivel', 23),
(105, '2024-11-18', '08:00:00', 'disponivel', 24),
(106, '2024-11-18', '13:00:00', 'disponivel', 24),
(107, '2024-11-18', '15:00:00', 'disponivel', 24),
(108, '2024-11-18', '16:00:00', 'indisponivel', 24),
(109, '2024-11-18', '17:00:00', 'disponivel', 24),
(110, '2024-11-18', '18:00:00', 'disponivel', 24),
(111, '2024-11-18', '19:00:00', 'indisponivel', 24),
(112, '2024-11-18', '20:00:00', 'indisponivel', 24),
(113, '2024-11-26', '10:00:00', 'disponivel', 25),
(114, '2024-11-26', '13:00:00', 'disponivel', 25),
(115, '2024-11-26', '15:00:00', 'disponivel', 25),
(116, '2024-11-26', '16:00:00', 'indisponivel', 25),
(117, '2024-11-26', '17:00:00', 'disponivel', 25),
(118, '2024-11-26', '18:00:00', 'disponivel', 25),
(119, '2024-11-26', '19:00:00', 'disponivel', 25),
(120, '2024-11-26', '20:00:00', 'indisponivel', 25),
(121, '2024-11-27', '08:00:00', 'disponivel', 26),
(122, '2024-11-27', '10:00:00', 'indisponivel', 26),
(123, '2024-11-27', '15:00:00', 'indisponivel', 26),
(124, '2024-11-27', '16:00:00', 'disponivel', 26),
(125, '2024-11-27', '17:00:00', 'indisponivel', 26),
(126, '2024-11-27', '18:00:00', 'indisponivel', 26),
(127, '2024-11-27', '19:00:00', 'indisponivel', 26),
(128, '2024-11-27', '20:00:00', 'indisponivel', 26),
(129, '2024-11-16', '08:00:00', 'disponivel', 27),
(130, '2024-11-16', '10:00:00', 'indisponivel', 27),
(131, '2024-11-16', '15:00:00', 'indisponivel', 27),
(132, '2024-11-16', '16:00:00', 'indisponivel', 27),
(133, '2024-11-16', '17:00:00', 'disponivel', 27),
(134, '2024-11-16', '18:00:00', 'disponivel', 27),
(135, '2024-11-16', '19:00:00', 'indisponivel', 27),
(136, '2024-11-16', '20:00:00', 'indisponivel', 27),
(137, '2024-11-16', '08:00:00', 'disponivel', 28),
(138, '2024-11-16', '10:00:00', 'indisponivel', 28),
(139, '2024-11-16', '13:00:00', 'indisponivel', 28),
(140, '2024-11-16', '15:00:00', 'indisponivel', 28),
(141, '2024-11-16', '16:00:00', 'indisponivel', 28),
(142, '2024-11-16', '18:00:00', 'disponivel', 28),
(143, '2024-11-16', '19:00:00', 'indisponivel', 28),
(144, '2024-11-16', '20:00:00', 'indisponivel', 28),
(145, '2024-11-11', '08:00:00', 'disponivel', 29),
(146, '2024-11-11', '10:00:00', 'disponivel', 29),
(147, '2024-11-11', '13:00:00', 'disponivel', 29),
(148, '2024-11-11', '15:00:00', 'indisponivel', 29),
(149, '2024-11-11', '17:00:00', 'disponivel', 29),
(150, '2024-11-11', '18:00:00', 'disponivel', 29),
(151, '2024-11-11', '19:00:00', 'disponivel', 29),
(152, '2024-11-11', '20:00:00', 'indisponivel', 29),
(153, '2024-11-16', '08:00:00', 'disponivel', 30),
(154, '2024-11-16', '10:00:00', 'indisponivel', 30),
(155, '2024-11-16', '13:00:00', 'disponivel', 30),
(156, '2024-11-16', '16:00:00', 'indisponivel', 30),
(157, '2024-11-16', '17:00:00', 'disponivel', 30),
(158, '2024-11-16', '18:00:00', 'disponivel', 30),
(159, '2024-11-16', '19:00:00', 'indisponivel', 30),
(160, '2024-11-16', '20:00:00', 'indisponivel', 30),
(161, '2024-11-12', '10:00:00', 'disponivel', 31),
(162, '2024-11-12', '13:00:00', 'disponivel', 31),
(163, '2024-11-12', '15:00:00', 'disponivel', 31),
(164, '2024-11-12', '16:00:00', 'disponivel', 31),
(165, '2024-11-12', '17:00:00', 'indisponivel', 31),
(166, '2024-11-12', '18:00:00', 'disponivel', 31),
(167, '2024-11-12', '19:00:00', 'disponivel', 31),
(168, '2024-11-12', '20:00:00', 'disponivel', 31),
(169, '2024-11-23', '08:00:00', 'indisponivel', 32),
(170, '2024-11-23', '13:00:00', 'indisponivel', 32),
(171, '2024-11-23', '15:00:00', 'indisponivel', 32),
(172, '2024-11-23', '16:00:00', 'indisponivel', 32),
(173, '2024-11-23', '17:00:00', 'indisponivel', 32),
(174, '2024-11-23', '18:00:00', 'indisponivel', 32),
(175, '2024-11-23', '19:00:00', 'indisponivel', 32),
(176, '2024-11-23', '20:00:00', 'indisponivel', 32),
(177, '2024-11-18', '08:00:00', 'disponivel', 33),
(178, '2024-11-18', '10:00:00', 'indisponivel', 33),
(179, '2024-11-18', '13:00:00', 'disponivel', 33),
(180, '2024-11-18', '15:00:00', 'disponivel', 33),
(181, '2024-11-18', '16:00:00', 'indisponivel', 33),
(182, '2024-11-18', '17:00:00', 'disponivel', 33),
(183, '2024-11-18', '18:00:00', 'disponivel', 33),
(184, '2024-11-18', '19:00:00', 'indisponivel', 33),
(185, '2024-11-21', '08:00:00', 'disponivel', 34),
(186, '2024-11-21', '10:00:00', 'indisponivel', 34),
(187, '2024-11-21', '13:00:00', 'disponivel', 34),
(188, '2024-11-21', '15:00:00', 'disponivel', 34),
(189, '2024-11-21', '16:00:00', 'disponivel', 34),
(190, '2024-11-21', '18:00:00', 'disponivel', 34),
(191, '2024-11-21', '19:00:00', 'disponivel', 34),
(192, '2024-11-21', '20:00:00', 'disponivel', 34),
(193, '2024-11-27', '08:00:00', 'disponivel', 35),
(194, '2024-11-27', '10:00:00', 'indisponivel', 35),
(195, '2024-11-27', '15:00:00', 'indisponivel', 35),
(196, '2024-11-27', '16:00:00', 'disponivel', 35),
(197, '2024-11-27', '17:00:00', 'indisponivel', 35),
(198, '2024-11-27', '18:00:00', 'indisponivel', 35),
(199, '2024-11-27', '19:00:00', 'indisponivel', 35),
(200, '2024-11-27', '20:00:00', 'indisponivel', 35),
(201, '2024-11-15', '08:00:00', 'indisponivel', 36),
(202, '2024-11-15', '10:00:00', 'indisponivel', 36),
(203, '2024-11-15', '13:00:00', 'indisponivel', 36),
(204, '2024-11-15', '15:00:00', 'indisponivel', 36),
(205, '2024-11-15', '16:00:00', 'disponivel', 36),
(206, '2024-11-15', '17:00:00', 'indisponivel', 36),
(207, '2024-11-15', '18:00:00', 'disponivel', 36),
(208, '2024-11-15', '19:00:00', 'indisponivel', 36),
(209, '2024-11-19', '08:00:00', 'disponivel', 37),
(210, '2024-11-19', '10:00:00', 'disponivel', 37),
(211, '2024-11-19', '13:00:00', 'indisponivel', 37),
(212, '2024-11-19', '16:00:00', 'indisponivel', 37),
(213, '2024-11-19', '17:00:00', 'indisponivel', 37),
(214, '2024-11-19', '18:00:00', 'indisponivel', 37),
(215, '2024-11-19', '19:00:00', 'indisponivel', 37),
(216, '2024-11-19', '20:00:00', 'indisponivel', 37),
(217, '2024-11-29', '08:00:00', 'indisponivel', 38),
(218, '2024-11-29', '10:00:00', 'indisponivel', 38),
(219, '2024-11-29', '15:00:00', 'indisponivel', 38),
(220, '2024-11-29', '16:00:00', 'disponivel', 38),
(221, '2024-11-29', '17:00:00', 'disponivel', 38),
(222, '2024-11-29', '18:00:00', 'disponivel', 38),
(223, '2024-11-29', '19:00:00', 'indisponivel', 38),
(224, '2024-11-29', '20:00:00', 'indisponivel', 38),
(225, '2024-11-15', '08:00:00', 'indisponivel', 39),
(226, '2024-11-15', '10:00:00', 'indisponivel', 39),
(227, '2024-11-15', '13:00:00', 'indisponivel', 39),
(228, '2024-11-15', '15:00:00', 'indisponivel', 39),
(229, '2024-11-15', '16:00:00', 'disponivel', 39),
(230, '2024-11-15', '17:00:00', 'indisponivel', 39),
(231, '2024-11-15', '19:00:00', 'indisponivel', 39),
(232, '2024-11-15', '20:00:00', 'disponivel', 39),
(233, '2024-11-16', '08:00:00', 'indisponivel', 40),
(234, '2024-11-16', '10:00:00', 'indisponivel', 40),
(235, '2024-11-16', '13:00:00', 'disponivel', 40),
(236, '2024-11-16', '16:00:00', 'indisponivel', 40),
(237, '2024-11-16', '17:00:00', 'disponivel', 40),
(238, '2024-11-16', '18:00:00', 'disponivel', 40),
(239, '2024-11-16', '19:00:00', 'indisponivel', 40),
(240, '2024-11-16', '20:00:00', 'indisponivel', 40),
(241, '2024-11-19', '08:00:00', 'disponivel', 41),
(242, '2024-11-19', '10:00:00', 'disponivel', 41),
(243, '2024-11-19', '15:00:00', 'disponivel', 41),
(244, '2024-11-19', '16:00:00', 'indisponivel', 41),
(245, '2024-11-19', '17:00:00', 'indisponivel', 41),
(246, '2024-11-19', '18:00:00', 'indisponivel', 41),
(247, '2024-11-19', '19:00:00', 'indisponivel', 41),
(248, '2024-11-19', '20:00:00', 'indisponivel', 41),
(249, '2024-11-29', '08:00:00', 'indisponivel', 42),
(250, '2024-11-29', '13:00:00', 'indisponivel', 42),
(251, '2024-11-29', '15:00:00', 'indisponivel', 42),
(252, '2024-11-29', '16:00:00', 'disponivel', 42),
(253, '2024-11-29', '17:00:00', 'disponivel', 42),
(254, '2024-11-29', '18:00:00', 'disponivel', 42),
(255, '2024-11-29', '19:00:00', 'indisponivel', 42),
(256, '2024-11-29', '20:00:00', 'indisponivel', 42),
(257, '2024-11-29', '08:00:00', 'indisponivel', 43),
(258, '2024-11-29', '13:00:00', 'indisponivel', 43),
(259, '2024-11-29', '15:00:00', 'indisponivel', 43),
(260, '2024-11-29', '16:00:00', 'disponivel', 43),
(261, '2024-11-29', '17:00:00', 'disponivel', 43),
(262, '2024-11-29', '18:00:00', 'disponivel', 43),
(263, '2024-11-29', '19:00:00', 'indisponivel', 43),
(264, '2024-11-29', '20:00:00', 'indisponivel', 43),
(265, '2024-11-15', '08:00:00', 'indisponivel', 44),
(266, '2024-11-15', '10:00:00', 'indisponivel', 44),
(267, '2024-11-15', '13:00:00', 'indisponivel', 44),
(268, '2024-11-15', '15:00:00', 'indisponivel', 44),
(269, '2024-11-15', '16:00:00', 'disponivel', 44),
(270, '2024-11-15', '18:00:00', 'disponivel', 44),
(271, '2024-11-15', '19:00:00', 'indisponivel', 44),
(272, '2024-11-15', '20:00:00', 'disponivel', 44),
(273, '2024-11-24', '10:00:00', 'indisponivel', 45),
(274, '2024-11-24', '13:00:00', 'disponivel', 45),
(275, '2024-11-24', '15:00:00', 'disponivel', 45),
(276, '2024-11-24', '16:00:00', 'disponivel', 45),
(277, '2024-11-24', '17:00:00', 'disponivel', 45),
(278, '2024-11-24', '18:00:00', 'indisponivel', 45),
(279, '2024-11-24', '19:00:00', 'indisponivel', 45),
(280, '2024-11-24', '20:00:00', 'disponivel', 45),
(281, '2024-11-13', '08:00:00', 'disponivel', 46),
(282, '2024-11-13', '10:00:00', 'disponivel', 46),
(283, '2024-11-13', '13:00:00', 'disponivel', 46),
(284, '2024-11-13', '15:00:00', 'indisponivel', 46),
(285, '2024-11-13', '16:00:00', 'disponivel', 46),
(286, '2024-11-13', '17:00:00', 'disponivel', 46),
(287, '2024-11-13', '19:00:00', 'disponivel', 46),
(288, '2024-11-13', '20:00:00', 'disponivel', 46),
(289, '2024-11-18', '08:00:00', 'disponivel', 28),
(290, '2024-11-18', '08:30:00', 'disponivel', 28),
(291, '2024-11-18', '09:00:00', 'disponivel', 28),
(292, '2024-11-18', '09:30:00', 'disponivel', 28),
(293, '2024-11-18', '10:00:00', 'disponivel', 28),
(294, '2024-11-18', '11:00:00', 'disponivel', 28),
(295, '2024-11-18', '11:30:00', 'disponivel', 28),
(296, '2024-11-18', '13:00:00', 'disponivel', 28),
(297, '2024-11-18', '14:30:00', 'disponivel', 28),
(298, '2024-11-18', '15:30:00', 'disponivel', 28),
(299, '2024-11-26', '08:00:00', 'disponivel', 28),
(300, '2024-11-26', '08:30:00', 'disponivel', 28),
(301, '2024-11-26', '09:00:00', 'disponivel', 28),
(302, '2024-11-26', '09:30:00', 'disponivel', 28),
(303, '2024-11-26', '10:00:00', 'disponivel', 28),
(304, '2024-11-26', '10:30:00', 'disponivel', 28),
(305, '2024-11-26', '11:00:00', 'disponivel', 28),
(306, '2024-11-26', '11:30:00', 'disponivel', 28),
(307, '2024-11-26', '12:00:00', 'disponivel', 28),
(308, '2024-11-26', '12:30:00', 'disponivel', 28),
(309, '2024-11-26', '13:00:00', 'disponivel', 28),
(310, '2024-11-27', '09:00:00', 'disponivel', 16),
(311, '2024-11-27', '11:00:00', 'indisponivel', 16),
(312, '2024-11-27', '14:00:00', 'disponivel', 16),
(313, '2024-11-27', '09:00:00', 'disponivel', 18),
(314, '2024-11-27', '12:00:00', 'disponivel', 18),
(315, '2024-11-27', '14:00:00', 'disponivel', 18),
(316, '2024-11-15', '09:00:00', 'disponivel', 19),
(317, '2024-11-15', '11:00:00', 'disponivel', 19),
(318, '2024-11-15', '14:00:00', 'disponivel', 19),
(319, '2024-11-25', '09:00:00', 'disponivel', 20),
(320, '2024-11-25', '11:00:00', 'disponivel', 20),
(321, '2024-11-25', '14:00:00', 'disponivel', 20),
(322, '2024-11-25', '09:00:00', 'disponivel', 21),
(323, '2024-11-25', '11:00:00', 'disponivel', 21),
(324, '2024-11-25', '14:00:00', 'disponivel', 21),
(325, '2024-11-29', '09:00:00', 'disponivel', 22),
(326, '2024-11-29', '11:00:00', 'disponivel', 22),
(327, '2024-11-29', '14:00:00', 'disponivel', 22),
(328, '2024-11-18', '09:00:00', 'disponivel', 23),
(329, '2024-11-18', '11:00:00', 'disponivel', 23),
(330, '2024-11-18', '14:00:00', 'disponivel', 23),
(331, '2024-11-18', '09:00:00', 'disponivel', 24),
(332, '2024-11-18', '11:00:00', 'disponivel', 24),
(333, '2024-11-18', '14:00:00', 'disponivel', 24),
(334, '2024-11-26', '09:00:00', 'disponivel', 25),
(335, '2024-11-26', '11:00:00', 'disponivel', 25),
(336, '2024-11-26', '14:00:00', 'disponivel', 25),
(337, '2024-11-27', '09:00:00', 'disponivel', 26),
(338, '2024-11-27', '12:00:00', 'disponivel', 26),
(339, '2024-11-27', '14:00:00', 'disponivel', 26),
(340, '2024-11-16', '09:00:00', 'disponivel', 27),
(341, '2024-11-16', '11:00:00', 'disponivel', 27),
(342, '2024-11-16', '14:00:00', 'disponivel', 27),
(343, '2024-11-16', '09:00:00', 'disponivel', 28),
(344, '2024-11-16', '11:00:00', 'disponivel', 28),
(345, '2024-11-16', '14:00:00', 'disponivel', 28),
(346, '2024-11-27', '13:00:00', 'disponivel', 21),
(347, '2024-11-27', '13:30:00', 'disponivel', 21),
(348, '2024-11-27', '14:00:00', 'indisponivel', 21),
(349, '2024-11-27', '14:30:00', 'disponivel', 21),
(350, '2024-11-27', '15:00:00', 'disponivel', 21),
(351, '2024-11-21', '08:00:00', 'disponivel', 23),
(352, '2024-11-21', '08:30:00', 'disponivel', 23),
(353, '2024-11-21', '09:00:00', 'disponivel', 23),
(354, '2024-11-21', '11:00:00', 'disponivel', 23),
(355, '2024-11-21', '11:30:00', 'disponivel', 23),
(356, '2024-11-21', '12:00:00', 'disponivel', 23),
(357, '2024-11-21', '13:00:00', 'disponivel', 23),
(358, '2024-11-21', '13:30:00', 'disponivel', 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `especialidades`
--

INSERT INTO `especialidades` (`id`, `nome`, `area_id`) VALUES
(1, 'Cardiologia', 1),
(2, 'Neurologia', 1),
(3, 'Ortopedista', 1),
(4, 'Dermatologia', 1),
(5, 'Oftamologia', 1),
(6, 'Pediatra', 1),
(7, 'Ortodontia', 2),
(9, 'Periodontia', 2),
(10, 'Estomatologista', 2),
(11, 'Implantodontia', 2),
(12, 'Odontologia Estética', 2),
(13, 'Nutrição Esportiva', 3),
(14, 'Nutrição Clínica', 3),
(15, 'Nutrição Infantil', 3),
(16, 'Comportamento Alimentar', 3),
(17, 'Nutrigenômica', 3),
(18, 'Terapia Corporal', 3),
(19, 'Fisioterapia Ortopédica', 4),
(20, 'Fisioterapia Neurológica', 4),
(21, 'Fisioterapia Cardiopulmonar', 4),
(22, 'Fisioterapia Geral', 4),
(23, 'Fisioterapia Aquática', 4),
(24, 'Fisioterapia Acupuntura', 4),
(25, 'Psicologia Jurídica', 5),
(26, 'Psicologia Hospitalar', 5),
(27, 'Psicologia Especial', 5),
(28, 'Psicologia do Esporte', 5),
(29, 'Psicopedagogia', 5),
(30, 'Psicologia Organizacional e do Trabalho', 5),
(31, 'Exames Laboratoriais', 6),
(33, 'Ultrassonografia', 6),
(34, 'Glicemia', 6),
(35, 'Exames de urina', 6),
(39, 'Odontologia', 2),
(40, 'Exame De Sangue', 6),
(41, 'Lipidograma', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerencia`
--

CREATE TABLE `gerencia` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `gerencia`
--

INSERT INTO `gerencia` (`id`, `email`, `senha`) VALUES
(1, 'adminbrabo@gmail.com', '$2a$12$EsBSWbrv/QEogVTrMq1r2uX1wPmiZ/7UfWibjt3CvMtVW0P7/XE9q');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planos`
--

CREATE TABLE `planos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `planos`
--

INSERT INTO `planos` (`id`, `nome`) VALUES
(1, 'Amil'),
(2, 'Bradesco Saúde'),
(3, 'Hapvida'),
(4, 'NotreDame Intermédica'),
(10, 'Biovida Saúde'),
(11, 'Qualquer');

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissionais`
--

CREATE TABLE `profissionais` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `registro` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `profissionais`
--

INSERT INTO `profissionais` (`id`, `nome`, `senha`, `email`, `registro`) VALUES
(16, 'Adriano Silva Costa', '$2y$10$iV5wsXCxmcMG5jpQrFtpmORFlhWP6oz7Q7gk8rK4iNDIRDr5iN.6e', 'SilvaCosta@gmail.com', '223456/RJ'),
(18, 'Carlos Silva', '$2y$10$owHLAWLiSBJ1rcOH1RQSw.jqSsRaS0h5FURDbfa8jahVw48qaYchm', 'carlos.silva@email.com', '123456/ES'),
(19, 'Ana Costa', '$2y$10$goNBWD0D/rsAOfsVMKjNgOnxo/Nb/L0xKS1dGQcXl.GiZTBRympyu', 'ana.costa@email.com', '123456/SP'),
(20, 'Roberto Oliveira', '$2y$10$jfzHzf7Q8./QkUNBRRGR4O4gX5AJEiPaYlPn1q9vrrxL8uV.11E1W', 'roberto.oliveira@email.com', '123456/RJ'),
(21, 'Andre Sobral Avelino', '$2y$10$m8PgqhEgVoAql14Bsr0yU.dFt6jTIDWpASZEJsJ.H6GjWIVYyxEXK', 'maria.souza@email.com', '123456/MG'),
(22, 'João Pereira', '$2y$10$m1KXIS6xk4QVKzeZoSY9feGo02FVE/uDoz6gxk/EdWwFFxO50sFm2', 'joao.pereira@email.com', '123456/RS'),
(23, 'Laura Alves', '$2y$10$N9wAQMzxyhhIIDk.let8C.NA6WV4ZhiXlLWL9visHQjVwTrtO.8K2', 'laura.alves@email.com', '123456/PR'),
(24, 'Pedro Santos', '$2y$10$6mdstvxR9SKyr8O7MkiPPu2IgLFCpar9zeFyCJVLBY3SzKqK9VdR.', 'pedro.santos@email.com', '123456/BA'),
(25, 'Juliana Lima', '$2y$10$V7M0grJ6TgSwqR9dyPYkpOYirAa8E3aB11BF7flichY7A5nkAEiaG', 'juliana.lima@email.com', '123456/SC'),
(26, 'Carlos Oliveira', '$2y$10$gXC25As8XgGjxdlx2CZ4xuUmSsOZU1DCWTyAPF/iopZuSNKMilotG', 'carlos.oliveira@email.com', '123456/GO'),
(27, 'Fernanda Rocha', '$2y$10$V3SY0efJlMLAvL3azK9vnu5AHaagRCtbtXUxq1Yf9czd13FWrcn0q', 'fernanda.rocha@email.com', '123456/DF'),
(28, 'Lazaro Pereira Santos', '$2y$10$UZovp0c7T3eDdAe1B/NeI.8ajI.MTugLD2HIbhjE8bzFt.SuN26oO', 'PereiraSantos@email.com', '123456/CE'),
(29, 'Cláudia Martins', '$2y$10$amDDDy6TcaPZib4wBGsGgelrpcOQBnWTgxdS2OFoDGpyg4eXuGVRS', 'claudia.martins@email.com', '123456/AM'),
(30, 'Eduardo Pereira', '$2y$10$N2eN/JKWeeMXkuv5mK03FON154oDw93rRf.Q6Z30oXoUvJGWJAbzi', 'eduardo.pereira@email.com', '123456/PE'),
(31, 'Mariana Sousa', '$2y$10$63oBDZlN73Xjoc/g7aPd3OOZ4kmOCEZF7xHXT6bdoQFCZAJrUtTzG', 'mariana.sousa@email.com', '123456/MT'),
(32, 'Felipe Gomes', '$2y$10$esgb5kAdB7bOJ83op5GUXudaJ8b5G1s7pqRTpPxFu9HbKhlZZ7jkS', 'felipe.gomes@email.com', '123456/MS'),
(33, 'Rafaela Costa', '$2y$10$rvvm/hsthSNR8q/fNHIqnecahO6qDJUpW47sU8hjLuvjep5JPBZd2', 'rafaela.costa@email.com', '123456/ES'),
(34, 'Bruno Silva', '$2y$10$iKVWK.xRqcFF47vwOWxTQuqKX9r.3RJCUKBxX.ShIk06yxLnndV8S', 'bruno.silva@email.com', '123456/SP'),
(35, 'Patrícia Almeida', '$2y$10$9GO1/OdbDhCorlqO5k8n9.zKF.b9hptsUWu/MwhNtvCPTbAyskCo.', 'patricia.almeida@email.com', '123456/RJ'),
(36, 'Antonio Junior', '$2y$10$kO0F0HunAsPepDNJNxRZv.H3I9uCsYMHdbdn6v0qn1sBHK1aylzYq', 'ricardo.lima@email.com', '123456/MG'),
(37, 'Vanessa Rocha', '$2y$10$F6bOU5ULj5ewnhZdIpLAoe2GxEgHPw6xgpuuYULKHp2ywkyKaTl3O', 'vanessa.rocha@email.com', '123456/RS'),
(38, 'Andre Souza', '$2y$10$4/TCWtJHiaiM2iF7G/QkAOWWEtbI44VSUjzIfUK22RQpehuS7zete', 'alberto.santos@email.com', '123456/PR'),
(39, 'Luana Costa', '$2y$10$wDamK0Ve7FpvQpxnOrR8Fee7J1fZ5gOcyfZoMOY6pmsQAwJSitdeq', 'luana.costa@email.com', '123456/BA'),
(40, 'Marcos Lima', '$2y$10$67AiLvvgvX76AL01GE0Ykut12k93OQtUD08xir0akGfS0C7hAjhjG', 'marcos.lima@email.com', '123456/SC'),
(41, 'Gabriel Costa', '$2y$10$ZP9N8M4jXeMRwkYIY0K7tuiJp.Mzce1DkVvxPJYZcnpDPxIv/Wzbe', 'gabriel.costa@email.com', '123456/GO'),
(42, 'Tatiane Almeida', '$2y$10$FT5NT/YVGDm7TjWvFAd9/u9lmjU7X5.36jkPPk2FhxBQvzDwiyFl.', 'tatiane.almeida@email.com', '123456/DF'),
(43, 'Claudinei Ferreira', '$2y$10$JkyGYVM5YCehQabNLmr1HuEpZD/J1SIjr5DmF71X4o/klxScOkU3q', 'claudinei.ferreira@email.com', '123456/CE'),
(44, 'Camila Ferreira', '$2y$10$36EGj2HGe80ZL0kpqg5AcuEE/.idA1a4fUC7OX3tdnrMHKnfbpnUi', 'camila.ferreira@email.com', '123456/AM'),
(45, 'Rodrigo Barbosa', '$2y$10$dcTj7ZF5J4Ac3miLSWjp/e5NM8HzKaPxXgKcn9D9Q2VNCOoSqjmEK', 'rodrigo.barbosa@email.com', '123456/PE'),
(46, 'Cristina Silva', '$2y$10$4NWS7mVC4/mLATc22vTfwOYJbyLtIimONMr6kzJHGnwKt.PbTO8Ia', 'cristina.silva@email.com', '123456/MT');

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissionais_especialidades`
--

CREATE TABLE `profissionais_especialidades` (
  `profissional_id` int(11) NOT NULL,
  `especialidade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `profissionais_especialidades`
--

INSERT INTO `profissionais_especialidades` (`profissional_id`, `especialidade_id`) VALUES
(16, 2),
(16, 2),
(18, 26),
(19, 9),
(20, 10),
(21, 21),
(22, 20),
(23, 10),
(24, 14),
(25, 41),
(26, 34),
(27, 19),
(28, 34),
(29, 9),
(30, 16),
(31, 39),
(32, 26),
(33, 26),
(34, 27),
(35, 7),
(36, 9),
(37, 11),
(38, 20),
(39, 23),
(40, 20),
(41, 9),
(42, 13),
(43, 15),
(44, 29),
(45, 5),
(46, 31);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`, `email`) VALUES
(37, 'Victor Leon De Macedo Martello', '$2a$12$bdQGKjpp3GoeuvJGV9VQ0OXmOTyHL5EzusIBkEiq9FXY05aRk.yKS', 'LeonMartello@gmail.com'),
(38, 'Yan Sacramento', '$2a$12$F4r1lCMiVQZSegnKk0qMRuwwxkffDyygglbm31AsHgxspFDqSCjxO', 'SacramentoGv@gmail.com'),
(39, 'Carlos Eduardo Marques Barreto', '$2y$10$MM9RWYcGWQgHVt74ubswpeyTL.mlH26w3yzh8DG5R3KJWn606baem', 'CarlosEduardo@gmail.com'),
(40, 'Gabriel Morais', '$2y$10$uEaidc.gtb8PrO/ewN/3oOYm25shX5jSaB7ziMrvvIAqe0Gn21Olu', 'GabrielCardoso@gmail.com'),
(41, 'Julio Cesar', '$2y$10$MdgmaXm5XEcNyGpgOe0z8etOKoiLhMU.tpBV.h2aQ10ZXykwvfewG', 'JulioCesar@gmail.com'),
(42, 'Leonardo Santos', '$2y$10$CaNGgqLgDaJK13WzMlt.eeaA4ykPzETSN.fceYVps6SrsybGw9Nba', 'LeonardoSantos@gmail.com'),
(43, 'Luis Santos', '$2y$10$LI.ViA5lMWpYgwOqmw3AheFbr9tACSQD0ps3gZvm/5OV1uNHI9u.S', 'LuisSantos@gmail.com'),
(44, 'Ana Carolina', '$2y$10$UwyCAuF4V7xJ2ZggjRbj0e01wWWtBXL6Dmd4t7sDVJ/MNHkXHVKnq', 'Ana123@gmail.com'),
(45, 'Barbara Magno', '$2y$10$BaWy2uIiJKjiwAMSemOeneIG0ehLGUeclpbAUVpoX2n56uSaxecT2', 'Barbara123@gmail.com'),
(47, 'Rafaela Beff', '$2y$10$4yJ10rhAVBZC0lTjJ17wOertor8JrS8yViTrqg7IdpVhgq44Zh9Mi', 'Rafaela123@gmail.com'),
(48, 'Renata Souza', '$2y$10$gy..2NN5vUHLhdJHOEVwYu0NHx2cm2c.xt6M6nWx1nuIGZ7hiSmAG', 'Renata123@gmail.com'),
(49, 'Jessica Vitoria', '$2y$10$q8lTx8vv14GAuY4ZaHa/qOxXD.L9Wa2dqysNlB2venba3g16awP9m', 'Jessica123@gmail.com'),
(50, 'Souzones Guimarães ', '$2y$10$1cX5Jqsy3oUeqOdccsUagOimwXbyTiqxQdFSoZdNLfvshbZcgluiW', 'SouzaGI@gmail.com'),
(51, 'Renato Souza', '$2y$10$nQH5IRIvEMabq22whSYIReow4DU6DDSb.kbe7N0OBOZPxaFcjI4CG', 'SouzaRT@gmail.com'),
(56, 'Victor Hugo', '$2y$10$0ztdBUkq5p3klpM1ng1gzOijRs4wDTY4bWTV1c9AR5eTCA.MCKQDO', 'HugoVctr@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profissional_id` (`profissional_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `disponibilidade_profissional`
--
ALTER TABLE `disponibilidade_profissional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_profissional_id` (`profissional_id`),
  ADD KEY `idx_data` (`data`),
  ADD KEY `idx_status` (`tipo`);

--
-- Índices para tabela `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_especialidades_area` (`area_id`);

--
-- Índices para tabela `gerencia`
--
ALTER TABLE `gerencia`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `profissionais`
--
ALTER TABLE `profissionais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `profissionais_especialidades`
--
ALTER TABLE `profissionais_especialidades`
  ADD KEY `fk_profissionais_especialidades_profissional` (`profissional_id`),
  ADD KEY `fk_profissionais_especialidades_especialidade` (`especialidade_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3199;

--
-- AUTO_INCREMENT de tabela `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=527;

--
-- AUTO_INCREMENT de tabela `disponibilidade_profissional`
--
ALTER TABLE `disponibilidade_profissional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT de tabela `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de tabela `profissionais`
--
ALTER TABLE `profissionais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`profissional_id`) REFERENCES `profissionais` (`id`),
  ADD CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `disponibilidade_profissional`
--
ALTER TABLE `disponibilidade_profissional`
  ADD CONSTRAINT `fk_profissional_id` FOREIGN KEY (`profissional_id`) REFERENCES `profissionais` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `especialidades`
--
ALTER TABLE `especialidades`
  ADD CONSTRAINT `fk_especialidades_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Limitadores para a tabela `profissionais_especialidades`
--
ALTER TABLE `profissionais_especialidades`
  ADD CONSTRAINT `fk_profissionais_especialidades_especialidade` FOREIGN KEY (`especialidade_id`) REFERENCES `especialidades` (`id`),
  ADD CONSTRAINT `fk_profissionais_especialidades_profissional` FOREIGN KEY (`profissional_id`) REFERENCES `profissionais` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
