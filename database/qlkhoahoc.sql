-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: mysql
-- Thời gian đã tạo: Th10 23, 2023 lúc 06:43 AM
-- Phiên bản máy phục vụ: 8.0.33
-- Phiên bản PHP: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlkhoahoc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `role`) VALUES
('01', 'GV1', '12345', 'GV'),
('02', 'GV2', '12345', 'GV'),
('03', 'GV3', '12345', 'GV'),
('04', 'GV4', '12345', 'GV'),
('05', 'GV5', '12345', 'GV'),
('1000', 'HV1000', '12345', 'HV'),
('1001', 'HV1001', '12345', 'HV'),
('1002', 'HV1002', '12345', 'HV'),
('1003', 'HV1003', '12345', 'HV'),
('1004', 'HV1004', '12345', 'HV'),
('QL_01', 'QL1', '12345', 'QL'),
('QL_02', 'QL2', '12345', 'QL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `id_bill` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `date_bill` date NOT NULL,
  `id_hv` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_ql` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_class` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `total` double NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`id_bill`, `date_bill`, `id_hv`, `id_ql`, `id_class`, `total`, `paid`) VALUES
('BILL_03', '2023-11-04', '1002', 'QL_02', 'LOP_03', 3000000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class`
--

CREATE TABLE `class` (
  `id_class` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_gv` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_course` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `class`
--

INSERT INTO `class` (`id_class`, `name`, `id_gv`, `level`, `id_course`, `time_start`, `time_end`) VALUES
('LOP_01', 'LỚP A', '01', 'SINH VIÊN', 'CO_01', '18:00:00', '20:00:00'),
('LOP_02', 'LỚP B', '02', 'SINH VIÊN', 'CO_02', '18:00:00', '20:00:00'),
('LOP_03', 'LƠP C', '03', 'GIÁO VIÊN', 'CO_03', '18:00:00', '20:00:00'),
('LOP_04', 'LỚP D', '04', 'GIÁO VIÊN', 'CO_04', '18:00:00', '20:00:00'),
('LOP_05', 'LỚP E', '05', 'SINH VIÊN', 'CO_05', '18:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class_days`
--

CREATE TABLE `class_days` (
  `id_class` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `class_days`
--

INSERT INTO `class_days` (`id_class`, `date_start`, `date_end`) VALUES
('LOP_01', '2023-10-07', '2024-01-07'),
('LOP_02', '2023-11-01', '2024-02-01'),
('LOP_03', '2023-10-05', '2024-01-05'),
('LOP_04', '2023-09-07', '2024-12-07'),
('LOP_05', '2023-10-01', '2024-01-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class_students`
--

CREATE TABLE `class_students` (
  `stt` int NOT NULL,
  `id_class` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_hv` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `class_students`
--

INSERT INTO `class_students` (`stt`, `id_class`, `id_hv`) VALUES
(1, 'LOP_01', '1000'),
(2, 'LOP_02', '1001'),
(3, 'LOP_03', '1002'),
(4, 'LOP_04', '1003'),
(5, 'LOP_05', '1004');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint NOT NULL,
  `id_hv` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_gv` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `id_hv`, `id_gv`, `role`, `content`, `created_at`, `updated_at`) VALUES
(3, '1000', NULL, 'HV', 'đasadasdasdas', '2023-11-22 02:47:26', '2023-11-22 02:47:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course`
--

CREATE TABLE `course` (
  `id_course` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `course`
--

INSERT INTO `course` (`id_course`, `name`) VALUES
('CO_01', 'TIẾNG ANH'),
('CO_02', 'TOÁN'),
('CO_03', 'TOEIC'),
('CO_04', 'HÓA'),
('CO_05', 'LÝ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lecturer`
--

CREATE TABLE `lecturer` (
  `id_gv` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `gender` text COLLATE utf8mb4_general_ci NOT NULL,
  `date _of_birth` date NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lecturer`
--

INSERT INTO `lecturer` (`id_gv`, `name`, `gender`, `date _of_birth`, `phone`, `address`, `email`, `level`) VALUES
('01', 'TRẦN TÚ NGÂN', 'NỮ', '2002-11-20', '0876098590', '56 NGUYỄN THỊ MINH KHAI Q3 TPHCM', 'tranngan@gmail.com', 'SINH VIÊN'),
('02', 'LÊ THỊ THU TRANG', 'NỮ', '2003-11-22', '0876098598', '78 BÀ HƠM Q6 TPHCM', 'lethithutrang@gmail.com', 'SINH VIÊN'),
('03', 'NGUYỄN ĐỨC NGHĨA', 'NAM', '1995-11-26', '0876098523', '41/4 CALMETTE Q1 TPHCM', 'nguyenducnghia@gmail.com', 'GIÁO VIÊN'),
('04', 'NGUYỄN THỊ TÂM', 'NỮ', '1998-11-05', '0347012390', '163/30 Thành Thái F.14 Q.10 TPHCM', 'nguyenthitam@gmail.com', 'GIÁO VIÊN'),
('05', 'NGUYỄN ĐỨC MINH', 'NAM', '2001-11-03', '0912345687', '178 NAM KỲ KHỞI NGHĨA Q4 TPHCM', 'mnguyenducminh@gmail.com', 'SINH VIÊN');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manager`
--

CREATE TABLE `manager` (
  `id_ql` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `gender` text COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `manager`
--

INSERT INTO `manager` (`id_ql`, `name`, `gender`, `phone`, `email`) VALUES
('QL_01', 'LÊ VĂN ĐỨC', 'NAM', '0156729487', 'levanduc@gmail.com'),
('QL_02', 'LÊ THỊ NGỌC', 'NỮ', '0283774785', 'lethingoc@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint NOT NULL,
  `id_bill` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reply`
--

CREATE TABLE `reply` (
  `id` int NOT NULL,
  `comment_id` bigint NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_ql` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reply`
--

INSERT INTO `reply` (`id`, `comment_id`, `content`, `id_ql`, `created_at`, `updated_at`) VALUES
(4, 3, 'Phản hồi 1', 'QL_01', '2023-11-22 06:04:59', '2023-11-22 06:04:59'),
(5, 3, 'phản hồi 2', NULL, '2023-11-22 06:06:15', '2023-11-22 06:06:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student`
--

CREATE TABLE `student` (
  `id_hv` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `gender` text COLLATE utf8mb4_general_ci NOT NULL,
  `date _of_birth` date NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student`
--

INSERT INTO `student` (`id_hv`, `name`, `gender`, `date _of_birth`, `phone`, `address`, `email`, `level`) VALUES
('1000', 'ĐỖ TÔ THẢO DUYÊN', 'NỮ', '2002-03-09', '0912345123', '123 TÂN HÒA ĐÔNG Q6 TPHCM', 'dotothaoduyen@gmail.com', 'ĐẠI HỌC'),
('1001', 'TRẦN Ý NHI', 'NỮ', '2013-11-14', '0876456523', '23 NGUYỄN VĂN LINH Q7 TPHCM', 'tranynhi@gmail.com', 'CẤP 1'),
('1002', 'NGUYỄN THỊ THU HÀ', 'NỮ', '2002-11-14', '0123456789', '34 TÔN ĐỨC THẮNG Q1 TPHCM', 'thuha@gmail.com', 'ĐẠI HỌC'),
('1003', 'LÊ MINH HIẾU', 'NAM', '2006-11-01', '0362856730', '189 ĐỖ XUÂN HỢP Q9 TPHCM', 'leminhhieu@gmail.com', 'CẤP 3'),
('1004', 'TẠ LÊ ANH', 'NỮ', '2010-11-30', '0919057345', '98 NGUYỄN THIỆN THUẬT Q3 TPHCM', 'leanhta@gmail.com', 'CẤP 2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_level`
--

CREATE TABLE `teacher_level` (
  `level` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `price_level` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `teacher_level`
--

INSERT INTO `teacher_level` (`level`, `price_level`) VALUES
('GIÁO VIÊN', 3000000),
('SINH VIÊN', 2000000);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id_bill`),
  ADD KEY `fk_bill_student` (`id_hv`),
  ADD KEY `fk_bill_manager` (`id_ql`);

--
-- Chỉ mục cho bảng `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `fk_class_lecturer` (`id_gv`),
  ADD KEY `fk_class_course` (`id_course`);

--
-- Chỉ mục cho bảng `class_days`
--
ALTER TABLE `class_days`
  ADD PRIMARY KEY (`id_class`);

--
-- Chỉ mục cho bảng `class_students`
--
ALTER TABLE `class_students`
  ADD PRIMARY KEY (`stt`),
  ADD KEY `fk_class_students_student` (`id_class`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_id_hv` (`id_hv`),
  ADD KEY `fk_foreign_id_gv` (`id_gv`);

--
-- Chỉ mục cho bảng `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`);

--
-- Chỉ mục cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`id_gv`),
  ADD KEY `fk_lecturer_teacher_level` (`level`);

--
-- Chỉ mục cho bảng `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id_ql`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_bill` (`id_bill`) USING BTREE;

--
-- Chỉ mục cho bảng `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_comment_id` (`comment_id`),
  ADD KEY `fk_foreign_manager_id` (`id_ql`);

--
-- Chỉ mục cho bảng `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id_hv`);

--
-- Chỉ mục cho bảng `teacher_level`
--
ALTER TABLE `teacher_level`
  ADD PRIMARY KEY (`level`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `class_students`
--
ALTER TABLE `class_students`
  MODIFY `stt` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `reply`
--
ALTER TABLE `reply`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_bill_manager` FOREIGN KEY (`id_ql`) REFERENCES `manager` (`id_ql`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bill_student` FOREIGN KEY (`id_hv`) REFERENCES `student` (`id_hv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `fk_class_class_days` FOREIGN KEY (`id_class`) REFERENCES `class_days` (`id_class`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_class_course` FOREIGN KEY (`id_course`) REFERENCES `course` (`id_course`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_class_lecturer` FOREIGN KEY (`id_gv`) REFERENCES `lecturer` (`id_gv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `class_students`
--
ALTER TABLE `class_students`
  ADD CONSTRAINT `fk_class_students_student` FOREIGN KEY (`id_class`) REFERENCES `class` (`id_class`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_foreign_id_gv` FOREIGN KEY (`id_gv`) REFERENCES `lecturer` (`id_gv`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_foreign_id_hv` FOREIGN KEY (`id_hv`) REFERENCES `student` (`id_hv`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `fk_lecturer_teacher_level` FOREIGN KEY (`level`) REFERENCES `teacher_level` (`level`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_pyament_bill` FOREIGN KEY (`id_bill`) REFERENCES `bill` (`id_bill`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `fk_foreign_comment_id` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `fk_foreign_manager_id` FOREIGN KEY (`id_ql`) REFERENCES `manager` (`id_ql`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
