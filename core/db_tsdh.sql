-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 02, 2024 lúc 03:42 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_tsdh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_majors`
--

CREATE TABLE `tb_majors` (
  `id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `score` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_students`
--

CREATE TABLE `tb_students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `citizenId` varchar(255) NOT NULL,
  `transcript` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_wishes`
--

CREATE TABLE `tb_wishes` (
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `majorId` varchar(20) NOT NULL,
  `pass` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tb_majors`
--
ALTER TABLE `tb_majors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_students`
--
ALTER TABLE `tb_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Chỉ mục cho bảng `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `tb_wishes`
--
ALTER TABLE `tb_wishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `majorId` (`majorId`),
  ADD KEY `tb_wishes_ibfk_1` (`studentId`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tb_students`
--
ALTER TABLE `tb_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tb_wishes`
--
ALTER TABLE `tb_wishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tb_students`
--
ALTER TABLE `tb_students`
  ADD CONSTRAINT `tb_students_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tb_wishes`
--
ALTER TABLE `tb_wishes`
  ADD CONSTRAINT `tb_wishes_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `tb_students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_wishes_ibfk_2` FOREIGN KEY (`majorId`) REFERENCES `tb_majors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
