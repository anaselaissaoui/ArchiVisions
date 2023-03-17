-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 17 mars 2023 à 19:46
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `archivision`
--

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `book_date` date DEFAULT NULL,
  `book_status` varchar(25) NOT NULL,
  `mem_id` int(11) DEFAULT NULL,
  `work_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`book_id`, `book_date`, `book_status`, `mem_id`, `work_id`) VALUES
(10, '2023-03-16', 'CLOSED', 7, 17),
(11, '2023-03-16', 'CLOSED', 7, 10),
(12, '2023-03-16', 'CLOSED', 7, 28);

--
-- Déclencheurs `booking`
--
DELIMITER $$
CREATE TRIGGER `book_work` AFTER INSERT ON `booking` FOR EACH ROW BEGIN
    UPDATE works SET work_dispo = 0 WHERE work_id = NEW.work_id;
    UPDATE member SET mem_res = mem_res + 1 WHERE mem_id = NEW.mem_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `booking_delete` AFTER DELETE ON `booking` FOR EACH ROW BEGIN
  IF OLD.book_date < DATE_SUB(NOW(), INTERVAL 24 HOUR) AND OLD.book_status = 'IN PROGRESS' THEN
    UPDATE member SET mem_res = mem_res + 1 WHERE mem_id = OLD.mem_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `librarian`
--

CREATE TABLE `librarian` (
  `lib_id` int(11) NOT NULL,
  `lib_name` varchar(255) DEFAULT NULL,
  `lib_email` varchar(255) DEFAULT NULL,
  `lib_pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `librarian`
--

INSERT INTO `librarian` (`lib_id`, `lib_name`, `lib_email`, `lib_pass`) VALUES
(1, 'John Doe', 'johndoe@example.com', 'password'),
(2, 'ziko', 'admin@gmail.com', '60b348bb250144900f8c45be7f1284f8');

-- --------------------------------------------------------

--
-- Structure de la table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(11) NOT NULL,
  `loan_date` date DEFAULT NULL,
  `loan_ret_date` date NOT NULL,
  `loan_eff_ret_date` date DEFAULT NULL,
  `loan_status` varchar(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `loan`
--

INSERT INTO `loan` (`loan_id`, `loan_date`, `loan_ret_date`, `loan_eff_ret_date`, `loan_status`, `book_id`) VALUES
(1, '2023-03-16', '2023-03-31', '2023-03-16', 'CLOSED', 10),
(2, '2023-03-16', '2023-03-31', '2023-03-16', 'CLOSED', 10),
(3, '2023-03-16', '2023-03-31', '2023-03-16', 'CLOSED', 10),
(4, '2023-03-16', '2023-03-31', '2023-03-16', 'CLOSED', 12);

--
-- Déclencheurs `loan`
--
DELIMITER $$
CREATE TRIGGER `tr_loan_status_update` AFTER UPDATE ON `loan` FOR EACH ROW IF NEW.loan_status = 'CLOSED' AND OLD.loan_status != 'CLOSED' THEN
    UPDATE booking SET book_status = 'CLOSED'
    WHERE book_id = NEW.book_id;
  END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_mem_pen` AFTER UPDATE ON `loan` FOR EACH ROW IF NEW.loan_status = 'LATE' AND OLD.loan_status != 'LATE' THEN
    UPDATE member SET mem_penalty = mem_penalty + 1
    WHERE mem_id = (
      SELECT mem_id FROM books WHERE book_id = NEW.book_id
    );
  END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `mem_id` int(11) NOT NULL,
  `mem_cin` varchar(255) DEFAULT NULL,
  `mem_name` varchar(255) DEFAULT NULL,
  `mem_username` varchar(255) DEFAULT NULL,
  `mem_address` varchar(255) DEFAULT NULL,
  `mem_email` varchar(255) DEFAULT NULL,
  `mem_pass` varchar(255) DEFAULT NULL,
  `mem_type` varchar(255) DEFAULT NULL,
  `mem_phone` varchar(255) DEFAULT NULL,
  `mem_birthd` date DEFAULT NULL,
  `mem_penalty` int(11) DEFAULT NULL,
  `mem_res` int(11) NOT NULL CHECK (`mem_res` >= 0 and `mem_res` <= 3),
  `mem_cr_acc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`mem_id`, `mem_cin`, `mem_name`, `mem_username`, `mem_address`, `mem_email`, `mem_pass`, `mem_type`, `mem_phone`, `mem_birthd`, `mem_penalty`, `mem_res`, `mem_cr_acc`) VALUES
