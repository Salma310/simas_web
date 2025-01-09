-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 21, 2024 at 05:48 PM
-- Server version: 10.6.20-MariaDB-cll-lve
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simasjti_simas_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda_assignee`
--

CREATE TABLE `agenda_assignee` (
  `assignee_id` bigint(20) UNSIGNED NOT NULL,
  `agenda_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `document_progress` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agenda_assignee`
--

INSERT INTO `agenda_assignee` (`assignee_id`, `agenda_id`, `user_id`, `jabatan_id`, `document_progress`, `created_at`, `updated_at`) VALUES
(1, 6, 14, 2, NULL, '2024-12-15 08:01:49', '2024-12-15 08:01:49'),
(2, 7, 11, 3, NULL, '2024-12-15 08:02:07', '2024-12-15 08:02:07'),
(3, 5, 7, 4, NULL, '2024-12-15 16:56:56', '2024-12-15 16:56:56'),
(48, 3, 10, 4, NULL, '2024-12-20 16:31:55', '2024-12-20 16:31:55'),
(49, 2, 11, 4, NULL, '2024-12-20 16:32:00', '2024-12-20 16:32:00'),
(52, 1, 11, 4, NULL, '2024-12-21 03:16:46', '2024-12-21 03:16:46'),
(53, 1, 9, 4, NULL, '2024-12-21 03:16:46', '2024-12-21 03:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `agenda_documents`
--

CREATE TABLE `agenda_documents` (
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `agenda_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agenda_documents`
--

INSERT INTO `agenda_documents` (`document_id`, `agenda_id`, `file_name`, `file_path`, `created_at`, `updated_at`) VALUES
(2, 1, '2241760013_Nabilah Rahmah_JS8.pdf', 'agenda_documents/bMBhRZRpIwUuppuPI4EYUE9YUz4b724Xd756MloP.pdf', '2024-12-20 16:28:54', '2024-12-20 16:28:54'),
(6, 5, '2241760013_Nabilah Rahmah_JS8.pdf', 'agenda_documents/XWdYaQ66MrknzPc4wiNPTokCjHYUBwamMPI7ipKB.pdf', '2024-12-20 19:23:23', '2024-12-20 19:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

CREATE TABLE `event_participants` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_participants`
--

