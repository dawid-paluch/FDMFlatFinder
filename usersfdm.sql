-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 03:46 AM
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
-- Database: `usersfdm`
--

-- --------------------------------------------------------

--
-- Table structure for table `fdm_users`
--

CREATE TABLE `fdm_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('consultant','landlord') NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `pref_location` varchar(255) DEFAULT NULL,
  `pref_postcode` varchar(20) DEFAULT NULL,
  `pref_maxprice` decimal(10,2) DEFAULT NULL,
  `pref_bedrooms` tinyint(3) DEFAULT NULL,
  `pref_bathrooms` tinyint(3) DEFAULT NULL,
  `pref_propertytype` varchar(11) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fdm_users`
--

INSERT INTO `fdm_users` (`id`, `username`, `email`, `password`, `role`, `otp`, `location`, `age`, `otp_expiry`, `pref_location`, `pref_postcode`, `pref_maxprice`, `pref_bedrooms`, `pref_bathrooms`, `pref_propertytype`, `reset_token`, `reset_token_expiry`) VALUES
(2, 'ec23380@qmul.ac.uk', 'ec23380@qmul.ac.uk', '$2y$10$za8.Qe2iKoXdUyvCAEicjujYKAlxbVE4WwgrHtq83u8mupzrtc6NW', 'landlord', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2968cb0061a1172025da757f2e04b8c3c8e70b41196561ce7d13d0e18a681a0d', '2025-04-09 21:32:42'),
(4, 'davepele101@gmail.com', 'davepele101@gmail.com', '$2y$10$hGKfIPaOdFYO84ILaNaPHeTb0K7kSO.bUbWa/2qlU0jiSnFCbO8N.', 'landlord', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acd54fad7dbd0e9283158943f2d1c348f4ecce726d3b79b8a84f50554f49b825', '2025-04-09 21:18:34'),
(5, 'dawid1paluch@gmail.com', 'dawid1paluch@gmail.com', '$2y$10$JlrT2r/5PPxzga5UrvyxRuMl2o1YkwZ4DutuZPammKyRVbhp7Xs3a', 'consultant', NULL, 'London', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f04ec8754fb8ce0f8c0d8311f9560d35e7d5bddf35e5c047621bd1dd4490e323', '2025-04-09 21:23:39');

-- --------------------------------------------------------

--
-- Table structure for table `propertylist`
--

CREATE TABLE `propertylist` (
  `propertyID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `addressLine1` varchar(255) NOT NULL,
  `addressLine2` varchar(255) DEFAULT NULL,
  `addressCityTown` varchar(255) NOT NULL,
  `addressPostcode` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `bedrooms` tinyint(3) UNSIGNED NOT NULL,
  `bathrooms` tinyint(3) UNSIGNED NOT NULL,
  `type` varchar(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `availability` text DEFAULT NULL,
  `dateUpdated` date NOT NULL DEFAULT current_timestamp(),
  `bookID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `propertylist`
--

INSERT INTO `propertylist` (`propertyID`, `userID`, `addressLine1`, `addressLine2`, `addressCityTown`, `addressPostcode`, `description`, `price`, `bedrooms`, `bathrooms`, `type`, `image_name`, `availability`, `dateUpdated`, `bookID`) VALUES
(8, 2, '12 The road', 'That place', 'Manchester', 'MC12 8DF', 'This is a house. It is in Manchester. It is very nice. This house is real. Please click if interested.', 800000.00, 5, 2, 'house', 'house image 1.jpeg', '2025-4-22,2025-4-23,2025-4-24,2025-4-25,2025-4-26,2025-4-27', '2025-04-10', NULL),
(9, 2, '86 Smith Street', '', 'London', 'N1', 'This is an apartment. It looks very nice. If you are interested please click on this place. The neighbourhood is very friendly and a very pleasant area to live. I hope you enjoy the overall experience of living in this place if you choose to live in it.', 260000.00, 2, 1, 'apartment', 'house image 2.jpg', '2025-4-30,2025-4-29,2025-4-28,2025-5-01,2025-5-07,2025-5-14,2025-5-13,2025-5-20,2025-5-29,2025-5-25', '2025-04-10', NULL),
(10, 2, '68 bright stree', '', 'Birmingham', 'br4 9fi', 'This is a place. It is a residential property. You can come live here if you like. It might be fun and pleasant. Please come and choose this property.', 441000.00, 3, 1, 'house', 'house image 3.jpg', '2025-4-15,2025-4-16,2025-4-12,2025-4-18,2025-4-21,2025-4-22,2025-4-25,2025-5-02,2025-5-09,2025-5-16,2025-5-23,2025-5-30,2025-5-13,2025-5-12,2025-5-18,2025-5-28,2025-6-12,2025-6-11,2025-6-17,2025-6-16,2025-6-27,2025-6-28,2025-6-06,2025-6-13,2025-6-20,2025-7-18,2025-7-11,2025-7-04,2025-7-16,2025-7-15,2025-7-07,2025-7-02', '2025-04-10', NULL),
(11, 2, '11 another road', 'this road', 'Glasgow', 'GL1 3ED', 'This is a flat. Please have a look if you are interested. We are in the city and very close to the centre. There are a lot of shops around and there is easy access to transport close to the property so there is absolutely nothing to worry in regards to those sort of things. Please choose this property.', 313000.00, 1, 1, 'flat', 'house image 5.jpg', '2025-4-22,2025-4-26,2025-4-30,2025-4-11', '2025-04-10', NULL),
(12, 2, '39 that street', 'some street', 'Liverpool', 'LV16 8PL', 'This is a studio apartment. It is in a very large building. The building has a large number of floors. This may take some time to get to the floor for the studio apartment as it is very high up in the building and the floor it is on can take some time to reach. Thankyou for reading all of this.', 160000.00, 1, 1, 'studio', 'house image 6.jpg', '2025-4-16,2025-4-17,2025-4-15,2025-4-14,2025-4-13,2025-4-18,2025-4-19,2025-4-12,2025-4-11,2025-4-23,2025-4-21,2025-4-20,2025-4-22,2025-4-30,2025-4-29', '2025-04-10', NULL),
(13, 2, '84 Great Street', '', 'Cardiff', 'CF3 1DF', 'This is a house. It is in Cardiff. It is not too big of a house. But it is a very nice house. We are happy to listen to any questions and answer them to the best of our ability. Goodbye!', 899000.00, 5, 3, 'house', 'house image 7.jpg', '2025-4-23,2025-4-26,2025-4-27,2025-4-14,2025-4-12,2025-5-08,2025-5-13,2025-5-30,2025-5-03,2025-5-18,2025-6-12,2025-6-17', '2025-04-10', NULL),
(14, 2, '6 Small Street', '', 'Cornwall', 'SW14 2WL', 'This is a house that is in Cornwall. If you are interested in potentially having a look at this house then please do have a look. We have a large number of dates that we are available for viewings of the property. Please do book it if you are interested.', 420000.00, 4, 1, 'house', 'house image 8.jpg', '2025-4-16,2025-4-15,2025-4-14,2025-4-13,2025-4-20,2025-4-21,2025-4-28,2025-4-29,2025-4-27,2025-4-23,2025-4-22,2025-4-17,2025-4-24,2025-4-18,2025-4-19,2025-4-11,2025-5-01,2025-5-02,2025-5-08,2025-5-09,2025-5-07,2025-5-06,2025-5-05,2025-5-12,2025-5-13,2025-5-15,2025-5-17,2025-5-23,2025-5-20,2025-5-18,2025-5-26,2025-5-27,2025-5-29,2025-5-30', '2025-04-10', NULL),
(15, 2, '41 Grand Park', '', 'Brighton', 'BW12 4GP', 'This is a grand property which is appropriately placed in the road of grand park making it a great location to live in with lots of nature and life all around it. I think you would greatly enjoy viewing this property.', 1234000.00, 8, 3, 'house', 'house image 10.jpg', '2025-4-22,2025-4-24,2025-4-16,2025-4-14,2025-4-20,2025-4-28,2025-4-30,2025-4-18,2025-4-26,2025-4-12,2025-5-08,2025-5-02,2025-5-10,2025-5-16,2025-5-14,2025-5-06,2025-5-12,2025-5-04,2025-5-18,2025-5-20,2025-5-26,2025-5-28,2025-5-22,2025-5-30,2025-5-24,2025-6-11,2025-6-03,2025-6-09,2025-6-01,2025-6-15,2025-6-17,2025-6-23,2025-6-29,2025-6-25,2025-6-19,2025-6-27,2025-6-21,2025-6-13,2025-6-07,2025-6-05,2025-7-10,2025-7-08,2025-7-02,2025-7-04,2025-7-12,2025-7-18,2025-7-16,2025-7-14,2025-7-22,2025-7-06,2025-7-20,2025-7-28,2025-7-30,2025-7-24,2025-7-26', '2025-04-10', NULL),
(16, 2, '78 Large Roag', '', 'London', 'W2 8DE', 'This is a very large property that finds itself to be located in London. It is very enjoyable to live here. I would very strongly recommending looking to live here and as such recommend this property. It comes with a high price but this is not an issue and is recommended as it is simply so pleasant. It also comes with a large number of bedrooms and bathrooms.', 1643000.00, 8, 5, 'house', 'house image 11.jpg', '2025-4-23,2025-4-24,2025-4-14,2025-4-13,2025-4-28,2025-4-19', '2025-04-10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_properties`
--

CREATE TABLE `saved_properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_properties`
--

INSERT INTO `saved_properties` (`id`, `user_id`, `property_id`, `saved_at`) VALUES
(26, 5, 7, '2025-04-07 22:38:50'),
(50, 5, 9, '2025-04-10 00:36:47'),
(51, 5, 11, '2025-04-10 00:36:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fdm_users`
--
ALTER TABLE `fdm_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`);

--
-- Indexes for table `propertylist`
--
ALTER TABLE `propertylist`
  ADD PRIMARY KEY (`propertyID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `saved_properties`
--
ALTER TABLE `saved_properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`property_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fdm_users`
--
ALTER TABLE `fdm_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `propertylist`
--
ALTER TABLE `propertylist`
  MODIFY `propertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `saved_properties`
--
ALTER TABLE `saved_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `propertylist`
--
ALTER TABLE `propertylist`
  ADD CONSTRAINT `propertylist_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `fdm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
