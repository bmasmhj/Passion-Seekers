-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2021 at 09:11 PM
-- Server version: 8.0.25-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_passion_seekers`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`id`, `name`, `username`, `password`, `email`, `address`, `phone_number`, `avatar`, `status`, `created_at`, `Updated_at`) VALUES
(14, 'aayush', 'aayush', 'd2295ddd09aa9e94b503b88f6d78eb97', 'aayush96@example.com', 'kathmandu balaju', '+1 (317) 261-6031', 'imagePost609cefc5bc5881748066991609cefc5bc5a81839372231.png', 1, '2021-05-13 09:16:26', '2021-05-16 04:43:29'),
(15, 'Mufutau Garrett', 'aayush100', 'd2295ddd09aa9e94b503b88f6d78eb97', 'bery@mailinator.com', 'Doloremque rerum lau', '+1 (119) 827-4674', 'imagePost60a21b850a9f1116197599360a21b850aa061217556664.png', 1, '2021-05-17 07:26:19', '2021-05-17 07:30:13'),
(16, 'Aphrodite Conway', 'xyz', 'd2295ddd09aa9e94b503b88f6d78eb97', 'qamyq@mailinator.com', 'Ullamco enim iusto i', '+1 (908) 669-3336', NULL, 0, '2021-05-20 05:54:04', NULL),
(17, 'Tyrone Cochran', 'aayush1123123', 'd2295ddd09aa9e94b503b88f6d78eb97', 'xajasaveh@mailinator.com', 'Sint tempore esse', '+1 (133) 683-2719', NULL, 0, '2021-05-20 14:57:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `location_id` int NOT NULL,
  `comment` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favorites`
--

