-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 16 Avril 2015 à 09:21
-- Version du serveur: 5.1.41
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `giao_hang`
--

-- --------------------------------------------------------

--
-- Structure de la table `don_hang`
--

CREATE TABLE IF NOT EXISTS `don_hang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int(11) NOT NULL,
  `id_giao_nhan` int(11) DEFAULT '0',
  `hinh_thuc_giao_hang` int(11) NOT NULL,
  `dia_chi_giao_hang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dia_chi_lay_hang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ten_nguoi_nhan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dien_thoai_nguoi_nhan` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email_nguoi_nhan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tong_tien` double NOT NULL DEFAULT '0',
  `cod` double NOT NULL DEFAULT '0',
  `is_cod` int(11) NOT NULL DEFAULT '0',
  `is_free` int(11) NOT NULL DEFAULT '0',
  `is_bao_hiem` int(11) NOT NULL DEFAULT '0',
  `is_de_vo` int(11) NOT NULL DEFAULT '0',
  `trang_thai_don_hang` int(11) DEFAULT '0',
  `phi_giao_hang` double NOT NULL,
  `khu_vuc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quan_huyen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_tao` int(11) NOT NULL,
  `ngay_duyet` int(11) DEFAULT '0',
  `ghi_chu` text COLLATE utf8_unicode_ci NOT NULL,
  `khoi_luong` int(11) NOT NULL,
  `ten_hang_hoa` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `so_luong` int(11) NOT NULL,
  `mo_ta` text COLLATE utf8_unicode_ci NOT NULL,
  `thoi_gian_du_kien` int(1) DEFAULT '0',
  `xoa` int(11) NOT NULL DEFAULT '0',
  `ly_do` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `don_hang`
--

