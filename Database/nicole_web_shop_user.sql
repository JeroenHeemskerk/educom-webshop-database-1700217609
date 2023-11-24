-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 24 nov 2023 om 17:04
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nicole_web_shop_user`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `price`, `filename`) VALUES
(1, 'Turing Machine', 'Een leuk kort deductie spel waarin spelers een proto-computer, die zonder elektriciteit of technologie functioneert, ondervragen om een geheimzinnige code te ontcijferen. Zowel alleen, samen als tegen elkaar te spelen met eindeloze raadsels.', 39.95, 'Turing_machine.png'),
(2, 'Fabelfruit', 'Een gezellig competatief spel waarin de spelers druk bezig met het maken van fabelachtige, verfrissende, fruitige, vrolijke frisdrankjes. De ingrediënten voor deze drankjes zijn met de hulp van je dierenvrienden te vinden in het bos.', 28.95, 'Fabelfruit.png'),
(3, 'De Crew', 'Een leuk coöperatief slagenspel waarbij de spelers aan de hand van 50 missies de ruimte trotseren.', 10.99, 'de_crew.png'),
(4, 'Paleo', 'In Paleo speelt elke speler met een groep mensen uit de stam. Daartoe behoren onder andere stoere vrouwelijke krijgers, handige uitvindsters en waakzame verkenners. De spelers vormen samen een volksstam en proberen de omgeving te verkennen. Dat leidt tot telkens nieuwe avonturen.', 25.99, 'paleo.png'),
(5, 'Unlock! 10', 'Unlock! is een coöperatief kaartspel geïnspireerd op escape rooms, waaruit je moet ontsnappen binnen 60 minuten. Unlock! laat je deze ervaring nu thuis aan je eigen tafel beleven met een kaartendeck en een gratis app die je door de diverse scenario\'s leidt. Doorzoek de ruimtes, combineer voorwerpen en los alle puzzels op! Werk goed samen om het avontuur op te lossen.', 27.99, 'Unlock!_10.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(4, 'Nicole Goris', 'nicole@hotmail.nl', '123'),
(5, 'Geert Weggemans', 'coach@man-kind.nl', 'halt!'),
(6, 'Ton Goris', 'ton@hotmail.com', 'halt!'),
(7, 'Alte Venema', 'alte@gmail.com', '890'),
(8, 'Ingrid Goris', 'ingrid@minfin.nl', 'asf'),
(9, 'Sandrine', 'san@gmail.com', '123');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
