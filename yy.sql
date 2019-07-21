-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2019-07-20 10:57:59
-- 服务器版本： 5.7.24
-- PHP 版本： 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `yy`
--

-- --------------------------------------------------------

--
-- 表的结构 `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `options`
--

INSERT INTO `options` (`option_id`, `option_name`, `option_value`) VALUES
(1, 'cat', '{\"a\":\"动画\",\"b\":\"漫画\",\"c\":\"游戏\",\"d\":\"小说\",\"e\":\"原创\",\"f\":\"来自网络\",\"g\":\"其他\"}');

-- --------------------------------------------------------

--
-- 表的结构 `sentence`
--

DROP TABLE IF EXISTS `sentence`;
CREATE TABLE IF NOT EXISTS `sentence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `content` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '句子内容',
  `userid` bigint(20) NOT NULL COMMENT '句子所属用户的id',
  `cat` char(1) DEFAULT 'g',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `sentence`
--

INSERT INTO `sentence` (`id`, `content`, `userid`, `cat`) VALUES
(24, '第七个句子', 5, 'g'),
(21, '第四个句子', 5, 'g'),
(20, '第三个句子', 5, 'g'),
(19, '第二个句子', 5, 'g'),
(17, '呐，知道么，樱花飘落的速度，是每秒五厘米哦~', 3, 'g'),
(18, '第一个句子', 5, 'g'),
(25, '第八个句子', 5, 'g'),
(26, '第九个句子', 5, 'g'),
(27, '第十个句子', 5, 'g'),
(28, '第十一个句子', 5, 'g'),
(29, '第十二个句子', 5, 'g'),
(30, '第十三个句子', 5, 'g'),
(31, '第十四个句子', 5, 'g'),
(32, '第十五个句子', 5, 'g'),
(33, '第十六个句子', 5, 'g'),
(34, '第十七个句子', 5, 'g'),
(35, '第十八个句子', 5, 'g'),
(36, '第十九个句子', 5, 'g'),
(37, '第二十个句子', 5, 'g'),
(38, '第二十一个句子', 5, 'g'),
(39, '第二十二个句子', 5, 'g'),
(42, '句子', 5, 'a'),
(43, '分类A', 5, 'a'),
(44, '11111111111', 5, 'a'),
(45, '呐，知道么，樱花飘落的速度，是每秒五厘米哦.', 5, 'a'),
(46, '呐，知道么，樱花飘落的速度，是每秒五厘米哦.', 5, 'a');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(5, 'admin', '123456');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
