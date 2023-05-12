-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 01:02 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET TIME_ZONE = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nienluancoso`
--

-- --------------------------------------------------------

--
-- Table structure for table `bangdt`
--

CREATE TABLE `BANGDT` (
  `ID` INT(11) NOT NULL,
  `PHUTRACH_ID` INT(11) NOT NULL,
  `DETAI_LOAIDETAI_ID` INT(11) NOT NULL,
  `HOC_KY` INT(11) NOT NULL,
  `NAM_HOC` INT(11) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `bangdt`
--

-- --------------------------------------------------------

--
-- Table structure for table `baocao`
--

CREATE TABLE `BAOCAO` (
  `ID` INT(11) NOT NULL,
  `DANGKY_DETAI_ID` INT(11) NOT NULL,
  `NGAY_BAO_CAO` DATE NOT NULL,
  `ND_THUC_HIEN` VARCHAR(255) NOT NULL,
  `ND_SAP_TOI` VARCHAR(255) NOT NULL,
  `THOI_HAN` DATE NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `baocao`
--



-- --------------------------------------------------------

--
-- Table structure for table `chuyennganh`
--

CREATE TABLE `CHUYENNGANH` (
  `ID` INT(11) NOT NULL,
  `TENCN` VARCHAR(255) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `chuyennganh`
--

INSERT INTO `CHUYENNGANH` (
  `ID`,
  `TENCN`
) VALUES (
  1,
  ''
),
 -- --------------------------------------------------------
 --
 -- Table structure for table `dangky_detai`
 --
 CREATE TABLE `DANGKY_DETAI` (
  `ID` INT(11) NOT NULL,
  `TAIKHOAN_ID` INT(11) NOT NULL,
  `BANGDT_ID` INT(11) NOT NULL,
  `TRANGTHAI_ID` INT(11) NOT NULL,
  `HOC_KY` INT(11) NOT NULL,
  `NAM_HOC` INT(11) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `dangky_detai`
--



-- --------------------------------------------------------

--
-- Table structure for table `detai`
--

CREATE TABLE `DETAI` (
  `ID` INT(11) NOT NULL,
  `TENDT` VARCHAR(255) NOT NULL,
  `MO_TADT` VARCHAR(255) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `detai`
--



-- --------------------------------------------------------

--
-- Table structure for table `detai_loaidetai`
--

CREATE TABLE `DETAI_LOAIDETAI` (
  `ID` INT(11) NOT NULL,
  `DETAI_ID` INT(11) NOT NULL,
  `LOAIDETAI_ID` INT(11) NOT NULL,
  `CHINHTHUC` INT(11) NOT NULL DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `detai_loaidetai`
--



-- --------------------------------------------------------

--
-- Table structure for table `gioitinh`
--

CREATE TABLE `GIOITINH` (
  `ID` INT(11) NOT NULL,
  `TENGT` VARCHAR(255) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `gioitinh`
--

INSERT INTO `GIOITINH` (
  `ID`,
  `TENGT`
) VALUES (
  1,
  ''
),
(
  2,
  'Nam'
),
(
  3,
  'Nữ'
);

-- --------------------------------------------------------

--
-- Table structure for table `loaidetai`
--

CREATE TABLE `LOAIDETAI` (
  `ID` INT(11) NOT NULL,
  `TEN_LOAI` VARCHAR(255) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `loaidetai`
--

INSERT INTO `LOAIDETAI` (
  `ID`,
  `TEN_LOAI`
) VALUES (
  3,
  'Niên luận cơ sở'
),
(
  4,
  'Niên luận ngành'
);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `TAIKHOAN` (
  `ID` INT(11) NOT NULL,
  `TENTK` VARCHAR(255) NOT NULL,
  `MAT_KHAU` VARCHAR(255) NOT NULL,
  `HO_TEN` VARCHAR(255) NOT NULL,
  `GIOITINH_ID` INT(11) NOT NULL,
  `MATK` VARCHAR(8) NOT NULL,
  `KHOA` INT(11) NOT NULL,
  `TRANG_THAITK` INT(11) NOT NULL,
  `CHUYENNGANH_ID` INT(11) NOT NULL,
  `VAI_TRO` INT(11) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `TAIKHOAN` (
  `ID`,
  `TENTK`,
  `MAT_KHAU`,
  `HO_TEN`,
  `GIOITINH_ID`,
  `MATK`,
  `KHOA`,
  `TRANG_THAITK`,
  `CHUYENNGANH_ID`,
  `VAI_TRO`
) VALUES (
  26,
  'admin',
  '21232f297a57a5a743894a0e4a801fc3',
  '',
  1,
  '',
  0,
  1,
  1,
  0
),
(
  27,
  'sv1',
  'c4ca4238a0b923820dcc509a6f75849b',
  'Trần Phước An',
  2,
  'B2007220',
  42,
  1,
  2,
  1
),
(
  28,
  'gv1',
  'c4ca4238a0b923820dcc509a6f75849b',
  'B',
  2,
  'G123',
  0,
  1,
  2,
  2
),
(
  29,
  'anb2007220@student.ctu.edu.vn',
  'fa5b479eb905ae84db6ba0229d44f7fa',
  'An',
  2,
  'B2007220',
  46,
  0,
  2,
  1
);

-- --------------------------------------------------------

--
-- Table structure for table `trangthai`
--

CREATE TABLE `TRANGTHAI` (
  `ID` INT(11) NOT NULL,
  `TEN_TRANG_THAI` VARCHAR(255) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `trangthai`
--

INSERT INTO `TRANGTHAI` (
  `ID`,
  `TEN_TRANG_THAI`
) VALUES (
  1,
  'Đề xuất'
),
(
  2,
  'Thực hiện'
),
(
  3,
  'Hoàn thành'
),
(
  4,
  'Chờ duyệt'
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bangdt`
--
ALTER TABLE `BANGDT` ADD PRIMARY KEY (`ID`), ADD KEY `BANGDT_IBFK_2` (`PHUTRACH_ID`), ADD KEY `DETAI_LOAIDETAI_ID` (`DETAI_LOAIDETAI_ID`);

