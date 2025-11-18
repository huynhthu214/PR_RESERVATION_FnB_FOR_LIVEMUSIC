-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 18, 2025 lúc 09:48 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `admindb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `events`
--

CREATE TABLE `events` (
  `EVENT_ID` varchar(10) NOT NULL,
  `ADMIN_ID` varchar(10) DEFAULT NULL,
  `VENUE_ID` varchar(10) DEFAULT NULL,
  `BAND_NAME` text DEFAULT NULL,
  `EVENT_DATE` datetime DEFAULT NULL,
  `START_TIME` datetime DEFAULT NULL,
  `TICKET_PRICE` float DEFAULT NULL,
  `STATUS` text DEFAULT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `END_TIME` datetime DEFAULT NULL,
  `IMAGE_URL` text DEFAULT NULL,
  `ARTIST_NAME` text DEFAULT NULL,
  `IMG_ARTIST` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `events`
--

INSERT INTO `events` (`EVENT_ID`, `ADMIN_ID`, `VENUE_ID`, `BAND_NAME`, `EVENT_DATE`, `START_TIME`, `TICKET_PRICE`, `STATUS`, `DESCRIPTION`, `END_TIME`, `IMAGE_URL`, `ARTIST_NAME`, `IMG_ARTIST`) VALUES
('E001', 'AD001', 'V001', 'The Chill Band', '2025-11-01 20:00:00', '2025-11-01 20:00:00', 350000, 'ACTIVE', 'Đêm acoustic thư giãn cuối tuần.', '2025-11-01 23:00:00', 'https://plus.unsplash.com/premium_photo-1682125232467-8fcf48869840?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bXVzaWMlMjBwb3N0ZXJ8ZW58MHx8MHx8fDA%3D', 'Nguyễn Văn A', 'https://images.unsplash.com/photo-1558730234-d8b2281b0d00?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
('E002', 'AD002', 'V002', 'Rock N Fire', '2025-11-10 19:30:00', '2025-11-10 19:30:00', 400000, 'ACTIVE', 'Đêm nhạc rock nồng nhiệt.', '2025-11-10 22:30:00', 'https://plus.unsplash.com/premium_photo-1682125472704-ae4c0109747a?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bXVzaWMlMjBldmVudCUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Trần Thị B', 'https://plus.unsplash.com/premium_photo-1690407617542-2f210cf20d7e?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
('E003', 'AD003', 'V003', 'Jazz in Sunset', '2025-12-05 19:00:00', '2025-12-05 19:00:00', 300000, 'ACTIVE', 'Không gian jazz chill buổi tối.', '2025-12-05 22:00:00', 'https://plus.unsplash.com/premium_photo-1759802355541-291479cd920e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bXVzaWMlMjBldmVudCUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Lê Minh C', 'https://images.pexels.com/photos/379962/pexels-photo-379962.jpeg'),
('E004', 'AD001', 'V004', 'Rooftop EDM Night', '2025-11-15 21:00:00', '2025-11-15 21:00:00', 500000, 'ACTIVE', 'EDM party trên sân thượng.', '2025-11-16 01:00:00', 'https://images.unsplash.com/photo-1672847900914-3fbd4fa39037?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fG11c2ljJTIwZXZlbnQlMjBwb3N0ZXJ8ZW58MHx8MHx8fDA%3D', 'Phạm Thùy D', 'https://images.pexels.com/photos/3388899/pexels-photo-3388899.jpeg'),
('E005', 'AD002', 'V005', 'Indie Music Fest', '2025-11-20 18:00:00', '2025-11-20 18:00:00', 250000, 'ACTIVE', 'Lễ hội nhạc Indie.', '2025-11-20 23:00:00', 'https://images.unsplash.com/photo-1556166647-f94afa32529d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGxpdmUlMjBtdXNpYyUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Ngô Văn E', 'https://images.pexels.com/photos/28934189/pexels-photo-28934189.jpeg'),
('E006', 'AD003', 'V006', 'Ladies Night DJ', '2025-11-22 20:30:00', '2025-11-22 20:30:00', 150000, 'ACTIVE', 'Miễn phí vào cửa cho nữ.', '2025-11-23 00:30:00', 'https://images.unsplash.com/photo-1679130707518-bc6561f0a7b1?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fGxpdmUlMjBtdXNpYyUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Đặng Thị F', 'https://images.unsplash.com/photo-1499952127939-9bbf5af6c51c?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fHBlcnNvbnxlbnwwfHwwfHx8MA%3D%3D'),
('E007', 'AD001', 'V007', 'Flamenco Dance', '2025-11-25 19:00:00', '2025-11-25 19:00:00', 300000, 'ACTIVE', 'Đêm nhạc Tây Ban Nha.', '2025-11-25 22:00:00', 'https://images.unsplash.com/photo-1561497248-6857fa337c31?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fGxpdmUlMjBtdXNpYyUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Hoàng Văn G', 'https://plus.unsplash.com/premium_photo-1671656349322-41de944d259b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHBlcnNvbnxlbnwwfHwwfHx8MA%3D%3D'),
('E008', 'AD002', 'V008', 'Acoustic Yoko', '2025-11-28 20:00:00', '2025-11-28 20:00:00', 200000, 'ACTIVE', 'Đêm nhạc mộc tại Yoko.', '2025-11-28 22:30:00', 'https://images.unsplash.com/photo-1520366103608-36a0cc873a36?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fGxpdmUlMjBtdXNpYyUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Yoko Trần', 'https://images.pexels.com/photos/1864641/pexels-photo-1864641.jpeg'),
('E009', 'AD003', 'V009', 'Classical Concert', '2025-12-10 19:00:00', '2025-12-10 19:00:00', 800000, 'ACTIVE', 'Hòa nhạc giao hưởng.', '2025-12-10 21:30:00', 'https://images.unsplash.com/photo-1651775730715-18dc21713071?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzZ8fGxpdmUlMjBtdXNpYyUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Nguyễn Minh H', 'https://images.pexels.com/photos/32114183/pexels-photo-32114183.jpeg'),
('E010', 'AD001', 'V010', 'Hip Hop Party', '2025-12-15 21:00:00', '2025-12-15 21:00:00', 450000, 'ACTIVE', 'Tiệc Hip Hop cuồng nhiệt.', '2025-12-16 01:00:00', 'https://images.unsplash.com/photo-1649463509404-53778015f9f4?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NDl8fGxpdmUlMjBtdXNpYyUyMHBvc3RlcnxlbnwwfHwwfHx8MA%3D%3D', 'Lê Thị I', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8cGVyc29ufGVufDB8fDB8fHww');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EVENT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
