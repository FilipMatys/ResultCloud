-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Neděle 24. listopadu 2013, 13:33
-- Verze MySQL: 5.0.51
-- Verze PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `name`
--

CREATE TABLE IF NOT EXISTS `name` (
  `Id` double NOT NULL auto_increment,
  `FirstName` varchar(64) NOT NULL,
  `LastName` varchar(64) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `name`
--

INSERT INTO `name` (`Id`, `FirstName`, `LastName`) VALUES
(1, 'Filip', 'Matys');

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Id` double NOT NULL auto_increment,
  `Username` varchar(64) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Name` double NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`Id`, `Username`, `Password`, `Email`, `Name`) VALUES
(1, 'admin', 'admin', 'cau@mail.cz', 1);
