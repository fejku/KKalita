-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas wygenerowania: 22 Lut 2014, 11:03
-- Wersja serwera: 5.6.14
-- Wersja PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `kkalita`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzial`
--

CREATE TABLE IF NOT EXISTS `dzial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=124 ;

--
-- Zrzut danych tabeli `dzial`
--

INSERT INTO `dzial` (`id`, `nazwa`) VALUES
(1, 'Ogólne'),
(3, 'Drugi_dzial');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE IF NOT EXISTS `komentarze` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` varchar(30) CHARACTER SET latin1 NOT NULL,
  `tekst` text CHARACTER SET latin1 NOT NULL,
  `id_kategoria` tinyint(4) NOT NULL,
  `id_element` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `komentarze`
--

INSERT INTO `komentarze` (`id`, `autor`, `tekst`, `id_kategoria`, `id_element`) VALUES
(1, 'Fejku', 'DUPA', 2, 1),
(2, 'Fejku2', 'Dpuszedasdas', 2, 1),
(3, 'Fee', 'dsadasdsa', 2, 2),
(4, 'DESZTA', 'dsadas', 1, 1),
(5, 'dadas', 'dasdasds', 1, 2),
(6, 'fddfds', 'fsdfsdf', 2, 2),
(7, 'gdfsgdf', 'dfgdsfgdf', 2, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tytul` varchar(50) CHARACTER SET latin1 NOT NULL,
  `obrazek` varchar(50) CHARACTER SET latin1 NOT NULL,
  `dodano` datetime NOT NULL,
  `autor_id` int(11) NOT NULL,
  `tresc` text CHARACTER SET latin1 NOT NULL,
  `dzial_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `news`
--

INSERT INTO `news` (`id`, `tytul`, `obrazek`, `dodano`, `autor_id`, `tresc`, `dzial_id`) VALUES
(1, 'Witam serdecznie', 'sdfafas', '2014-01-28 00:00:00', 1, 'Zapraszam do przegl&#261;dania moich projektów oraz stworzonych przeze mnie stron.', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projekty`
--

CREATE TABLE IF NOT EXISTS `projekty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `obrazek` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opis` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `jezyk` tinyint(4) NOT NULL,
  `bin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zrodlo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dodano` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `projekty`
--

INSERT INTO `projekty` (`id`, `nazwa`, `obrazek`, `opis`, `status`, `jezyk`, `bin`, `zrodlo`, `dodano`) VALUES
(2, 'Gramatyki Lindenmayera', '2.png', 'Program do rysowania graficznych tworów o fraktalnej budowie stworzony na zaliczenie sztucznej inteligencji. Przykładowe reguły znajdują się razem z plikiem wykonalnym. Sposób działania programu jest następujący, podajemy parametry lub wczytujemy reguły z pliku, następnie wciskamy GO. Czekamy na wygenerowanie ciągu, następnie klikamy Rysuj aby zobaczyć wynik.', 1, 1, '2.zip', '2.zip', '2014-01-29 17:31:25'),
(3, 'Płaty Beziera', '3.png', 'Praca magisterska polegająca na wymodelowaniu i symulacji pływającej ryby przy użyciu płatów Beziera. Używam w niej Tao Framework.', 1, 1, '', '3.zip', '2014-01-29 17:31:25'),
(4, 'Kółko i krzyżyk', '4.png', 'Kółko i krzyżyk', 1, 1, '4.zip', '4.zip', '2014-01-29 17:31:25'),
(5, 'Seriale do eseta', '5.png', 'Program pobierający kody do Eseta. Trzeba w "ochronie dostępu do stron internetowych" zezwolić na połączenia ze stroną która jest ustawiona domyślnie w programie.', 1, 1, '5.zip', '5.zip', '2014-01-29 23:12:59'),
(6, 'Drabinka turniejowa ', '6.png', 'Program do generowania drabinki turniejowej niestety przed skończeniem okazał się nie potrzebny więc nie skończyłem go, może jeszcze kiedyś do niego wrócę.', 3, 1, '6.zip', '6.zip', '2014-01-29 23:14:05'),
(7, 'Przechwytywanie klawiatury ', '7.png', 'Program konsolowy do przechwytywanie klawiszy, działa w tle.', 1, 1, '7.zip', '7.zip', '2014-01-29 23:15:11'),
(8, 'Przerwy', '8.png', 'Kolejny program pomagający w ćwiczeniach, a mianowicie odliczający czas przerwy między seriami. Ćwiczenia trzeba wczytywać z pliku, przykładowy plik jest spakowany razem z plikiem wykonalnym.', 1, 1, '8.zip', '8.zip', '2014-01-29 23:15:47'),
(9, 'Środowisko symulacyjne SSN', '9.png', 'Praca inżynierska - Środowisko symulacyjne sztucznych sieci neuronowych. Pozwala na symulowanie wielowarstowych sieci z algorytmem uczenia backpropagation.', 1, 1, '9.zip', '9.zip', '2014-01-29 23:16:23'),
(10, 'Wąż ', '10.png', 'Gra wąż stworzona z nudów.', 1, 1, '10.zip', '10.zip', '2014-01-29 23:17:02'),
(11, 'Odliczacz ', '11.png', 'Program odliczający czas do końca serii.', 1, 1, '11.zip', '11.zip', '2014-01-29 23:23:38'),
(12, 'Rozwiązania SPOJ', '12.png', 'Lista rozwiązanych przeze mnie zadań z polskiego serwisu "SPOJ.com", które pomogły mi się przygotować do konkursu programistycznego na UWM.', 2, 2, '12.zip', '12.zip', '2014-01-29 23:26:22');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tagi`
--

CREATE TABLE IF NOT EXISTS `tagi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `tagi`
--

INSERT INTO `tagi` (`id`, `nazwa`) VALUES
(1, 'ogólne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tagi_news`
--

CREATE TABLE IF NOT EXISTS `tagi_news` (
  `news_id` int(11) NOT NULL,
  `tagi_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`tagi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `tagi_news`
--

INSERT INTO `tagi_news` (`news_id`, `tagi_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 1),
(4, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imie` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nazwisko` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `imie`, `nazwisko`) VALUES
(1, 'fejq', 'a714f1b12d6aec208478d4dcbfa37699d8e09b268ef75848cd3875c22028c3b6', '4ab8e6ba4d97bf6f', 'przecinek45@o2.pl', 'Krystian', 'Kalita'),
(2, 'ola', 'adas', 'asd', 'asdsada@asd.pl', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
