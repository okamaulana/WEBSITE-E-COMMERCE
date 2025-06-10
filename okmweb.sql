-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 12:26 PM
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
-- Database: `okmweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `pengirim_id` int(11) NOT NULL,
  `penerima_id` int(11) NOT NULL,
  `pesan` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `tipe_file` enum('text','image','zip') DEFAULT 'text',
  `waktu_kirim` datetime DEFAULT current_timestamp(),
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `pengirim_id`, `penerima_id`, `pesan`, `file_path`, `tipe_file`, `waktu_kirim`, `file`) VALUES
(8, 4, 1, 'hai', NULL, 'text', '2025-04-14 13:52:57', NULL),
(11, 4, 1, 'halo anjir', NULL, 'text', '2025-04-14 14:32:34', NULL),
(12, 4, 1, 'yo', NULL, 'text', '2025-04-14 14:34:01', NULL),
(13, 4, 1, 'bg', NULL, 'text', '2025-04-16 15:16:05', NULL),
(14, 1, 4, 'ya gmna?', NULL, 'text', '2025-04-16 15:29:44', NULL),
(15, 4, 1, 'gmna', NULL, 'text', '2025-04-16 15:35:03', NULL),
(16, 4, 1, 'h', NULL, 'text', '2025-04-16 15:35:14', NULL),
(17, 4, 1, 'r', NULL, 'text', '2025-04-16 15:35:18', NULL),
(18, 4, 1, 'wdsd', NULL, 'text', '2025-04-16 15:35:22', NULL),
(19, 1, 4, 'tes', '', 'text', '2025-04-16 15:48:35', NULL),
(20, 1, 4, 'ni fotonya', 'uploads/67ff6ef390a334.17157811.jpg', 'text', '2025-04-16 15:48:51', NULL),
(21, 1, 4, 'tes', '', 'text', '2025-04-16 15:49:13', NULL),
(22, 1, 4, 'ni file nya', 'uploads/NAVY BLUE PAGE DESIGN.jpg', 'text', '2025-04-16 15:51:18', NULL),
(23, 4, 1, 'ni bg', 'uploads/67ff72ec019fb.jpg', '', '2025-04-16 16:05:48', NULL),
(24, 4, 1, 't', 'uploads/67ff733d713f5.jpg', '', '2025-04-16 16:07:09', NULL),
(25, 9, 1, 'p', NULL, 'text', '2025-04-16 18:11:59', NULL),
(26, 1, 9, 'anyeong', '', 'text', '2025-04-16 18:12:11', NULL),
(27, 1, 9, 'hh', 'uploads/akunset6.png', 'text', '2025-04-16 18:12:50', NULL),
(28, 4, 1, 'ha', '', 'text', '2025-04-16 19:08:01', NULL),
(29, 4, 1, '', 'uploads/1744805289_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 19:08:09', NULL),
(30, 4, 1, '', 'uploads/1744805839_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 19:17:19', NULL),
(31, 4, 1, 'halo anjir', '', 'text', '2025-04-16 19:37:02', NULL),
(32, 4, 1, '', 'uploads/1744807295_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 19:41:35', NULL),
(33, 4, 1, '', 'uploads/1744807385_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 19:43:05', NULL),
(34, 4, 1, '', 'uploads/1744807600_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 19:46:40', NULL),
(35, 4, 1, '', 'uploads/1744807998_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 19:53:18', NULL),
(36, 4, 1, '', 'uploads/1744808009_OKA MAULANA 2205903040045 SISTEM BERBASIS ENTERPRISE.pdf', '', '2025-04-16 19:53:29', NULL),
(37, 4, 1, 'oo', '', 'text', '2025-04-16 19:55:24', NULL),
(38, 1, 9, 'u have money?', '', 'text', '2025-04-16 19:56:11', NULL),
(39, 1, 9, 'tuh', '', 'text', '2025-04-16 19:56:53', NULL),
(40, 1, 9, 'p', 'uploads/akunset5.png', 'text', '2025-04-16 19:57:07', NULL),
(41, 9, 1, '', 'uploads/1744808280_OKA MAULANA 2205903040045 SISTEM BERBASIS ENTERPRISE.pdf', '', '2025-04-16 19:58:00', NULL),
(42, 1, 9, 'hey', '', 'text', '2025-04-16 19:58:19', NULL),
(43, 1, 9, 'yo', '', 'text', '2025-04-16 19:58:22', NULL),
(44, 1, 9, 'pookie mac', '', 'text', '2025-04-16 19:58:32', NULL),
(45, 1, 9, 'upin', '', 'text', '2025-04-16 20:02:49', NULL),
(46, 6, 1, 'p', '', 'text', '2025-04-16 21:14:56', NULL),
(47, 6, 1, '', 'uploads/1744812902_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 21:15:02', NULL),
(48, 6, 1, 'tes', '', 'text', '2025-04-16 21:15:29', NULL),
(49, 6, 1, 'yoo', '', 'text', '2025-04-16 21:15:41', NULL),
(50, 6, 1, '', 'uploads/1744812946_NAVY BLUE PAGE DESIGN.jpg', '', '2025-04-16 21:15:46', NULL),
(51, 1, 6, 'jj', '', 'text', '2025-04-16 21:23:24', NULL),
(52, 4, 1, 'hg', '', 'text', '2025-04-16 21:51:24', NULL),
(53, 1, 12, 'halo', '', 'text', '2025-04-16 22:18:03', NULL),
(54, 1, 12, 'p', '', 'text', '2025-04-16 22:18:15', NULL),
(55, 12, 1, 'hlo', '', 'text', '2025-04-16 22:19:34', NULL),
(56, 12, 1, 'tes', '', 'text', '2025-04-16 22:19:43', NULL),
(57, 1, 12, 'p', '', 'text', '2025-04-16 22:20:28', NULL),
(58, 1, 12, 'halo', '', 'text', '2025-04-16 22:20:39', NULL),
(59, 1, 12, 'p', '', 'text', '2025-04-16 22:21:55', NULL),
(60, 1, 12, 'p', '', 'text', '2025-04-16 22:22:02', NULL),
(61, 1, 12, 'y', '', 'text', '2025-04-16 22:22:09', NULL),
(62, 1, 12, 'p', '', 'text', '2025-04-16 22:23:56', NULL),
(63, 1, 12, 'halo', '', 'text', '2025-04-16 22:24:05', NULL),
(64, 1, 12, 'tes', '', 'text', '2025-04-16 22:24:35', NULL),
(65, 12, 1, 'yo', '', 'text', '2025-04-16 22:24:40', NULL),
(66, 1, 12, 'halo', '', 'text', '2025-04-16 22:24:49', NULL),
(67, 1, 12, 'hlo', '', 'text', '2025-04-16 22:25:00', NULL),
(68, 1, 12, 'halo', '', 'text', '2025-04-16 22:28:04', NULL),
(69, 1, 12, 'hlo', '', 'text', '2025-04-16 22:28:16', NULL),
(70, 12, 1, 'ypp', '', 'text', '2025-04-16 22:33:04', NULL),
(71, 1, 12, 'halo', '', 'text', '2025-04-16 22:34:02', NULL),
(72, 12, 1, 'p', '', 'text', '2025-04-16 22:37:07', NULL),
(73, 1, 12, 'iya?', '', 'text', '2025-04-16 22:37:13', NULL),
(74, 1, 12, 'o', '', 'text', '2025-04-16 22:37:26', NULL),
(75, 1, 12, 'z', '', 'text', '2025-04-16 22:37:33', NULL),
(76, 1, 12, 'p', '', 'text', '2025-04-16 22:43:33', NULL),
(77, 1, 12, 'ppp', '', 'text', '2025-04-16 22:43:52', NULL),
(78, 12, 1, 'mam', '', 'text', '2025-04-16 22:44:11', NULL),
(79, 12, 1, 'akkk', '', 'text', '2025-04-16 22:46:07', NULL),
(80, 1, 12, 'yoo', '', 'text', '2025-04-16 22:46:13', NULL),
(81, 1, 12, 'yoo', '', 'text', '2025-04-16 22:46:25', NULL),
(82, 12, 1, 'kk', '', 'text', '2025-04-16 22:52:39', NULL),
(83, 1, 12, 'pp', '', 'text', '2025-04-16 22:52:44', NULL),
(84, 1, 12, 'u have money?', '', 'text', '2025-04-16 22:55:31', NULL),
(85, 12, 1, 'p', '', 'text', '2025-04-16 22:55:35', NULL),
(86, 12, 1, 'p', '', 'text', '2025-04-16 22:55:41', NULL),
(87, 12, 1, 'y', '', 'text', '2025-04-16 22:55:43', NULL),
(88, 1, 4, 'hlo el', '', 'text', '2025-04-16 23:29:11', NULL),
(89, 4, 1, 'iya knpa', '', 'text', '2025-04-16 23:29:18', NULL),
(90, 1, 4, 'p', '', 'text', '2025-04-16 23:35:59', NULL),
(91, 4, 1, 'yoo', '', 'text', '2025-04-16 23:36:06', NULL),
(92, 4, 1, 'p', '', 'text', '2025-04-17 14:58:49', NULL),
(93, 4, 1, 'p', '', 'text', '2025-04-17 14:59:02', NULL),
(94, 4, 1, 'p', '', 'text', '2025-04-17 15:04:30', NULL),
(95, 4, 1, 'l', '', 'text', '2025-04-17 15:04:37', NULL),
(96, 1, 4, 'p', '', 'text', '2025-04-17 15:06:06', NULL),
(97, 4, 1, 'p', '', 'text', '2025-04-17 15:06:10', NULL),
(98, 4, 1, 'ga', '', 'text', '2025-04-17 15:06:59', NULL),
(99, 4, 1, 'p', '', 'text', '2025-04-17 15:08:11', NULL),
(100, 4, 1, 'p', '', 'text', '2025-04-17 15:08:20', NULL),
(101, 4, 1, 'p', '', 'text', '2025-04-17 15:08:26', NULL),
(102, 4, 1, 'p', '', 'text', '2025-04-17 15:10:39', NULL),
(103, 4, 1, 'p', '', 'text', '2025-04-17 15:15:50', NULL),
(104, 4, 1, 'p', '', 'text', '2025-04-17 15:16:59', NULL),
(105, 4, 1, 'p', '', 'text', '2025-04-17 15:18:14', NULL),
(106, 4, 1, 'p', '', 'text', '2025-04-17 15:20:02', NULL),
(107, 4, 1, 'l', '', 'text', '2025-04-17 15:20:07', NULL),
(108, 1, 4, 'p', '', 'text', '2025-04-17 15:20:36', NULL),
(109, 1, 4, 'p', '', 'text', '2025-04-17 15:20:38', NULL),
(110, 4, 1, 'p', '', 'text', '2025-04-17 15:20:46', NULL),
(111, 4, 1, 'p', '', 'text', '2025-04-17 15:22:45', NULL),
(112, 4, 1, 'p', '', 'text', '2025-04-17 15:40:05', NULL),
(113, 4, 1, 'p', '', 'text', '2025-04-17 15:43:44', NULL),
(114, 4, 1, 'pw', '', 'text', '2025-04-17 15:44:42', NULL),
(115, 4, 1, 'l', '', 'text', '2025-04-17 15:46:18', NULL),
(116, 4, 1, 'g', '', 'text', '2025-04-17 15:48:40', NULL),
(117, 4, 1, 'lol', '', 'text', '2025-04-17 15:49:07', NULL),
(118, 4, 1, 'lol', '', 'text', '2025-04-17 15:49:17', NULL),
(119, 4, 1, 'g', '', 'text', '2025-04-17 15:50:26', NULL),
(120, 4, 1, 'sa', '', 'text', '2025-04-17 15:51:38', NULL),
(121, 4, 1, 'lk', '', 'text', '2025-04-17 15:52:51', NULL),
(122, 4, 1, 'halo', '', 'text', '2025-04-17 16:00:59', NULL),
(123, 4, 1, 'p', '', 'text', '2025-04-17 16:06:33', NULL),
(124, 4, 1, 'p', '', 'text', '2025-04-17 16:06:36', NULL),
(125, 4, 1, 'p', '', 'text', '2025-04-17 16:07:30', NULL),
(126, 4, 1, 'ff', '', 'text', '2025-04-17 16:08:36', NULL),
(127, 4, 1, 'p', '', 'text', '2025-04-17 16:12:28', NULL),
(128, 4, 1, 'ana', '', 'text', '2025-04-17 16:13:13', NULL),
(129, 4, 1, 'fg', '', 'text', '2025-04-17 16:16:05', NULL),
(130, 4, 1, 'p', '', 'text', '2025-04-17 16:16:20', NULL),
(131, 4, 1, 'p', '', 'text', '2025-04-17 16:16:26', NULL),
(132, 1, 4, 'p', '', 'text', '2025-04-17 16:17:10', NULL),
(133, 4, 1, 'ad', '', 'text', '2025-04-17 16:17:14', NULL),
(134, 1, 4, 'oi', '', 'text', '2025-04-17 16:17:31', NULL),
(135, 1, 4, 'oi', '', 'text', '2025-04-17 16:17:41', NULL),
(136, 4, 1, 'p', '', 'text', '2025-04-17 16:18:13', NULL),
(137, 1, 4, 'p', '', 'text', '2025-04-17 16:18:17', NULL),
(138, 1, 4, 'kk', '', 'text', '2025-04-17 16:18:25', NULL),
(139, 4, 1, 'kaka', '', 'text', '2025-04-17 16:18:33', NULL),
(140, 4, 1, 'kaka', '', 'text', '2025-04-17 16:18:41', NULL),
(141, 4, 1, 'p', '', 'text', '2025-04-17 16:19:24', NULL),
(142, 4, 1, 'p', '', 'text', '2025-04-17 16:19:32', NULL),
(143, 4, 1, 'll', '', 'text', '2025-04-17 16:19:41', NULL),
(144, 4, 1, 'p', '', 'text', '2025-04-17 16:19:44', NULL),
(145, 4, 1, 'p', '', 'text', '2025-04-17 16:20:10', NULL),
(146, 4, 1, 'halo', '', 'text', '2025-04-17 16:21:22', NULL),
(147, 4, 1, 'p', '', 'text', '2025-04-17 16:22:10', NULL),
(148, 4, 1, 'tes', '', 'text', '2025-04-17 16:22:40', NULL),
(149, 4, 1, 'pp', '', 'text', '2025-04-17 16:24:51', NULL),
(150, 4, 1, 'lol', '', 'text', '2025-04-17 16:25:40', NULL),
(151, 4, 1, 'papa', '', 'text', '2025-04-17 16:25:50', NULL),
(152, 4, 1, 'p', '', 'text', '2025-04-17 16:28:17', NULL),
(153, 4, 1, 'pp', '', 'text', '2025-04-17 16:29:11', NULL),
(154, 4, 1, 'p', '', 'text', '2025-04-17 16:34:26', NULL),
(155, 1, 4, 'lol', '', 'text', '2025-04-17 16:34:56', NULL),
(156, 1, 4, 'lo', '', 'text', '2025-04-17 16:35:23', NULL),
(157, 1, 4, 'p', '', 'text', '2025-04-17 16:35:31', NULL),
(158, 1, 4, 'pp', '', 'text', '2025-04-17 16:35:35', NULL),
(159, 4, 1, 'pp', '', 'text', '2025-04-17 16:35:41', NULL),
(160, 1, 4, 'y?', '', 'text', '2025-04-17 16:35:51', NULL),
(161, 4, 1, 'tes', '', 'text', '2025-04-17 16:40:52', NULL),
(162, 4, 1, 'p', '', 'text', '2025-04-17 16:42:53', NULL),
(163, 4, 1, 'p', '', 'text', '2025-04-17 16:45:15', NULL),
(164, 4, 1, 'halo', '', 'text', '2025-04-17 16:45:40', NULL),
(165, 1, 4, 'p', '', 'text', '2025-04-17 16:47:05', NULL),
(166, 4, 1, 'ya?', '', 'text', '2025-04-17 16:47:10', NULL),
(167, 4, 1, 'apsb', '', 'text', '2025-04-17 17:04:43', NULL),
(168, 4, 1, 'p', '', 'text', '2025-04-17 17:14:10', NULL),
(169, 4, 1, 'p', '', 'text', '2025-04-17 17:17:36', NULL),
(170, 1, 4, 'y?', '', 'text', '2025-04-17 17:18:13', NULL),
(171, 4, 1, 'p', '', 'text', '2025-04-17 17:18:31', NULL),
(172, 1, 4, 'w', '', 'text', '2025-04-17 17:18:39', NULL),
(173, 4, 1, 'p', '', 'text', '2025-04-17 17:18:43', NULL),
(174, 4, 1, 'pp', '', 'text', '2025-04-17 17:18:49', NULL),
(175, 4, 1, 'yoo', '', 'text', '2025-04-17 17:19:00', NULL),
(176, 1, 4, 'pp', '', 'text', '2025-04-17 17:19:06', NULL),
(177, 1, 4, 'p', '', 'text', '2025-04-17 17:19:33', NULL),
(178, 1, 4, 'yo', '', 'text', '2025-04-17 17:19:39', NULL),
(179, 4, 1, 'hab', '', 'text', '2025-04-17 17:19:47', NULL),
(180, 4, 1, 'p', '', 'text', '2025-04-17 17:19:52', NULL),
(181, 1, 4, 'hlo', '', 'text', '2025-04-17 17:21:21', NULL),
(182, 1, 4, 'hlo', '', 'text', '2025-04-17 17:21:37', NULL),
(183, 1, 4, 'hlo', '', 'text', '2025-04-17 17:21:45', NULL),
(184, 1, 4, 'hlo', '', 'text', '2025-04-17 17:21:48', NULL),
(185, 1, 4, 'p', '', 'text', '2025-04-17 17:21:52', NULL),
(186, 1, 4, 'i', '', 'text', '2025-04-17 17:22:01', NULL),
(187, 1, 4, 'hlo cuk', '', 'text', '2025-04-17 17:22:39', NULL),
(188, 4, 1, 'iya?', '', 'text', '2025-04-17 17:22:43', NULL),
(189, 4, 1, 'ya?', '', 'text', '2025-04-17 17:22:51', NULL),
(190, 1, 4, 'gmn', '', 'text', '2025-04-17 17:22:56', NULL),
(191, 4, 1, 'poi', '', 'text', '2025-04-17 17:25:40', NULL),
(192, 4, 1, 'p', '', 'text', '2025-04-17 17:48:21', NULL),
(193, 4, 1, 'y', '', 'text', '2025-04-17 17:48:26', NULL),
(194, 1, 4, 'P', '', 'text', '2025-04-17 17:48:33', NULL),
(195, 1, 4, 'P', '', 'text', '2025-04-17 17:49:45', NULL),
(196, 1, 4, 'P', '', 'text', '2025-04-17 17:50:19', NULL),
(197, 1, 4, 'P', '', 'text', '2025-04-17 17:50:49', NULL),
(198, 1, 4, 'H', '', 'text', '2025-04-17 17:50:55', NULL),
(199, 1, 4, 'PI', '', 'text', '2025-04-17 17:51:52', NULL),
(200, 4, 1, 'k', '', 'text', '2025-04-17 17:51:59', NULL),
(201, 1, 4, 'P', '', 'text', '2025-04-17 18:00:56', NULL),
(202, 1, 4, 'P', '', 'text', '2025-04-17 18:01:22', NULL),
(203, 1, 11, 'P', '', 'text', '2025-04-17 18:39:51', NULL),
(204, 11, 1, 'hm', '', 'text', '2025-04-17 18:40:27', NULL),
(205, 1, 11, 'P', '', 'text', '2025-04-17 18:40:29', NULL),
(206, 1, 4, 'p', '', 'text', '2025-04-17 20:43:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hubungi_kami`
--

