-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 18/04/2026 às 11:36
-- Versão do servidor: 10.11.10-MariaDB-log
-- Versão do PHP: 8.5.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `paradise`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `page` varchar(255) NOT NULL,
  `state` varchar(2) DEFAULT NULL,
  `country` varchar(2) DEFAULT 'BR',
  `referrer` varchar(512) DEFAULT NULL,
  `user_agent` varchar(512) DEFAULT NULL,
  `ip_hash` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `analytics`
--

INSERT INTO `analytics` (`id`, `session_id`, `page`, `state`, `country`, `referrer`, `user_agent`, `ip_hash`, `created_at`) VALUES
(1, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'android-app://com.google.android.googlequicksearchbox/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 21:58:25'),
(2, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'android-app://com.google.android.googlequicksearchbox/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:00:30'),
(3, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'android-app://com.google.android.googlequicksearchbox/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:00:39'),
(4, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:02:35'),
(5, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:02:45'),
(6, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:02:52'),
(7, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:03:01'),
(8, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:03:16'),
(9, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:03:31'),
(10, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:03:46'),
(11, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:04:01'),
(12, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:04:16'),
(13, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:04:31'),
(14, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:04:46'),
(15, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:05:01'),
(16, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:05:16'),
(17, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:05:22'),
(18, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:05:30'),
(19, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:05:46'),
(20, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:06:01'),
(21, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:06:31'),
(22, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:06:36'),
(23, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:06:44'),
(24, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:07:07'),
(25, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:07:14'),
(26, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:07:16'),
(27, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:07:45'),
(28, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:07:46'),
(29, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:08:15'),
(30, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:08:45'),
(31, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:08:56'),
(32, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:09:02'),
(33, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:09:13'),
(34, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:09:44'),
(35, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:09:56'),
(36, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'android-app://com.google.android.googlequicksearchbox/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:10:06'),
(37, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:10:13'),
(38, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463106876-28w3ps51yw17c&sck=KW-1776463106876-28w3ps51yw17c', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:10:36'),
(39, 'l6juhmza4dmo3gf558', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463373456-4kr030kc8njzf&sck=KW-1776463373456-4kr030kc8njzf', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:10:44'),
(40, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:10:51'),
(41, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:10:56'),
(42, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463106876-28w3ps51yw17c&sck=KW-1776463106876-28w3ps51yw17c', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:11:06'),
(43, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:11:21'),
(44, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463106876-28w3ps51yw17c&sck=KW-1776463106876-28w3ps51yw17c', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:11:36'),
(45, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:11:52'),
(46, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:11:56'),
(47, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463106876-28w3ps51yw17c&sck=KW-1776463106876-28w3ps51yw17c', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:12:07'),
(48, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:12:11'),
(49, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:12:17'),
(50, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:12:43'),
(51, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:12:56'),
(52, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:13:14'),
(53, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:13:39'),
(54, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:13:56'),
(55, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:14:09'),
(56, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:14:10'),
(57, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:14:41'),
(58, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:14:56'),
(59, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:15:49'),
(60, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:15:56'),
(61, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:16:20'),
(62, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:16:35'),
(63, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', '', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:16:46'),
(64, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:16:56'),
(65, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:17:17'),
(66, 'rgpphirxlfsmo3gpewa', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463852440-8aq8nvszamucc&sck=KW-1776463852440-8aq8nvszamucc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:17:47'),
(67, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:17:56'),
(68, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:18:56'),
(69, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:19:56'),
(70, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:20:56'),
(71, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:21:56'),
(72, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:22:56'),
(73, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:23:56'),
(74, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:24:56'),
(75, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:25:56'),
(76, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:26:16'),
(77, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463106876-28w3ps51yw17c&sck=KW-1776463106876-28w3ps51yw17c', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:26:20'),
(78, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:26:46'),
(79, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:27:56'),
(80, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:28:56'),
(81, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:29:56'),
(82, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:30:56'),
(83, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:31:56'),
(84, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:32:56'),
(85, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:33:57'),
(86, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:34:56'),
(87, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:35:57'),
(88, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '08a20812980bc6d0', '2026-04-17 22:36:57'),
(89, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:37:57'),
(90, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:38:57'),
(91, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:39:56'),
(92, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:40:56'),
(93, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:41:51'),
(94, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:42:17'),
(95, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:42:46'),
(96, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:43:17'),
(97, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:43:46'),
(98, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:44:17'),
(99, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:44:47'),
(100, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:45:16'),
(101, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:45:57'),
(102, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '10ec810399e93764', '2026-04-17 22:46:57'),
(103, 'hnynioxewvkmo3g9kf8', '/', 'SP', 'BR', 'android-app://com.google.android.googlequicksearchbox/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '08a20812980bc6d0', '2026-04-17 22:58:44'),
(104, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:01:17'),
(105, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:01:56'),
(106, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:02:57'),
(107, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:03:56'),
(108, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:04:57'),
(109, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:05:56'),
(110, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:06:57'),
(111, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:07:57'),
(112, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:08:56'),
(113, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:09:57'),
(114, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:10:52'),
(115, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:11:16'),
(116, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:11:46'),
(117, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:12:17'),
(118, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:12:57'),
(119, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:13:57'),
(120, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:14:57'),
(121, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:15:57'),
(122, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:16:57'),
(123, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:17:57'),
(124, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:18:57'),
(125, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:19:57'),
(126, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:20:57'),
(127, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:21:57'),
(128, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:22:57'),
(129, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:23:57'),
(130, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:24:57'),
(131, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:25:57'),
(132, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:26:57'),
(133, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:27:57'),
(134, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:28:57');
INSERT INTO `analytics` (`id`, `session_id`, `page`, `state`, `country`, `referrer`, `user_agent`, `ip_hash`, `created_at`) VALUES
(135, '238zcm3ngslmo3gesk0', '/', 'SP', 'BR', 'https://torremoney.online/?click_id=XNTrAsm-kh3L1eIzJWcgiQ&pixel_id=308409102684315&ks_px_test=1&utm_source=KW-1776463366330-p9ztooj5pavm9&sck=KW-1776463366330-p9ztooj5pavm9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'b441b95990d1562c', '2026-04-17 23:29:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `kwai_pixels`
--

CREATE TABLE `kwai_pixels` (
  `id` int(11) NOT NULL,
  `pixel_id` varchar(64) NOT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `kwai_pixels`
--

INSERT INTO `kwai_pixels` (`id`, `pixel_id`, `access_token`, `is_active`, `created_at`, `updated_at`) VALUES
(7, '307923359251311', 'tX9RLfqFRTd_ZjNhW1eBIEPVYgkdvJLau3sWdi7vbOU', 1, '2026-04-18 01:50:22', '2026-04-18 01:50:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'PARADISE_API_KEY', 'sk_e694d169eca32dccfc3589a9928ad6f3a889d76652b91b4c28092cdb748ba4da', '2026-04-17 21:43:56', '2026-04-18 00:27:10'),
(2, 'KWAI_PIXEL_ID', '307923359251311', '2026-04-17 21:43:56', '2026-04-18 01:50:28'),
(3, 'ADMIN_USERNAME', 'admin', '2026-04-17 21:43:56', '2026-04-17 21:43:56'),
(4, 'ADMIN_PASSWORD', '$2y$10$rDJli063brqRZYVtErbYre4ESHTPO5DAePJ1mtjhjElk3vLiYomCi', '2026-04-17 21:43:56', '2026-04-18 02:11:15'),
(15, 'CLICK_ID_PARAM', 'YTLOQbI2k81IQcgGvfODDA', '2026-04-18 01:53:49', '2026-04-18 02:08:12'),
(17, 'kwai_access_token', 'tX9RLfqFRTd_ZjNhW1eBIEPVYgkdvJLau3sWdi7vbOU', '2026-04-18 01:57:58', '2026-04-18 01:57:58'),
(23, 'kwai_pixel_ativo', '1', '2026-04-18 02:18:02', '2026-04-18 02:51:18'),
(29, 'kwai_preview_clickid', 'YTLOQbI2k81IQcgGvfODDA', '2026-04-18 03:08:33', '2026-04-18 03:08:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `external_id` varchar(255) NOT NULL COMMENT 'transaction_id from Paradise',
  `reference` varchar(255) NOT NULL COMMENT 'Our reference (REF-...)',
  `amount` int(11) NOT NULL COMMENT 'Amount in cents',
  `status` enum('pending','approved','paid','rejected','cancelled') DEFAULT 'pending',
  `pix_code` text DEFAULT NULL COMMENT 'PIX copy-paste code',
  `qr_code_base64` text DEFAULT NULL COMMENT 'QR Code image in base64',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `transactions`
--

INSERT INTO `transactions` (`id`, `external_id`, `reference`, `amount`, `status`, `pix_code`, `qr_code_base64`, `created_at`, `updated_at`) VALUES
(1, '6893869', 'REF1776462303815', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/fe910814-f4b9-4d21-ae79-657e33a4d6ee5204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***630475FC', '', '2026-04-17 21:45:05', '2026-04-17 21:45:05'),
(2, '6895336', 'REF1776465948312', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/e9d5bc2c-1b30-4f1e-bfc8-d3a6a6a8a8585204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***63049503', '', '2026-04-17 22:45:49', '2026-04-17 22:45:49'),
(3, '6896033', 'REF1776467624932', 5980, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/5f1e8c6e-dfcb-48f1-b38f-ab6436e686185204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***630474B7', '', '2026-04-17 23:13:45', '2026-04-17 23:13:45'),
(4, '6896672', 'REF1776469225988', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/7e5dd2be-7b23-44f5-b7ea-ce262cafc6545204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***63047AE3', '', '2026-04-17 23:40:25', '2026-04-17 23:40:25'),
(5, '6897801', 'REF1776472090304', 3000, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/64ba66f4-22ae-4916-be67-5d06276dc0ba5204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***63041AAB', '', '2026-04-18 00:28:12', '2026-04-18 00:28:12'),
(6, '6898656', 'REF1776474806498', 3990, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/fec752e8-86cd-4b33-972e-19683936c1fb5204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***630457D5', '', '2026-04-18 01:13:28', '2026-04-18 01:13:28'),
(7, '6899475', 'REF1776477715532', 7000, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/9959fbeb-51bc-4531-8012-e7351a4b75b45204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***6304897F', '', '2026-04-18 02:01:56', '2026-04-18 02:01:56'),
(8, '6900362', 'REF1776481328320', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/4b8239aa-d439-4081-8a9b-e4491c8cfa565204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***63048765', '', '2026-04-18 03:02:09', '2026-04-18 03:02:09'),
(9, '6900469', 'REF1776481786437', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/750e3740-9288-4a9a-918a-9f5f891405665204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***630439C9', '', '2026-04-18 03:09:47', '2026-04-18 03:09:47'),
(10, '6900481', 'REF1776481872790', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/e6398c9f-ea62-42ec-ab8b-287fc51a309b5204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***6304D375', '', '2026-04-18 03:11:13', '2026-04-18 03:11:13'),
(11, '6900658', 'REF1776482528168', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/985f5b15-c8b1-48aa-98a1-1a2a4873e0aa5204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***63044978', '', '2026-04-18 03:22:08', '2026-04-18 03:22:08'),
(12, '6900760', 'REF1776482980235', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/68d2f578-3ca9-416c-b0ee-73a94625c1625204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***6304F348', '', '2026-04-18 03:29:41', '2026-04-18 03:29:41'),
(13, '6900800', 'REF1776483192985', 8970, 'pending', '00020101021226800014br.gov.bcb.pix2558qrcode.mkip.com.br/v1/5c4d78e4-56a7-4477-b0df-5d1b7d3ad22f5204000053039865802BR5916ULTIMAOFERTALTDA6008SAOPAULO62070503***6304188F', '', '2026-04-18 03:33:13', '2026-04-18 03:33:13');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_created` (`created_at`);

--
-- Índices de tabela `kwai_pixels`
--
ALTER TABLE `kwai_pixels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_pixel_id` (`pixel_id`);

--
-- Índices de tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Índices de tabela `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_id` (`external_id`),
  ADD KEY `idx_external_id` (`external_id`),
  ADD KEY `idx_reference` (`reference`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de tabela `kwai_pixels`
--
ALTER TABLE `kwai_pixels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