INSERT INTO `event_participants` (`participant_id`, `event_id`, `user_id`, `jabatan_id`, `created_at`, `updated_at`) VALUES
(25, 3, 13, 1, '2024-11-28 10:05:15', '2024-11-28 10:05:15'),
(48, 18, 12, 1, '2024-12-01 07:16:43', '2024-12-01 07:16:43'),
(49, 19, 14, 1, '2024-12-01 07:19:38', '2024-12-01 07:19:38'),
(52, 15, 7, 1, '2024-12-02 01:58:39', '2024-12-02 01:58:39'),
(53, 15, 4, 2, '2024-12-02 01:58:39', '2024-12-02 01:58:39'),
(54, 15, 6, 3, '2024-12-02 01:58:39', '2024-12-02 01:58:39'),
(55, 15, 10, 4, '2024-12-02 01:58:39', '2024-12-02 01:58:39'),
(76, 24, 13, 1, '2024-12-06 07:31:35', '2024-12-06 07:31:35'),
(77, 24, 12, 2, '2024-12-06 07:31:35', '2024-12-06 07:31:35'),
(78, 24, 14, 3, '2024-12-06 07:31:35', '2024-12-06 07:31:35'),
(79, 24, 9, 4, '2024-12-06 07:31:35', '2024-12-06 07:31:35'),
(80, 24, 7, 4, '2024-12-06 07:31:35', '2024-12-06 07:31:35'),
(311, 16, 6, 1, '2024-12-12 18:24:17', '2024-12-12 18:24:17'),
(312, 20, 7, 1, '2024-12-12 18:28:20', '2024-12-12 18:28:20'),
(316, 30, 17, 1, '2024-12-14 06:27:48', '2024-12-14 06:27:48'),
(321, 32, 5, 1, '2024-12-14 22:49:27', '2024-12-14 22:49:27'),
(327, 15, 8, 4, '2024-12-17 10:15:41', '2024-12-17 10:15:41'),
(329, 24, 6, 4, '2024-12-17 10:15:41', '2024-12-17 10:15:41'),
(337, 15, 14, 4, '2024-12-17 10:15:41', '2024-12-17 10:15:41'),
(339, 24, 15, 4, '2024-12-17 10:15:41', '2024-12-17 10:15:41'),
(347, 15, 9, 4, '2024-12-17 10:15:41', '2024-12-17 10:15:41'),
(349, 24, 11, 4, '2024-12-17 10:15:41', '2024-12-17 10:15:41'),
(350, 12, 15, 1, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(351, 12, 13, 2, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(352, 12, 17, 3, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(353, 12, 5, 4, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(354, 12, 6, 4, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(355, 12, 15, 4, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(356, 12, 10, 4, '2024-12-17 03:51:33', '2024-12-17 03:51:33'),
(357, 5, 5, 1, '2024-12-17 03:51:45', '2024-12-17 03:51:45'),
(358, 34, 5, 1, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
(359, 34, 4, 3, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
(360, 34, 11, 4, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
(361, 35, 4, 1, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
(362, 35, 5, 4, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
(363, 35, 11, 4, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
(377, 31, 5, 1, '2024-12-18 20:14:17', '2024-12-18 20:14:17'),
(378, 31, 14, 2, '2024-12-18 20:14:17', '2024-12-18 20:14:17'),
(379, 31, 11, 3, '2024-12-18 20:14:17', '2024-12-18 20:14:17'),
(380, 31, 17, 4, '2024-12-18 20:14:17', '2024-12-18 20:14:17'),
(381, 31, 12, 4, '2024-12-18 20:14:17', '2024-12-18 20:14:17'),
(382, 31, 7, 4, '2024-12-18 20:14:17', '2024-12-18 20:14:17'),
(383, 26, 5, 1, '2024-12-18 20:15:10', '2024-12-18 20:15:10'),
(384, 26, 6, 2, '2024-12-18 20:15:10', '2024-12-18 20:15:10'),
(385, 26, 10, 3, '2024-12-18 20:15:10', '2024-12-18 20:15:10'),
(386, 26, 11, 4, '2024-12-18 20:15:10', '2024-12-18 20:15:10'),
(387, 25, 9, 1, '2024-12-18 20:15:50', '2024-12-18 20:15:50'),
(388, 25, 7, 2, '2024-12-18 20:15:50', '2024-12-18 20:15:50'),
(389, 25, 10, 3, '2024-12-18 20:15:50', '2024-12-18 20:15:50'),
(390, 25, 12, 4, '2024-12-18 20:15:50', '2024-12-18 20:15:50'),
(391, 25, 14, 4, '2024-12-18 20:15:50', '2024-12-18 20:15:50'),
(392, 2, 7, 1, '2024-12-18 20:17:51', '2024-12-18 20:17:51'),
(393, 2, 6, 3, '2024-12-18 20:17:51', '2024-12-18 20:17:51'),
(394, 2, 11, 2, '2024-12-18 20:17:51', '2024-12-18 20:17:51'),
(395, 2, 6, 4, '2024-12-18 20:17:51', '2024-12-18 20:17:51'),
(401, 36, 11, 1, '2024-12-19 02:18:15', '2024-12-19 02:18:15'),
(402, 36, 9, 2, '2024-12-19 02:18:15', '2024-12-19 02:18:15'),
(403, 36, 8, 3, '2024-12-19 02:18:15', '2024-12-19 02:18:15'),
(404, 36, 14, 4, '2024-12-19 02:18:15', '2024-12-19 02:18:15'),
(405, 36, 15, 4, '2024-12-19 02:18:15', '2024-12-19 02:18:15'),
(406, 9, 5, 1, '2024-12-20 16:14:33', '2024-12-20 16:14:33'),
(407, 9, 6, 2, '2024-12-20 16:14:33', '2024-12-20 16:14:33'),
(408, 9, 8, 3, '2024-12-20 16:14:33', '2024-12-20 16:14:33'),
(409, 9, 11, 4, '2024-12-20 16:14:33', '2024-12-20 16:14:33'),
(410, 9, 9, 4, '2024-12-20 16:14:33', '2024-12-20 16:14:33'),
(411, 9, 10, 4, '2024-12-20 16:14:33', '2024-12-20 16:14:33'),
(412, 1, 4, 1, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(413, 1, 5, 2, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(414, 1, 6, 3, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(415, 1, 8, 4, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(416, 1, 7, 4, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(417, 1, 15, 4, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(418, 1, 14, 4, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(419, 1, 9, 4, '2024-12-20 16:30:49', '2024-12-20 16:30:49'),
(420, 10, 11, 1, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(421, 10, 6, 2, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(422, 10, 8, 3, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(423, 10, 13, 4, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(424, 10, 4, 4, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(425, 10, 14, 4, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(426, 10, 9, 4, '2024-12-20 16:33:04', '2024-12-20 16:33:04'),
(427, 33, 11, 1, '2024-12-20 16:37:57', '2024-12-20 16:37:57'),
(428, 33, 12, 4, '2024-12-20 16:37:57', '2024-12-20 16:37:57'),
(436, 44, 11, 3, '2024-12-20 18:09:28', '2024-12-20 18:09:28'),
(437, 45, 11, 4, '2024-12-20 18:24:50', '2024-12-20 18:24:50'),
(438, 46, 5, 1, '2024-12-21 03:13:22', '2024-12-21 03:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(81, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(82, '2024_10_12_213940_create_roles_table', 1),
(83, '2024_10_12_221015_create_users_table', 1),
(84, '2024_11_11_083117_jabatan_table', 1),
(85, '2024_11_11_083230_user_role_table', 1),
(86, '2024_11_11_163401_jenis_event_table', 1),
(87, '2024_11_12_022802_add_table_m_event_table', 1),
(88, '2024_11_12_034823_add_table_t_agenda_table', 1),
(89, '2024_11_12_034910_add_table_agenda_document', 1),
(90, '2024_11_12_034929_add_table_t_workload', 1),
(91, '2024_11_12_034951_add_table_t_notification', 1),
(92, '2024_11_12_041127_add_table_event_participants', 1),
(93, '2024_11_12_041352_add_table_agenda_assignee', 1),
(94, '2024_12_01_071554_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_event`
--

CREATE TABLE `m_event` (
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_code` varchar(10) NOT NULL,
  `event_description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('not started','progress','completed') NOT NULL,
  `assign_letter` varchar(255) DEFAULT NULL,
  `jenis_event_id` bigint(20) UNSIGNED NOT NULL,
  `point` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_event`
--

INSERT INTO `m_event` (`event_id`, `event_name`, `event_code`, `event_description`, `start_date`, `end_date`, `status`, `assign_letter`, `jenis_event_id`, `point`, `created_at`, `updated_at`) VALUES
(1, 'Pelatihan IT', 'PIT', 'Pelatihan bidang teknologi informasi', '2024-11-12', '2024-11-16', 'not started', '1734737449_Surat_Tugas_Pelatihan_IT.pdf', 1, 35, '2024-11-17 05:47:33', '2024-12-20 16:30:49'),
(2, 'Seminar Akademik', 'SMA', 'Seminar yang membahas tentang akademik kampus', '2024-11-17', '2024-11-21', 'not started', 'surat_tugas2.pdf', 1, 20, '2024-11-12 05:47:33', '2024-12-15 16:16:11'),
(3, 'IGDX Bootcamp', 'IGB', 'Bootcamp yang membahas tentang game development', '2024-11-21', '2024-11-25', 'not started', 'surat_tugas3.pdf', 3, 20, '2024-11-12 05:47:33', '2024-12-15 16:16:11'),
(5, 'Seminar Gemastik', 'SGE', 'Gemastik adalah lomba yang sangat diminati banyak orang', '2024-11-18', '2024-11-21', 'not started', NULL, 2, 30, '2024-11-17 09:20:27', '2024-12-15 16:16:11'),
(9, 'Seminar Skripsi 1', 'SSK1', 'Seminar yang membahas teknis skripsi bagi mahasiswa tingkat akhir', '2024-11-28', '2024-11-29', 'progress', '1734736473_Surat Tugas Seminar Skripsi 1.pdf', 1, 20, '2024-11-28 00:15:00', '2024-12-20 16:14:33'),
(10, 'English 101', 'ENG', 'Event ini membahas bagaimana berkomunikasi bahasa inggris dengan benar.', '2024-11-30', '2024-12-03', 'progress', NULL, 2, 30, '2024-11-30 07:36:13', '2024-12-20 19:31:14'),
(12, 'Workshop Game Development 12', 'WGD', 'Kegiatan yang membahas game development secara praktik dan teori.', '2024-12-03', '2024-12-05', 'not started', NULL, 1, 30, '2024-12-01 06:32:08', '2024-12-15 16:16:11'),
(15, 'Seminar 8', 'SM8', 'Seminar jti kedelapan pada tahun 2024', '2024-12-05', '2024-12-07', 'not started', NULL, 1, 30, '2024-12-01 07:03:50', '2024-12-15 16:16:11'),
(16, 'Seminar Ke-9', 'SM9', 'Seminar Jurusan Teknologi Informasi yang ke-9', '2024-12-05', '2024-12-08', 'not started', NULL, 2, 20, '2024-12-01 07:08:55', '2024-12-15 16:16:11'),
(18, 'Acara 11', 'ACR', 'Acara ke-11 dari JTI', '2024-12-10', '2024-12-11', 'not started', NULL, 2, 20, '2024-12-01 07:16:43', '2024-12-15 16:16:11'),
(19, 'Acara 12', 'ACR12', 'Acara ke-12 JTI', '2024-12-12', '2024-12-13', 'not started', NULL, 2, 25, '2024-12-01 07:19:38', '2024-12-01 07:19:38'),
(20, 'Forum Pertemuan Antar Dosen', 'FPD', 'Event Forum Pertemuan Antar Dosen', '2024-12-11', '2024-12-14', 'not started', NULL, 2, 30, '2024-12-01 21:13:35', '2024-12-12 18:28:20'),
(24, 'Seminar Smart City', 'SMSC', 'Seminar yang membahas terkait smart city', '2024-12-14', '2024-12-16', 'not started', NULL, 1, 30, '2024-12-06 07:30:44', '2024-12-06 07:31:16'),
(25, 'Workshop Laravel 1', 'WSL', 'Workshop yang membahas bagaimana industri dari laravel saat ini. Selain itu, akan dibawakan oleh pemateri yang sangat handal di bidangnya yang sudah memiliki pengalaman sebanyak 5 tahun.', '2024-12-16', '2024-12-18', 'not started', NULL, 2, 30, '2024-12-09 18:26:28', '2024-12-09 18:26:28'),
(26, 'Seminar Mahasiswa Tingkat Akhir', 'SMT', 'Seminar yang ditujukan untuk mahasiswa tingkat akhir, bersifat penting.', '2024-12-19', '2024-12-21', 'not started', NULL, 1, 30, '2024-12-09 19:11:03', '2024-12-09 19:11:03'),
(30, 'Study Excursie Perusahaan', 'SEP', 'Kunjungan ke beberapa perusahaan ternama', '2024-12-23', '2024-12-24', 'not started', NULL, 2, 35, '2024-12-14 06:27:48', '2024-12-14 06:27:48'),
(31, 'Workshop Front End React JS', 'WFE', 'Workshop yang membahas framework React JS', '2024-12-25', '2024-12-26', 'not started', NULL, 2, 35, '2024-12-14 22:45:00', '2024-12-15 20:04:44'),
(32, 'Workshop Back End TypeScript', 'WBE', 'Workshop yang membahas Typescript', '2024-12-27', '2024-12-28', 'not started', NULL, 2, 30, '2024-12-14 22:49:27', '2024-12-14 22:49:27'),
(33, 'Seminar Penggunaan AI', 'SPA', 'Seminar yang membahas pentingnya penggunaan AI', '2024-12-28', '2024-12-29', 'not started', NULL, 2, 30, '2024-12-15 03:07:25', '2024-12-15 17:54:06'),
(34, 'Workshop Pengembangan Soft Skill', 'WPSS2024', 'Workshop Pengembangan soft skill', '2024-12-23', '2024-12-25', 'not started', NULL, 2, 30, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
(35, 'Workshop Pengembangan Diri', 'WPD2024', 'Workshop pengembangan diri', '2024-12-23', '2024-12-24', 'not started', NULL, 1, 25, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
(36, 'Seminar Mahasiswa', 'SMS', 'Seminar Mahasiswa', '2024-12-21', '2024-12-24', 'not started', '1734599893_Business Intelligent - Career & Use Cases.pdf', 2, 30, '2024-12-19 02:16:35', '2024-12-19 02:18:15'),
(44, 'testing', 'TST', '2dfvfbwi4gfuyheajfb', '2024-12-22', '2024-12-31', 'not started', '1734743368_showDetail (2).jpg', 3, NULL, '2024-12-20 18:09:28', '2024-12-20 18:09:28'),
(45, 'testing', 'TSR', 'righo53ngkl4nb96j', '2024-12-22', '2024-12-31', 'not started', '1734744290_showDetail.jpg', 3, NULL, '2024-12-20 18:24:50', '2024-12-20 18:24:50'),
(46, 'Seminar Pengembangan Skill', 'NTI', 'Seminar Pengembangan Diri Bertempat Di Surabaya', '2024-12-09', '2024-12-09', 'not started', '1734776002_Surat Tugas.pdf', 3, NULL, '2024-12-21 03:13:22', '2024-12-21 03:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `m_jabatan`
--

CREATE TABLE `m_jabatan` (
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_name` varchar(50) NOT NULL,
  `jabatan_code` varchar(10) NOT NULL,
  `point` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_jabatan`
--

INSERT INTO `m_jabatan` (`jabatan_id`, `jabatan_name`, `jabatan_code`, `point`, `created_at`, `updated_at`) VALUES
(1, 'Ketua Pelaksana (PIC)', 'PIC', 3, '2024-11-13 05:13:05', '2024-11-13 05:13:05'),
(2, 'Pembina', 'PMB', 1, '2024-11-13 05:13:05', '2024-11-13 05:13:05'),
(3, 'Sekretaris', 'SKR', 1, '2024-11-13 05:13:05', '2024-11-13 05:13:05'),
(4, 'Anggota', 'AGT', 1, '2024-11-13 05:13:05', '2024-11-13 05:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE `m_role` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_role`
--

INSERT INTO `m_role` (`role_id`, `role_name`, `role_code`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'ADM', '2024-11-22 09:22:47', '2024-11-22 09:22:47'),
(2, 'Pimpinan', 'PMP', '2024-11-22 09:22:47', '2024-11-22 09:22:47'),
(3, 'Dosen', 'DSN', '2024-11-22 09:22:47', '2024-11-22 09:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `auth_token` varchar(500) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `role_id`, `username`, `email`, `password`, `name`, `phone`, `picture`, `auth_token`, `device_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'dewilestari@gmail.com', '$2y$12$iKEj3dW1EOwav6p7cW2XTu.81dS2debmwbbDYJV9aSva6KkCruN8y', 'Dewi Lestari', '081234564849', '640cb02fc61a69294839c46254e1ca41f8801501bbebd1ba9cb52988428172b2.jpg', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3NpbWFzX3dlYi9wdWJsaWMvYXBpL2xvZ2luIiwiaWF0IjoxNzM0MzA3NTU4LCJleHAiOjE3MzQzMTExNTgsIm5iZiI6MTczNDMwNzU1OCwianRpIjoid250T29ESUFIMks3SUZBMCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.---iMc6ra7P1XES2aqiiy_mlpFX-7mRc70nHm3pYP7A', '', '2024-11-12 22:17:44', '2024-12-20 16:01:31'),
(2, 2, 'pimpinan', 'aimandestra123@gmail.com', '$2y$12$CgIOb1K.8RZzdmLajY2hDeBd9WWgv0kr1dBlOhW10YFfKFxZIgn7O', 'Aiman Destra Jubran', '0813788283729', '5ba5ab1f562f1c9dc7e2dfd78c18b480584ec74760436180efcecb25db26a433.jpg', '', '', '2024-11-12 22:19:43', '2024-12-20 16:35:54'),
(3, 2, 'rakha123', 'rakha123@gmail.com', '$2y$12$Bhcy4pm10yDek/XufKRMzuqwBBV0r23NavZ.BlpyklUhLtrimIzZ.', 'Ryan Rakha Nugraha', '082726262527', '', '', '', '2024-11-12 22:19:43', '2024-12-14 22:47:34'),
(4, 3, 'bagus123', 'baguschyo@gmail.com', '$2y$12$Wgb6joWhmuQDaPmeOPatyO.0qENeBZ.AC3ICUYT/hI7bLmH/Q/s.q', 'Bagus Cahyo Hardono', '083363742922', '998375ddc0d3c26fe2dfaba266f64952abbf3ec712b6e0019af90f290f1a0e6e.jpg', '', '', '2024-11-16 06:53:49', '2024-12-20 16:38:42'),
(5, 3, 'rizki456', 'rizki@gmail.com', '$2y$12$gDEzFWQHpjcq45/.nY5jj.fv/wWs9Faw45XSzNgvZV3C/cJlHTc2.', 'Rizki Pratama', '083363742923', '96698ceecfe2837cb10a9ca4d33e906d055dae0a83e6ef9ddf999aaad530a9a3.jpg', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTkyLjE2OC4wLjEwMzo4MDAwL2FwaS9sb2dpbiIsImlhdCI6MTczNDI2ODg5MSwiZXhwIjoxNzM0MjcyNDkxLCJuYmYiOjE3MzQyNjg4OTEsImp0aSI6IkUwUUlpbnJlNEFEcENlT3kiLCJzdWIiOiI1IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.q3MKHg5jUurdLOksPjvvNKTKEaEiSFoaANVLfHPbfhs', '', '2024-11-16 06:55:26', '2024-12-21 03:10:12'),
(6, 3, 'siti789', 'siti@gmail.com', '$2y$12$SX/Nq2iN4FAeYJbHhm481.i/oxeV6pmsT/4UNjK4jdc4OxgcWJ5eC', 'Siti Aisyah', '083363742924', 'f9638911bfaccee9c1c68f54563c7d14cd95c649909ea82f0f93166143fadf61.jpg', '', '', '2024-11-16 06:55:26', '2024-12-20 19:52:15'),
(7, 3, 'yusuf321', 'yusuf@gmail.com', '$2y$12$xVXjc62KaPVS96x3O70NaeOGjrOiXud9u20EyJCRyNi.6U6EkWTZG', 'Yusuf Maulana', '083363742925', '', '', '', '2024-11-16 06:55:26', '2024-11-16 06:55:26'),
(8, 3, 'ani654', 'ani@gmail.com', '$2y$12$os0WpyU0JnAgBT6epC8GIuEy0Ykq7c/4XagA2tAp26RCIdmVQlKam', 'Ani Lestari', '083363742926', '', '', '', '2024-11-16 06:55:26', '2024-11-16 06:55:26'),
(9, 3, 'budi123', 'budi@gmail.com', '$2y$12$AD/NJuIAXDNa02hagoxBkO62xaBoMB/2e087sZaRrqTCuD079GUnq', 'Budi Santoso', '083363742927', '', '', '', '2024-11-16 06:55:26', '2024-11-16 06:55:26'),
(10, 3, 'ina456', 'ina@gmail.com', '$2y$12$2CbkLLbQO..DzThVbNTCIOvuEmhg6yUk6LD3Sq0RXnymZfDvITVHa', 'Ina Kartika', '083363742928', '5a176ea394b56f6f18fa4d79327227c1c769dd2a2d9a2b27a515bf3ad9a8c610.jpg', '', '', '2024-11-16 06:55:26', '2024-12-20 16:08:59'),
(11, 3, 'agus789', 'agus@gmail.com', '$2y$12$oeA8CPtF3W7C3xPjmN6eDuUVvTHM.XtRDNLL25fAL5D7AVWQrAKNi', 'Agus Wijaya', '083363742929', '', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTkyLjE2OC4wLjEwMzo4MDAwL2FwaS9sb2dpbiIsImlhdCI6MTczNDA1MDkxMywiZXhwIjoxNzM0MDU0NTEzLCJuYmYiOjE3MzQwNTA5MTMsImp0aSI6InFZcjMyUUVCa2VWQzN1SGIiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.kLIkQM8MA30_66Xgn1I78nM58NdDjnjfLELsvMIIHqE', '', '2024-11-16 06:55:26', '2024-12-12 17:48:33'),
(12, 3, 'dina321', 'dina@gmail.com', '$2y$12$sZr4lOapN8O8eBhQ7gR67O1DdawDF/1lEGBAVrOBYH2N5yUDo2uI6', 'Dina Syafitri', '083363742930', '', '', '', '2024-11-16 06:55:26', '2024-11-16 06:55:26'),
(13, 3, 'andi654', 'andi@gmail.com', '$2y$12$eBWBvMcOQJho/fL/JoFvMOUw74adV3dHJ4rS/YU04naP1gOKOsary', 'Andi Setiawan', '083363742931', '', '', '', '2024-11-16 06:55:26', '2024-11-16 06:55:26'),
(14, 3, 'linda123', 'linda@gmail.com', '$2y$12$lAMCCvdZciHfvtSYpq.DaumKHdbK/1Vei1RAECYXamOboQUJKB0BW', 'Linda Susanti', '083363742932', '41150b7e8bad16b98fceb4699b6588bee61f6a317ce7cec8d450910b6bd58974.jpg', '', '', '2024-11-16 06:55:26', '2024-12-20 16:39:27'),
(15, 3, 'faridpradana', 'farid123@gmail.com', '$2y$12$tYlYG9CLyrEibONo7vpkUuCCvcPs9EMmYgTLXW1LbmP9Jd44C9cPS', 'Farid Pradana Agung', '081122334456', NULL, NULL, NULL, '2024-11-28 07:00:43', '2024-11-28 09:06:26'),
(17, 3, 'inggachintia', NULL, '$2y$12$WC9aLBwwgSXprS4q0Clh2uAhq3ImGmyv9NmGetHH16srzAoSFcwvK', 'Ingga Chintia Sari', NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTkyLjE2OC4wLjEwMzo4MDAwL2FwaS9sb2dpbiIsImlhdCI6MTczNDI0NzI0OCwiZXhwIjoxNzM0MjUwODQ4LCJuYmYiOjE3MzQyNDcyNDgsImp0aSI6IkNtcklkVXhBMDFOZEJ3YTQiLCJzdWIiOiIxNyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.CvDM8OoyNvty9k8wxd6HD_zvJT-SmKQnOvqbY_a_Pn4', NULL, '2024-11-28 19:52:25', '2024-12-15 00:20:49'),
(18, 1, 'roszyhana', NULL, '$2y$12$L1j1PeNzQ1H9ag64dbK6YuX2wpcyVFx1/tdVgakP7rEN8AW81QDim', 'Rosyhana', NULL, NULL, NULL, NULL, '2024-12-15 21:49:51', '2024-12-15 21:50:37'),
(19, 2, 'andi', 'andiii@gmail.com', '$2y$12$4xNFB6ab3Ne0TGt8nxXjOOc7bAtMBOgCNPahmAEynGNgUEnhhD4IO', 'andi', '081222111333', NULL, NULL, NULL, '2024-12-15 23:10:55', '2024-12-17 04:11:39'),
(20, 2, 'pak rosa', NULL, '$2y$12$VihGk25ae3gr5mIBkN/A6euP7LzMRh.jTB8NXdQFO60OOag1FjhfG', 'pak rosa', NULL, NULL, NULL, NULL, '2024-12-18 21:16:34', '2024-12-18 21:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('05068809-fbc4-462d-89a5-1cf6306b8132', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 5, '{\"event_id\":32,\"event_name\":\"Workshop Back End TypeScript\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Back End TypeScript\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/32\"}', '2024-12-15 19:28:53', '2024-12-14 22:49:27', '2024-12-15 19:28:53'),
('08c6ab02-3ae9-4d4b-9a9e-ca400fda6796', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 8, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('08d97c05-5f0b-4006-b29e-18d391533eff', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 3, '{\"event_id\":34,\"event_name\":\"Workshop Pengembangan Soft Skill\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Pengembangan Soft Skill\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/34\"}', NULL, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
('0f345178-4bb3-4dd3-abd5-0c2bc62fc25d', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 17, '{\"event_id\":30,\"event_name\":\"Study Excursie Perusahaan\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Study Excursie Perusahaan\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/30\"}', '2024-12-14 08:49:49', '2024-12-14 06:27:53', '2024-12-14 08:49:49'),
('1579d7ce-2987-4907-96e6-36871da56c20', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 5, '{\"event_id\":35,\"event_name\":\"Workshop Pengembangan Diri\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Pengembangan Diri\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/35\"}', '2024-12-17 04:07:14', '2024-12-17 04:02:58', '2024-12-17 04:07:14'),
('296e0b2a-9d8c-483f-b5cf-b3a149405b94', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 11, '{\"event_id\":33,\"event_name\":\"Seminar Pentingnya Penggunaan AI\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Seminar Pentingnya Penggunaan AI\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/33\"}', '2024-12-15 03:08:03', '2024-12-15 03:07:27', '2024-12-15 03:08:03'),
('2b023280-ec20-4408-a82f-157f4bc88c3d', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 19, '{\"event_id\":35,\"event_name\":\"Workshop Pengembangan Diri\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Pengembangan Diri\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/35\"}', NULL, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
('31f23c26-ece1-4a50-b9b3-d4d108dee201', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 5, '{\"event_id\":31,\"event_name\":\"Workshop Front End React JS\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Front End React JS\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/31\"}', '2024-12-14 22:45:25', '2024-12-14 22:45:03', '2024-12-14 22:45:25'),
('3400f2e0-9a7a-4731-aa50-451e7ba1b357', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 11, '{\"event_id\":35,\"event_name\":\"Workshop Pengembangan Diri\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Pengembangan Diri\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/35\"}', NULL, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
('358ffe65-9fcc-4575-bfaa-7dc323de390a', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 17, '{\"event_id\":31,\"event_name\":\"Workshop Front End React JS\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Front End React JS\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/31\"}', '2024-12-15 01:35:57', '2024-12-14 22:45:03', '2024-12-15 01:35:57'),
('3ec66549-2912-4e83-9c5e-0b5a3af3728e', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 15, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('5716c4b9-f41e-41b9-958c-d0dfc74b0601', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 4, '{\"event_id\":34,\"event_name\":\"Workshop Pengembangan Soft Skill\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Pengembangan Soft Skill\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/34\"}', '2024-12-20 16:38:15', '2024-12-17 04:01:37', '2024-12-20 16:38:15'),
('5c7be74e-9c6c-4505-82ad-3eeea5fcb682', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 19, '{\"event_id\":34,\"event_name\":\"Workshop Pengembangan Soft Skill\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Pengembangan Soft Skill\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/34\"}', NULL, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
('640fb3a6-65a9-4796-bb55-d705e51174d5', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 2, '{\"event_id\":35,\"event_name\":\"Workshop Pengembangan Diri\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Pengembangan Diri\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/35\"}', '2024-12-18 17:43:02', '2024-12-17 04:02:58', '2024-12-18 17:43:02'),
('648579bf-82c9-4da4-b2e7-e9a424c5d0df', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 3, '{\"event_id\":33,\"event_name\":\"Seminar Pentingnya Penggunaan AI\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Seminar Pentingnya Penggunaan AI\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_pimpinan\\/33\"}', NULL, '2024-12-15 03:07:28', '2024-12-15 03:07:28'),
('660af848-62ad-49df-bd9f-f99184f46f78', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 14, '{\"event_id\":31,\"event_name\":\"Workshop Front End React JS\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Front End React JS\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/31\"}', NULL, '2024-12-14 22:45:03', '2024-12-14 22:45:03'),
('66be4662-cf01-4d9a-8561-c7587f1caabb', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 3, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('8eb779f2-3738-428b-810d-965dad8d2e25', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 2, '{\"event_id\":34,\"event_name\":\"Workshop Pengembangan Soft Skill\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Pengembangan Soft Skill\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/34\"}', '2024-12-18 17:43:02', '2024-12-17 04:01:37', '2024-12-18 17:43:02'),
('976b05af-99b5-4c57-b501-71c1e6f40c66', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 11, '{\"event_id\":34,\"event_name\":\"Workshop Pengembangan Soft Skill\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Pengembangan Soft Skill\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/34\"}', NULL, '2024-12-17 04:01:37', '2024-12-17 04:01:37'),
('9c2f6ee9-25ca-495d-b915-a74d7a00ea3b', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 2, '{\"event_id\":33,\"event_name\":\"Seminar Pentingnya Penggunaan AI\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Seminar Pentingnya Penggunaan AI\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_pimpinan\\/33\"}', '2024-12-18 17:43:02', '2024-12-15 03:07:27', '2024-12-18 17:43:02'),
('a52d9b16-ca39-49c0-8859-b7351b164b4c', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 9, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('a78164b8-e6b4-40ec-8c90-1fc03bec5274', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 4, '{\"event_id\":35,\"event_name\":\"Workshop Pengembangan Diri\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Pengembangan Diri\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/35\"}', '2024-12-20 16:38:15', '2024-12-17 04:02:58', '2024-12-20 16:38:15'),
('a78fafb5-a7ca-4fb5-9c3a-28cab58c76bf', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 3, '{\"event_id\":32,\"event_name\":\"Workshop Back End TypeScript\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Back End TypeScript\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_pimpinan\\/32\"}', '2024-12-14 23:29:46', '2024-12-14 22:49:27', '2024-12-14 23:29:46'),
('a9f25d1d-c129-49ec-b91d-d689fe9c1e08', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 3, '{\"event_id\":35,\"event_name\":\"Workshop Pengembangan Diri\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Pengembangan Diri\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/35\"}', NULL, '2024-12-17 04:02:58', '2024-12-17 04:02:58'),
('acda2c41-530e-4c2c-a00c-e6e2a0d0d291', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 2, '{\"event_id\":32,\"event_name\":\"Workshop Back End TypeScript\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Back End TypeScript\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_pimpinan\\/32\"}', '2024-12-14 23:29:10', '2024-12-14 22:49:27', '2024-12-14 23:29:10'),
('b35aa361-a73d-4f76-bf8a-1f25f1388e72', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 2, '{\"event_id\":31,\"event_name\":\"Workshop Front End React JS\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Workshop Front End React JS\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_pimpinan\\/31\"}', '2024-12-14 23:29:11', '2024-12-14 22:45:03', '2024-12-14 23:29:11'),
('b41a86c8-221c-47b7-affb-9696adf6133b', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 2, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('b539be74-0c06-4966-b4a7-e0cabd88ba48', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 20, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('c896b847-e5d6-4860-8826-6bac1988f926', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 5, '{\"event_id\":34,\"event_name\":\"Workshop Pengembangan Soft Skill\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Pengembangan Soft Skill\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/34\"}', '2024-12-17 04:07:14', '2024-12-17 04:01:37', '2024-12-17 04:07:14'),
('d920b364-3bc6-4c9e-93e0-6d2110da4db9', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 14, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('e4f5dd13-a90e-4fc7-89da-0b15eef094ae', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 11, '{\"event_id\":31,\"event_name\":\"Workshop Front End React JS\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Workshop Front End React JS\",\"url\":\"http:\\/\\/localhost\\/simas_web\\/public\\/notifikasi_event\\/31\"}', '2024-12-15 03:08:03', '2024-12-14 22:45:03', '2024-12-15 03:08:03'),
('eb880317-c579-418a-80ee-7dd599538169', 'App\\Notifications\\PimpinanNotification', 'App\\Models\\User', 19, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_pimpinan\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35'),
('f5995e3a-f241-41b6-8924-fbdd91167ae4', 'App\\Notifications\\EventNotification', 'App\\Models\\User', 11, '{\"event_id\":36,\"event_name\":\"Seminar Mahasiswa\",\"title\":\"Event Baru\",\"message\":\"Admin telah menambahkan Anda dalam event Seminar Mahasiswa\",\"url\":\"https:\\/\\/simasjti.my.id\\/public\\/notifikasi_event\\/36\"}', NULL, '2024-12-19 02:16:35', '2024-12-19 02:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_agenda`
--

CREATE TABLE `t_agenda` (
  `agenda_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `nama_agenda` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `tempat` varchar(100) NOT NULL,
  `point_beban_kerja` double DEFAULT NULL,
  `status` enum('not started','progress','completed') NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `needs_update` tinyint(1) NOT NULL DEFAULT 0,
  `point_generated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_agenda`
--

INSERT INTO `t_agenda` (`agenda_id`, `event_id`, `nama_agenda`, `start_date`, `end_date`, `tempat`, `point_beban_kerja`, `status`, `jabatan_id`, `needs_update`, `point_generated_at`, `created_at`, `updated_at`) VALUES
(1, 9, 'Survey Tempat', '2024-12-20 00:00:00', '2024-12-21 00:00:00', 'Lokasi Rapat', 11.33, 'completed', 4, 0, '2024-12-20 16:31:47', '2024-12-15 20:07:34', '2024-12-21 03:16:46'),
(2, 9, 'Rapat Bersama Pimpinan', '2024-12-24 00:00:00', '2024-12-27 00:00:00', 'Di Ruang Rapat LSI', 2, 'completed', 4, 0, '2024-12-20 16:31:47', '2024-12-15 20:08:17', '2024-12-20 16:32:00'),
(3, 9, 'Rapat 1', '2024-12-21 00:00:00', '2024-12-23 00:00:00', 'Auditorium', 6.67, 'not started', 4, 0, '2024-12-20 16:31:47', '2024-12-19 02:28:08', '2024-12-20 16:31:55'),
(4, 10, 'Rapat Koordinasi', '2024-12-22 00:00:00', '2024-12-29 00:00:00', 'online', NULL, 'progress', 1, 0, NULL, '2024-12-20 19:19:38', '2024-12-20 19:19:38'),
(5, 10, 'Membuat List Perlengkapan', '2024-12-22 00:00:00', '2024-12-31 00:00:00', 'anywhere', NULL, 'progress', 4, 0, NULL, '2024-12-20 19:23:21', '2024-12-20 19:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `t_jenis_event`
--

CREATE TABLE `t_jenis_event` (
  `jenis_event_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_event_name` varchar(100) NOT NULL,
  `jenis_event_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_jenis_event`
--

INSERT INTO `t_jenis_event` (`jenis_event_id`, `jenis_event_name`, `jenis_event_code`, `created_at`, `updated_at`) VALUES
(1, 'Terprogram', 'TPR', '2024-11-12 05:42:11', '2024-11-12 05:42:11'),
(2, 'Non-Program', 'NPR', '2024-11-12 05:42:11', '2024-11-12 05:42:11'),
(3, 'Non-JTI', 'NTI', '2024-11-12 05:42:11', '2024-11-12 05:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `t_notification`
--

CREATE TABLE `t_notification` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_notification`
--

INSERT INTO `t_notification` (`notification_id`, `event_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pengumuman event', 'Event Pelatihan IT sedang berlangsung', 0, '2024-11-12 06:02:12', '2024-11-12 06:02:12'),
(2, 2, 'Pengumuman Event', 'Event seminar hampir tiba', 0, '2024-11-12 06:02:12', '2024-11-12 06:02:12'),
(3, 3, 'Pengumuman Event IGDX', 'IGDX Bootcamp sedang berlangsung', 0, '2024-11-12 06:02:12', '2024-11-12 06:02:12'),
(4, 5, 'Pengumuman Acara Tambahan', 'Acara akan sedang berlangsung', 0, '2024-11-19 02:45:02', '2024-11-19 02:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `t_workload`
--

CREATE TABLE `t_workload` (
  `workload_id` bigint(20) UNSIGNED NOT NULL,
  `agenda_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `earned_points` double NOT NULL,
  `period` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_workload`
--

INSERT INTO `t_workload` (`workload_id`, `agenda_id`, `user_id`, `earned_points`, `period`, `created_at`, `updated_at`) VALUES
(1, 5, 7, 5, '2024-2025', '2024-12-15 16:56:56', '2024-12-15 16:56:56'),
(43, 3, 10, 6.67, '2024-2025', '2024-12-20 16:31:55', '2024-12-20 16:31:55'),
(44, 2, 11, 2, '2024-2025', '2024-12-20 16:32:00', '2024-12-20 16:32:00'),
(47, 1, 11, 5.665, '2024-2025', '2024-12-21 03:16:46', '2024-12-21 03:16:46'),
(48, 1, 9, 5.665, '2024-2025', '2024-12-21 03:16:46', '2024-12-21 03:16:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda_assignee`
--
ALTER TABLE `agenda_assignee`
  ADD PRIMARY KEY (`assignee_id`),
  ADD KEY `agenda_assignee_agenda_id_foreign` (`agenda_id`),
  ADD KEY `agenda_assignee_user_id_foreign` (`user_id`),
  ADD KEY `agenda_assignee_jabatan_id_foreign` (`jabatan_id`);

--
-- Indexes for table `agenda_documents`
--
ALTER TABLE `agenda_documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `agenda_documents_agenda_id_foreign` (`agenda_id`);

--
-- Indexes for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `event_participants_event_id_foreign` (`event_id`),
  ADD KEY `event_participants_user_id_foreign` (`user_id`),
  ADD KEY `event_participants_jabatan_id_foreign` (`jabatan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_event`
--
ALTER TABLE `m_event`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `m_event_event_code_unique` (`event_code`),
  ADD KEY `m_event_jenis_event_id_foreign` (`jenis_event_id`);

--
-- Indexes for table `m_jabatan`
--
ALTER TABLE `m_jabatan`
  ADD PRIMARY KEY (`jabatan_id`),
  ADD UNIQUE KEY `m_jabatan_jabatan_code_unique` (`jabatan_code`);

--
-- Indexes for table `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `m_role_role_code_unique` (`role_code`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `m_user_username_unique` (`username`),
  ADD UNIQUE KEY `m_user_email_unique` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `t_agenda`
--
ALTER TABLE `t_agenda`
  ADD PRIMARY KEY (`agenda_id`),
  ADD KEY `t_agenda_event_id_foreign` (`event_id`),
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- Indexes for table `t_jenis_event`
--
ALTER TABLE `t_jenis_event`
  ADD PRIMARY KEY (`jenis_event_id`),
  ADD UNIQUE KEY `t_jenis_event_jenis_event_code_unique` (`jenis_event_code`);

--
-- Indexes for table `t_notification`
--
ALTER TABLE `t_notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `t_notification_event_id_foreign` (`event_id`);

--
-- Indexes for table `t_workload`
--
ALTER TABLE `t_workload`
  ADD PRIMARY KEY (`workload_id`),
  ADD KEY `t_workload_agenda_id_foreign` (`agenda_id`),
  ADD KEY `t_workload_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda_assignee`
--
ALTER TABLE `agenda_assignee`
  MODIFY `assignee_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `agenda_documents`
--
ALTER TABLE `agenda_documents`
  MODIFY `document_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `participant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `m_event`
--
ALTER TABLE `m_event`
  MODIFY `event_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `m_jabatan`
--
ALTER TABLE `m_jabatan`
  MODIFY `jabatan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_role`
--
ALTER TABLE `m_role`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_agenda`
--
ALTER TABLE `t_agenda`
  MODIFY `agenda_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_jenis_event`
--
ALTER TABLE `t_jenis_event`
  MODIFY `jenis_event_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_notification`
--
ALTER TABLE `t_notification`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_workload`
--
ALTER TABLE `t_workload`
  MODIFY `workload_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda_documents`
--
ALTER TABLE `agenda_documents`
  ADD CONSTRAINT `agenda_documents_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `t_agenda` (`agenda_id`);

--
-- Constraints for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `m_event` (`event_id`),
  ADD CONSTRAINT `event_participants_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `m_jabatan` (`jabatan_id`),
  ADD CONSTRAINT `event_participants_juser_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