(3, 'zg414141', 'ali elai', 'alialiali', 'guercif f derb', 'ali@gmail.com', '884ce4bb65d328ecb03c598409e2b168', 'Student', '0615241524', '2017-01-01', 0, 0, '0000-00-00'),
(4, 'zg414141', 'ali elai', 'alialiali', 'guercif f derb', 'ali@gmail.com', '884ce4bb65d328ecb03c598409e2b168', 'Student', '0615241524', '2017-01-01', 0, 0, '2023-03-07'),
(5, '152425', 'zakaria', 'ziko', 'gha hna', 'ziko@gmail.com', 'b495ce63ede0f4efc9eec62cb947c162', 'Student', '623152425', '2011-03-02', 0, 0, '2023-03-07'),
(7, 'ZG141953', 'anas', 'anaselai', '257 comp al irfane gh20 , imm 257 ,etg 4 app 245', 'anassaissaoui9815@gmail.com', '60b348bb250144900f8c45be7f1284f8', 'Student', '0649409177', '1998-09-19', 0, 1, '2023-03-14');

-- --------------------------------------------------------

--
-- Structure de la table `works`
--

CREATE TABLE `works` (
  `work_id` int(11) NOT NULL,
  `work_title` varchar(255) DEFAULT NULL,
  `work_author` varchar(255) DEFAULT NULL,
  `work_img` varchar(255) DEFAULT NULL,
  `work_state` varchar(255) DEFAULT NULL,
  `work_type` varchar(255) DEFAULT NULL,
  `work_pub_d` date DEFAULT NULL,
  `work_purch_d` date DEFAULT NULL,
  `work_pages` int(11) DEFAULT NULL,
  `work_dispo` tinyint(1) DEFAULT NULL,
  `lib_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `works`
--

INSERT INTO `works` (`work_id`, `work_title`, `work_author`, `work_img`, `work_state`, `work_type`, `work_pub_d`, `work_purch_d`, `work_pages`, `work_dispo`, `lib_id`) VALUES
(9, 'The Great Gatsby', 'F. Scott Fitzgerald', './img/The_Great_Gatsby_10.jpg', '3', 'BOOK', '1925-04-10', '2022-01-15', 180, 1, 1),
(10, 'To Kill a Mockingbird', 'Harper Lee', './img/to_kill_a_mockingbird.jpg', '4', 'BOOK', '1960-07-11', '2022-02-22', 324, 0, 1),
(11, 'Pride and Prejudice', 'Jane Austen', './img/pride_and_prejudice.jpg', '2', 'BOOK', '1813-01-28', '2022-03-11', 432, 1, 1),
(12, '1984', 'George Orwell', './img/1984.jpg', '3', 'BOOK', '1949-06-08', '2022-01-01', 328, 1, 1),
(13, 'Animal Farm', 'George Orwell', './img/animal_farm.jpg', '3', 'BOOK', '1945-08-17', '2022-02-14', 144, 1, 1),
(14, 'Brave New World', 'Aldous Huxley', './img/brave_new_world.jpg', '2', 'BOOK', '1932-05-01', '2022-03-09', 288, 1, 1),
(15, 'The Catcher in the Rye', 'J.D. Salinger', './img/catcher_in_the_rye.jpg', '4', 'BOOK', '1951-07-16', '2022-01-12', 224, 0, 1),
(16, 'Lord of the Flies', 'William Golding', './img/lord_of_the_flies.jpg', '3', 'BOOK', '1954-09-17', '2022-02-27', 224, 1, 1),
(17, 'The Matrix', 'Lana Wachowski, Lilly Wachowski', './img/the_matrix.jpg', '4', 'DVD', '1999-03-31', '2022-03-12', 1, 0, 1),
(18, 'The Lord of the Rings: The Fellowship of the Ring', 'J.R.R. Tolkien', './img/lord_of_the_rings.jpg', '3', 'DVD', '2001-12-10', '2022-03-12', 5, 1, 1),
(19, 'The Shawshank Redemption', 'Stephen King', './img/the_shawshank_redemption.jpg', '2', 'DVD', '1994-09-23', '2022-03-12', 60, 1, 1),
(20, 'Inception', 'Christopher Nolan', './img/inception.jpg', '3', 'DVD', '2010-07-08', '2022-03-12', 1, 1, 1),
(21, 'Pulp Fiction', 'Quentin Tarantino', './img/pulp_fiction.jpg', '4', 'DVD', '1994-05-21', '2022-03-12', 1, 0, 1),
(22, 'National Geographic', 'Various', './img/nat_geo.jpg', '2', 'MAGAZINE', '1888-10-01', '2022-03-12', 100, 0, 1),
(23, 'The New Yorker', 'Various', './img/new_yorker.jpg', '3', 'MAGAZINE', '1925-02-21', '2022-03-12', 80, 1, 1),
(24, 'Time', 'Various', './img/time.jpg', '4', 'MAGAZINE', '1923-03-03', '2022-03-12', 60, 1, 1),
(25, 'The Economist', 'Various', './img/economist.jpg', '3', 'MAGAZINE', '1843-09-02', '2022-03-12', 50, 1, 1),
(26, 'Vogue', 'Various', './img/vogue.jpg', '2', 'MAGAZINE', '1892-12-17', '2022-03-12', 40, 0, 1),
(27, 'The Great Gatsby', 'F. Scott Fitzgerald', './img/The_Great_Gatsby_10.jpg', '2', 'BOOK', '1925-04-10', '2022-01-15', 180, 1, 1),
(28, 'To Kill a Mockingbird', 'Harper Lee', './img/to_kill_a_mockingbird.jpg', '3', 'BOOK', '1960-07-11', '2022-02-22', 324, 0, 1),
(29, 'Pride and Prejudice', 'Jane Austen', './img/pride_and_prejudice.jpg', '2', 'BOOK', '1813-01-28', '2022-03-11', 432, 1, 1),
(30, 'To Kill a Mockingbird', 'Harper Lee', './img/to_kill_a_mockingbird.jpg', '2', 'BOOK', '1960-07-11', '2022-02-22', 324, 1, 1),
(31, 'Pride and Prejudice', 'Jane Austen', './img/pride_and_prejudice.jpg', '4', 'BOOK', '1813-01-28', '2022-03-11', 432, 1, 1),
(32, 'To Kill a Mockingbird', 'Harper Lee', './img/to_kill_a_mockingbird.jpg', '3', 'BOOK', '1960-07-11', '2022-02-22', 324, 1, 1),
(33, 'Pride and Prejudice', 'Jane Austen', './img/pride_and_prejudice.jpg', '3', 'BOOK', '1813-01-28', '2022-03-11', 432, 1, 1),
(34, 'To Kill a Mockingbird', 'Harper Lee', './img/to_kill_a_mockingbird.jpg', '4', 'Book', '1960-07-11', '2022-02-22', 324, 1, 1),
(35, 'Pride and Prejudice', 'Jane Austen', './img/pride_and_prejudice.jpg', '2', 'Book', '1813-01-28', '2022-03-11', 432, 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `mem_id` (`mem_id`),
  ADD KEY `work_id` (`work_id`);

--
-- Index pour la table `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`lib_id`);