CREATE TABLE `tbl_favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `location_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_favorites`
--

INSERT INTO `tbl_favorites` (`id`, `user_id`, `location_id`, `status`, `created_at`, `updated_at`) VALUES
(20, 76, 87, 1, '2021-05-20 06:00:06', NULL),
(22, 76, 104, 1, '2021-05-20 09:37:52', NULL),
(24, 76, 96, 1, '2021-05-20 14:48:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `id` int NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `location_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`id`, `image`, `location_id`, `status`, `created_at`, `updated_at`) VALUES
(790, 'imagePost60a5204f05373152834733660a5204f05390294768684.png', 87, 1, '2021-05-19 14:27:27', NULL),
(791, 'imagePost60a5204f05784170906579060a5204f0578a565438341.png', 87, 1, '2021-05-19 14:27:27', NULL),
(811, 'imagePost60a5275f6c935175418183060a5275f6c944940138557.png', 90, 1, '2021-05-19 14:57:35', NULL),
(812, 'imagePost60a5275f6cc85113013733560a5275f6cc8e193369327.png', 90, 1, '2021-05-19 14:57:35', NULL),
(813, 'imagePost60a5275f6ce25142270976360a5275f6ce291396399890.png', 90, 1, '2021-05-19 14:57:35', NULL),
(814, 'imagePost60a5275f6d3f942157194960a5275f6d401457267541.png', 90, 1, '2021-05-19 14:57:35', NULL),
(815, 'imagePost60a527bc9b1ae173674512960a527bc9b1c11474265021.png', 91, 1, '2021-05-19 14:59:08', NULL),
(816, 'imagePost60a527bc9b40c88606274860a527bc9b4111395527470.png', 91, 1, '2021-05-19 14:59:08', NULL),
(817, 'imagePost60a527bc9b8d787374579660a527bc9b8db299460032.png', 91, 1, '2021-05-19 14:59:08', NULL),
(818, 'imagePost60a527bc9bada141284480060a527bc9badd1553484504.png', 91, 1, '2021-05-19 14:59:08', NULL),
(819, 'imagePost60a5292ae0564127996769760a5292ae05771120670858.png', 92, 1, '2021-05-19 15:05:14', NULL),
(820, 'imagePost60a5292ae07fd36469279760a5292ae08032017443727.png', 92, 1, '2021-05-19 15:05:14', NULL),
(821, 'imagePost60a5292ae142055594769760a5292ae1428566959619.png', 92, 1, '2021-05-19 15:05:14', NULL),
(822, 'imagePost60a5292ae160e191391597760a5292ae16121845418916.png', 92, 1, '2021-05-19 15:05:14', NULL),
(823, 'imagePost60a52985da36668758407260a52985da3751446213254.png', 93, 1, '2021-05-19 15:06:45', NULL),
(824, 'imagePost60a52985da788144902893860a52985da78e1141945777.png', 93, 1, '2021-05-19 15:06:45', NULL),
(825, 'imagePost60a52985dae2e107213915360a52985dae37170494778.png', 93, 1, '2021-05-19 15:06:45', NULL),
(826, 'imagePost60a529ce4265278344868260a529ce426612100942603.png', 94, 1, '2021-05-19 15:07:58', NULL),
(827, 'imagePost60a529ce42839186142953160a529ce4283d640444901.png', 94, 1, '2021-05-19 15:07:58', NULL),
(828, 'imagePost60a529ce42ab952468446560a529ce42abc1255379276.png', 94, 1, '2021-05-19 15:07:58', NULL),
(829, 'imagePost60a529ce42cf7207353223660a529ce42cfa1884262709.png', 94, 1, '2021-05-19 15:07:58', NULL),
(830, 'imagePost60a52a27daf494899220260a52a27daf5a1013052293.png', 95, 1, '2021-05-19 15:09:27', NULL),
(831, 'imagePost60a52a27db5a3149570430460a52a27db5aa768559771.png', 95, 1, '2021-05-19 15:09:27', NULL),
(832, 'imagePost60a52a27db9d5204077834660a52a27db9dd1313761653.png', 95, 1, '2021-05-19 15:09:27', NULL),
(833, 'imagePost60a52a27dbe8328908982860a52a27dbe8b2112128984.png', 95, 1, '2021-05-19 15:09:27', NULL),
(834, 'imagePost60a52a27dc27b183537520460a52a27dc2821717771925.png', 95, 1, '2021-05-19 15:09:27', NULL),
(835, 'imagePost60a52a702522976890484160a52a70252361881115737.png', 96, 1, '2021-05-19 15:10:40', NULL),
(836, 'imagePost60a52a7025764208223230460a52a702576d1293105886.png', 96, 1, '2021-05-19 15:10:40', NULL),
(837, 'imagePost60a52a70258fd156173433860a52a7025900409505605.png', 96, 1, '2021-05-19 15:10:40', NULL),
(838, 'imagePost60a52a7025ad223816382360a52a7025ad5564202419.png', 96, 1, '2021-05-19 15:10:40', NULL),
(839, 'imagePost60a52a7025c0364419615260a52a7025c06474556214.png', 96, 1, '2021-05-19 15:10:40', NULL),
(840, 'imagePost60a52aa86fba429428629560a52aa86fbb6895553420.png', 97, 1, '2021-05-19 15:11:36', NULL),
(841, 'imagePost60a52aa86fd8c739439860a52aa86fd8f2009417921.png', 97, 1, '2021-05-19 15:11:36', NULL),
(842, 'imagePost60a52aa87023667069846760a52aa87023b793377571.png', 97, 1, '2021-05-19 15:11:36', NULL),
(843, 'imagePost60a52aa870c31119325665360a52aa870c381937131692.png', 97, 1, '2021-05-19 15:11:36', NULL),
(844, 'imagePost60a52aa870e6817258137560a52aa870e6d1379220514.png', 97, 1, '2021-05-19 15:11:36', NULL),
(845, 'imagePost60a52aa87106b133446491560a52aa8710722025504995.png', 97, 1, '2021-05-19 15:11:36', NULL),
(846, 'imagePost60a52aa87123c139691501760a52aa87123f1396858900.png', 97, 1, '2021-05-19 15:11:36', NULL),
(847, 'imagePost60a52b1426f11205682193960a52b1426f211600389536.png', 98, 1, '2021-05-19 15:13:24', NULL),
(848, 'imagePost60a52b14277e048697377360a52b14277e86832805.png', 98, 1, '2021-05-19 15:13:24', NULL),
(849, 'imagePost60a52b1427ab7204049021960a52b1427aba1995078373.png', 98, 1, '2021-05-19 15:13:24', NULL),
(850, 'imagePost60a52b1427e6857957368260a52b1427e6c1685505087.png', 98, 1, '2021-05-19 15:13:24', NULL),
(851, 'imagePost60a52b142851118823743160a52b14285191577297358.png', 98, 1, '2021-05-19 15:13:24', NULL),
(852, 'imagePost60a52b142888127168487660a52b14288891922504708.png', 98, 1, '2021-05-19 15:13:24', NULL),
(853, 'imagePost60a52b6e00108187408064560a52b6e001291178170555.png', 99, 1, '2021-05-19 15:14:54', NULL),
(854, 'imagePost60a52b6e00340126654518760a52b6e00344950898037.png', 99, 1, '2021-05-19 15:14:54', NULL),
(855, 'imagePost60a52b6e0178096879947960a52b6e017881189508385.png', 99, 1, '2021-05-19 15:14:54', NULL),
(856, 'imagePost60a52bcd76eb496293711560a52bcd76ec2842227371.png', 100, 1, '2021-05-19 15:16:29', NULL),
(857, 'imagePost60a52bcd7705c42783274060a52bcd7705f502243552.png', 100, 1, '2021-05-19 15:16:29', NULL),
(858, 'imagePost60a52bcd7720b138746505760a52bcd7720d1925344056.png', 100, 1, '2021-05-19 15:16:29', NULL),
(859, 'imagePost60a52c67a64f416149647160a52c67a6504609394275.png', 101, 1, '2021-05-19 15:19:03', NULL),
(860, 'imagePost60a52c67a687b22008522660a52c67a68837472138.png', 101, 1, '2021-05-19 15:19:03', NULL),
(861, 'imagePost60a52c67a6d9739705530760a52c67a6d9e1083532775.png', 101, 1, '2021-05-19 15:19:03', NULL),
(862, 'imagePost60a52c67a6ed1129517286160a52c67a6ed3147327783.png', 101, 1, '2021-05-19 15:19:03', NULL),
(863, 'imagePost60a52cb062144105929424560a52cb062153412721716.png', 102, 1, '2021-05-19 15:20:16', NULL),
(864, 'imagePost60a52cb0625bc32370308960a52cb0625c41589338419.png', 102, 1, '2021-05-19 15:20:16', NULL),
(865, 'imagePost60a52cb062afe135692246960a52cb062b06676266465.png', 102, 1, '2021-05-19 15:20:16', NULL),
(866, 'imagePost60a52d0333bae92901692960a52d0333bbe2106752954.png', 103, 1, '2021-05-19 15:21:39', NULL),
(867, 'imagePost60a52d0333e39195380066960a52d0333e3f628292050.png', 103, 1, '2021-05-19 15:21:39', NULL),
(868, 'imagePost60a52d0334a3763744199960a52d0334a40480838614.png', 103, 1, '2021-05-19 15:21:39', NULL),
(869, 'imagePost60a52dab2d25856979013060a52dab2d26b815049916.png', 104, 1, '2021-05-19 15:24:27', NULL),
(870, 'imagePost60a52dab2d8b58592058660a52dab2d8be1291620310.png', 104, 1, '2021-05-19 15:24:27', NULL),
(871, 'imagePost60a52dab2dd5957839802560a52dab2dd61548141536.png', 104, 1, '2021-05-19 15:24:27', NULL),
(872, 'imagePost60a52dab2e07463583147960a52dab2e0792135964446.png', 104, 1, '2021-05-19 15:24:27', NULL),
(873, 'imagePost60a52de3b73b4210109043560a52de3b73c11434452946.png', 105, 1, '2021-05-19 15:25:23', NULL),
(874, 'imagePost60a52de3b76469353315460a52de3b7649589976490.png', 105, 1, '2021-05-19 15:25:23', NULL),
(875, 'imagePost60a52de3b7779123203786560a52de3b777b1339696161.png', 105, 1, '2021-05-19 15:25:23', NULL),
(876, 'imagePost60a52de3b787d208720034960a52de3b7880526415594.png', 105, 1, '2021-05-19 15:25:23', NULL),
(877, 'imagePost60a52e23458a2209285124260a52e23458b1311123547.png', 106, 1, '2021-05-19 15:26:27', NULL),
(878, 'imagePost60a52e2345c18114548076160a52e2345c1d1097801838.png', 106, 1, '2021-05-19 15:26:27', NULL),
(879, 'imagePost60a52e2345d7b209235074860a52e2345d7e1751894720.png', 106, 1, '2021-05-19 15:26:27', NULL),
(880, 'imagePost60a52e64eb52d139164137460a52e64eb53f655558743.png', 107, 1, '2021-05-19 15:27:32', NULL),
(881, 'imagePost60a52e64eb87357267526760a52e64eb8922034495572.png', 107, 1, '2021-05-19 15:27:32', NULL),
(882, 'imagePost60a52e64ebf46139730149260a52e64ebf62799669801.png', 107, 1, '2021-05-19 15:27:32', NULL),
(883, 'imagePost60a52e64ec1b7209892944460a52e64ec1ba1397446375.png', 107, 1, '2021-05-19 15:27:33', NULL),
(884, 'imagePost60a52ea1d47ab203144550060a52ea1d47bb1631287483.png', 108, 1, '2021-05-19 15:28:33', NULL),
(885, 'imagePost60a52ea1d4a1e164339728660a52ea1d4a23780585164.png', 108, 1, '2021-05-19 15:28:33', NULL),
(886, 'imagePost60a52ea1d4da8139607295160a52ea1d4dab779785925.png', 108, 1, '2021-05-19 15:28:33', NULL),
(887, 'imagePost60a52ea1d75d9190684937860a52ea1d75e1218129651.png', 108, 1, '2021-05-19 15:28:33', NULL),
(888, 'imagePost60a52edd5b7a218373344260a52edd5b7b1105273617.png', 109, 1, '2021-05-19 15:29:33', NULL),
(889, 'imagePost60a52edd5b982133217893460a52edd5b9861618203654.png', 109, 1, '2021-05-19 15:29:33', NULL),
(890, 'imagePost60a52edd5c189136007446760a52edd5c190708965569.png', 109, 1, '2021-05-19 15:29:33', NULL),
(891, 'imagePost60a52f1726401185259106560a52f172640d1509758812.png', 110, 1, '2021-05-19 15:30:31', NULL),
(892, 'imagePost60a52f172679a209104458960a52f17267a1672464969.png', 110, 1, '2021-05-19 15:30:31', NULL),
(893, 'imagePost60a52f17268c8135584714760a52f17268cb579992462.png', 110, 1, '2021-05-19 15:30:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `type_of_activity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin_id` int NOT NULL,
  `lattitude` decimal(22,20) NOT NULL,
  `longitude` decimal(22,20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `title`, `description`, `type_of_activity`, `admin_id`, `lattitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(87, 'Pashupatinath Temple', 'Pashupatinath Temple is the oldest Hindu temple in Kathmandu. It is not known for certain when Pashupatinath Temple was built. But according to Nepal Mahatmaya and Himvatkhanda,[6] the deity here gained great fame there as Pashupati, the Lord of all Pashus, which are living as well as non-living beings. Pashupatinath Temple\'s existence dates back to 400 B.C.[citation needed] The richly ornamented pagoda houses the sacred linga or holy symbol of Lord Shiva. There are many legends describing how the temple of Lord Aalok Pashupatinath came to existence here. Some of them are narrated below.\r\n\r\nKathmandu pasupati', 'Religious Places', 14, '27.71147342184870000000', '85.35027166765624000000', 0, '2021-05-19 14:27:27', '2021-05-20 14:56:00'),
(90, 'Swayambhunath', 'Swayambhu literally means \"self-existent one\". Believed to date back to 460 A.D., it was built by King Manadeva and by the 13th century, it had become an important center of Buddhism. Legend has it that Swayambhu was born out of a lotus flower that bloomed in the middle of a lake that once spread across the Kathmandu Valley once was. The largest image of the Sakyamuni Buddha in Nepal sits on a high pedestal on the western boundary of Swayambhu beside the Ring Road. Behind the hilltop is a temple dedicated to Manjusri or Saraswati - the Goddess of learning. Chaityas, statues and shrines of Buddhist and Hindu deities fill the stupa complex. The base of the hill is almost entirely surrounded by prayer wheels and deities. Devotees can be seen circumambulating the stupa at all times.\r\n\r\nKathmandu swayambhu', 'Religious Places', 14, '27.71559393346087300000', '85.29252556710304000000', 1, '2021-05-19 14:57:35', NULL),
(91, 'Boudhanath', 'Boudhanath has been an important place of pilgrimage and meditation for Tibetan Buddhists & local Nepalis. It is located on what was a major trade route between Nepal & Tibet. Many traveling merchants used it as a resting place. It is also a popular tourist site. In 1979, Boudha became a UNESCO World Heritage Site. The Great Stupa of Boudhanath is the focal point of the district. There are at least 29 Tibetan Gompas (Monasteries & Nunneries) around Boudhanath. The culture is very much Himalayan with a strong presence of Tibetans & Sherpas, as can be evidenced by the number of restaurants selling momos, thukpa & other Tibetan favorites. Many maroon clad Tibetan Buddhist monks & nuns can be seen walking around Boudha, especially at the Stupa. As a daily ritual, many people walk three or more times around the stupa while repeating the mantra \'Om Mani Padme Hum\' either quietly or aloud.\r\n\r\nKathmandu boudha', 'Religious Places', 14, '27.72164598749106000000', '85.36194112920887000000', 1, '2021-05-19 14:59:08', '2021-05-19 15:03:23'),
(92, 'Hiranya Varna Mahavihar', 'This Buddhist temple complex is believed to have been conserved in the 12th century by the King Vaskar Dev Varma. It is full of art and architecture of the Nepalese pattern. This Vihar is also known as Kwabahal in the Newari language. Legend associates the formal name Hiranya with a rat name Hiranyaka because of its golden color and the popular Vihar located at Kwalakhu a few minutes walking distances from the Patan Durbar Square. The ground floor of the main pagoda is occupied by an image of Shakya muni Buddha. The most ancient structure is the Swoyambhu Stupa in the courtyard. The holy text of Pragya Parmita, written in letters of gold is also faith of people is preserved here since ancient times of recitation.\r\n\r\nLalitpur patan dhoka', 'Religious Places', 14, '27.67628835145507000000', '85.32592159094595000000', 1, '2021-05-19 15:05:14', NULL),
(93, 'Tharlam Monastery', 'Tharlam Monastery is a Tibetan Buddhist monastery of the Sakya sect in Boudhanath, Kathmandu, Nepal.In 1436, Ga Rabjampa Kunga Yeshe (1397 - 1470) founded Tharlam Monastery in Kham, Eastern Tibet. \r\nIt was also known as Tarlam Sabzang Namgyaling, 唐隆寺, 汤陇寺, tanglong si, and Śrī Tarlam Ganden Sabzang Namgyel Ling (thar lam dga\' ldan sa bzang rnam rgyal gling).\r\nIn 1959 the monastery was destroyed by Chinese communists.\r\nThe monastery was rebuilt by Dezhung Rinpoche in Kathmandu, Nepal in 1981.40 rooms for \"meditation and retreat\" were later built.\r\n\r\nKathmandu Jorpati', 'Religious Places', 14, '27.72387775360464000000', '85.36567011478886000000', 1, '2021-05-19 15:06:45', NULL),
(94, 'Shree Bindhyabasini Temple', 'The Bindhyabasini Temple is the oldest temple in the city of Pokhara, Nepal and is located in Ward No. 2, Miruwa. It regularly attracts a large number of locals, Nepalis from across the country and foreigners alike. The main temple is devoted to goddess Bindhyabasini, a Bhagawati who is the incarnation of Kali. There are smaller temples of goddess Saraswati, Shiva, Hanuman, Ganesha in the premises. The temple is situated atop a small hill and can be accessed via stone staircases on the East and North East. The views of the Himalayas from the North of the temple are breathtaking while from the South one can see the expanse of Pokhara city.\r\n\r\nPokhara Bagar', 'Religious Places', 14, '28.23880240466677400000', '83.98584128299832000000', 1, '2021-05-19 15:07:58', NULL),
(95, 'Bhaktapur Durbar Square', 'The ancient city Bhaktapur lies on the Eastern part of Kathmandu valley which is also known as Bhadgaon or Khwopa. The historical monument on around signifies medieval age culture and tradition of Nepal and this old city is inhabited by indigenous Newari people in large group. you can visit to this place to experience Nepali culture,tradition,religion from right way.we are here to support you for your tours.\r\n\r\nBhaktapur', 'sightseeing', 14, '27.67306256946956800000', '85.43072013586573000000', 1, '2021-05-19 15:09:27', NULL),
(96, 'Kathmandu Durbar Square ( Basantapur Durbar )', 'Kathmandu Durbar Square , is one of three squares within Kathmandu Valley in Nepal. Durbar Square (durbar translates to “palace” or “a court held by a prince”) is an important site for Buddhist and Hindu rituals, holy ceremonies, royal events, and kingly coronations.\r\nSurrounded by fountains, ancient statues, small ponds, and a series of courtyards such as Mohan Chok and Sundari Chok, Kathmandu Durbar Square is a meditative, religious site for spiritual seekers. Within the inner complex of Durbar Square is the site of the Old Royal Palaces (referred to as the Hanuman Dhoka Palace Complex). The Royal Palaces used to house the kings of the Shah and Malla Dynasty, who ruled over the city until the 19th-century. The palaces have since been turned into museums.\r\n\r\nKathmandu Basantapur', 'sightseeing', 14, '27.70500769821364000000', '85.30854057505069000000', 1, '2021-05-19 15:10:40', NULL),
(97, 'Patan durbar square', 'The Durbar Square is a marvel of Newar architecture. The square floor is tiled with red bricks. There are many temples and idols in the area. The main temples are aligned opposite of the western face of the palace. The entrance of the temples faces east, towards the palace. There is also a bell situated in the alignment beside the main temples. The Square also holds old Newari residential houses. There are other temples and structures in and around Patan Durbar Square built by the Newa People. A center of both Hinduism and Buddhism, Patan Durbar Square has 136 \"bahals\" (courtyards) and 55 major temples.\r\n\r\nLalitpur patan', 'sightseeing', 14, '27.67353423920594200000', '85.32686605231419000000', 1, '2021-05-19 15:11:36', NULL),
(98, 'Garden of dreams', 'The Garden of Dreams, a neo classical historical garden, is situated in the midst of Kathmandu city, Nepal. The Garden\'s design has much in common with formal European gardens: paved perimeter paths, punctuated by pavilions, trellises, and various planting areas, surrounded by a sunken flower garden with a large pond at its center. It is an architectural landscape that encourages the visitor to stroll around and discover the Garden\'s treasures from many different vantage points.\r\nSightseeing\r\nKathmandu thamel', 'sightseeing', 14, '27.71477196297190000000', '85.31467576136824000000', 1, '2021-05-19 15:13:24', NULL),
(99, 'Narayanhiti palace', 'The Narayanhiti Palace Museum is a public museum in Kathmandu, Nepal located east of the Kaiser Mahal and next to Thamel. The museum was created in 2008 from the complex of the former Narayanhiti Palace following the 2006 revolution. Before the revolution, the palace was the residence and principal workplace of the monarch of the Kingdom of Nepal, and hosted occasions of state. The existing palace complex was built by King Mahendra in 1963, and incorporates an impressive array of courtyards, gardens and buildings\r\n\r\nKathmandu', 'sightseeing', 14, '27.71466773204828700000', '85.31922646026183000000', 0, '2021-05-19 15:14:54', '2021-05-20 09:24:31'),
(100, 'Taleju Bhawani Deju', 'Taleju Temple is a Hindu temple dedicated to Taleju Bhawani, the royal goddess of the Malla dynasty of Nepal. It was built in 1564 by Mahendra Malla and is located in Hanuman Dhoka, Kathmandu Durbar Square, a UNESCO Heritage site. Inside the temple, there is a shire dedicated to Taleju Bhawani, and Kumari Devi. Taleju Temple is only opened once a year on the occasion of Dashain.\r\n\r\nKathmandu Indra chowk', 'sightseeing', 14, '27.70537134216671400000', '85.30916249889360000000', 1, '2021-05-19 15:16:29', NULL),
(101, 'National Museum of Nepal', 'The National Museum of Nepal is a popular attraction of the capital city of Kathmandu. About a century old, the museum stands as a tourist destination and historical symbol for Nepal. Being the largest museum of the country of Nepal, it plays an important role in nationwide archaeological works and development of museums. For the residents of Kathmandu, the monument serves to relive the battles fought on the grounds of Nepal. The main attractions are collection of historical artworks and a historical display of weapons used in the wars in the 18-19th century. The museum has separate galleries dedicated to statues, paintings, murals, coins and weapons. It has three buildings — Juddha Jayatia Khate Sala, Buddha Art Gallery and the main building which consists of natural historical section, cultural section and philatelic section. The National Museum is under the Ministry of Culture, Tourism and Civil Aviation. The museum has practical application in portraying and understanding the past and present traditions of the people of Nepal.\r\n\r\nKathmandu Tahachal', 'sightseeing', 14, '27.70594231038337400000', '85.29019725288482000000', 1, '2021-05-19 15:19:03', NULL),
(102, 'Central Zoo', 'The Central Zoo is a 6-hectare zoo in Jawalakhel, Nepal. It is home to some 870 animals in 109 species, and is operated by the National Trust for Nature Conservation. Although it was originally a private zoo, it was opened to the public in 1956. During the Bhoto Jatra festival, celebrated near the zoo, the zoo may see upwards of 34,000 visitors in a single day after they come to see a historical jeweled vest at the culmination of the Rato Machchhindranath jatra.\r\n\r\nLalitpur Jawalakhel', 'sightseeing', 14, '27.67373016989584000000', '85.31384642107686000000', 1, '2021-05-19 15:20:16', NULL),
(103, 'Aviation Museum', 'Aircraft Museum Kathmandu is an aviation museum located in Sinamangal, Kathmandu, Nepal. The museum is inside an Airbus A330-300 of Turkish Airlines that only flew for about eight months before suffering a runway excursion at Tribhuvan International Airport in Kathmandu in March 2015. It was established under a joint initiative by the Civil Aviation Authority of Nepal and pilot Bed Upreti and his trust. This museum was officially opened to public on 28 November, 2017. The museum\'s exhibits include the aircraft\'s original cockpit setting, model and miniature aircraft and items documenting the history of Nepalese aviation. The museum is the second of its kind in Nepal, after Bed Upreti had already set up a similar, yet smaller aviation museum, the Aircraft Museum Dhangadhi in Dhangadhi in Western Nepal. The museum cost around NPRs 70 million.\r\n\r\nKathmandu, sinamangal', 'sightseeing', 14, '27.69449427792884300000', '85.35520927505067000000', 1, '2021-05-19 15:21:39', NULL),
(104, 'Phewa Lake', 'Phewa Lake, Phewa Tal or Fewa Lake is a freshwater lake in Nepal formerly called Baidam Tal located in the south of the Pokhara Valley that includes Pokhara city; parts of Sarangkot and Kaskikot. The lake is stream-fed but a dam regulates the water reserves, therefore, the lake is classified as semi-natural freshwater lake. It is the second largest lake in Nepal; the largest in Gandaki Pradesh after the Rara lake in the comparison to Nepal\'s water bodies. It is the most popular and most visited lake of Nepal. It is the only lake in Nepal to have a templeTal Barahi Temple at the central part of lake. Phewa lake is located at an altitude of 742 m and covers an area of about 4.43 km². It has an average depth of about 8.6 m and a maximum depth of 24 m. Maximum water capacity of the lake is approximately 43,000,000 cubic metres. The Annapurna range on the north is only about 28 km away from the lake. The lake is also famous for the reflection of mount Machhapuchhre and other mountain peaks of the Annapurna and Dhaulagiri ranges on its surface. The Tal Barahi Temple is situated on an island in the lake. It is located 4 km from the city\'s centre Chipledhunga.\r\n\r\nPokhara', 'sightseeing', 14, '28.21676981772844400000', '83.94508465968173000000', 1, '2021-05-19 15:24:27', NULL),
(105, 'Begnas Lake', 'Begnas Lake is a freshwater lake in Pokhara Lekhnath Metropolis of Kaski district of Nepal located in the south-east of the Pokhara Valley. The lake is the third largest lake of Nepal and second largest, after Phewa Lake, among the eight lakes in Pokhara Valley. Water level in the lake fluctuates seasonally due to rain, and utilization for irrigation. The water level is regulated through a dam constructed in 1988 on the western outlet stream, Khudi Khola.\r\n \r\nPokhara', 'sightseeing', 14, '28.17541336800896000000', '84.09722758689769000000', 1, '2021-05-19 15:25:23', NULL),
(106, 'Devi\'s Falls', 'Devi\'s Falls is a waterfall located at Pokhara in Kaski District, Nepal. The water forms a tunnel after reaching the bottom. This tunnel is approximately 500 feet long and runs 100 feet below ground level. On 31 July 1961, a Swiss couple went swimming but the woman drowned in a pit because of the overflow. Her body was recovered 3 days later in river Phusre with great effort. Her father wished to name it \"David\'s falls\" after her but changed to Devi\'s Fall. Its Nepali name is Patale Chango, which means \"underworld waterfall\". This is one of the most visited places in Nepal. After exiting the tunnel, the water passes through a cave called Gupteshwor Mahadev Cave or \"cave beneath the ground\". The Phewa Lake dam is the water source. The cave also acts as a tourism site because it has complex designs and people even forget the way inside the cave.\r\n\r\nPokhara', 'sightseeing', 14, '28.19124959228333000000', '83.96127323641890000000', 1, '2021-05-19 15:26:27', NULL),
(107, 'Mahendra Cave', 'Mahendra Cave is a cave located in Pokhara-16, batulechaur, Kaski district, close to the Kali khola, is a large limestone cave. It is a rare example of a cave system in Nepal containing stalagmites and stalactites. This show cave attracts thousands of tourists every year. A statue of Hindu lord Shiva can be found inside the cave.\r\n\r\nPokhara near Gharmi Village', 'sightseeing', 14, '28.27268608832398700000', '83.98101363697212000000', 1, '2021-05-19 15:27:32', NULL),
(108, 'Matepani Gumba', 'Matepani Gumba located in Matepani, Kundahar area of Pokhara, Kaski District of the Gandaki Zone in western Nepal. It was established in 1960 A.D.by Nyeshang people who migrated to Pokhara from Manang. Situated on a small hill, east of the Pokhara city, the monastery is about five km from Mahendrapul. This gumba is situated on the top of a green hill mountain.\r\nReligious tourism\r\nPokhara Matepani', 'sightseeing', 14, '28.21712166336856200000', '84.00946343641890000000', 1, '2021-05-19 15:28:33', NULL),
(109, 'Khaste Lake', 'Khaste Lake is a freshwater lake located at the Kharane Phant in Pokhara metropolitan city, Nepal. The lake is located in Lekhnath ward numbers 3, 4 and 6. It covers an area of 24.8030 hectares and the water \'s area covers 13.7370 hectares. Since some years, Pisciculture has also been practiced in this lake. The area known as ‘Bird Wetland’ is best suited as a bird watching lake, as the Siberian, Indian and Afghani birds come here to protect themselves from the cold. Yellow bittern, a summer migratory bird species has been observed near the lake. This area is also a potential research center for migratory birds of different species.\r\n\r\nPokhara', 'sightseeing', 14, '28.19467374649927000000', '84.05046613614961000000', 1, '2021-05-19 15:29:33', NULL),
(110, 'Dipang Lake', 'Dipang Lake is a freshwater lake located in the Lekhnath municipality of Kaski, Nepal. It is the fourth-largest lake among the seven lakes of Lekhnath to be listed in the wetland list of the world. It is famous as a picnic spot from where HImalayas and green hills can be seen. It is also known for wild lotus and swan.\r\nPokhara', 'sightseeing', 14, '28.18092878599860300000', '84.06894394039978000000', 1, '2021-05-19 15:30:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `password`, `email`, `phone_number`, `address`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(76, 'aayush dhakal 123', 'aayush1', 'd2295ddd09aa9e94b503b88f6d78eb97', 'hekewixi@mailinator.com', '+1 (301) 198-529799', 'Qui qui excepturi sa', 'imagePost60a67771383aa20513166060a67771383bb1464262797.png', 1, '2021-05-13 09:17:18', '2021-05-20 14:51:58'),
(77, 'Kenyon Little', 'aayush2', 'd2295ddd09aa9e94b503b88f6d78eb97', 'weryda@mailinator.com', '+1 (931) 931-6883', 'Vel dolor magna dign', NULL, 1, '2021-05-13 09:46:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN KEY on location_id favorite` (`location_id`),
  ADD KEY `FOREIGN KEY on user_id favorite` (`user_id`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN KEY on location_id images` (`location_id`) USING BTREE,
  ADD KEY `FOREIGN KEY on location_status images` (`status`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN KEY on admin_id location` (`admin_id`) USING BTREE,
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=897;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  ADD CONSTRAINT `FOREIGN KEY on location_id favorite` FOREIGN KEY (`location_id`) REFERENCES `tbl_location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FOREIGN KEY on user_id favorite` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD CONSTRAINT `FOREIGN KEY` FOREIGN KEY (`location_id`) REFERENCES `tbl_location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
