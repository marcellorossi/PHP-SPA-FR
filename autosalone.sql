-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 21, 2024 alle 18:27
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autosalone`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cars`
--

CREATE TABLE `cars` (
  `plate` varchar(9) NOT NULL,
  `brand` varchar(15) NOT NULL,
  `model` varchar(20) NOT NULL,
  `capacity` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `cars`
--

INSERT INTO `cars` (`plate`, `brand`, `model`, `capacity`, `path`) VALUES
('DB700LL', 'Ford', 'Fiesta', 1200, '../uploads/img_664cc30d2a40d7.40783069.jpg'),
('DB700MA', 'Aston Martin', 'Vantage', 4000, '../uploads/img_664cc061d58c25.15846598.png'),
('DB700MN', 'Suzuki', 'Swift', 1200, '../uploads/img_664cc077cdcd46.14854392.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `email` varchar(40) NOT NULL,
  `password` varchar(150) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `level` varchar(1) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`email`, `password`, `name`, `surname`, `level`, `date`, `text`) VALUES
('marcello.rossi.it@gmail.com', '$2y$10$EJ6N2W.2tGfnKZj9BhlpuuzFf2F1eFx9sS.Zv9yhsvMf5GNK8kavO', 'Marcello', 'Rossi', '0', '2024-04-17', 'text'),
('marcello.rossi@test.com', '$2y$10$EJ6N2W.2tGfnKZj9BhlpuuzFf2F1eFx9sS.Zv9yhsvMf5GNK8kavO', 'Marcello', 'Rossi', '1', '2024-03-04', 'text');

-- --------------------------------------------------------

--
-- Struttura della tabella `users_cars`
--

CREATE TABLE `users_cars` (
  `email` varchar(255) NOT NULL,
  `plate` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users_cars`
--

INSERT INTO `users_cars` (`email`, `plate`) VALUES
('marcello.rossi.it@gmail.com', 'DB700MN');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`plate`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `users_cars`
--
ALTER TABLE `users_cars`
  ADD PRIMARY KEY (`email`,`plate`),
  ADD KEY `plate` (`plate`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `users_cars`
--
ALTER TABLE `users_cars`
  ADD CONSTRAINT `users_cars_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_cars_ibfk_2` FOREIGN KEY (`plate`) REFERENCES `cars` (`plate`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