INSERT INTO `don_hang` (`id`, `id_khach_hang`, `id_giao_nhan`, `hinh_thuc_giao_hang`, `dia_chi_giao_hang`, `dia_chi_lay_hang`, `ten_nguoi_nhan`, `dien_thoai_nguoi_nhan`, `email_nguoi_nhan`, `tong_tien`, `cod`, `is_cod`, `is_free`, `is_bao_hiem`, `is_de_vo`, `trang_thai_don_hang`, `phi_giao_hang`, `khu_vuc`, `quan_huyen`, `ngay_tao`, `ngay_duyet`, `ghi_chu`, `khoi_luong`, `ten_hang_hoa`, `so_luong`, `mo_ta`, `thoi_gian_du_kien`, `xoa`, `ly_do`) VALUES
(1, 1, 11, 1, '200 cach mang thang tam, quan 10', '2b bo bao tan thang, tan phu', '', '', '', 1000000, 1000000, 0, 0, 0, 0, 1, 50000, '2', '', 1428434445, 0, 'giao hang trong 1 tuan', 15, 'bep Gas', 0, 'Bep Gas am Hong Ngoai', 0, 1, ''),
(2, 7, 11, 0, '131 ba huyen thanh quan, quan 3', 'kcn tan tao', '', '', '', 2340000, 0, 0, 0, 0, 0, 0, 50000, '2', '', 1428435095, 0, 'giao hang trong 3 ngay', 12, 'May xay thit', 0, 'May Xay thit 1903', 0, 1, ''),
(3, 22, 3, 0, 'cau nguyen tri phuong', 'duong so 3, ly gia', '', '', '', 1500000, 1500000, 0, 0, 0, 0, 0, 30000, '2', '', 1428435095, 0, 'giao hang trong 24 gio', 25, 'bep Gas', 0, 'Bep Gas am mat kinh', 0, 0, ''),
(4, 22, 21, 1, '323 pham van bach, tan binh', '989 pham van bach, tan binh', '', '', '', 12000000, 0, 0, 0, 0, 0, 0, 60000, '2', '', 1428435355, 0, '', 15, 'Bep gas am mat kinh cao cap', 0, 'Bep gas am Taka', 0, 0, ''),
(5, 22, 18, 1, '23 phan chau trinh quan 5', 'tran van du, tan binh', '', '', '', 8000000, 8000000, 0, 0, 0, 0, 0, 60000, '2', '', 1428435378, 0, '', 15, 'Bep dien tu tanaka', 0, 'Bep dien tu tanaka', 0, 0, ''),
(6, 0, 0, 0, '5/3 nguyen phuc chu', 'abc', 'hoa', '01645142745', 'huongthien1993@gmail.com', 600000, 600000, 1, 1, 0, 0, 0, 0, 'HCM', 'Tan Binh', 1429121214, 0, 'giao hang thu tien tan nha', 0, '', 0, 'nokia moi tinh', 0, 0, ''),
(7, 0, 0, 0, '1 nguyến phúc chu', 'Xuyên Mộc, Bà Rịa Vũng Tàu VIet Nam', 'Nguyễn Thiên Hướng', '0914503745', 'huonthien93@gmail.com', 7900000, 7900000, 1, 1, 1, 0, 0, 0, 'HCM', 'Tan Binh', 1429122183, 0, 'Giao hang thu tien tan nha, cho xem hang truoc khi nhan', 1400, 'Nokia 1020', 1, 'Hàng brandnew 100%', 0, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `loai_nghanh`
--

CREATE TABLE IF NOT EXISTS `loai_nghanh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_nghanh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `loai_nghanh`
--

INSERT INTO `loai_nghanh` (`id`, `ten_nghanh`) VALUES
(1, 'Điện Máy'),
(2, 'Mỹ Phẩm'),
(3, 'Quần Áo');

-- --------------------------------------------------------

--
-- Structure de la table `loai_thanh_vien`
--

CREATE TABLE IF NOT EXISTS `loai_thanh_vien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_loai` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `loai_thanh_vien`
--

INSERT INTO `loai_thanh_vien` (`id`, `ten_loai`) VALUES
(2, 'Thành Viên Vàng'),
(3, 'Thành Viên Bạc'),
(4, 'Thành Viên Đồng');

-- --------------------------------------------------------

--
-- Structure de la table `loai_user`
--

CREATE TABLE IF NOT EXISTS `loai_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_loai` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `loai_user`
--

INSERT INTO `loai_user` (`id`, `ten_loai`) VALUES
(1, 'Khách hàng'),
(2, 'Nhân viên giao hàng'),
(3, 'Quản trị');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dia_chi` text COLLATE utf8_unicode_ci NOT NULL,
  `dien_thoai` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lan_dang_nhap_cuoi` int(11) DEFAULT '0',
  `hoat_dong_cuoi` int(11) DEFAULT '0',
  `xac_nhan` int(11) DEFAULT '0',
  `xoa` int(11) DEFAULT '0',
  `ngay_tao` int(11) NOT NULL,
  `loai_user` int(11) NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nghanh_kinh_doanh` int(11) NOT NULL DEFAULT '0',
  `dia_chi_kho_hang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `khu_vuc` int(11) NOT NULL,
  `ma_kich_hoat` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_kich_hoat` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `ten`, `password`, `dia_chi`, `dien_thoai`, `email`, `lan_dang_nhap_cuoi`, `hoat_dong_cuoi`, `xac_nhan`, `xoa`, `ngay_tao`, `loai_user`, `website`, `nghanh_kinh_doanh`, `dia_chi_kho_hang`, `khu_vuc`, `ma_kich_hoat`, `ngay_kich_hoat`) VALUES
