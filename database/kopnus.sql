-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2022 at 06:41 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kopnus`
--

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `lamaran_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `perkerjaan_id` int(11) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lamaran`
--

INSERT INTO `lamaran` (`lamaran_id`, `user_id`, `perkerjaan_id`, `catatan`) VALUES
(1, 7, 1, 'Dengan ini saya ingin sampaikan bahwa saya tertarik dan ingin melamar perkerjaan '),
(3, 7, 1, 'dengan ini saya ');

-- --------------------------------------------------------

--
-- Table structure for table `perkerjaan`
--

CREATE TABLE `perkerjaan` (
  `perkerjaan_id` int(11) NOT NULL,
  `nama_perkerjaan` varchar(128) NOT NULL,
  `status` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `syarat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perkerjaan`
--

INSERT INTO `perkerjaan` (`perkerjaan_id`, `nama_perkerjaan`, `status`, `deskripsi`, `syarat`) VALUES
(1, 'Back End Developer', 1, 'Membuat api', 'Lulusan Teknik informatika, teknik komputer atau sejenisnya'),
(2, 'Front End', 1, 'membuat front end aplikasi', 'menguasai javascript'),
(4, 'Full Stack', 1, 'membuat aplikasi', 'menguasai javascript');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `nama_role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `nama_role`) VALUES
(0, 'user'),
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role_id` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `nama`, `email`, `password`, `role_id`, `create_at`) VALUES
(1, 'nadia', 'nadia', 'nadia@gmail.com', '$2y$10$hacuAksAdLSAGjYwfCxx6.pRZwNfdb.DzHUWnSeguiNY/cnp5k1Hm', 1, '2022-11-08 03:42:57'),
(7, 'abelpermata', 'abel p', 'abel@gmail.com', '$2y$10$kFa/vqn28uyTM6ZaQJEkhexUeGD6Zz.wJtixNofIlmjByHjcRJuFe', 0, '2022-11-08 04:27:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`lamaran_id`);

--
-- Indexes for table `perkerjaan`
--
ALTER TABLE `perkerjaan`
  ADD PRIMARY KEY (`perkerjaan_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `lamaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `perkerjaan`
--
ALTER TABLE `perkerjaan`
  MODIFY `perkerjaan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