CREATE TABLE `hubungi_kami` (
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `pesan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hubungi_kami`
--

INSERT INTO `hubungi_kami` (`nama`, `email`, `no_hp`, `pesan`) VALUES
('Selfia istri jaehyun', 'istrijae@gmail.com', '', 'i love u'),
('benjamin', 'benjamin@gmail.com', '', 'perbagus lagi tampilannya');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(5, 'WEB DEVELOPER'),
(6, 'LOGO DESIGN'),
(7, 'IMAGE EDITING'),
(8, 'VIDEO EDITING'),
(9, 'INTRO & OUTRO VIDEOS'),
(10, 'PROMOSI ENDORSEMENT'),
(11, 'LOGO ANIMATION');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `total_pendapatan` double DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_pendapatan`
--

CREATE TABLE `laporan_pendapatan` (
  `id` int(11) NOT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `total_pendapatan` bigint(20) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_pendapatan`
--

INSERT INTO `laporan_pendapatan` (`id`, `bulan`, `tahun`, `total_pendapatan`, `dibuat_pada`) VALUES
(1, '04', 2025, 5000000, '2025-04-29 05:16:49'),
(2, '05', 2025, 120000, '2025-05-08 08:02:10'),
(3, '06', 2025, 200000, '2025-06-10 10:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `produk` varchar(100) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `status` enum('Menunggu Pembayaran','Diproses','Diterima','Ditolak','Selesai') DEFAULT 'Menunggu Pembayaran',
  `created_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama`, `produk`, `harga`, `status`, `created_at`, `user_id`) VALUES
(5, NULL, 'tes dulu', 50000, 'Selesai', '2025-04-29 13:31:25', 3),
(6, NULL, 'tes dulu', 2000, 'Selesai', '2025-04-29 21:13:10', 6),
(7, NULL, 'website pabrik', 2000000, 'Selesai', '2025-04-29 22:20:52', 4),
(9, NULL, 'Pepaya', 200000, 'Selesai', '2025-06-10 17:24:03', 4);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `deskripsi`, `kategori_id`, `foto`) VALUES
(6, 'Pepaya', 20000, 'eee', 5, '[\"1749550974_1744013063_amazon.jpg\",\"1749550974_1744013063_download (1).jpg\",\"1749550974_1744013063_download.jpg\"]');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `isi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','customer') NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `no_hp`, `username`, `password`, `role`, `foto`) VALUES
(1, 'admin@gmail.com', '082277580167', 'admin', '$2a$12$tTMl9VLrmp7qpSGL1zl/SeFpCdyg.EXNXl0IzauEWJ9og2lu56H.q', 'admin', '1749550019_logol.jpg'),
(3, 'benjamin@gmail.com', '082277580163', 'benjamin', '$2a$12$6le67woxAKobU3y1vGTu9uLDmKaYB328ppk04jpgdF6c62YkznKx6', 'customer', '1744011233_20221113_180006.jpg'),
(4, 'eliot@gmail.com', '085277384355', 'eliot', '$2y$10$4QLRIPrPtJ.shT3EwfDGMOE1dYx8dOelLybLvqv.IJoV9QrZjKwvy', 'customer', '1744011405_Remini20210823145935418.jpg'),
(6, 'oka77mbo@gmail.com', '-', 'oka77mbo', '$2y$10$nIwcp474jE81oCHYt5GxAO4smTEaRfkrVEHwL/tbPNv.zdEyPoGoi', 'customer', 'https://lh3.googleusercontent.com/a/ACg8ocIDK5fxXEaFkCydBIH1AI2syoHTVd-ZFphUb-PKcPkelKCYZw=s96-c'),
(7, 'okamaulana008@gmail.com', '-', 'okamaulana008', '$2y$10$zdtqoEdq0qC4GUKRHixszuOhWWiSp265UE1fPAenMrI2aVeXJNw7m', 'customer', 'https://lh3.googleusercontent.com/a/ACg8ocLc4JV_ZFbBqv1vlX18l09txXnRpX0eXc0ZVgPpUOKeUTeLPw=s96-c'),
(8, 'okmindustries@gmail.com', '-', 'okmindustries', '$2y$10$1Yr8nZN6Oyr6HnbYRuTLcuV/hhTw/OXN8xwKf0MKRqmYGsOkNzxcC', 'customer', 'https://lh3.googleusercontent.com/a/ACg8ocKV24Mq6MrwxB2L_BIJ2Sw8yRRbeuXVwSUbAc4n5v020PysBsU=s96-c'),
(9, 'upin@gmail.com', '082672537171', 'upin', '$2y$10$urX2o4d7xJXbMhkYXyqdTe5dgmspDU.Dm8c0B/tOUeKy77EnvRRz2', 'customer', ''),
(10, 'canonkita9@gmail.com', '-', 'canonkita9', '$2y$10$3COzi.7.Hvyo1UUJFtcWtOj2d1Ev/ck3i3he2P4QwR2P1YPR9BRc.', 'customer', 'https://lh3.googleusercontent.com/a/ACg8ocLDhQ-ZvGtb25DWOAQL1-31bDAsiq5Xw71TVIBSLXM-XqtU9Q=s96-c'),
(11, 'tese@gmail.com', '098646754644', 'tese', '$2a$12$ShtjH7ACunMGqdlqoYc8MOYkxzMUNQfp4s7w9iVKbAgcVTptVIdgG', 'customer', ''),
(12, 'kelompokgtk@gmail.com', '082277580168', 'gtk', '$2y$10$MZVzPkO5DjOSry4ANgO1reFgW4VU.JKREb8uq.zoU0k8orr6TDl9e', 'customer', ''),
(13, 'selpiaistritoji@gmail.com', '08999999', 'toji', '$2y$10$u4a9S9JCqjF/WOyIN5TOn.v8zpiSl7QLpurNpM/gxDsprzFSFRjsq', 'customer', '1745913923_download.png'),
(14, 'newcat101010@gmail.com', '-', 'newcat101010', '$2y$10$GuVX.6ODBnIGDVXQ6q5tbuxjVd4hmKBkoiMahRLpw4BJ95p4yv/Cu', 'customer', 'https://lh3.googleusercontent.com/a/ACg8ocJtUb2VrqggxX42kmNhTN3auss3xeLypu-nIoyA26jJnurPrQ=s96-c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengirim_id` (`pengirim_id`),
  ADD KEY `penerima_id` (`penerima_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_pendapatan`
--
ALTER TABLE `laporan_pendapatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_pendapatan`
--
ALTER TABLE `laporan_pendapatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