(1, 'Huong Thien', 'e10adc3949ba59abbe56e057f20f883e', 'Tan Binh, Ho Chi Minh', '0914502745', 'huongthien93@yahoo.com', 0, 0, 0, 0, 1427936276, 1, 'nhomsinhvien.com', 1, 'Go Vap, Ho Chi Minh', 1, '', 0),
(4, 'hoang long truong', '32250170a0dca92d53ec9624f336ca24', '5/3 nguyen phuc chu, tan binh', '0912324242', 'hoang_long9xx@gmail.com', 0, 0, 0, 0, 1428431735, 1, 'chotot.vn', 1, 'Tan Binh, Ho Chi Minh', 3, '', 0),
(3, 'nguyen hoai lam', 'pass321', '222 quang trung, go vap', '0998998899', 'hoailam9x@gmail.com', 0, 0, 0, 0, 1428431394, 2, '', 0, '', 2, '', 0),
(6, 'Administrator', '202cb962ac59075b964b07152d234b70', '230 pham the hien, quan 8', '0923456789', 'admin@ghn.com', 0, 0, 0, 0, 1428432017, 3, '', 0, '', 3, '', 0),
(7, 'Tran Thi Anh Vy', 'e10adc3949ba59abbe56e057f20f883e', '200 ton dan, quan 4, ho chi minh', '01222645567', 'anhvy_tran@gmail.com', 0, 0, 0, 0, 1428432316, 1, 'mp3.zing.vn', 0, 'Tan Phu, Ho Chi Minh', 2, '', 0),
(8, 'Ly Tieu Long', '21232f297a57a5a743894a0e4a801fc3', '121 Nguyen Tat Thanh', '0989656412', 'tieulong_ly@gmail.com', 0, 0, 0, 0, 1428432949, 3, '', 0, '', 2, '', 0),
(9, 'Tieu Muc Linh Dong', 'e10adc3949ba59abbe56e057f20f883e', '200/7b Chau Thanh, Ben Tre', '0908743443', 'dong_tieutieu@gmail.com', 0, 0, 0, 0, 1428432949, 1, 'muahangnhanh.vn', 0, 'Binh Tan, Ho Chi Minh', 2, '', 0),
(10, 'Nguyen Van Dau Dua', 'e10adc3949ba59abbe56e057f20f883e', '41 diuong so 2, cat lai, quan 2, ho chi minh', '097565555', 'daudua_nguyen989@gmail.com', 0, 0, 0, 0, 1428432949, 1, 'tuoitre.vn', 0, 'Phu Nhuan, Ho Chi Minh', 1, '', 0),
(11, 'Nguyen Hoang Tuan Anh', 'e10adc3949ba59abbe56e057f20f883e', '211 nguyen van troi, phu nhuan, ho chi minh', '0965556789', 'tuananh_hoang98@gmail.com', 0, 0, 0, 0, 1428432949, 2, '', 0, '', 3, '', 0),
(12, 'Nguyen Thi Lan Anh', 'e10adc3949ba59abbe56e057f20f883e', '800 pham van bach, tan binh, ho chi minh', '0987992752', 'lananh_nguyen@gmail.com', 0, 0, 0, 0, 1428432949, 2, '', 0, '', 2, '', 0),
(22, 'Nguyen Minh Anh', 'e10adc3949ba59abbe56e057f20f883e', '224 au co, tan phu, ho chi minh', '0906566464', 'Anh_nguyen233@gmail.com', 0, 0, 0, 0, 1428433693, 1, '0', 0, 'an lac, Ho Chi Minh', 2, '', 0),
(21, 'Nguyen Minh Hoang', 'e10adc3949ba59abbe56e057f20f883e', '120 Le Van Sy, tan binh, ho chi minh', '0945555666', 'Hoang_banche@gmail.com', 0, 0, 0, 0, 1428433693, 2, '', 0, '', 2, '', 0),
(19, 'Nguyen Minh Hoang', 'e10adc3949ba59abbe56e057f20f883e', '120 Le Van Sy, tan binh, ho chi minh', '0945555666', 'Hoang_banche@gmail.com', 0, 0, 0, 0, 1428433625, 2, '', 0, '', 2, '', 0),
(18, 'Nguyen Minh Tri', 'e10adc3949ba59abbe56e057f20f883e', '122/7 cong lo, tan binh, ho chi minh', '0902434344', 'minhtri_codon@gmail.com', 0, 0, 0, 0, 1428433164, 2, '', 0, '', 2, '', 0),
(28, 'Hong Hoa', 'e10adc3949ba59abbe56e057f20f883e', 'HCM, VN', '01677731910', 'huongthien1993@gmail.com', 0, 0, 0, 0, 1429129688, 0, '', 0, '', 0, 'e204053', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
