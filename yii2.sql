-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2022 at 03:13 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller_action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `name`, `controller_action`, `group`) VALUES
(1, 'Danh sách người dùng', 'User;Index', 'Người dùng'),
(2, 'Thêm người dùng', 'User;Create', 'Người dùng'),
(3, 'Cập nhật người dùng', 'User;Update', 'Người dùng'),
(4, 'Xóa người dùng', 'User;Delete', 'Người dùng'),
(5, 'Chi tiết người dùng', 'User;Detail', 'Người dùng'),
(6, 'Tải danh sách người dùng', 'User;Download', 'Người dùng'),
(7, 'Danh sách vai trò', 'Role;Index', 'Vai trò'),
(8, 'Thêm vai trò', 'Role;Create', 'Vai trò'),
(9, 'Cập nhật vai trò', 'Role;Update', 'Vai trò'),
(10, 'Xóa vai trò', 'Role;Delete', 'Vai trò'),
(11, 'Danh sách chức năng', 'Activity;Index', 'Chức năng'),
(12, 'Thêm chức năng', 'Activity;Create', 'Chức năng'),
(13, 'Cập nhật chức năng', 'Activity;Update', 'Chức năng'),
(14, 'Xóa chức năng', 'Chức năng', 'Chức năng'),
(15, 'Truy cập phân quyền', 'Permission;Index', 'Phân quyền'),
(16, 'Xem thông tin phân quyền', 'Permission;Load', 'Phân quyền'),
(17, 'Lưu phân quyền', 'Permission;Save', 'Phân quyền'),
(18, 'Danh sách loại sản phẩm', 'ProductType;Index', 'Loại sản phẩm'),
(19, 'Thêm loại sản phẩm', 'ProductType;Create', 'Loại sản phẩm'),
(20, 'Cập nhật loại sản phẩm', 'ProductType;Update', 'Loại sản phẩm'),
(21, 'Xóa loại sản phẩm', 'ProductType;Delete', 'Loại sản phẩm'),
(22, 'Danh sách từ khóa', 'Keyword;Index', 'Từ khóa'),
(23, 'Thêm từ khóa', 'Keyword;Create', 'Từ khóa'),
(24, 'Cập nhật từ khóa', 'Keyword;Update', 'Từ khóa'),
(25, 'Xóa từ khóa', 'Keyword;Delete', 'Từ khóa');

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE `keyword` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keyword`
--

INSERT INTO `keyword` (`id`, `name`, `slug`, `active`) VALUES
(1, 'Dành cho nữ', 'danh-cho-nu', 1),
(2, 'Dành cho nam', 'danh-cho-nam', 1),
(3, 'Đồng hồ', 'dong-ho', 1),
(4, 'Áo khoác', 'ao-khoac', 1),
(5, 'Áo phông', 'ao-phong', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1650343340),
('m220404_071818_create_user_table', 1650343341),
('m220404_083344_add_foreign_key_user', 1650343341),
('m220404_090242_create_role_table', 1650343341),
('m220404_092229_create_user_role_table', 1650343341),
('m220404_093017_create_note_table', 1650343341),
('m220412_035847_create_activity_table', 1650343341),
('m220412_040103_create_permission_table', 1650343342),
('m220418_093952_create_product_type_table', 1650343342),
('m220418_094250_create_keyword_table', 1650343342),
('m220418_094416_create_trademark_table', 1650343342),
('m220418_094516_create_slider_table', 1650343342),
('m220418_094623_create_slider_image_table', 1650343342),
('m220418_094902_create_product_table', 1650343342),
('m220418_095842_create_product_keyword_table', 1650343342),
('m220420_094549_create_product_image_table', 1650448237),
('m220421_020559_create_product_product_type_table', 1650507334);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effect_day` datetime DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(20,3) DEFAULT 0.000,
  `price` decimal(20,3) DEFAULT 0.000,
  `price_sale` decimal(20,3) DEFAULT 0.000,
  `exist_day` datetime DEFAULT NULL,
  `features` smallint(6) DEFAULT 0,
  `newest` smallint(6) DEFAULT 0,
  `sellest` smallint(6) DEFAULT 0,
  `trademark_id` int(11) DEFAULT NULL,
  `trademark_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `user_created_id` int(11) DEFAULT NULL,
  `user_created` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_updated_id` int(11) DEFAULT NULL,
  `user_updated` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `short_description`, `description`, `cost`, `price`, `price_sale`, `exist_day`, `features`, `newest`, `sellest`, `trademark_id`, `trademark_name`, `representation`, `class_type`, `active`, `user_created_id`, `user_created`, `user_updated_id`, `user_updated`) VALUES
