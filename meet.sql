-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 18 feb 2018 om 20:23
-- Serverversie: 10.1.25-MariaDB
-- PHP-versie: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meet`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `forgot_password`
--

CREATE TABLE `forgot_password` (
  `password_reset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_unique_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uploads`
--

CREATE TABLE `uploads` (
  `upload_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `upload_name` text NOT NULL,
  `upload_time` datetime NOT NULL,
  `random` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `uploads`
--

INSERT INTO `uploads` (`upload_id`, `user_id`, `upload_name`, `upload_time`, `random`) VALUES
(2, 1, '5a8897088201a6.30599807.jpg', '2018-02-17 21:56:40', '5a89b348566cd5.20433354');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `upload_geo`
--

CREATE TABLE `upload_geo` (
  `upload_id` int(11) NOT NULL,
  `geo_enabled` varchar(5) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `upload_geo`
--

INSERT INTO `upload_geo` (`upload_id`, `geo_enabled`, `address`) VALUES
(1, 'false', ''),
(2, 'true', 'Heerlen, Nederland');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `upload_likes`
--

CREATE TABLE `upload_likes` (
  `like_id` int(11) NOT NULL,
  `upload_id` int(11) NOT NULL,
  `liked_by_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_uid` varchar(20) NOT NULL,
  `user_pwd` text NOT NULL,
  `user_email` text NOT NULL,
  `user_age` int(11) NOT NULL,
  `activated` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `user_uid`, `user_pwd`, `user_email`, `user_age`, `activated`) VALUES
(1, 'justLars7D1', '$2y$10$tQ0iw4/IrKYfYPdKPq6YVOQCFv59Tf3iZukeCnM.dXdZb7mAKTEJu', 'Larsquaedvlieg@outlook.com', 16, '1'),
(2, 'Brammieboy', 'idk', 'bram@bram.bram', 16, '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_following`
--

CREATE TABLE `user_following` (
  `follow_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `user_following`
--

INSERT INTO `user_following` (`follow_id`, `follower_id`, `following_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `user_profile_image` text NOT NULL,
  `user_tag` text NOT NULL,
  `user_special_tag` text NOT NULL,
  `user_total_exp` int(11) NOT NULL,
  `user_profile_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `user_info`
--

INSERT INTO `user_info` (`user_id`, `user_profile_image`, `user_tag`, `user_special_tag`, `user_total_exp`, `user_profile_desc`) VALUES
(1, '5a8897088201a6.30599807.jpg', 'Known Person', 'CEO at Meet Inc.', 0, 'Hi, I am Lars Quaedvlieg, founder and CEO of Meet. Meet is social media website like Instagram, but we edit our content to your likings. We have also added challenges for fun! I hope to see you around');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`password_reset_id`);

--
-- Indexen voor tabel `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`upload_id`);

--
-- Indexen voor tabel `upload_geo`
--
ALTER TABLE `upload_geo`
  ADD PRIMARY KEY (`upload_id`);

--
-- Indexen voor tabel `upload_likes`
--
ALTER TABLE `upload_likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexen voor tabel `user_following`
--
ALTER TABLE `user_following`
  ADD PRIMARY KEY (`follow_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `uploads`
--
ALTER TABLE `uploads`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `upload_likes`
--
ALTER TABLE `upload_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `user_following`
--
ALTER TABLE `user_following`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