--
-- Indexes for table `baocao`
--
ALTER TABLE `BAOCAO` ADD PRIMARY KEY (`ID`), ADD KEY `DANGKY_DETAI_ID` (`DANGKY_DETAI_ID`);

--
-- Indexes for table `chuyennganh`
--
ALTER TABLE `CHUYENNGANH` ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dangky_detai`
--
ALTER TABLE `DANGKY_DETAI` ADD PRIMARY KEY (`ID`), ADD KEY `DANGKY_DETAI_IBFK_1` (`TRANGTHAI_ID`), ADD KEY `TAIKHOAN_ID` (`TAIKHOAN_ID`), ADD KEY `BANGDT_ID` (`BANGDT_ID`);

--
-- Indexes for table `detai`
--
ALTER TABLE `DETAI` ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `detai_loaidetai`
--
ALTER TABLE `DETAI_LOAIDETAI` ADD PRIMARY KEY (`ID`), ADD KEY `DETAI_ID` (`DETAI_ID`), ADD KEY `DETAI_LOAIDETAI_IBFK_2` (`LOAIDETAI_ID`);

--
-- Indexes for table `gioitinh`
--
ALTER TABLE `GIOITINH` ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `loaidetai`
--
ALTER TABLE `LOAIDETAI` ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `TAIKHOAN` ADD PRIMARY KEY (`ID`), ADD KEY `TAIKHOAN_IBFK_2` (`CHUYENNGANH_ID`), ADD KEY `GIOITINH_ID` (`GIOITINH_ID`);

--
-- Indexes for table `trangthai`
--
ALTER TABLE `TRANGTHAI` ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bangdt`
--
ALTER TABLE `BANGDT` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `baocao`
--
ALTER TABLE `BAOCAO` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chuyennganh`
--
ALTER TABLE `CHUYENNGANH` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dangky_detai`
--
ALTER TABLE `DANGKY_DETAI` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detai`
--
ALTER TABLE `DETAI` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detai_loaidetai`
--
ALTER TABLE `DETAI_LOAIDETAI` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `gioitinh`
--
ALTER TABLE `GIOITINH` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loaidetai`
--
ALTER TABLE `LOAIDETAI` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `TAIKHOAN` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `trangthai`
--
ALTER TABLE `TRANGTHAI` MODIFY `ID` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bangdt`
--
ALTER TABLE `BANGDT` ADD CONSTRAINT `BANGDT_IBFK_2` FOREIGN KEY (`PHUTRACH_ID`) REFERENCES `TAIKHOAN` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `BANGDT_IBFK_3` FOREIGN KEY (`DETAI_LOAIDETAI_ID`) REFERENCES `DETAI_LOAIDETAI` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `baocao`
--
ALTER TABLE `BAOCAO` ADD CONSTRAINT `BAOCAO_IBFK_1` FOREIGN KEY (`DANGKY_DETAI_ID`) REFERENCES `DANGKY_DETAI` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dangky_detai`
--
ALTER TABLE `DANGKY_DETAI` ADD CONSTRAINT `DANGKY_DETAI_IBFK_1` FOREIGN KEY (`TRANGTHAI_ID`) REFERENCES `TRANGTHAI` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `DANGKY_DETAI_IBFK_2` FOREIGN KEY (`TAIKHOAN_ID`) REFERENCES `TAIKHOAN` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `DANGKY_DETAI_IBFK_3` FOREIGN KEY (`BANGDT_ID`) REFERENCES `BANGDT` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detai_loaidetai`
--
ALTER TABLE `DETAI_LOAIDETAI` ADD CONSTRAINT `DETAI_LOAIDETAI_IBFK_1` FOREIGN KEY (`DETAI_ID`) REFERENCES `DETAI` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `DETAI_LOAIDETAI_IBFK_2` FOREIGN KEY (`LOAIDETAI_ID`) REFERENCES `LOAIDETAI` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taikhoan`
--
ALTER TABLE `TAIKHOAN` ADD CONSTRAINT `TAIKHOAN_IBFK_2` FOREIGN KEY (`CHUYENNGANH_ID`) REFERENCES `CHUYENNGANH` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `TAIKHOAN_IBFK_3` FOREIGN KEY (`GIOITINH_ID`) REFERENCES `GIOITINH` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;