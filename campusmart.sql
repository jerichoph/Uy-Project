-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 04:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campusmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'afojyo8PX+YfhjxZ7GlSBg==', 'E3nvfK6VwlRB5a9iLOfkYwSAGADE5zS1o/5zNx7yw6s=', '$2y$10$881R07sdIzClvxI8hvVSn.Hm1doeAz.sYqARXzBVtGTcLQc31vWaK');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT 'General'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `category`) VALUES
(3, 'Calculus Textbook', 50, 'Calculus textbooks provide a foundational guide to studying change, covering key concepts such as derivatives, integrals, and multivariable calculus. They typically feature a structured progression from functions and limits to techniques of integration, Taylor series, and vector calculus, often accompanied by illustrative graphs, practical examples, and exercises.', 'General'),
(4, 'Ruler', 20, 'Ruler for measuring on a paper', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `is_banned`) VALUES
(8, 'uxvq2HBR1JlAZ6u1X/tUxQ==', 'NXXVFWWBz6M1ozjXKWTCSqOlSqx+ycFYEX2sHSM1yio=', 'Xc+5joIqVxu79mLhHVeM8A==', '$2y$10$AwEhSj4AAqhyzKDQjpKCwOLmnyYmEfIPjPsAm7YEav7lc9HC6qq1C', 0),
(9, 'ReQOA0zENfdwo3s996k4Rw==', 'XuosPM1fkHl/mBIvJEcnS8EKZN7whBA5wA9OIEzWs6A=', 'd6lDavqDhqaMb2ej+Dn1WQ==', '$2y$10$Yp1S655RH619n8N5JKCqAe8/5InzlAsJRstCD29pUlovyL.3QDuJa', 0),
(10, 'dUnO3Q35ZWRtd3OdHT1fSg==', 'XN00o4FWAQd57sPokz7I3sEKZN7whBA5wA9OIEzWs6A=', 'TIhZGGQ9IG0luYRNbXpREg==', '$2y$10$OF8MDQ9S69c1mDq3e4snDOvwCRY3m89WbCVNtpTWmutg566oHfiMi', 0),
(11, '0J0cshuV/q0epR/Jg43OqA==', 'F30teb2t8yKvZ9QDESOs6g==', '5nBRfgL1BrbF/R19oUYtNg==', '$2y$10$TpK4WimDr4NdMx8iizLSqeLqj0eFYkIw1/RIw3WkKVzGDKGpw9fZG', 0),
(12, 'm5W6wSYgrl4xEE7mrXGsBw==', '9mg7GOg3dcrYXsL51ymhpg==', 'Ih67eUZnXryaZaO3Wr1zSA==', '$2y$10$ROk2UvUOq3TyI7uFNHIwJ.q5LeoJRg6f36dG93pONjH1oWalhe93.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
