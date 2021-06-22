-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2021 at 03:55 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `deleted_receipts`
-- (See below for the actual view)
--
CREATE TABLE `deleted_receipts` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `invoices_data`
-- (See below for the actual view)
--
CREATE TABLE `invoices_data` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `invoices_monthly_total`
-- (See below for the actual view)
--
CREATE TABLE `invoices_monthly_total` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `invoices_total`
-- (See below for the actual view)
--
CREATE TABLE `invoices_total` (
);

-- --------------------------------------------------------

--
-- Structure for view `deleted_receipts`
--
DROP TABLE IF EXISTS `deleted_receipts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `deleted_receipts`  AS  select `invoices`.`cancel_reason` AS `cancel_reason`,`invoices`.`cancel_reason_detail` AS `cancel_reason_detail`,`test_categories`.`test_category` AS `test_category`,`invoices`.`invoice_id` AS `invoice_id`,`invoices`.`status` AS `status`,cast(`invoices`.`created_date` as date) AS `date` from (`invoices` join `test_categories`) where `invoices`.`category_id` = `test_categories`.`test_category_id` and `invoices`.`is_deleted` = 1 and `invoices`.`category_id` <> 5 and `invoices`.`status` = 3 order by cast(`invoices`.`created_date` as date) desc ;

-- --------------------------------------------------------

--
-- Structure for view `invoices_data`
--
DROP TABLE IF EXISTS `invoices_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `invoices_data`  AS  select cast(`invoices`.`created_date` as date) AS `created_date`,sum(if(`invoices`.`category_id` = 1 and `invoices`.`is_deleted` = 0,`invoices`.`total_price`,0)) AS `lab`,sum(if(`invoices`.`category_id` = 2 and `invoices`.`is_deleted` = 0,`invoices`.`total_price`,0)) AS `ecg`,sum(if(`invoices`.`category_id` = 3 and `invoices`.`is_deleted` = 0,`invoices`.`total_price`,0)) AS `ultrasound`,sum(if(`invoices`.`category_id` = 4 and `invoices`.`is_deleted` = 0,`invoices`.`total_price`,0)) AS `x_ray`,sum(if(`invoices`.`category_id` = 5 and `invoices`.`is_deleted` = 0,`invoices`.`total_price`,0)) AS `opd`,sum(if(`invoices`.`category_id` = 5 and `invoices`.`is_deleted` = 0 and `invoices`.`opd_doctor` = 77,`invoices`.`total_price`,0)) AS `dr_naila`,sum(if(`invoices`.`category_id` = 5 and `invoices`.`is_deleted` = 0 and `invoices`.`opd_doctor` = 86,`invoices`.`alkhidmat_income`,0)) AS `dr_shabana`,sum(if(`invoices`.`category_id` = 5 and `invoices`.`is_deleted` = 0 and `invoices`.`opd_doctor` = 104,`invoices`.`alkhidmat_income`,0)) AS `dr_shabana_us_doppler`,sum(if(`invoices`.`discount` > 0 and `invoices`.`is_deleted` = 0,`invoices`.`discount`,0)) AS `discount`,sum(if(`invoices`.`is_deleted` = 1 and `invoices`.`category_id` <> 5,`invoices`.`is_deleted`,0)) AS `other_deleted`,sum(if(`invoices`.`is_deleted` = 1 and `invoices`.`category_id` = 5,`invoices`.`is_deleted`,0)) AS `opd_deleted` from `invoices` group by cast(`invoices`.`created_date` as date) ;

-- --------------------------------------------------------

--
-- Structure for view `invoices_monthly_total`
--
DROP TABLE IF EXISTS `invoices_monthly_total`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `invoices_monthly_total`  AS  select year(`invoices_total`.`created_date`) AS `year`,month(`invoices_total`.`created_date`) AS `month`,sum(`invoices_total`.`lab`) AS `lab`,sum(`invoices_total`.`ecg`) AS `ecg`,sum(`invoices_total`.`ultrasound`) AS `ultrasound`,sum(`invoices_total`.`x_ray`) AS `x_ray`,sum(`invoices_total`.`opd`) AS `opd`,sum(`invoices_total`.`dr_naila`) AS `dr_naila`,sum(`invoices_total`.`dr_shabana`) AS `dr_shabana`,sum(`invoices_total`.`dr_shabana_us_doppler`) AS `dr_shabana_us_doppler`,sum(`invoices_total`.`discount`) AS `discount`,sum(`invoices_total`.`other_deleted`) AS `other_deleted`,sum(`invoices_total`.`opd_deleted`) AS `opd_deleted`,sum(`invoices_total`.`alkhidmat_total`) AS `alkhidmat_total` from `invoices_total` group by year(`invoices_total`.`created_date`),month(`invoices_total`.`created_date`) ;

-- --------------------------------------------------------

--
-- Structure for view `invoices_total`
--
DROP TABLE IF EXISTS `invoices_total`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `invoices_total`  AS  select `invoices_data`.`created_date` AS `created_date`,`invoices_data`.`lab` AS `lab`,`invoices_data`.`ecg` AS `ecg`,`invoices_data`.`ultrasound` AS `ultrasound`,`invoices_data`.`x_ray` AS `x_ray`,`invoices_data`.`opd` AS `opd`,`invoices_data`.`dr_naila` AS `dr_naila`,`invoices_data`.`dr_shabana` AS `dr_shabana`,`invoices_data`.`dr_shabana_us_doppler` AS `dr_shabana_us_doppler`,`invoices_data`.`discount` AS `discount`,`invoices_data`.`other_deleted` AS `other_deleted`,`invoices_data`.`opd_deleted` AS `opd_deleted`,`invoices_data`.`lab` + `invoices_data`.`ecg` + `invoices_data`.`ultrasound` + `invoices_data`.`x_ray` + `invoices_data`.`dr_naila` + `invoices_data`.`dr_shabana` + `invoices_data`.`dr_shabana_us_doppler` AS `alkhidmat_total` from `invoices_data` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