(1, 'Áo phông cho nữ', 'Áo phông cho nữ', '<p>&Aacute;o ph&ocirc;ng cho nữ</p>\r\n', '120000.000', '150000.000', '140000.000', '2022-04-30 00:00:00', 1, 1, 0, 2, 'Chanel', '2022/04/21/0_ao-phong-cho-nu.jpg', 'ao-phong', 1, 1, 'admin', NULL, NULL),
(2, 'Áo sơ mi cho nữ', 'Áo sơ mi cho nữ', '<p>&Aacute;o sơ mi cho nữ</p>\r\n', '200000.000', '230000.000', '220000.000', '2022-04-30 00:00:00', 0, 1, 1, 1, 'Gucci', '2022/04/23/0_ao-so-mi-cho-nu.jpg', 'ao-so-mi', 1, 1, 'admin', NULL, NULL),
(3, 'Áo sơ mi nam', 'Áo sơ mi nam', '<p>&Aacute;o sơ mi nam</p>\r\n', '150000.000', '180000.000', '170000.000', '2022-04-01 00:00:00', 0, 0, 1, 1, 'Gucci', '2022/04/23/0_ao-so-mi-nam.jpg', 'ao-so-mi', 1, 1, 'admin', NULL, NULL),
(4, 'Áo khoác nữ', 'Áo khoác nữ', '<p>&Aacute;o kh&oacute;a nữ</p>\r\n', '500000.000', '650000.000', '640000.000', '2022-10-01 00:00:00', 0, 0, 0, 2, 'Chanel', '2022/04/23/0_ao-khoac-nu.jpg', '', 1, 1, 'admin', NULL, NULL),
(5, 'Concept ngày hè cho nữ', 'Concept ngày hè cho nữ', '<p>Concept ng&agrave;y h&egrave; cho nữ</p>\r\n', '500000.000', '980000.000', '950000.000', '2022-05-15 00:00:00', 0, 0, 0, 1, 'Gucci', '2022/04/23/0_concept-ngay-he-cho-nu.jpg', '', 1, 1, 'admin', NULL, NULL),
(6, 'Đồng hồ Omega', 'Đồng hồ Omega', '<p>Đồng hồ Omega</p>\r\n', '2500000.000', '3000000.000', '2999000.000', '2022-04-23 00:00:00', 1, 1, 0, NULL, NULL, '2022/04/23/0_dong-ho-omega.jpg', 'dong-ho', 1, 1, 'admin', NULL, NULL),
(7, 'Áo khoác ngang hông nữ', 'Áo khoác ngang hông nữ', '<p>&Aacute;o kho&aacute;c ngang h&ocirc;ng nữ</p>\r\n', '600000.000', '800000.000', '750000.000', '2022-04-25 00:00:00', 1, 0, 1, 2, 'Chanel', '2022/04/23/0_ao-khoac-ngang-hong-nu.jpg', '', 1, 1, 'admin', NULL, NULL),
(8, 'Áo phông nữ', 'Áo phông nữ', '<p>&Aacute;o ph&ocirc;ng nữ</p>\r\n', '200000.000', '350000.000', '320000.000', '2022-04-15 00:00:00', 1, 1, 0, 1, 'Gucci', '2022/04/23/0_ao-phong-nu.jpg', 'ao-phong', 1, 1, 'admin', NULL, NULL),
(9, 'Giày mới 2022', 'Giày mới 2022', '<p>Gi&agrave;y mới 2022</p>\r\n', '3500000.000', '4000000.000', '3900000.000', '2022-04-30 00:00:00', 1, 0, 0, 3, 'Adidas', '2022/04/23/0_giay-moi-2022.jpg', 'giay', 1, 1, 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `file`, `product_id`) VALUES
(1, '2022/04/21/0_ao-phong-cho-nu.jpg', 1),
(2, '2022/04/23/0_ao-so-mi-cho-nu.jpg', 2),
(3, '2022/04/23/0_ao-so-mi-nam.jpg', 3),
(4, '2022/04/23/0_ao-khoac-nu.jpg', 4),
(5, '2022/04/23/0_concept-ngay-he-cho-nu.jpg', 5),
(6, '2022/04/23/0_dong-ho-omega.jpg', 6),
(7, '2022/04/23/0_ao-khoac-ngang-hong-nu.jpg', 7),
(8, '2022/04/23/0_ao-phong-nu.jpg', 8),
(9, '2022/04/23/0_giay-moi-2022.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `product_keyword`
--

CREATE TABLE `product_keyword` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_keyword`
--

INSERT INTO `product_keyword` (`id`, `product_id`, `keyword_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 5, 1),
(5, 6, 3),
(6, 6, 2),
(7, 7, 1),
(8, 7, 4),
(9, 8, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_product_type`
--

CREATE TABLE `product_product_type` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_product_type`
--

INSERT INTO `product_product_type` (`id`, `product_id`, `product_type_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 6, 3),
(5, 8, 1),
(6, 9, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `name`, `slug`, `active`) VALUES
(1, 'Áo phông', 'ao-phong', 1),
(2, 'Áo sơ mi', 'ao-so-mi', 1),
(3, 'Đồng hồ', 'dong-ho', 1),
(4, 'Thắt lưng', 'that-lung', 1),
(5, 'Giày', 'giay', 1),
(6, 'Áo khoác', 'ao-khoac', 1),
(7, 'Áo croptop', 'ao-croptop', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `status`) VALUES
(1, 'Quản trị viên', 1),
(2, 'Quản lý', 1),
(3, 'Nhân viên', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `title`, `content`, `link`, `representation`) VALUES
(1, 'Giảm giá mùa hè', 'Giảm giá mùa hè', '#', '2022/04/19/0_giam-gia-mua-he.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `slider_image`
--

CREATE TABLE `slider_image` (
  `id` int(11) NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_image`
--

INSERT INTO `slider_image` (`id`, `file`, `slider_id`) VALUES
(1, '2022/04/19/0_giam-gia-mua-he.jpg', 1),
(2, '2022/04/19/1_giam-gia-mua-he.jpg', 1),
(3, '2022/04/19/2_giam-gia-mua-he.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trademark`
--

CREATE TABLE `trademark` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trademark`
--

INSERT INTO `trademark` (`id`, `name`, `slug`, `file`, `active`) VALUES
(1, 'Gucci', 'gucci', '2022/04/20/gucci.png', 1),
(2, 'Chanel', 'chanel', '2022/04/20/chanel.png', 1),
(3, 'Adidas', 'adidas', '2022/04/20/adidas.png', 1),
(4, '', '', 'no-image.jpeg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hash` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` smallint(6) DEFAULT 10,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `verification` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Thành viên','Khách hàng') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` int(11) DEFAULT NULL,
  `user_created` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_updated_id` int(11) DEFAULT NULL,
  `user_updated` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_deleted_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `name`, `phone`, `email`, `status`, `created_at`, `updated_at`, `deleted_at`, `verification`, `type`, `role`, `user_created_id`, `user_created`, `user_updated_id`, `user_updated`, `user_deleted_id`) VALUES
(1, 'admin', NULL, '$2y$13$fG4rmylQzbcVW8n8aOuLkeQrpg.sLUqeacOpjBXsWnJeUeQT6pT/6', NULL, 'Admin', '0123456789', 'admin@gmail.com', 10, '2022-04-19 07:14:45', NULL, NULL, NULL, 'Thành viên', 'Quản trị viên', NULL, NULL, NULL, NULL, NULL),
(2, 'code', NULL, '$2y$13$SHkWC2rp2DmcvE8bNJbgb.ZMn6yOjjBHDEz5ouz1DG0LbuFWg/rBS', NULL, 'Code', '0123456789', 'code@gmail.com', 10, '2022-04-19 07:17:15', NULL, NULL, NULL, NULL, 'Quản lý', 1, 'Admin', NULL, NULL, NULL),
(3, 'minato', NULL, '$2y$13$fqX/txR91jPpKle5B4Ol0uxVkqWXkLfvNE5f9uLYfQlGCHdanTJ5.', NULL, 'Thành', '0123456789', 'thanh@gmail.com', 10, '2022-04-19 07:17:35', NULL, NULL, NULL, NULL, 'Nhân viên', 1, 'Admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
(1, 2, 2),
(2, 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keyword`
--
ALTER TABLE `keyword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_user_id_fk` (`user_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_activity_id_fk` (`activity_id`),
  ADD KEY `permission_role_id_fk` (`role_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_trademark_id_fk` (`trademark_id`),
  ADD KEY `product_user_created_id` (`user_created_id`),
  ADD KEY `product_user_updated_id` (`user_updated_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image_product_id_fk` (`product_id`);

--
-- Indexes for table `product_keyword`
--
ALTER TABLE `product_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_keywork_product_id_fk` (`product_id`),
  ADD KEY `product_keywork_keyword_id_fk` (`keyword_id`);

--
-- Indexes for table `product_product_type`
--
ALTER TABLE `product_product_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_product_type_product_id_fk` (`product_id`),
  ADD KEY `product_product_type_product_type_id_fk` (`product_type_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_image`
--
ALTER TABLE `slider_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `picture_slider_slider_id_fk` (`slider_id`);

--
-- Indexes for table `trademark`
--
ALTER TABLE `trademark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_user_created_id_fk` (`user_created_id`),
  ADD KEY `user_user_updated_id_fk` (`user_updated_id`),
  ADD KEY `user_user_deleted_id_fk` (`user_deleted_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_user_id_fk` (`user_id`),
  ADD KEY `user_role_role_id_fk` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `keyword`
--
ALTER TABLE `keyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_keyword`
--
ALTER TABLE `product_keyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_product_type`
--
ALTER TABLE `product_product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider_image`
--
ALTER TABLE `slider_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trademark`
--
ALTER TABLE `trademark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_activity_id_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permission_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_trademark_id_fk` FOREIGN KEY (`trademark_id`) REFERENCES `trademark` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_user_created_id` FOREIGN KEY (`user_created_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_user_updated_id` FOREIGN KEY (`user_updated_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_keyword`
--
ALTER TABLE `product_keyword`
  ADD CONSTRAINT `product_keywork_keyword_id_fk` FOREIGN KEY (`keyword_id`) REFERENCES `keyword` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_keywork_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_product_type`
--
ALTER TABLE `product_product_type`
  ADD CONSTRAINT `product_product_type_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_product_type_product_type_id_fk` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `slider_image`
--
ALTER TABLE `slider_image`
  ADD CONSTRAINT `picture_slider_slider_id_fk` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_user_created_id_fk` FOREIGN KEY (`user_created_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_user_deleted_id_fk` FOREIGN KEY (`user_deleted_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_user_updated_id_fk` FOREIGN KEY (`user_updated_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_role_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;