-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: db
-- 生成日時: 2021 年 12 月 29 日 21:57
-- サーバのバージョン： 5.5.62
-- PHP のバージョン: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `pollApp`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'コメントID',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `agree` int(1) NOT NULL COMMENT '賛否（賛成:1, 反対:0）',
  `body` varchar(100) DEFAULT NULL COMMENT '本文',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1:削除、0:有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'pollapp' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `topic_id`, `agree`, `body`, `user_id`, `del_flg`, `updated_by`, `updated_at`) VALUES
(1, 1, 0, 'いいえ遅いです。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(2, 1, 1, '亀はウサギよりも早いと思います。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(3, 1, 1, '早いですね。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(4, 1, 1, 'いや遅いですね。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(5, 2, 0, 'いいえ。そんなことないと思います。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(6, 2, 1, 'はい。そうでしょうね。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(7, 3, 1, 'はい。そうですね。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(8, 3, 1, 'うん、そう思います。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(9, 3, 0, 'そうですかね？', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(10, 4, 1, 'たまには当たるのでは？？', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(11, 4, 0, '多分、当たらないですよ。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(12, 4, 0, 'あなたの思い込みでは。。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(13, 4, 1, 'はい。当たります。', 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(14, 4, 1, '一生に一回くらいは当たると思います。', 'test', 0, 'pollapp', '2021-12-15 12:18:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'トピックID',
  `title` varchar(30) NOT NULL COMMENT 'トピック本文',
  `published` int(1) NOT NULL COMMENT '公開状態(1:公開、0:非公開)',
  `views` int(10) NOT NULL DEFAULT '0' COMMENT 'PV数',
  `likes` int(10) NOT NULL DEFAULT '0' COMMENT '賛成数',
  `dislikes` int(10) NOT NULL DEFAULT '0' COMMENT '反対数',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1:削除、0:有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'pollapp' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `topics`
--

INSERT INTO `topics` (`id`, `title`, `published`, `views`, `likes`, `dislikes`, `user_id`, `del_flg`, `updated_by`, `updated_at`) VALUES
(1, '亀はウサギよりも早いですか？', 1, 8, 3, 1, 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(2, 'スーパーサイヤ人は最強ですか？', 1, 9, 1, 1, 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(3, 'たこ焼きっておいしいですよね。', 1, 21, 2, 1, 'test', 0, 'pollapp', '2021-12-15 12:18:55'),
(4, '犬も歩けば棒に当たりますか？', 1, 25, 3, 2, 'test', 0, 'pollapp', '2021-12-15 12:18:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `pwd` varchar(60) NOT NULL COMMENT 'パスワード',
  `nickname` varchar(10) NOT NULL COMMENT '画面表示用名',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1:削除、0:有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'pollapp' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `pwd`, `nickname`, `del_flg`, `updated_by`, `updated_at`) VALUES
('c', '$2y$10$q3hYRXvEcz770Yeup7F/BuXAABtlDFRUe7F0OKshDY1U8GNnf4qXO', 'c', 0, 'pollapp', '2021-12-21 13:29:54'),
('test', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー', 0, 'pollapp', '2021-12-15 12:18:55');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'コメントID', AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'トピックID', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
