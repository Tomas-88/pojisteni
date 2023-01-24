-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 24. led 2023, 12:52
-- Verze serveru: 10.4.27-MariaDB
-- Verze PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `pojistovna`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `pojisteni`
--

CREATE TABLE `pojisteni` (
  `pojisteni_id` int(11) NOT NULL,
  `pojistenec_id` int(11) NOT NULL,
  `typ_pojisteni` varchar(255) NOT NULL,
  `castka` int(11) DEFAULT NULL,
  `platnost_od` date DEFAULT NULL,
  `platnost_do` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `pojisteni`
--

INSERT INTO `pojisteni` (`pojisteni_id`, `pojistenec_id`, `typ_pojisteni`, `castka`, `platnost_od`, `platnost_do`) VALUES
(1, 1, 'Životní pojištění', 2000000, '2023-04-08', '2024-02-04'),
(2, 2, 'Cestovní pojištění', 5000, '2023-03-13', '2024-03-19'),
(3, 3, 'Cestovní pojištění', 48000, '2023-05-01', '2024-04-10'),
(4, 4, 'Životní pojištění', 20000, '2023-11-17', '2024-08-26'),
(5, 5, 'Úrazové pojištění', 9000000, '2023-07-01', '2024-03-28'),
(6, 6, 'Pojištění domácnosti', 5800000, '2024-05-16', '2025-01-17'),
(7, 7, 'Životní pojištění', 7600000, '2023-07-16', '2024-06-28'),
(8, 8, 'Úrazové pojištění', 1000000, '2023-04-21', '2024-09-04'),
(9, 9, 'Životní pojištění', 3000000, '2023-02-17', '2024-12-27'),
(10, 10, 'Životní pojištění', 4800000, '2023-04-05', '2024-02-24'),
(11, 11, 'Pojištění domácnosti', 200000, '2023-04-04', '2023-04-22'),
(12, 12, 'Pojištění domácnosti', 2000000, '2023-03-06', '2024-10-31'),
(13, 13, 'Životní pojištění', 1000000, '2023-02-05', '2024-05-21'),
(14, 14, 'Úrazové pojištění', 6600000, '2023-02-19', '2024-02-05'),
(15, 15, 'Úrazové pojištění', 3800000, '2023-02-01', '2024-05-28');

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE `uzivatele` (
  `uzivatel_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jmeno` varchar(255) NOT NULL,
  `prijmeni` varchar(255) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `mesto` varchar(255) NOT NULL,
  `psc` int(10) NOT NULL,
  `heslo` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`uzivatel_id`, `email`, `jmeno`, `prijmeni`, `adresa`, `mesto`, `psc`, `heslo`, `admin`) VALUES
(1, 'Conrad_Frizzell61@example.com', 'Conrad', 'Holt', 'Ridlerstraße 8', 'Metten', 91821, 'MFTTXHfm/um1v2mbDhfNHw==', 1),
(2, 'Schuler@example.com', 'Morgan', 'Pointer', 'Kaiserplatz 1', 'Konradsmühle', 16831, '6/qo4PQd1lQZU9dqtsX0WQ==', 0),
(3, 'ZapataF@example.com', 'Micheal', 'Leyva', 'Edlingerplatz 11-15', 'Mettendorf', 94981, '5kmx/JKKtXW4C3KmrNcG4Q==', 0),
(4, 'Sanford549@nowhere.com', 'Adam', 'Esquivel', 'Arberstraße 75', 'Heroldsberg', 27381, 'c5fQ9fnIqYv6YsQWp9HisA==', 1),
(5, 'Barr@nowhere.com', 'Kittie', 'Holton', 'Pfeuferstraße 1', 'Konradsreuth', 13938, '4RasIF7uT1TZ86waM+wzVw==', 1),
(6, 'Almanza@example.com', 'Stefani', 'Hammond', 'Lothringer Straße 47c', 'Zwota', 19427, 'ZHShVr7WO3NIJr/DZUO0Gw==', 0),
(7, 'Ron.Irish@example.com', 'Madelene', 'Wasson', 'Ampfingstraße 2b', 'Mettenheim', 21438, '2IbF+/zSyPBmz0jhfqwTAw==', 0),
(8, 'ktercnnp_okcisx@example.com', 'Ramiro', 'Carl', 'Pariser Platz 1', 'Geldersheim', 94918, 'nq0B8WOvX0LxMy+k/ulDmw==', 0),
(9, 'mnksgeiq8021@example.com', 'Abraham', 'Estep', 'Roecklplatz 4', 'Quittelsdorf', 66589, 'cd9GRwf+BgIX2pT8Oxa2BQ==', 1),
(10, 'Atwood@nowhere.com', 'Amos', 'Hammonds', 'Simeonistraße 5', 'Neu Heinde', 64676, 'SopdFQq8Y8yRD8ITna6gsA==', 0),
(11, 'Sima_Call6@example.com', 'Josef', 'Smyth', 'Am Nockherberg 1d', 'Quitzdorf am See', 27316, 'o1h8RkAexUuaCOMkSJ8kpQ==', 1),
(12, 'Kirk.HKoehler@nowhere.com', 'Keira', 'Waterman', 'Haimhauserstraße 11-17', 'Konstanz', 78243, 'e8mRHr+2Uvk/8h+44ssvlg==', 1),
(13, 'EdmundBenitez631@example.com', 'Abby', 'Libby', 'Pariser Straße 1f', 'Burgbretzingen', 45685, 'o+S25/zXxfr6ZUxS2RGdZQ==', 0),
(14, 'Salley69@nowhere.com', 'Cathryn', 'Meredith', 'Residenzstraße 2', 'Metterich', 45708, 'XSwMC4Dvq4n30ADCD3+oBw==', 0),
(15, 'Kiefer@nowhere.com', 'Gail', 'Poirier', 'Pfeuferstraße 1', 'Zaisenhausen', 72096, '53eMlwK5YIqQgaOh4X+kCg==', 0),
(16, 'kuruc.tomas@gmail.com', 'Tomas', 'Kuruc', 'Georg', 'Videň', 1210, '$2y$10$euMFqJTQnhMcQSbQKDgeZeeNsWyZzRvhVaTdCwKK8piAaa05s2Dqy', 1);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `pojisteni`
--
ALTER TABLE `pojisteni`
  ADD PRIMARY KEY (`pojisteni_id`);

--
-- Indexy pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`uzivatel_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `pojisteni`
--
ALTER TABLE `pojisteni`
  MODIFY `pojisteni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `uzivatel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
