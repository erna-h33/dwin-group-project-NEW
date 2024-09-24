-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 10:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estate`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `state_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`) VALUES
(1, 'Sydney', 1),
(2, 'Wollongong', 1),
(3, 'Melbourne', 2),
(4, 'Canberra', 4),
(5, 'Perth', 5);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Australia'),
(2, 'Indonesia'),
(3, 'Singapore'),
(4, 'New Zealand'),
(5, 'Korea'),
(6, 'Japan'),
(7, 'Antartica');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `property_id`, `user_id`, `message`, `response`, `created_at`) VALUES
(1, 1, 3, 'Hello is this still available?', 'Yes', '2024-09-21 07:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `content`) VALUES
(1, 'about_us', 'Test 123'),
(2, 'contact_us', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `property_type_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `status` enum('available','sold','rented') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `description`, `price`, `property_type_id`, `country_id`, `state_id`, `city_id`, `owner_id`, `status`, `created_at`) VALUES
(1, '338 Beamish Street', 'Apartment with 2 bedrooms brand new!', 800000.00, 4, 1, 1, 1, 2, 'available', '2024-09-21 07:01:55'),
(2, '1 Kings Lane', 'Multi Million Apartment', 99999999.99, 4, 1, 1, 1, 6, 'available', '2024-09-21 08:18:59'),
(3, '1 Pitt Street', 'Home Sweet Home', 123.00, 5, 1, 1, 1, 6, 'available', '2024-09-21 08:19:23'),
(4, '101 Elm Street', 'Beautiful apartment with modern amenities.', 450000.00, 4, 1, 1, 1, 2, 'available', '2024-09-21 08:25:07'),
(5, '202 Oak Avenue', 'Cozy family home with a large garden.', 520000.00, 5, 1, 1, 1, 6, 'available', '2024-09-21 08:25:07'),
(6, '303 Maple Drive', 'Spacious home with 4 bedrooms and a pool.', 720000.00, 5, 1, 1, 1, 2, 'available', '2024-09-21 08:25:07'),
(7, '404 Pine Crescent', 'Modern apartment with stunning views.', 650000.00, 4, 1, 1, 1, 6, 'available', '2024-09-21 08:25:07'),
(8, '505 Cedar Lane', 'Luxurious villa with a private pool and garden.', 1200000.00, 5, 1, 1, 1, 2, 'available', '2024-09-21 08:25:07'),
(9, '606 Birch Road', 'Charming townhouse in a quiet neighborhood.', 350000.00, 4, 1, 1, 1, 6, 'available', '2024-09-21 08:25:07'),
(10, '707 Spruce Way', 'Affordable apartment in the city center.', 300000.00, 4, 1, 1, 1, 2, 'available', '2024-09-21 08:25:07'),
(11, '808 Redwood Street', 'Spacious apartment with modern design.', 500000.00, 4, 1, 1, 1, 6, 'available', '2024-09-21 08:25:07'),
(12, '909 Willow Avenue', 'Family home with 3 bedrooms and a garden.', 580000.00, 5, 1, 1, 1, 2, 'available', '2024-09-21 08:25:07'),
(13, '1010 Cypress Court', 'Luxury penthouse with rooftop views.', 980000.00, 4, 1, 1, 1, 6, 'available', '2024-09-21 08:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `propertytypes`
--

CREATE TABLE `propertytypes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `propertytypes`
--

INSERT INTO `propertytypes` (`id`, `name`) VALUES
(1, 'Duplex'),
(3, 'House'),
(4, 'Apartment'),
(5, 'Mansion'),
(6, 'Retail'),
(7, 'Granny Flat'),
(8, 'Land'),
(9, '2-bedroom Apartment ');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`) VALUES
(1, 'NSW', 1),
(2, 'VIC', 1),
(3, 'QLD', 1),
(4, 'ACT', 1),
(5, 'WA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','owner','customer','agent') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@gmail.com', 'Admin100!', 'admin', '2024-09-13 01:09:27'),
(2, 'Property Owner', 'owner@gmail.com', 'Owner100!', 'owner', '2024-09-13 01:09:27'),
(3, 'Customer User', 'customer@gmail.com', 'Customer100!', 'customer', '2024-09-13 01:09:27'),
(4, 'Samia', 'samia@gmail.com', 'Agent100!', 'agent', '2024-09-13 02:28:51'),
(5, 'Admin User1', 'admin1@gmail.com', 'Admin100!', 'admin', '2024-09-21 08:11:06'),
(6, 'Property Owner1', 'owner1@gmail.com', 'Owner100!', 'owner', '2024-09-21 08:11:06'),
(7, 'Customer User1', 'customer1@gmail.com', 'Customer100!', 'customer', '2024-09-21 08:11:06'),
(8, 'Samia1', 'samia1@gmail.com', 'Agent100!', 'agent', '2024-09-21 08:11:06'),
(9, 'Admin User2', 'admin2@gmail.com', 'Admin100!', 'admin', '2024-09-21 08:11:06'),
(10, 'Property Owner2', 'owner2@gmail.com', 'Owner100!', 'owner', '2024-09-21 08:11:06'),
(11, 'Customer User2', 'customer2@gmail.com', 'Customer100!', 'customer', '2024-09-21 08:11:06'),
(12, 'Samia2', 'samia2@gmail.com', 'Agent100!', 'agent', '2024-09-21 08:11:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_name` (`page_name`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_type_id` (`property_type_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `propertytypes`
--
ALTER TABLE `propertytypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `propertytypes`
--
ALTER TABLE `propertytypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD CONSTRAINT `enquiries_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `enquiries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`property_type_id`) REFERENCES `propertytypes` (`id`),
  ADD CONSTRAINT `properties_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `properties_ibfk_3` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `properties_ibfk_4` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `properties_ibfk_5` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
