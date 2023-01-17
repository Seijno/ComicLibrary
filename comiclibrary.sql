-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 14 dec 2022 om 11:02
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comiclibrary`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `book`
--

CREATE TABLE `book` (
  `id` int(10) NOT NULL,
  `title` varchar(256) NOT NULL,
  `genre` varchar(256) NOT NULL,
  `author` varchar(256) NOT NULL,
  `price` int(10) NOT NULL,
  `description` varchar(256) NOT NULL,
  `pdf` blob NOT NULL,
  `image` blob NOT NULL,
  `store_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `library`
--

CREATE TABLE `library` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `store`
--

CREATE TABLE `store` (
  `id` int(10) NOT NULL,
  `name` varchar(256) NOT NULL,
  `owner_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `book`
--
ALTER TABLE `book`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `library`
--
ALTER TABLE `library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `store`
--
ALTER TABLE `store`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
