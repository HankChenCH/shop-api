-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-09-18 13:57:16
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `true_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `state` enum('1','0') CHARACTER SET utf8 NOT NULL DEFAULT '1' COMMENT '是否启用，0否，1是',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL,
  `login_ip` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `user_name`, `password`, `true_name`, `state`, `create_time`, `update_time`, `delete_time`, `login_time`, `login_ip`) VALUES
(1, 'hank', 'f2dedb3d6cd4c4df56298b802a1cc012', 'hank', '1', 1501918974, 1505141655, 1505141655, NULL, NULL),
(2, 'hankchen', '167238e4d710e60ce23f5a4b3a4647e8', '陈国哼', '1', 1501919394, 1505226120, NULL, NULL, NULL),
(5, 'bear', '20c2699c55e0ab35499ad7430824ee31', 'bear豪', '1', 1505546795, 1505550045, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_profile`
--

CREATE TABLE `admin_profile` (
  `admin_id` int(11) NOT NULL,
  `phone` varchar(18) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `gender` enum('1','0') CHARACTER SET utf8 DEFAULT '1' COMMENT '1男，2女',
  `age` int(3) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `admin_profile`
--

INSERT INTO `admin_profile` (`admin_id`, `phone`, `email`, `gender`, `age`, `create_time`, `update_time`, `delete_time`) VALUES
(5, '18676154972', '372259464@qq.com', '1', 28, 1505546795, 1505546795, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner管理表';

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`id`, `name`, `description`, `delete_time`, `update_time`) VALUES
(1, '首页置顶', '首页轮播图', NULL, NULL),
(2, 'banner测试用例', '', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `banner_item`
--

CREATE TABLE `banner_item` (
  `id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `delete_time` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner子项表';

--
-- 转存表中的数据 `banner_item`
--

INSERT INTO `banner_item` (`id`, `img_id`, `key_word`, `type`, `delete_time`, `banner_id`, `update_time`) VALUES
(1, 65, '6', 1, NULL, 1, NULL),
(2, 2, '25', 1, NULL, 1, NULL),
(3, 3, '11', 1, NULL, 1, NULL),
(5, 1, '10', 1, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) DEFAULT NULL COMMENT '外键，关联image表',
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品类目';

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `topic_img_id`, `create_time`, `delete_time`, `description`, `update_time`) VALUES
(2, '果味', 6, NULL, 1501417026, NULL, 1501417026),
(3, '蔬菜', 5, NULL, 1501417026, NULL, 1501417026),
(4, '炒货', 7, NULL, NULL, NULL, NULL),
(5, '点心', 4, NULL, NULL, NULL, NULL),
(6, '粗茶', 8, NULL, NULL, NULL, NULL),
(7, '淡饭', 9, NULL, NULL, NULL, NULL),
(8, '咖啡', 85, 1501326854, 1501394150, '咖啡人生，品味生活', 1501394150),
(9, '咖啡', 107, 1501417097, NULL, '咖啡人生,品味生活', 1502202165),
(10, '哈哈', 109, 1502525139, 1502525212, '哈哈啊哈', 1502525212);

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='图片总表';

--
-- 转存表中的数据 `image`
--

INSERT INTO `image` (`id`, `url`, `from`, `create_time`, `delete_time`, `update_time`) VALUES
(1, '/banner-1a.png', 1, NULL, NULL, NULL),
(2, '/banner-2a.png', 1, NULL, NULL, NULL),
(3, '/banner-3a.png', 1, NULL, NULL, NULL),
(4, '/category-cake.png', 1, NULL, NULL, NULL),
(5, '/category-vg.png', 1, NULL, NULL, NULL),
(6, '/category-dryfruit.png', 1, NULL, NULL, NULL),
(7, '/category-fry-a.png', 1, NULL, NULL, NULL),
(8, '/category-tea.png', 1, NULL, NULL, NULL),
(9, '/category-rice.png', 1, NULL, NULL, NULL),
(10, '/product-dryfruit@1.png', 1, NULL, NULL, NULL),
(13, '/product-vg@1.png', 1, NULL, NULL, NULL),
(14, '/product-rice@6.png', 1, NULL, NULL, NULL),
(16, '/1@theme.png', 1, NULL, NULL, NULL),
(17, '/2@theme.png', 1, NULL, NULL, NULL),
(18, '/3@theme.png', 1, NULL, NULL, NULL),
(19, '/detail-1@1-dryfruit.png', 1, NULL, NULL, NULL),
(20, '/detail-2@1-dryfruit.png', 1, NULL, NULL, NULL),
(21, '/detail-3@1-dryfruit.png', 1, NULL, NULL, NULL),
(22, '/detail-4@1-dryfruit.png', 1, NULL, NULL, NULL),
(23, '/detail-5@1-dryfruit.png', 1, NULL, NULL, NULL),
(24, '/detail-6@1-dryfruit.png', 1, NULL, NULL, NULL),
(25, '/detail-7@1-dryfruit.png', 1, NULL, NULL, NULL),
(26, '/detail-8@1-dryfruit.png', 1, NULL, NULL, NULL),
(27, '/detail-9@1-dryfruit.png', 1, NULL, NULL, NULL),
(28, '/detail-11@1-dryfruit.png', 1, NULL, NULL, NULL),
(29, '/detail-10@1-dryfruit.png', 1, NULL, NULL, NULL),
(31, '/product-rice@1.png', 1, NULL, NULL, NULL),
(32, '/product-tea@1.png', 1, NULL, NULL, NULL),
(33, '/product-dryfruit@2.png', 1, NULL, NULL, NULL),
(36, '/product-dryfruit@3.png', 1, NULL, NULL, NULL),
(37, '/product-dryfruit@4.png', 1, NULL, NULL, NULL),
(38, '/product-dryfruit@5.png', 1, NULL, NULL, NULL),
(39, '/product-dryfruit-a@6.png', 1, NULL, NULL, NULL),
(40, '/product-dryfruit@7.png', 1, NULL, NULL, NULL),
(41, '/product-rice@2.png', 1, NULL, NULL, NULL),
(42, '/product-rice@3.png', 1, NULL, NULL, NULL),
(43, '/product-rice@4.png', 1, NULL, NULL, NULL),
(44, '/product-fry@1.png', 1, NULL, NULL, NULL),
(45, '/product-fry@2.png', 1, NULL, NULL, NULL),
(46, '/product-fry@3.png', 1, NULL, NULL, NULL),
(47, '/product-tea@2.png', 1, NULL, NULL, NULL),
(48, '/product-tea@3.png', 1, NULL, NULL, NULL),
(49, '/1@theme-head.png', 1, NULL, NULL, NULL),
(50, '/2@theme-head.png', 1, NULL, NULL, NULL),
(51, '/3@theme-head.png', 1, NULL, NULL, NULL),
(52, '/product-cake@1.png', 1, NULL, NULL, NULL),
(53, '/product-cake@2.png', 1, NULL, NULL, NULL),
(54, '/product-cake-a@3.png', 1, NULL, NULL, NULL),
(55, '/product-cake-a@4.png', 1, NULL, NULL, NULL),
(56, '/product-dryfruit@8.png', 1, NULL, NULL, NULL),
(57, '/product-fry@4.png', 1, NULL, NULL, NULL),
(58, '/product-fry@5.png', 1, NULL, NULL, NULL),
(59, '/product-rice@5.png', 1, NULL, NULL, NULL),
(60, '/product-rice@7.png', 1, NULL, NULL, NULL),
(62, '/detail-12@1-dryfruit.png', 1, NULL, NULL, NULL),
(63, '/detail-13@1-dryfruit.png', 1, NULL, NULL, NULL),
(65, '/banner-4a.png', 1, NULL, NULL, NULL),
(66, '/product-vg@4.png', 1, NULL, NULL, NULL),
(67, '/product-vg@5.png', 1, NULL, NULL, NULL),
(68, '/product-vg@2.png', 1, NULL, NULL, NULL),
(69, '/product-vg@3.png', 1, NULL, NULL, NULL),
(70, '20170727\\0cf524629a3800c63077b19be9562e24.png', 1, 1501163201, NULL, 1501163201),
(71, '/20170727/9c6e4020e1440ed6419a8d0c03086a3f.png', 1, 1501163386, NULL, 1501163386),
(72, '/20170727/ba59f6279d9c124fc83f28626e608be3.png', 1, 1501163465, NULL, 1501163465),
(73, '/20170727/3959fef1749508c977d13dfbc385840e.png', 1, 1501163554, NULL, 1501163554),
(74, '/20170727/3ba1f4472e61fc69d5d099fe094bc0d6.png', 1, 1501163782, NULL, 1501163782),
(75, '/20170727/696f0f63a0761d8509a87079b2c939a7.png', 1, 1501164411, NULL, 1501164411),
(76, '/20170727/d594b7fb9d28bd15fdb3106120ff8fbb.png', 1, 1501165135, NULL, 1501165135),
(77, '/20170727/a40428f28650ad19d0d274e01b9e731e.png', 1, 1501165337, NULL, 1501165337),
(78, '/20170727/c119cf7296ba7397f0aba24fd4b8e545.png', 1, 1501165595, NULL, 1501165595),
(79, '/20170727/95311cfdef42b86e3a7cb906e0fccfcb.jpg', 1, 1501165786, NULL, 1501165786),
(80, '/20170729/17b8e2db2ff179446ac2cd232d823bd0.png', 1, 1501325674, NULL, 1501325674),
(81, '/20170729/1174fbe33a7e1860963e3381147b06b9.png', 1, 1501325885, NULL, 1501325885),
(82, '/20170729/560135018dbbe6d113ca4bb8c856405d.jpg', 1, 1501326027, NULL, 1501326027),
(83, '/20170729/b251df4e9e43e0cab0bb3c14efd4e31b.jpg', 1, 1501326235, NULL, 1501326235),
(84, '/20170729/8286f9f18a33ed1e6abbee8fcb236b09.jpg', 1, 1501326331, NULL, 1501326331),
(85, '/20170729/2a1667eb5a3537b89db51304ca93ea95.jpg', 1, 1501326772, NULL, 1501326772),
(86, '/20170730/269345f5d62d11ef2ccbc94cf70d642a.jpg', 1, 1501417096, NULL, 1501417096),
(87, '/20170806/fbc1edfe2026f30e331c50d9c894f12f.jpg', 1, 1502026227, NULL, 1502026227),
(88, '/product/20170806/4a8f38b4780e74de78efbfa2f6775e1d.jpg', 1, 1502027317, NULL, 1502027317),
(89, '/product/20170806/8b9533af4a577f4f4a55d814e30d3291.jpg', 1, 1502027379, NULL, 1502027379),
(90, '/product/20170806/a919322f9a72cecffa4c120e25ffbf81.jpg', 1, 1502027671, NULL, 1502027671),
(91, '/product/20170806/486c4b26c340a875d4f8a43b9052f97f.jpg', 1, 1502027741, NULL, 1502027741),
(92, '/product/20170806/e044bf8918d0daa74063f5d8f7b53802.jpg', 1, 1502028503, NULL, 1502028503),
(93, '/product/20170806/a53c48a09539db76d84301a24929ab78.jpg', 1, 1502028535, NULL, 1502028535),
(94, '/product/20170807/52a00ae1294f693806f105c418cd2be9.jpg', 1, 1502113472, NULL, 1502113472),
(95, '/product/20170807/bc7e80be0a055a047cc3e4bf2ecac5ef.jpg', 1, 1502113676, NULL, 1502113676),
(96, '/product/20170807/22793294be5cb60bf9363be8e8bc69fe.jpg', 1, 1502114016, NULL, 1502114016),
(97, '/product/20170807/ada9d7990ba3bb6c641563de923698cd.jpg', 1, 1502114101, NULL, 1502114101),
(98, '/product/20170807/e661531f2dd83e3cc66b5e4d292eea24.jpg', 1, 1502114518, NULL, 1502114518),
(99, '/product-7f233201708082145414042.jpg', 2, 1502199941, NULL, 1502199941),
(100, '/product-0c35f201708082147148323.jpg', 2, 1502200035, NULL, 1502200035),
(101, '/product-a2756201708082148124205.jpg', 2, 1502200103, NULL, 1502200103),
(102, '/product-3fa5f20170808215102149.jpg', 2, 1502200262, NULL, 1502200262),
(103, '/product-ba4b9201708082151356004.jpg', 2, 1502200296, NULL, 1502200296),
(104, '/product_e0f84201708082212362770.jpg', 2, 1502201560, NULL, 1502201560),
(105, '/product_0f25a201708082218547055.jpg', 2, 1502201934, NULL, 1502201934),
(106, '/product_ec705201708082220516461.jpg', 2, 1502202052, NULL, 1502202052),
(107, '/category_dc4a0201708082222418356.jpg', 2, 1502202162, NULL, 1502202162),
(108, '/product_b643c201708082235014683.jpg', 2, 1502202901, NULL, 1502202901),
(109, '/category_e2b9020170812160531350.jpg', 2, 1502525132, NULL, 1502525132),
(110, '/product_detail_f9593201708231931212670.jpg', 2, 1503487882, NULL, 1503487882),
(111, '/product_detail_0c9cd201708231935331268.jpg', 2, 1503488133, NULL, 1503488133),
(112, '/product_detail_28288201708231940037638.jpg', 2, 1503488403, NULL, 1503488403),
(113, '/product_detail_8bfe1201708231942006804.jpg', 2, 1503488520, NULL, 1503488520),
(114, '/product_detail_ef4ce201708231952113929.jpg', 2, 1503489131, NULL, 1503489131),
(115, '/product_detail_dc791201708231953149074.jpg', 2, 1503489194, NULL, 1503489194),
(116, '/product_detail_14cbf201708231953446660.jpg', 2, 1503489224, NULL, 1503489224),
(117, '/product_detail_72f2e201708231954515851.jpg', 2, 1503489292, NULL, 1503489292),
(118, '/product_detail_3dc64201708232000313136.jpg', 2, 1503489631, NULL, 1503489631),
(119, '/product_detail_44350201708232006043345.jpg', 2, 1503489964, NULL, 1503489964),
(120, '/product_detail_f146620170823200629350.png', 2, 1503489989, NULL, 1503489989),
(121, '/product_detail_f9ec3201708232021033706.jpg', 2, 1503490863, NULL, 1503490863),
(122, '/product_detail_6c96c201708232021442481.jpg', 2, 1503490904, NULL, 1503490904),
(123, '/product_detail_2e22f201708232023242519.jpg', 2, 1503491004, NULL, 1503491004),
(124, '/product_detail_7e9ce201708232023398396.jpg', 2, 1503491019, NULL, 1503491019),
(125, '/product_detail_02c13201708232024116307.jpg', 2, 1503491051, NULL, 1503491051),
(126, '/product_detail_baef1201708232024359150.jpg', 2, 1503491075, NULL, 1503491075),
(127, '/product_detail_1432c2017082320271732.jpg', 2, 1503491237, NULL, 1503491237),
(128, '/product_detail_68a37201708232033435484.jpg', 2, 1503491623, NULL, 1503491623),
(129, '/product_detail_79175201708232034444592.jpg', 2, 1503491685, NULL, 1503491685),
(130, '/product_detail_f9659201708232035015330.jpg', 2, 1503491701, NULL, 1503491701),
(131, '/product_detail_0092d201708232035494323.jpg', 2, 1503491749, NULL, 1503491749),
(132, '/product_detail_fd476201708261531394195.jpg', 2, 1503732700, NULL, 1503732700),
(133, '/product_4734b20170827193018501.jpg', 2, 1503833419, NULL, 1503833419),
(134, '/product_e0056201708271931204324.jpg', 2, 1503833483, NULL, 1503833483),
(135, '/product_1b3aa201708271935549685.jpg', 2, 1503833754, NULL, 1503833754),
(136, '/product_3643020170827193735688.jpg', 2, 1503833855, NULL, 1503833855),
(137, '/product_detail_fb11a201708271955502438.jpg', 2, 1503834953, NULL, 1503834953),
(138, '/product_234af201708312201282078.jpg', 2, 1504188089, NULL, 1504188089),
(139, '/product_f88ca201709012101432157.png', 2, 1504270904, NULL, 1504270904),
(140, '/product_dbb32201709012104271757.png', 2, 1504271067, NULL, 1504271067),
(141, '/product_4dfc2201709012107069241.jpg', 2, 1504271235, NULL, 1504271235),
(142, '/product_33f8c201709012127404264.jpg', 2, 1504272462, NULL, 1504272462),
(143, '/product_5294b201709012153116536.png', 2, 1504273992, NULL, 1504273992),
(144, '/product_2f81d201709012158302156.jpg', 2, 1504274311, NULL, 1504274311),
(145, '/product_3b8ee201709031810392939.jpg', 2, 1504433441, NULL, 1504433441),
(146, '/product_4c5a4201709031819325294.jpg', 2, 1504433974, NULL, 1504433974),
(147, '/product_4f9bd201709031822137463.jpg', 2, 1504434135, NULL, 1504434135),
(148, '/product_80163201709031823489898.jpg', 2, 1504434229, NULL, 1504434229),
(149, '/product_91607201709031824389598.jpg', 2, 1504434288, NULL, 1504434288),
(150, '/product_8ddd0201709031824506743.jpg', 2, 1504434292, NULL, 1504434292),
(151, '/product_84cea201709031826518526.jpg', 2, 1504434413, NULL, 1504434413),
(152, '/product_b6c9e201709031930555321.jpg', 2, 1504438257, NULL, 1504438257),
(153, '/product_2ac9d201709031939093517.jpg', 2, 1504438757, NULL, 1504438757),
(154, '/product_8c554201709031940247605.jpg', 2, 1504438907, NULL, 1504438907),
(155, '/product_643bc201709031941458359.jpg', 2, 1504438912, NULL, 1504438912),
(156, '/product_5addd201709031940541035.jpg', 2, 1504438914, NULL, 1504438914),
(157, '/product_ff9ad201709032050021214.jpg', 2, 1504443002, NULL, 1504443002),
(158, '/product_db4bc201709032051569592.jpg', 2, 1504443117, NULL, 1504443117),
(159, '/product_8c6aa201709032052573301.jpg', 2, 1504443177, NULL, 1504443177),
(160, '/product_46109201709032055537911.jpg', 2, 1504443353, NULL, 1504443353),
(161, '/product_ca6db201709032058353820.jpg', 2, 1504443515, NULL, 1504443515),
(162, '/product_3de2d201709032100104761.jpg', 2, 1504443610, NULL, 1504443610),
(163, '/product_194ae201709032102246014.jpg', 2, 1504443745, NULL, 1504443745),
(164, '/product_e3206201709032104208540.jpg', 2, 1504443861, NULL, 1504443861),
(165, '/product_b643020170903210550313.jpg', 2, 1504443950, NULL, 1504443950),
(166, '/product_e892c201709032109251083.jpg', 2, 1504444165, NULL, 1504444165),
(167, '/product_2a9b3201709032115581833.jpg', 2, 1504444558, NULL, 1504444558),
(168, '/theme_b5242201709101326403995.jpg', 2, 1505021201, NULL, 1505021201),
(169, '/theme_05acf201709101341003632.jpg', 2, 1505022061, NULL, 1505022061),
(170, '/product_detail_18843201709131921075019.jpg', 2, 1505301668, NULL, 1505301668),
(171, '/product_detail_e2ecb201709131940037023.jpg', 2, 1505302804, NULL, 1505302804),
(172, '/product_detail_3900020170913194116871.jpg', 2, 1505302877, NULL, 1505302877),
(173, '/product_detail_12de4201709131943476392.jpg?imageMogr2/thumbnail/750x/blur/1x0/quality/75|imageslim', 2, 1505303027, NULL, 1505303027),
(174, '/product_detail_30532201709131954242460.jpg?imageMogr2/thumbnail/750x/blur/1x0/quality/75|imageslim', 2, 1505303665, NULL, 1505303665),
(175, '/product_detail_93604201709131959503628.jpg', 2, 1505303990, NULL, 1505303990),
(176, '/product_detail_fec8c201709132000593965.jpg', 2, 1505304060, NULL, 1505304060),
(177, '/product_detail_017f3201709132001134316.jpg', 2, 1505304073, NULL, 1505304073),
(178, '/product_detail_21d30201709132001514255.jpg', 2, 1505304111, NULL, 1505304111),
(179, '/product_detail_62628201709132004594979.jpg?imageMogr2/thumbnail/375x/blur/1x0/quality/75|imageslim', 2, 1505304299, NULL, 1505304299);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:未支付， 2：已支付，3：已发货 , 4: 已支付，但库存不足',
  `snap_img` varchar(255) DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `discount_price` decimal(6,2) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `snap_items` text COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) DEFAULT NULL COMMENT '地址快照',
  `snap_express` varchar(500) DEFAULT NULL COMMENT '快递快照，发货后填写',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `order_no`, `user_id`, `delete_time`, `create_time`, `total_price`, `status`, `snap_img`, `snap_name`, `total_count`, `discount_price`, `update_time`, `snap_items`, `snap_address`, `snap_express`, `prepay_id`) VALUES
(1, 'A611823859999144', 1, 1502594630, NULL, '0.02', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤等', 2, NULL, 1502594630, '[{"id":1,"haveStock":true,"count":1,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.01},{"id":2,"haveStock":true,"count":1,"name":"\\u68a8\\u82b1\\u5e26\\u96e8 3\\u4e2a","totalPrice":0.01}]', '{"id":1,"name":"hank","mobile":"18676154972","province":"\\u5e7f\\u4e1c","city":"\\u4e2d\\u5c71\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u4ead\\u5b50\\u4e0b\\u5927\\u8857\\u5341\\u53f7\\u4e4b\\u4e4b\\u4e00 202","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(2, 'A6118238744192 7', 1, 1502594649, NULL, '0.02', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤等', 2, NULL, 1502594649, '[{"id":1,"haveStock":true,"count":1,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.01},{"id":2,"haveStock":true,"count":1,"name":"\\u68a8\\u82b1\\u5e26\\u96e8 3\\u4e2a","totalPrice":0.01}]', '{"id":1,"name":"hank","mobile":"18676154972","province":"\\u5e7f\\u4e1c","city":"\\u4e2d\\u5c71\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u4ead\\u5b50\\u4e0b\\u5927\\u8857\\u5341\\u53f7\\u4e4b\\u4e4b\\u4e00 202","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(3, 'A611824918204731', 1, 1502594771, 1497182491, '0.08', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤等', 8, NULL, 1502594771, '[{"id":1,"haveStock":true,"count":3,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.03},{"id":7,"haveStock":true,"count":5,"name":"\\u6ce5\\u84bf \\u534a\\u65a4","totalPrice":0.05}]', '{"id":1,"name":"hank","mobile":"18676154972","province":"\\u5e7f\\u4e1c","city":"\\u4e2d\\u5c71\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u4ead\\u5b50\\u4e0b\\u5927\\u8857\\u5341\\u53f7\\u4e4b\\u4e4b\\u4e00 202","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(4, 'A614432940590887', 1, 1502594779, 1497443293, '0.02', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤等', 2, NULL, 1502594779, '[{"id":1,"haveStock":true,"count":1,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.01},{"id":2,"haveStock":true,"count":1,"name":"\\u68a8\\u82b1\\u5e26\\u96e8 3\\u4e2a","totalPrice":0.01}]', '{"id":1,"name":"hank","mobile":"18676154972","province":"\\u5e7f\\u4e1c","city":"\\u4e2d\\u5c71\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u4ead\\u5b50\\u4e0b\\u5927\\u8857\\u5341\\u53f7\\u4e4b\\u4e4b\\u4e00 202","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(5, 'A614433838278378', 1, NULL, 1497443383, '0.02', 3, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤等', 2, NULL, 1505636715, '[{"id":1,"haveStock":true,"count":1,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.01},{"id":2,"haveStock":true,"count":1,"name":"\\u68a8\\u82b1\\u5e26\\u96e8 3\\u4e2a","totalPrice":0.01}]', '{"id":1,"name":"hank","mobile":"18676154972","province":"\\u5e7f\\u4e1c","city":"\\u4e2d\\u5c71\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u4ead\\u5b50\\u4e0b\\u5927\\u8857\\u5341\\u53f7\\u4e4b\\u4e4b\\u4e00 202","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', '{"express_name":"\\u5706\\u901a","express_no":"feklnlkn342n1lk4n2"}', NULL),
(6, 'A614445834886636', 1, NULL, 1497444583, '0.02', 3, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤等', 2, NULL, 1505636611, '[{"id":1,"haveStock":true,"count":1,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.01},{"id":2,"haveStock":true,"count":1,"name":"\\u68a8\\u82b1\\u5e26\\u96e8 3\\u4e2a","totalPrice":0.01}]', '{"id":1,"name":"hank","mobile":"18676154972","province":"\\u5e7f\\u4e1c","city":"\\u4e2d\\u5c71\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u4ead\\u5b50\\u4e0b\\u5927\\u8857\\u5341\\u53f7\\u4e4b\\u4e4b\\u4e00 202","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', '{"express_name":"\\u4e2d\\u901a","express_no":"jnenl3212nkln"}', NULL),
(7, 'A625926990864070', 1, 1502594839, 1498392698, '0.03', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤', 3, NULL, 1502594839, '[{"id":1,"haveStock":true,"count":3,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.03}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(8, 'A625931141900824', 1, 1502595755, 1498393114, '0.03', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤', 3, NULL, 1502595755, '[{"id":1,"haveStock":true,"count":3,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.03}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(9, 'A625934300160371', 1, 1502595779, 1498393429, '0.03', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤', 3, NULL, 1502595779, '[{"id":1,"haveStock":true,"count":3,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.03}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(10, 'A625934637375587', 1, 1502596142, 1498393463, '0.03', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤', 3, NULL, 1502596142, '[{"id":1,"haveStock":true,"count":3,"name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.03}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(11, 'A702981734849289', 1, 1502596142, 1498998173, '0.02', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克等', 2, NULL, 1502596142, '[{"id":3,"haveStock":true,"count":1,"name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01},{"id":5,"haveStock":true,"count":1,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(12, 'A702987099432650', 1, 1502596159, 1498998709, '0.02', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克等', 2, NULL, 1502596159, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01},{"id":5,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@2.png","name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(13, 'A702987129273521', 1, 1502596160, 1498998712, '0.02', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克等', 2, NULL, 1502596160, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01},{"id":5,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@2.png","name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(14, 'A702987285898734', 1, NULL, 1498998728, '25.00', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克等', 2, NULL, 1502610000, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01},{"id":5,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@2.png","name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(15, 'A702987427600161', 1, NULL, 1498998742, '89.00', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克', 1, NULL, 1503734728, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(16, 'A702989584320695', 1, NULL, 1498998958, '0.01', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克', 1, NULL, 1498998958, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(17, 'A702990469052993', 1, NULL, 1498999046, '0.01', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克', 1, NULL, 1498999046, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(18, 'A702991638466788', 1, NULL, 1498999163, '0.01', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克', 1, NULL, 1498999163, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(19, 'A702994209718837', 1, NULL, 1498999420, '0.01', 1, 'http://api.c.cn/images/product-rice@1.png', '素米 327克', 1, NULL, 1498999420, '[{"id":3,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-rice@1.png","name":"\\u7d20\\u7c73 327\\u514b","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(20, 'A709042446539770', 1, NULL, 1499604244, '0.01', 1, 'http://api.c.cn/images/product-vg@1.png', '芹菜 半斤', 1, NULL, 1499604244, '[{"id":1,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-vg@1.png","name":"\\u82b9\\u83dc \\u534a\\u65a4","totalPrice":0.01}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(21, 'A826350166769846', 1, NULL, 1503735016, '60.00', 1, 'https://image.onegledog.cn/product_e0f84201708082212362770.jpg', '食探咖啡', 1, NULL, 1503735241, '[{"id":39,"haveStock":true,"counts":1,"price":"39.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_e0f84201708082212362770.jpg","name":"\\u98df\\u63a2\\u5496\\u5561","totalPrice":39}]', '{"id":1,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":"\\u4e2d\\u5c71\\u5e02","detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":1,"update_time":"1970-01-01 08:00:00"}', NULL, NULL),
(22, 'A907823924517524', 2, NULL, 1504782392, '66.00', 1, 'https://image.onegledog.cn/product_b6c9e201709031930555321.jpg', 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', 1, NULL, 1504782392, '[{"id":43,"haveStock":true,"counts":1,"price":"66.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_b6c9e201709031930555321.jpg","name":"FCR \\u6302\\u8033\\u5496\\u5561\\u66fc\\u7279\\u5b81G1 \\u9ed1\\u5496\\u5561\\u6ee4\\u6ce1\\u5f0f\\u73b0\\u78e8\\u5496\\u5561\\u7c89\\u6302\\u8033\\u530510\\u5305\\u88c5","totalPrice":66}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, NULL),
(23, 'A907824428958487', 2, NULL, 1504782442, '66.00', 1, 'https://image.onegledog.cn/product_b6c9e201709031930555321.jpg', 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', 1, '44.00', 1504785705, '[{"id":43,"haveStock":true,"counts":1,"price":"66.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_b6c9e201709031930555321.jpg","name":"FCR \\u6302\\u8033\\u5496\\u5561\\u66fc\\u7279\\u5b81G1 \\u9ed1\\u5496\\u5561\\u6ee4\\u6ce1\\u5f0f\\u73b0\\u78e8\\u5496\\u5561\\u7c89\\u6302\\u8033\\u530510\\u5305\\u88c5","totalPrice":66}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, 'wx20170907192254902eafe8570046366867'),
(24, 'A907834162223755', 2, NULL, 1504783416, '0.01', 1, 'http://api.c.cn/images/product-dryfruit@3.png', '夏日芒果 3个', 1, NULL, 1504783416, '[{"id":8,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@3.png","name":"\\u590f\\u65e5\\u8292\\u679c 3\\u4e2a","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, 'wx20170907192321b169e312470002719882'),
(25, 'A907834678426465', 2, NULL, 1504783467, '0.01', 1, 'http://api.c.cn/images/product-dryfruit@5.png', '万紫千凤梨 300克', 1, NULL, 1504783467, '[{"id":10,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@5.png","name":"\\u4e07\\u7d2b\\u5343\\u51e4\\u68a8 300\\u514b","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, 'wx20170907192412613554d40e0398310844'),
(26, 'A907835855531962', 2, NULL, 1504783585, '0.01', 1, 'http://api.c.cn/images/product-dryfruit@4.png', '冬木红枣 500克', 1, NULL, 1504783585, '[{"id":9,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@4.png","name":"\\u51ac\\u6728\\u7ea2\\u67a3 500\\u514b","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, 'wx20170907193608cebcc27ca00068443140'),
(27, 'A907840225255494', 2, NULL, 1504784022, '11.00', 1, 'http://api.c.cn/images/product-tea@1.png', '红袖枸杞 6克*3袋', 1, NULL, 1504784022, '[{"id":4,"haveStock":true,"counts":1,"price":"11.00","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-tea@1.png","name":"\\u7ea2\\u8896\\u67b8\\u675e 6\\u514b*3\\u888b","totalPrice":11}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, 'wx2017090719342953ae38da480442445333'),
(28, 'A907847056406472', 2, NULL, 1504784705, '0.01', 3, 'http://api.c.cn/images/product-cake@2.png', '小红的猪耳朵 120克', 1, NULL, 1505637632, '[{"id":6,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-cake@2.png","name":"\\u5c0f\\u7ea2\\u7684\\u732a\\u8033\\u6735 120\\u514b","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_name":"\\u987a\\u4e30","express_no":"jengnne24l2421m","express_price":null}', 'wx20170907194709e2d084503c0306863288'),
(29, 'A909552900385954', 2, NULL, 1504955290, '66.00', 1, 'https://image.onegledog.cn/product_b6c9e201709031930555321.jpg', 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', 1, NULL, 1504955290, '[{"id":43,"haveStock":true,"counts":1,"price":"66.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_b6c9e201709031930555321.jpg","name":"FCR \\u6302\\u8033\\u5496\\u5561\\u66fc\\u7279\\u5b81G1 \\u9ed1\\u5496\\u5561\\u6ee4\\u6ce1\\u5f0f\\u73b0\\u78e8\\u5496\\u5561\\u7c89\\u6302\\u8033\\u530510\\u5305\\u88c5","totalPrice":66}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, NULL),
(30, 'A909555534052885', 2, NULL, 1504955553, '0.01', 1, 'http://api.c.cn/images/product-vg@2.png', '泥蒿 半斤', 1, NULL, 1504955553, '[{"id":7,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-vg@2.png","name":"\\u6ce5\\u84bf \\u534a\\u65a4","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, NULL),
(31, 'A909561208214292', 2, NULL, 1504956120, '0.01', 1, 'http://api.c.cn/images/product-cake@2.png', '小红的猪耳朵 120克', 1, NULL, 1504956120, '[{"id":6,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-cake@2.png","name":"\\u5c0f\\u7ea2\\u7684\\u732a\\u8033\\u6735 120\\u514b","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', NULL, 'wx20170909202726966ba9ce2e0745575372'),
(32, 'A913051856986399', 2, NULL, 1505305185, '20.05', 1, 'http://api.c.cn/images/product-cake@2.png', '小红的猪耳朵 120克', 5, NULL, 1505305185, '[{"id":6,"haveStock":true,"counts":5,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-cake@2.png","name":"\\u5c0f\\u7ea2\\u7684\\u732a\\u8033\\u6735 120\\u514b","totalPrice":0.05}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_price":"20"}', 'wx201709132019423d5f42e38f0611746995'),
(33, 'A913056720063243', 2, NULL, 1505305672, '79.00', 1, 'https://image.onegledog.cn/product_e0f84201708082212362770.jpg', '食探咖啡', 1, NULL, 1505305672, '[{"id":39,"haveStock":true,"counts":1,"price":"39.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_e0f84201708082212362770.jpg","name":"\\u98df\\u63a2\\u5496\\u5561","totalPrice":39}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_price":"20"}', 'wx20170913202737759fb9a2a00660045689'),
(34, 'A9130576744540 5', 2, NULL, 1505305767, '79.00', 1, 'https://image.onegledog.cn/product_e0f84201708082212362770.jpg', '食探咖啡', 1, '59.00', 1505306828, '[{"id":39,"haveStock":true,"counts":1,"price":"39.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_e0f84201708082212362770.jpg","name":"\\u98df\\u63a2\\u5496\\u5561","totalPrice":39}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_price":"20"}', NULL),
(35, 'A913063049026865', 2, NULL, 1505306304, '20.01', 1, 'http://api.c.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, NULL, 1505306304, '[{"id":5,"haveStock":true,"counts":1,"price":"0.01","main_img_url":"http:\\/\\/api.c.cn\\/images\\/product-dryfruit@2.png","name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","totalPrice":0.01}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_price":"20"}', 'wx20170913204117a5449c3a4a0655291376'),
(36, 'A913073602082997', 2, NULL, 1505307360, '66.00', 3, 'https://image.onegledog.cn/product_b6c9e201709031930555321.jpg', 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', 1, '50.00', 1505307387, '[{"id":43,"haveStock":true,"counts":1,"price":"66.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_b6c9e201709031930555321.jpg","name":"FCR \\u6302\\u8033\\u5496\\u5561\\u66fc\\u7279\\u5b81G1 \\u9ed1\\u5496\\u5561\\u6ee4\\u6ce1\\u5f0f\\u73b0\\u78e8\\u5496\\u5561\\u7c89\\u6302\\u8033\\u530510\\u5305\\u88c5","totalPrice":66}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_price":"0","express_no":"ANEN224NN42K2444","name":"shunfeng"}', 'wx20170913205621b78a693ac80284099477'),
(37, 'A913093444990550', 2, NULL, 1505309344, '66.00', 2, 'https://image.onegledog.cn/product_b6c9e201709031930555321.jpg', 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', 1, NULL, 1505640997, '[{"id":43,"haveStock":true,"counts":1,"price":"66.00","main_img_url":"https:\\/\\/image.onegledog.cn\\/product_b6c9e201709031930555321.jpg","name":"FCR \\u6302\\u8033\\u5496\\u5561\\u66fc\\u7279\\u5b81G1 \\u9ed1\\u5496\\u5561\\u6ee4\\u6ce1\\u5f0f\\u73b0\\u78e8\\u5496\\u5561\\u7c89\\u6302\\u8033\\u530510\\u5305\\u88c5","totalPrice":66}]', '{"id":2,"name":"\\u5f20\\u4e09","mobile":"18888888888","province":"\\u5e7f\\u4e1c\\u7701","city":"\\u5e7f\\u5dde\\u5e02","country":null,"detail":"\\u67d0\\u5df7\\u67d0\\u53f7","delete_time":null,"user_id":2,"create_time":"2017-09-07 19:06:22","update_time":"2017-09-07 19:06:22"}', '{"express_name":"\\u987a\\u4e30","express_no":"enwlkngek2142fq124f","express_price":"0"}', 'wx20170913212931d4968f19840289347358');

-- --------------------------------------------------------

--
-- 表的结构 `order_log`
--

CREATE TABLE `order_log` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `type` enum('1') CHARACTER SET utf8 NOT NULL COMMENT '日志类型[1=>价格修改日志]',
  `log` varchar(250) CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `reason` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_log`
--

INSERT INTO `order_log` (`id`, `order_id`, `type`, `log`, `create_time`, `update_time`, `delete_time`, `reason`) VALUES
(1, 14, '1', '陈国哼于2017-08-13 15:35:57更改订单价格为：65', 1502609757, 1502609757, NULL, '商品升价'),
(2, 14, '1', '陈国哼于2017-08-13 15:37:57更改订单价格为：14', 1502609877, 1502609877, NULL, '包邮'),
(3, 14, '1', '陈国哼于2017-08-13 15:40:00更改订单价格为：25', 1502610000, 1502610000, NULL, '不包邮了'),
(4, 15, '1', '陈国哼于2017-08-26 16:05:28更改订单价格为：89', 1503734728, 1503734728, NULL, '价格修订'),
(5, 21, '1', '陈国哼于2017-08-26 16:11:37更改订单价格为：59', 1503735097, 1503735097, NULL, '不包邮'),
(6, 21, '1', '陈国哼于2017-08-26 16:14:02更改订单价格为：60', 1503735242, 1503735242, NULL, '凑整'),
(7, 23, '1', '陈国哼于2017-09-07 20:01:45更改订单价格为：44', 1504785705, 1504785705, NULL, '包邮'),
(8, 34, '1', '陈国哼于2017-09-13 20:47:08更改订单价格为：59元', 1505306828, 1505306828, NULL, '订单价格错误'),
(9, 36, '1', '陈国哼于2017-09-13 20:56:27更改订单价格为：50元', 1505307387, 1505307387, NULL, '八折');

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `count`, `delete_time`, `create_time`, `update_time`) VALUES
(1, 1, 1, NULL, 0, NULL),
(2, 1, 1, NULL, 0, NULL),
(3, 1, 3, NULL, 0, NULL),
(4, 1, 1, NULL, 0, NULL),
(5, 1, 1, NULL, 0, NULL),
(6, 1, 1, NULL, 0, NULL),
(7, 1, 3, NULL, 0, NULL),
(8, 1, 3, NULL, 0, NULL),
(9, 1, 3, NULL, 0, NULL),
(10, 1, 3, NULL, 0, NULL),
(20, 1, 1, NULL, 0, NULL),
(1, 2, 1, NULL, 0, NULL),
(2, 2, 1, NULL, 0, NULL),
(4, 2, 1, NULL, 0, NULL),
(5, 2, 1, NULL, 0, NULL),
(6, 2, 1, NULL, 0, NULL),
(11, 3, 1, NULL, 0, NULL),
(12, 3, 1, NULL, 0, NULL),
(13, 3, 1, NULL, 0, NULL),
(14, 3, 1, NULL, 0, NULL),
(15, 3, 1, NULL, 0, NULL),
(16, 3, 1, NULL, 0, NULL),
(17, 3, 1, NULL, 0, NULL),
(18, 3, 1, NULL, 0, NULL),
(19, 3, 1, NULL, 0, NULL),
(27, 4, 1, NULL, 1504784022, 1504784022),
(11, 5, 1, NULL, 0, NULL),
(12, 5, 1, NULL, 0, NULL),
(13, 5, 1, NULL, 0, NULL),
(14, 5, 1, NULL, 0, NULL),
(35, 5, 1, NULL, 1505306304, 1505306304),
(28, 6, 1, NULL, 1504784705, 1504784705),
(31, 6, 1, NULL, 1504956120, 1504956120),
(32, 6, 5, NULL, 1505305185, 1505305185),
(3, 7, 5, NULL, 0, NULL),
(30, 7, 1, NULL, 1504955553, 1504955553),
(24, 8, 1, NULL, 1504783416, 1504783416),
(26, 9, 1, NULL, 1504783585, 1504783585),
(25, 10, 1, NULL, 1504783467, 1504783467),
(33, 39, 1, NULL, 1505305672, 1505305672),
(34, 39, 1, NULL, 1505305767, 1505305767),
(23, 43, 1, NULL, 1504782442, 1504782442),
(29, 43, 1, NULL, 1504955290, 1504955290),
(36, 43, 1, NULL, 1505307360, 1505307360),
(37, 43, 1, NULL, 1505309344, 1505309344);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `price` decimal(6,2) NOT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `delete_time` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来自 1 本地 ，2公网',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL,
  `is_on` enum('1','0') DEFAULT '0' COMMENT '上下架，0下架，1上架',
  `summary` varchar(50) DEFAULT NULL COMMENT '摘要',
  `img_id` int(11) DEFAULT NULL COMMENT '图片外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stock`, `delete_time`, `category_id`, `main_img_url`, `from`, `create_time`, `update_time`, `is_on`, `summary`, `img_id`) VALUES
(1, '芹菜 半斤', '10.22', 982, 1501421481, 9, '/product-vg@1.png', 1, NULL, 1501421481, '1', NULL, 13),
(2, '梨花带雨 3个', '0.01', 982, 1501421497, 9, '/product-dryfruit@1.png', 1, NULL, 1501421497, '0', NULL, 10),
(3, '素米 327克', '56.00', 54, NULL, 0, '/product-rice@1.png', 1, NULL, 1502629373, '1', '素米嗯', 31),
(4, '红袖枸杞 6克*3袋', '11.00', 88, NULL, 6, '/product-tea@1.png', 1, NULL, 1502629403, '1', '枸杞', 32),
(5, '春生龙眼 500克', '0.01', 995, NULL, 9, '/product-dryfruit@2.png', 1, NULL, 1502629571, '1', '龙眼', 33),
(6, '小红的猪耳朵 120克', '0.01', 997, NULL, 5, '/product-cake@2.png', 1, NULL, 1501683764, '1', NULL, 53),
(7, '泥蒿 半斤', '0.01', 98, NULL, 9, '/product-vg@2.png', 1, NULL, 1502629075, '1', '这是泥嚎', 68),
(8, '夏日芒果 3个', '0.01', 995, NULL, 0, '/product-dryfruit@3.png', 1, NULL, 1501683764, '1', NULL, 36),
(9, '冬木红枣 500克', '0.01', 996, NULL, 0, '/product-dryfruit@4.png', 1, NULL, 1501683764, '1', NULL, 37),
(10, '万紫千凤梨 300克', '0.01', 996, NULL, 0, '/product-dryfruit@5.png', 1, NULL, 1501683764, '1', NULL, 38),
(11, '贵妃笑 100克', '33.00', 103, NULL, 0, '/product-dryfruit-a@6.png', 1, NULL, 1502628981, '1', '应该是红枣', 39),
(12, '珍奇异果 3个', '0.01', 999, NULL, 0, '/product-dryfruit@7.png', 1, NULL, 1501683764, '1', NULL, 40),
(13, '绿豆 125克', '0.01', 999, NULL, 7, '/product-rice@2.png', 1, NULL, 1501684681, '1', NULL, 41),
(14, '芝麻 50克', '0.01', 999, NULL, 7, '/product-rice@3.png', 1, NULL, 1501683938, '1', NULL, 42),
(15, '猴头菇 370克', '0.01', 999, NULL, 7, '/product-rice@4.png', 1, NULL, 1501684048, '1', NULL, 43),
(16, '西红柿 1斤', '0.01', 999, NULL, 0, '/product-vg@3.png', 1, NULL, 1501684048, '1', NULL, 69),
(17, '油炸花生 300克', '0.01', 999, NULL, 4, '/product-fry@1.png', 1, NULL, 1501683938, '1', NULL, 44),
(18, '春泥西瓜子 128克', '0.01', 997, NULL, 4, '/product-fry@2.png', 1, NULL, 1501684136, '1', NULL, 45),
(19, '碧水葵花籽 128克', '0.01', 999, NULL, 4, '/product-fry@3.png', 1, NULL, 1501683938, '1', NULL, 46),
(20, '碧螺春 12克*3袋', '0.01', 999, NULL, 6, '/product-tea@2.png', 1, NULL, 1501683938, '1', NULL, 47),
(21, '西湖龙井 8克*3袋', '0.01', 998, NULL, 6, '/product-tea@3.png', 1, NULL, 1501684678, '1', NULL, 48),
(22, '梅兰清花糕 1个', '0.01', 997, NULL, 5, '/product-cake-a@3.png', 1, NULL, 1501684678, '1', NULL, 54),
(23, '清凉薄荷糕 1个', '0.01', 998, NULL, 5, '/product-cake-a@4.png', 1, NULL, 1501684612, '1', NULL, 55),
(25, '小明的妙脆角 120克', '0.01', 993, NULL, 5, '/product-cake@1.png', 1, NULL, 1502115485, '1', NULL, 52),
(26, '红衣青瓜 混搭160克', '0.01', 999, NULL, 0, '/product-dryfruit@8.png', 1, NULL, 1501684612, '1', NULL, 56),
(27, '锈色瓜子 100克', '0.01', 998, NULL, 4, '/product-fry@4.png', 1, NULL, 1502115484, '1', NULL, 57),
(28, '春泥花生 200克', '0.01', 992, NULL, 4, '/product-fry@5.png', 1, NULL, 1502115498, '1', NULL, 58),
(29, '冰心鸡蛋 2个', '0.01', 999, NULL, 7, '/product-rice@5.png', 1, NULL, 1501684659, '1', NULL, 59),
(30, '八宝莲子 200克', '0.01', 999, 1502115128, 7, '/product-rice@6.png', 1, NULL, 1502115128, '0', NULL, 14),
(31, '深涧木耳 78克', '0.01', 999, 1502115115, 7, '/product-rice@7.png', 1, NULL, 1502115115, '0', NULL, 60),
(32, '土豆 半斤', '0.01', 999, NULL, 0, '/product-vg@4.png', 1, NULL, 1501684306, '1', NULL, 66),
(33, '青椒 半斤', '0.01', 999, NULL, 0, '/product-vg@5.png', 1, NULL, 1501684306, '1', NULL, 67),
(34, '咖啡', '45.00', 99, 1502114992, NULL, 'http://api.c.cn/images/product/20170807/bc7e80be0a055a047cc3e4bf2ecac5ef.jpg', 1, 1502113805, 1502114992, '0', '食探咖啡', 95),
(35, '咖啡', '45.00', 99, 1502114992, NULL, 'http://api.c.cn/images/product/20170807/22793294be5cb60bf9363be8e8bc69fe.jpg', 1, 1502114018, 1502114992, '0', '食探咖啡', 96),
(36, '咖啡', '45.00', 99, 1502114546, NULL, 'http://api.c.cn/images/product/20170807/ada9d7990ba3bb6c641563de923698cd.jpg', 1, 1502114103, 1502114546, '0', '食探咖啡', 97),
(37, '咖啡', '45.00', 108, 1502116156, 9, '/product/20170807/e661531f2dd83e3cc66b5e4d292eea24.jpg', 1, 1502114519, 1502116156, '1', '食探咖啡', 98),
(38, '食探咖啡', '45.00', 99, 1502201465, NULL, 'https://image.onegledog.cn/product-ba4b9201708082151356004.jpg', 2, 1502201296, 1502201465, '0', '自家制咖啡,欢迎品尝', 103),
(39, '食探咖啡', '39.00', 97, NULL, NULL, '/product_e0f84201708082212362770.jpg', 2, 1502201674, 1504434905, '1', '自家制咖啡,欢迎品尝', 104),
(40, '测试', '44.00', 55, 1502202079, NULL, '/product_0f25a201708082218547055.jpg', 2, 1502201956, 1502202079, '0', '测试', 105),
(41, '惊愕万分', '45.00', 66, 1502202084, NULL, '/product_ec705201708082220516461.jpg', 2, 1502202056, 1502202084, '0', '积分哇', 106),
(42, 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', '66.00', 100, 1504438319, NULL, '/product_b6c9e201709031930555321.jpg', 2, 1504438265, 1504438319, '0', '口感厚重浓郁，品尝时舌尖能感觉到明显的润滑和它特有的草药味。', 152),
(43, 'FCR 挂耳咖啡曼特宁G1 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', '66.00', 100, NULL, NULL, '/product_b6c9e201709031930555321.jpg', 2, 1504438279, 1504438416, '1', '口感厚重浓郁，品尝时舌尖能感觉到明显的润滑和它特有的草药味。', 152),
(44, 'FCR挂耳咖啡 巴拿马SHB 黑咖啡滤泡式现磨咖啡粉挂耳包10包', '55.00', 100, NULL, NULL, '/product_643bc201709031941458359.jpg', 2, 1504438918, 1504438918, '0', 'FCR挂耳咖啡 巴拿马SHB 黑咖啡滤泡式现磨咖啡粉挂耳包10包', 155),
(45, 'FCR挂耳咖啡 玻利维亚SHB黑咖啡滤泡式现磨咖啡粉挂耳包 10袋', '45.00', 100, NULL, NULL, '/product_ff9ad201709032050021214.jpg', 2, 1504443007, 1504443007, '0', 'FCR挂耳咖啡 玻利维亚SHB黑咖啡滤泡式现磨咖啡粉挂耳包 10袋', 157),
(46, 'FCR挂耳咖啡 肯尼亚AA+ 黑咖啡滤泡式现磨咖啡粉挂耳包10包', '70.00', 100, NULL, NULL, '/product_db4bc201709032051569592.jpg', 2, 1504443124, 1504443124, '0', 'FCR挂耳咖啡 肯尼亚AA+ 黑咖啡滤泡式现磨咖啡粉挂耳包10包', 158),
(47, 'FCR挂耳咖啡 卢旺达波旁黑咖啡滤泡式现磨咖啡粉挂耳包10包', '55.00', 100, NULL, NULL, '/product_8c6aa201709032052573301.jpg', 2, 1504443182, 1504443182, '0', 'FCR挂耳咖啡 卢旺达波旁黑咖啡滤泡式现磨咖啡粉挂耳包10包', 159),
(48, 'FCR挂耳咖啡 厦日微风意式黑咖啡滤泡式现磨咖啡粉挂耳包10包', '40.00', 100, NULL, NULL, '/product_46109201709032055537911.jpg', 2, 1504443355, 1504443355, '0', 'FCR挂耳咖啡 厦日微风意式黑咖啡滤泡式现磨咖啡粉挂耳包10包', 160),
(49, 'FCR挂耳咖啡 云南小粒黑咖啡滤泡式现磨咖啡粉挂耳包10包', '61.00', 100, NULL, NULL, '/product_ca6db201709032058353820.jpg', 2, 1504443517, 1504443517, '0', 'FCR挂耳咖啡 云南小粒黑咖啡滤泡式现磨咖啡粉挂耳包10包', 161),
(50, 'FCR挂耳咖啡巴西雨林 新鲜现磨滤泡式黑咖啡粉挂耳包 20袋', '80.00', 100, NULL, NULL, '/product_3de2d201709032100104761.jpg', 2, 1504443613, 1504443613, '0', 'FCR挂耳咖啡巴西雨林 新鲜现磨滤泡式黑咖啡粉挂耳包 20袋', 162),
(51, 'FCR挂耳咖啡哥伦比亚supremo 黑咖啡滤泡式现磨挂耳 10包', '67.00', 100, NULL, NULL, '/product_194ae201709032102246014.jpg', 2, 1504443747, 1504443747, '0', 'FCR挂耳咖啡哥伦比亚supremo 黑咖啡滤泡式现磨挂耳 10包', 163),
(52, 'FCR挂耳咖啡混搭组合10袋 新鲜烘焙黑咖啡现磨咖啡粉滤泡式挂耳包', '35.00', 100, NULL, NULL, '/product_e3206201709032104208540.jpg', 2, 1504443864, 1504443864, '0', 'FCR挂耳咖啡混搭组合10袋 新鲜烘焙黑咖啡现磨咖啡粉滤泡式挂耳包', 164),
(53, 'FCR挂耳咖啡曼特宁G1 现磨滤泡式黑咖啡粉挂耳包 20袋', '120.00', 100, NULL, NULL, '/product_b643020170903210550313.jpg', 2, 1504443957, 1504443957, '0', 'FCR挂耳咖啡曼特宁G1 现磨滤泡式黑咖啡粉挂耳包 20袋', 165),
(54, 'FCR挂耳咖啡摩卡 黑咖啡滤泡式现磨咖啡粉挂耳包 10袋', '40.00', 100, NULL, NULL, '/product_e892c201709032109251083.jpg', 2, 1504444168, 1505551499, '1', 'FCR挂耳咖啡摩卡 黑咖啡滤泡式现磨咖啡粉挂耳包 10袋', 166),
(55, 'FCR挂耳咖啡耶加雪菲G2 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', '33.00', 100, NULL, NULL, '/product_2a9b3201709032115581833.jpg', 2, 1504444571, 1505551499, '1', 'FCR挂耳咖啡耶加雪菲G2 黑咖啡滤泡式现磨咖啡粉挂耳包10包装', 167);

-- --------------------------------------------------------

--
-- 表的结构 `product_detail`
--

CREATE TABLE `product_detail` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `detail` text CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `product_detail`
--

INSERT INTO `product_detail` (`id`, `product_id`, `detail`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 39, '<p style="text-align:center;"></p>\n<p style="text-align:center;"><span style="font-size: 12px;">这是个食探咖啡</span></p>\n<p style="text-align:center;"><span style="font-size: 12px;">欢迎购买品尝</span></p>\n<p></p>\n<p></p>\n<img src="https://image.onegledog.cn/product_detail_62628201709132004594979.jpg?imageMogr2/thumbnail/375x/blur/1x0/quality/75|imageslim" alt="undefined" style="float:none;height: auto;width: auto"/>\n<p></p>\n<p style="text-align:center;"><span style="font-size: 12px;">噢！这太棒了！</span></p>\n<p style="text-align:center;"><span style="font-size: 12px;"> 食探出品必属精品</span></p>\n', 1503219326, 1505304308, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product_image`
--

INSERT INTO `product_image` (`id`, `img_id`, `delete_time`, `order`, `product_id`) VALUES
(4, 19, NULL, 1, 11),
(5, 20, NULL, 2, 11),
(6, 21, NULL, 3, 11),
(7, 22, NULL, 4, 11),
(8, 23, NULL, 5, 11),
(9, 24, NULL, 6, 11),
(10, 25, NULL, 7, 11),
(11, 26, NULL, 8, 11),
(12, 27, NULL, 9, 11),
(13, 28, NULL, 11, 11),
(14, 29, NULL, 10, 11),
(18, 62, NULL, 12, 11),
(19, 63, NULL, 13, 11);

-- --------------------------------------------------------

--
-- 表的结构 `product_property`
--

CREATE TABLE `product_property` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product_property`
--

INSERT INTO `product_property` (`id`, `name`, `detail`, `product_id`, `create_time`, `delete_time`, `update_time`) VALUES
(1, '品名', '杨梅', 11, 0, NULL, NULL),
(2, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, 0, NULL, NULL),
(3, '产地', '火星', 11, 0, NULL, NULL),
(4, '保质期', '180天', 11, 0, NULL, NULL),
(5, '品名', '梨子', 2, 0, NULL, NULL),
(6, '产地', '金星', 2, 0, NULL, NULL),
(7, '净含量', '100g', 2, 0, NULL, NULL),
(8, '保质期', '10天', 2, 0, NULL, NULL),
(23, '包装', '盒装', 39, 1505301709, NULL, 1505301709),
(24, '口味', '白咖啡 三合一', 39, 1505301709, NULL, 1505301709),
(25, '数量', '10包', 39, 1505301709, NULL, 1505301709);

-- --------------------------------------------------------

--
-- 表的结构 `product_sales`
--

CREATE TABLE `product_sales` (
  `product_id` int(11) NOT NULL,
  `sales` decimal(11,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `counts` int(11) UNSIGNED NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `product_sales`
--

INSERT INTO `product_sales` (`product_id`, `sales`, `counts`, `create_time`, `update_time`, `delete_time`) VALUES
(43, '33.30', 2, 1505641418, 1505641418, NULL),
(11, '14.14', 3, 1504141400, NULL, NULL),
(13, '6.70', 1, 1501200000, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `search_word`
--

CREATE TABLE `search_word` (
  `id` int(11) NOT NULL,
  `keyword` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT '搜索词',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '搜索次数',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `search_word`
--

INSERT INTO `search_word` (`id`, `keyword`, `count`, `update_time`, `create_time`, `delete_time`) VALUES
(1, '土豆', 2, NULL, 0, NULL),
(6, '米', 2, NULL, 0, NULL),
(3, '瓜', 4, NULL, 0, NULL),
(4, '红', 0, NULL, 0, NULL),
(5, '菜', 1, NULL, 0, NULL),
(7, '咖啡', 0, 1504956952, 1504956952, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '专题名称',
  `description` varchar(255) DEFAULT NULL COMMENT '专题描述',
  `topic_img_id` int(11) DEFAULT NULL COMMENT '主题图，外键',
  `delete_time` int(11) DEFAULT NULL,
  `head_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题信息表';

--
-- 转存表中的数据 `theme`
--

INSERT INTO `theme` (`id`, `name`, `description`, `topic_img_id`, `delete_time`, `head_img_id`, `create_time`, `update_time`) VALUES
(1, '专题栏位一', '美味水果世界', 16, 1505019840, 49, 0, 1505019840),
(2, '专题栏位二', '新品推荐', 17, 1505022685, 50, 0, 1505022685),
(3, '专题栏位三', '做个干物女', 18, 1505022685, 18, 0, 1505022685),
(4, '店长推荐', '店长精选咖啡推荐', NULL, NULL, 169, 1505022108, 1505022461);

-- --------------------------------------------------------

--
-- 表的结构 `theme_product`
--

CREATE TABLE `theme_product` (
  `theme_id` int(11) NOT NULL COMMENT '主题外键',
  `product_id` int(11) NOT NULL COMMENT '商品外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题所包含的商品';

--
-- 转存表中的数据 `theme_product`
--

INSERT INTO `theme_product` (`theme_id`, `product_id`) VALUES
(1, 2),
(1, 5),
(1, 8),
(1, 10),
(1, 12),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(2, 6),
(2, 16),
(2, 33),
(3, 15),
(3, 18),
(3, 19),
(3, 27),
(3, 30),
(3, 31),
(4, 43),
(4, 46),
(4, 47),
(4, 48),
(4, 52),
(4, 53),
(4, 54),
(4, 55);

-- --------------------------------------------------------

--
-- 表的结构 `third_app`
--

CREATE TABLE `third_app` (
  `id` int(11) NOT NULL,
  `app_id` varchar(64) NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) NOT NULL COMMENT '应用权限',
  `scope_description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问API的各应用账号密码表';

--
-- 转存表中的数据 `third_app`
--

INSERT INTO `third_app` (`id`, `app_id`, `app_secret`, `app_description`, `scope`, `scope_description`, `delete_time`, `update_time`) VALUES
(1, 'starcraft', '777*777', 'CMS', '32', 'Super', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `extend` varchar(255) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `openid`, `nickname`, `extend`, `delete_time`, `create_time`, `update_time`) VALUES
(1, 'ofbv90AR2oBpX6OqgIyJEvMk0SqU', '陈国珩', '{"gender":1,"language":"zh_CN","city":"Zhongshan","province":"Guangdong","country":"CN"}', NULL, NULL, 1500211631),
(2, 'oSlj_0Oki9ibUWUu24jZosxpmkrE', '陈国珩', '{"gender":1,"language":"zh_CN","city":"Zhongshan","province":"Guangdong","country":"China"}', NULL, 1504781866, 1504782185);

-- --------------------------------------------------------

--
-- 表的结构 `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user_address`
--

INSERT INTO `user_address` (`id`, `name`, `mobile`, `province`, `city`, `country`, `detail`, `delete_time`, `user_id`, `create_time`, `update_time`) VALUES
(1, '张三', '18888888888', '广东省', '广州市', '中山市', '某巷某号', NULL, 1, 0, NULL),
(2, '张三', '18888888888', '广东省', '广州市', NULL, '某巷某号', NULL, 2, 1504782382, 1504782382);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_name` (`user_name`) USING HASH;

--
-- Indexes for table `admin_profile`
--
ALTER TABLE `admin_profile`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_item`
--
ALTER TABLE `banner_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_no` (`order_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_log`
--
ALTER TABLE `order_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`) USING BTREE;

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`product_id`,`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_property`
--
ALTER TABLE `product_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `search_word`
--
ALTER TABLE `search_word`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_product`
--
ALTER TABLE `theme_product`
  ADD PRIMARY KEY (`theme_id`,`product_id`);

--
-- Indexes for table `third_app`
--
ALTER TABLE `third_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `openid` (`openid`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `banner_item`
--
ALTER TABLE `banner_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
--
-- 使用表AUTO_INCREMENT `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- 使用表AUTO_INCREMENT `order_log`
--
ALTER TABLE `order_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- 使用表AUTO_INCREMENT `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `product_property`
--
ALTER TABLE `product_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- 使用表AUTO_INCREMENT `search_word`
--
ALTER TABLE `search_word`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `third_app`
--
ALTER TABLE `third_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
