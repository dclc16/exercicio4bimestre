-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2019 at 04:57 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ex_4obimestre`
--

-- --------------------------------------------------------

--
-- Table structure for table `cadastro`
--

CREATE TABLE IF NOT EXISTS `cadastro` (
  `id_cadastro` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sexo` char(1) NOT NULL COMMENT 'F = "Feminino" e M = "Masculino"',
  `cod_cidade` int(11) NOT NULL,
  `salario` float NOT NULL,
  PRIMARY KEY (`id_cadastro`),
  KEY `cod_cidade` (`cod_cidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `cadastro`
--

INSERT INTO `cadastro` (`id_cadastro`, `nome`, `email`, `sexo`, `cod_cidade`, `salario`) VALUES
(1, 'Deoclécia', 'deia@gmail.com', 'F', 1, 200),
(4, 'Aida Quaresma de Sousa', 'aida@gmaiil.com', 'F', 1, 20),
(13, 'Amanda Moreira', 'nnda@gmail.com', 'F', 1, 50),
(14, 'Guilherme Colturato', 'gui@gmail.com', 'M', 1, 5000),
(15, 'Jesus Maria José', 'jmj@jj.com', 'M', 1, 10),
(16, 'Jadson Moreira', 'aj@gmail.com', 'F', 3, 50);

-- --------------------------------------------------------

--
-- Table structure for table `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `id_cidade` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cod_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cidade`),
  KEY `cod_estado` (`cod_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cidade`
--

INSERT INTO `cidade` (`id_cidade`, `nome`, `cod_estado`) VALUES
(1, 'Araraquara', 1),
(2, 'Maringá', 1),
(3, 'Curitba', 1),
(5, 'São Carlos', 1),
(6, 'Ibaté', 1),
(7, 'São Paulo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `UF` char(2) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id_estado`, `nome`, `UF`) VALUES
(1, 'São Paulo', 'SP'),
(3, 'Paraná', 'PR');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cadastro`
--
ALTER TABLE `cadastro`
  ADD CONSTRAINT `cadastro_ibfk_1` FOREIGN KEY (`cod_cidade`) REFERENCES `cidade` (`id_cidade`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cidade`
--
ALTER TABLE `cidade`
  ADD CONSTRAINT `cidade_ibfk_1` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
