-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 16, 2023 lúc 06:20 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nienluancoso`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bangdt`
--

CREATE TABLE `bangdt` (
  `ID` int(11) NOT NULL,
  `phutrach_ID` int(11) NOT NULL,
  `detai_loaidetai_ID` int(11) NOT NULL,
  `hoc_ky` int(11) NOT NULL,
  `nam_hoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bangdt`
--

INSERT INTO `bangdt` (`ID`, `phutrach_ID`, `detai_loaidetai_ID`, `hoc_ky`, `nam_hoc`) VALUES
(4, 28, 44, 2, 2023),
(5, 28, 45, 2, 2023),
(6, 28, 46, 2, 2023),
(7, 28, 47, 2, 2023),
(8, 28, 48, 2, 2023),
(9, 28, 49, 2, 2023);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocao`
--

CREATE TABLE `baocao` (
  `ID` int(11) NOT NULL,
  `dangky_detai_ID` int(11) NOT NULL,
  `ngay_bao_cao` date NOT NULL,
  `nd_thuc_hien` varchar(255) NOT NULL,
  `nd_sap_toi` varchar(255) NOT NULL,
  `thoi_han` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `baocao`
--

INSERT INTO `baocao` (`ID`, `dangky_detai_ID`, `ngay_bao_cao`, `nd_thuc_hien`, `nd_sap_toi`, `thoi_han`) VALUES
(1, 4, '2023-05-11', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis, aspernatur. Esse, minus quo magnam reiciendis saepe molestiae optio ex exercitationem possimus quas nobis maxime eos. Dolor natus est recusandae rerum?', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis, aspernatur. Esse, minus quo magnam reiciendis saepe molestiae optio ex exercitationem possimus quas nobis maxime eos. Dolor natus est recusandae rerum?', '2023-05-25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyennganh`
--

CREATE TABLE `chuyennganh` (
  `ID` int(11) NOT NULL,
  `tenCN` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chuyennganh`
--

INSERT INTO `chuyennganh` (`ID`, `tenCN`) VALUES
(1, ''),
(2, 'CNTT'),
(3, 'Khoa học máy tính');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky_detai`
--

CREATE TABLE `dangky_detai` (
  `ID` int(11) NOT NULL,
  `taikhoan_ID` int(11) NOT NULL,
  `bangdt_ID` int(11) NOT NULL,
  `trangthai_ID` int(11) NOT NULL,
  `hoc_ky` int(11) NOT NULL,
  `nam_hoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dangky_detai`
--

INSERT INTO `dangky_detai` (`ID`, `taikhoan_ID`, `bangdt_ID`, `trangthai_ID`, `hoc_ky`, `nam_hoc`) VALUES
(4, 27, 4, 2, 2, 2023);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detai`
--

CREATE TABLE `detai` (
  `ID` int(11) NOT NULL,
  `tenDT` varchar(255) NOT NULL,
  `mo_taDT` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `detai`
--

INSERT INTO `detai` (`ID`, `tenDT`, `mo_taDT`) VALUES
(6, 'Phân tích thiết kế hệ thống thông tin sử dụng biểu đồ UML', 'https://viblo.asia/p/phan-tich-thiet-ke-he-thong-thong-tin-su-dung-bieu-do-uml-phan-2-0bDM6wpAG2X4'),
(7, 'Watch \"Project Management Tutorial  ( Complete Course )\" on YouTube', 'https://github.com/dappuniversity/eth-todo-list'),
(8, 'Phần mềm chơi loto', ''),
(9, 'Quản lý thông báo học bổng', ''),
(10, 'Quản lý khách hàng thân thiết', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detai_loaidetai`
--

CREATE TABLE `detai_loaidetai` (
  `ID` int(11) NOT NULL,
  `detai_ID` int(11) NOT NULL,
  `loaidetai_ID` int(11) NOT NULL,
  `chinhthuc` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `detai_loaidetai`
--

INSERT INTO `detai_loaidetai` (`ID`, `detai_ID`, `loaidetai_ID`, `chinhthuc`) VALUES
(44, 6, 3, 1),
(45, 7, 3, 0),
(46, 8, 4, 1),
(47, 9, 3, 1),
(48, 10, 3, 1),
(49, 10, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gioitinh`
--

CREATE TABLE `gioitinh` (
  `ID` int(11) NOT NULL,
  `tenGT` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `gioitinh`
--

INSERT INTO `gioitinh` (`ID`, `tenGT`) VALUES
(1, ''),
(2, 'Nam'),
(3, 'Nữ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaidetai`
--

CREATE TABLE `loaidetai` (
  `ID` int(11) NOT NULL,
  `ten_loai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaidetai`
--

INSERT INTO `loaidetai` (`ID`, `ten_loai`) VALUES
(3, 'Niên luận cơ sở'),
(4, 'Niên luận ngành');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `ID` int(11) NOT NULL,
  `tenTK` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `gioitinh_ID` int(11) NOT NULL,
  `maTK` varchar(8) NOT NULL,
  `khoa` int(11) NOT NULL,
  `trang_thaiTK` int(11) NOT NULL,
  `chuyennganh_ID` int(11) NOT NULL,
  `vai_tro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`ID`, `tenTK`, `mat_khau`, `ho_ten`, `gioitinh_ID`, `maTK`, `khoa`, `trang_thaiTK`, `chuyennganh_ID`, `vai_tro`) VALUES
(26, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 1, '', 0, 1, 1, 0),
(27, 'sv1', 'c4ca4238a0b923820dcc509a6f75849b', 'Trần Phước An', 2, 'B2007220', 42, 1, 2, 1),
(28, 'gv1', 'c4ca4238a0b923820dcc509a6f75849b', 'B', 2, 'G123', 0, 1, 2, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai`
--

CREATE TABLE `trangthai` (
  `ID` int(11) NOT NULL,
  `ten_trang_thai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthai`
--

INSERT INTO `trangthai` (`ID`, `ten_trang_thai`) VALUES
(1, 'Đề xuất'),
(2, 'Thực hiện'),
(3, 'Hoàn thành'),
(4, 'Chờ duyệt');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bangdt`
--
ALTER TABLE `bangdt`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `bangdt_ibfk_2` (`phutrach_ID`),
  ADD KEY `detai_loaidetai_ID` (`detai_loaidetai_ID`);

--
-- Chỉ mục cho bảng `baocao`
--
ALTER TABLE `baocao`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `dangky_detai_ID` (`dangky_detai_ID`);

--
-- Chỉ mục cho bảng `chuyennganh`
--
ALTER TABLE `chuyennganh`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `dangky_detai`
--
ALTER TABLE `dangky_detai`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `dangky_detai_ibfk_1` (`trangthai_ID`),
  ADD KEY `taikhoan_ID` (`taikhoan_ID`),
  ADD KEY `bangdt_ID` (`bangdt_ID`);

--
-- Chỉ mục cho bảng `detai`
--
ALTER TABLE `detai`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `detai_loaidetai`
--
ALTER TABLE `detai_loaidetai`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `detai_ID` (`detai_ID`),
  ADD KEY `detai_loaidetai_ibfk_2` (`loaidetai_ID`);

--
-- Chỉ mục cho bảng `gioitinh`
--
ALTER TABLE `gioitinh`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `loaidetai`
--
ALTER TABLE `loaidetai`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `taikhoan_ibfk_2` (`chuyennganh_ID`),
  ADD KEY `gioitinh_ID` (`gioitinh_ID`);

--
-- Chỉ mục cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bangdt`
--
ALTER TABLE `bangdt`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `baocao`
--
ALTER TABLE `baocao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `chuyennganh`
--
ALTER TABLE `chuyennganh`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `dangky_detai`
--
ALTER TABLE `dangky_detai`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `detai`
--
ALTER TABLE `detai`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `detai_loaidetai`
--
ALTER TABLE `detai_loaidetai`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `gioitinh`
--
ALTER TABLE `gioitinh`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `loaidetai`
--
ALTER TABLE `loaidetai`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bangdt`
--
ALTER TABLE `bangdt`
  ADD CONSTRAINT `bangdt_ibfk_2` FOREIGN KEY (`phutrach_ID`) REFERENCES `taikhoan` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bangdt_ibfk_3` FOREIGN KEY (`detai_loaidetai_ID`) REFERENCES `detai_loaidetai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `baocao`
--
ALTER TABLE `baocao`
  ADD CONSTRAINT `baocao_ibfk_1` FOREIGN KEY (`dangky_detai_ID`) REFERENCES `dangky_detai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dangky_detai`
--
ALTER TABLE `dangky_detai`
  ADD CONSTRAINT `dangky_detai_ibfk_1` FOREIGN KEY (`trangthai_ID`) REFERENCES `trangthai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dangky_detai_ibfk_2` FOREIGN KEY (`taikhoan_ID`) REFERENCES `taikhoan` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dangky_detai_ibfk_3` FOREIGN KEY (`bangdt_ID`) REFERENCES `bangdt` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `detai_loaidetai`
--
ALTER TABLE `detai_loaidetai`
  ADD CONSTRAINT `detai_loaidetai_ibfk_1` FOREIGN KEY (`detai_ID`) REFERENCES `detai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detai_loaidetai_ibfk_2` FOREIGN KEY (`loaidetai_ID`) REFERENCES `loaidetai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_ibfk_2` FOREIGN KEY (`chuyennganh_ID`) REFERENCES `chuyennganh` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taikhoan_ibfk_3` FOREIGN KEY (`gioitinh_ID`) REFERENCES `gioitinh` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
