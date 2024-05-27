-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-05-27 00:55:02
-- 服务器版本： 5.7.44-log
-- PHP 版本： 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `hct-ds`
--

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image_path`, `price`) VALUES
(29, '华为HUAWEI MatePad Pro', '13.2吋144Hz OLED柔性屏星闪连接 办公创作平板电脑12+256GB WiFi 雅川青', 'image/huawei.avif', '4749.00'),
(28, '小米充气宝2', '小米米家 数字胎压检测 小米汽车su7 预设压力充到即停 ', 'image/688667f8dbae6d38.jpg.avif', '179.00'),
(30, 'LiberLiveC1 融合伴奏吉他', '无弦吉他自动挡弹唱一人乐队 LiberLive 石墨灰 官方标配', 'image/jita.avif', '2249.00'),
(31, '小米14', ' 徕卡影像 旗舰手机 澎湃OS闪充电竞骁龙轻薄小屏 雪山粉 12GB+256GB【官方标配】', 'image/ximi14.avif', '3699.00'),
(32, '小牛（XIAONIU）', '【到店自提】小牛电动 G3C 都市版 长续航 电动两轮轻便摩托车', 'image/xn.avif', '3999.00'),
(33, 'Apple/苹果 Watch Ultra 2代', ' 智能手表正品保障苹果手表ultra1全国联保 午夜色  海洋表带 iWatch Ultra 1', 'image/a[[.avif', '4069.00');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'a', 'a'),
(2, 'aa', 'a'),
(3, 'aaa', 'a'),
(4, 'zz', 'zz'),
(5, '1', 'a');

--
-- 转储表的索引
--

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