--
-- Index pour la table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Index pour la table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_id`);

--
-- Index pour la table `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`work_id`),
  ADD KEY `lib_id` (`lib_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `librarian`
--
ALTER TABLE `librarian`
  MODIFY `lib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `works`
--
ALTER TABLE `works`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`mem_id`) REFERENCES `member` (`mem_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`);

--
-- Contraintes pour la table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `booking` (`book_id`);

--
-- Contraintes pour la table `works`
--
ALTER TABLE `works`
  ADD CONSTRAINT `works_ibfk_1` FOREIGN KEY (`lib_id`) REFERENCES `librarian` (`lib_id`);

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_booking_event` ON SCHEDULE EVERY 10 MINUTE STARTS '2023-03-14 15:27:28' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM booking
    WHERE book_date < DATE_SUB(NOW(), INTERVAL 24 HOUR)
    AND book_status = 'in progress'$$

CREATE DEFINER=`root`@`localhost` EVENT `loan` ON SCHEDULE EVERY 10 MINUTE STARTS '2023-03-16 20:57:36' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE loan
    SET laon_status = 'LATE'
    WHERE loan_eff_ret_date IS NULL
    AND loan_date < DATE_SUB(NOW(), INTERVAL 15 DAY)
    AND loan_status = 'OPEN'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
