-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 21 fév. 2025 à 08:17
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `author_name` varchar(256) NOT NULL,
  `image_path` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id_book`, `title`, `author_name`, `image_path`, `description`, `owner_id`, `is_available`, `creation_date`, `update_date`) VALUES
(42, 'Wabi Sabi', 'Beth Kempton', './uploads/books/img_6790f9ff8aed1.png', 'Per maecenas primis mauris lobortis fames est. Natoque nisl purus molestie vivamus quis condimentum vivamus finibus. Diam primis justo suspendisse enim; ipsum sodales fusce sagittis rhoncus. Sociosqu curae erat et consequat eros. Faucibus odio in aliquam tempus lobortis fames.\r\n\r\nLacinia etiam vehicula per habitant vulputate purus eleifend. Cras congue id praesent ad potenti montes convallis aliquet. Adipiscing bibendum tincidunt ultricies lobortis nec congue. Neque id inceptos id dictum tellus maecenas risus. Pretium vulputate placerat imperdiet rutrum sociosqu tellus ipsum accumsan. Semper auctor vivamus erat felis platea risus iaculis. Molestie nullam torquent eleifend accumsan scelerisque natoque facilisi. Sociosqu egestas ridiculus sed arcu lectus senectus cursus.\r\n\r\nUltricies odio amet cras justo porttitor commodo in. Posuere curabitur at leo vulputate magnis nunc dui. Est netus semper metus viverra; scelerisque mollis vestibulum. Natoque magna volutpat mollis, egestas consequat a? Vitae penatibus leo eu neque hendrerit dis libero.', 3, 1, '2025-01-22', '2025-01-22'),
(43, 'Delight!', 'Justin Rossow', './uploads/books/img_6791063d784bf.png', 'Per maecenas primis mauris lobortis fames est. Natoque nisl purus molestie vivamus quis condimentum vivamus finibus. Diam primis justo suspendisse enim; ipsum sodales fusce sagittis rhoncus. Sociosqu curae erat et consequat eros. Faucibus odio in aliquam tempus lobortis fames.\r\n\r\nLacinia etiam vehicula per habitant vulputate purus eleifend. Cras congue id praesent ad potenti montes convallis aliquet. Adipiscing bibendum tincidunt ultricies lobortis nec congue. Neque id inceptos id dictum tellus maecenas risus. Pretium vulputate placerat imperdiet rutrum sociosqu tellus ipsum accumsan. Semper auctor vivamus erat felis platea risus iaculis. Molestie nullam torquent eleifend accumsan scelerisque natoque facilisi. Sociosqu egestas ridiculus sed arcu lectus senectus cursus.\r\n\r\nUltricies odio amet cras justo porttitor commodo in. Posuere curabitur at leo vulputate magnis nunc dui. Est netus semper metus viverra; scelerisque mollis vestibulum. Natoque magna volutpat mollis, egestas consequat a? Vitae penatibus leo eu neque hendrerit dis libero.', 6, 0, '2025-01-22', '2025-01-22'),
(44, 'Esther', 'Alabaster', './uploads/books/img_679106e6d3e0b.png', 'Per maecenas primis mauris lobortis fames est. Natoque nisl purus molestie vivamus quis condimentum vivamus finibus. Diam primis justo suspendisse enim; ipsum sodales fusce sagittis rhoncus. Sociosqu curae erat et consequat eros. Faucibus odio in aliquam tempus lobortis fames.\r\n\r\nLacinia etiam vehicula per habitant vulputate purus eleifend. Cras congue id praesent ad potenti montes convallis aliquet. Actor vivamus erat felis platea risus iaculis. Molestie nullam torquent eleifend accumsan scelerisque natoque facilisi. Sociosqu egestas ridiculus sed arcu lectus senectus cursus.\r\n\r\nUltricies odio amet cras justo porttitor commodo in. Posuere curabitur at leo vulputate magnis nunc dui. Est netus semper metus viverra; scelerisque mollis vestibulum. Natoque magna volutpat mollis, egestas consequat a? Vitae penatibus leo eu neque hendrerit dis libero.', 4, 1, '2025-01-22', '2025-01-22'),
(45, 'The Kinfolk Table', 'Nathan Williams', './uploads/books/img_679107c801708.png', 'Per maecenas primis mauris lobortis fames est. Natoque nisl purus molestie vivamus quis condimentum vivamus finibus. Diam primis justo suspendisse enim; ipsum sodales fusce sagittis rhoncus. Sociosqu curae erat et consequat eros. Faucibus odio in aliquam tempus lobortis fames.\r\n\r\nLacinia etiam vehicula per habitant vulputate purus eleifend. Cras congue id praesent ad potenti montes convallis aliquet. Adipiscing bibendum tincidunt ultricies lobortis nec congue. Neque id inceptos id dictum tellus maecenas risus. Pretium vulputate placerat imperdiet rutrum sociosqu tellus ipsum accumsan. Semper auctor vivamus erat felis platea risus iaculis. Molestie nullam torquent eleifend accumsan scelerisque natoque facilisi. Sociosqu egestas ridiculus sed arcu lectus senectus cursus.\r\n\r\nUltricies odio amet cras justo porttitor commodo in. Posuere curabitur at leo vulputate magnis nunc dui. Est netus semper metus viverra; scelerisque mollis vestibulum. Natoque magna volutpat mollis, egestas consequat a? Vitae penatibus leo eu neque hendrerit dis libero.', 3, 1, '2025-01-22', '2025-01-22'),
(46, 'Milk & honey', 'Rupi Kaur', './uploads/books/img_6791088651cd7.png', 'Per maecenas primis mauris lobortis fames est. Natoque nisl purus molestie vivamus quis condimentum vivamus finibus. Diam primis justo suspendisse enim; ipsum sodales fusce sagittis rhoncus. Sociosqu curae erat et consequat eros. Faucibus odio in aliquam tempus lobortis fames.\r\n\r\nLacinia etiam vehicula per habitant vulputate purus eleifend. Cras congue id praesent ad potenti montes convallis aliquet. Adquent eleifend accumsan scelerisque natoque facilisi. Sociosqu egestas ridiculus sed arcu lectus senectus cursus.\r\n\r\nUltricies odio amet cras justo porttitor commodo in. Posuere curabitur at leo vulputate magnis nunc dui. Est netus semper metus viverra; scelerisque mollis vestibulum. Natoque magna volutpat mollis, egestas consequat a? Vitae penatibus leo eu neque hendrerit dis libero.', 5, 1, '2025-01-22', '2025-01-22'),
(47, 'Hygge', 'Meik Wiking', './uploads/books/img_6791090b7bd45.png', 'Lacinia etiam vehicula per habitant vulputate purus eleifend. Cras congue id praesent ad potenti montes convallis aliquet. Adipiscing bibendum tincidunt ultricies lobortis nec congue. uctor vivamus erat felis platea risus iaculis. Molestie nullam torquent eleifend accumsan scelerisque natoque facilisi. Sociosqu egestas ridiculus sed arcu lectus senectus cursus.\r\n\r\nUltricies odio amet cras justo porttitor commodo in. Posuere curabitur at leo vulputate magnis nunc dui. Est netus semper metus viverra; scelerisque mollis vestibulum. Natoque magna volutpat mollis, egestas consequat a? Vitae penatibus leo eu neque hendrerit dis libero.', 5, 1, '2025-01-22', '2025-01-22'),
(48, 'Milwaukee Mission', 'Elder Cooper Low', './uploads/books/img_67914effaf653.png', 'avida vulputate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl hendrerit mollis. Suspendisse ut massa. Cras nec ante. Pellentesque a nulla. Cum sociis natoque penatibus et mag', 7, 1, '2025-01-22', '2025-01-22'),
(49, 'Minimalist Graphics', 'Julia Schonlau', './uploads/books/img_67914f625fef9.png', 'avida vulputate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl hendrerit mollis. Suspendisse ut massa. Cras nec ante. Pellentesque a nulla. Cum sociis natoque penatibus et mag', 8, 1, '2025-01-22', '2025-01-22'),
(50, 'Innovation', 'Matt Ridley', './uploads/books/img_67914ff84cbf4.png', 'Vivamus adipiscing. Curabitur imperdiet tempus turpis. Vivamus sapien dolor, congue venenatis, euismod eget, porta rhoncus, magna. Proin condimentum pretium enim. Fusce fringilla, liberUt laoreet ornare est. Phasellus gravida vulputate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, r quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vees, nascetur ridiculus mus. Aliquam tincidunt urna. Nulla ullamcorper vestibulum turpis. Pellentesque cursus luctus mauris.\r\n\r\nVestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec scelerisque metus. am nec sem. Sed eros turpis, facilisis nec, vehicula vitae, aliquam sed, nulla. Curabitur justo leo, vestibulum eget, tristique ut, tempus at, nisl.\r\n\r\nVivamus sodales elementum', 9, 1, '2025-01-22', '2025-01-22'),
(51, 'Psalms', 'Alabaster', './uploads/books/img_6791503da91a8.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 10, 1, '2025-01-22', '2025-01-22'),
(52, 'Thinking, Fast & Slow', 'Daniel Kahneman', './uploads/books/img_679150bad03b6.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 11, 0, '2025-01-22', '2025-01-22'),
(53, 'A Book Full Of Hope', 'Rupi Kaur', './uploads/books/img_6791510082489.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 12, 1, '2025-01-22', '2025-01-22'),
(54, 'The Subtle Art Of...', 'Mark Manson', './uploads/books/img_679151e3e6e57.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 13, 1, '2025-01-22', '2025-01-22'),
(55, 'Narnia', 'C.S Lewis', './uploads/books/img_67915241aabbb.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 14, 0, '2025-01-22', '2025-01-22'),
(56, 'Company Of One', 'Paul Jarvis', './uploads/books/img_679152921399b.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 15, 1, '2025-01-22', '2025-01-22'),
(57, 'The Two Towers', 'J.R.R Tolkien', './uploads/books/img_679152f1b6ab0.png', 'putate nulla. Donec sit amet arcu ut sem tempor malesuada. Praesent hendrerit augue in urna. Proin enim ante, ornare vel, consequat ut, blandit in, justo. Donec felis elit, dignissim sed, sagittis ut, ullamcorper a, nulla. Aenean pharetra vulputate odio.\r\n\r\nInteger ac diam. Nullam porttitor dolor eget metus. Nulla sed metus quis tortor lacinia tempor. Mauris mauris dui, faucibus vitae, aliquet sit amet, placerat a, ante. Nunc placerat tincidunt neque. Mauris egestas dolor ut ipsum cursus malesuada. Curabitur odio. Nunc lobortis. Sed mattis tempor felis. Mauris dolor quam, facilisis at, bibendum sit amet, rutrum ornare, pede. Suspendisse accumsan sagittis velit. Pellentesque varius laoreet lorem. Vivamus egestas sapien id diam.\r\n\r\nNam dui ligula, fringilla a, euismod sodales, sollicitudin vel, wisi. Morbi auctor lorem non justo. Nam lacus libero, pretium at, lobortis vitae, ultricies et, tellus. Donec aliquet, tortor sed accumsan bibendum, erat ligula aliquet magna, vitae ornare odio metus a mi. Morbi ac orci et nisl he', 16, 1, '2025-01-22', '2025-01-22');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `created_at` datetime NOT NULL,
  `from_user` int(20) NOT NULL,
  `to_user` int(20) NOT NULL,
  `is_read` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `message_text`, `created_at`, `from_user`, `to_user`, `is_read`) VALUES
(1, 'bonjour', '2025-01-28 18:53:56', 3, 8, 1),
(2, 'teryetyt', '2025-01-28 18:55:05', 3, 8, 1),
(3, 'fsdfsdfsdf', '2025-01-29 09:24:54', 8, 3, 1),
(4, 'dsfsdgfgs', '2025-01-29 09:27:17', 8, 4, 0),
(5, 'yteyery', '2025-01-29 16:00:50', 8, 3, 1),
(6, 'ghjghgg', '2025-01-29 16:24:51', 8, 4, 0),
(7, 'jhghjkgj', '2025-01-29 21:23:53', 8, 3, 1),
(8, 'gdfhfghfjghjgkgjkhldghegheth', '2025-01-30 18:07:35', 3, 8, 1),
(9, 'fgdfgdfhrjtkituierzt', '2025-01-30 18:08:08', 8, 3, 1),
(10, 'dfgdfgefg', '2025-01-30 18:46:24', 8, 4, 0),
(11, 'rytetyetyetye', '2025-01-30 18:46:46', 4, 8, 1),
(12, 'salut \r\n', '2025-02-01 17:45:20', 8, 3, 1),
(13, 'coucou', '2025-02-02 18:00:37', 8, 3, 0),
(14, 'coucou', '2025-02-06 12:10:14', 8, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(128) NOT NULL DEFAULT 'NOT NULL',
  `email` varchar(256) NOT NULL DEFAULT 'NOT NULL',
  `image_path` text NOT NULL,
  `password` text NOT NULL DEFAULT 'NOT NULL',
  `user_creation_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `image_path`, `password`, `user_creation_date`) VALUES
(2, 'Nathalire', 'nathalie@mail.com', './uploads/users/img_678fa71d611c9.png', '$2y$10$5MoAKrtSE/Kb.e4RANgzEOCqxD7DrJlhZgIrg0VRbBnObR7XdjK8m', '2025-01-11'),
(3, 'AlexLecture', 'alexlecture@mail.com', './uploads/users/img_678fe11cc8f8c.png', '$2y$10$840BsmnmCn8tE68fGeujvezb4YNDeoX0OEJtS3nw9F4dDyd2X2jKC', '2025-01-18'),
(4, 'CamilleClubLit', 'camille@mail.com', './uploads/users/img_67910706be8b4.png', '$2y$10$vtgduJ86xZsFaKL9JxpFHOqA5eQRHLcAbItowerpe8G5O49QZ3Ele', '2025-01-22'),
(5, 'Hugo1990_12', 'hugo@mail.com', './uploads/users/img_679108a1dc393.png', '$2y$10$840BsmnmCn8tE68fGeujvezb4YNDeoX0OEJtS3nw9F4dDyd2X2jKC', '2025-01-22'),
(6, 'Juju1432', 'juju@mail.com', './uploads/users/img_6791055f80799.png', '$2y$10$vtgduJ86xZsFaKL9JxpFHOqA5eQRHLcAbItowerpe8G5O49QZ3Ele', '2025-01-22'),
(7, 'Christiane75014', 'christiane@mail.com', './uploads/users/img_679109b67b7d4.png', '$2y$10$TK.TgGZ6OydeHNNbun6GueLRaQxtYl3YkhlJ9ZHTggwVSP6i2WCLC', '2025-01-22'),
(8, 'HamzaLecture', 'hamza@mail.com', './uploads/users/img_67910996ef26c.png', '$2y$10$tOG6P/./8H5xQPmCa9XkNetgAeS2Zc5OGCuVIiJHJsStvvt5wbiuW', '2025-01-22'),
(9, 'Lou&Ben50', 'Louben@mail.com', './uploads/users/img_67910b19828ac.png', '$2y$10$W.yReVBd5iLchwPA9g62JewWSvY.h.gNBAqXYrebWEjNF583pwhbq', '2025-01-22'),
(10, 'Lolobzh', 'lolo@mail.com', './uploads/users/img_67910b59755fd.png', '$2y$10$LvXvyEdSIXXNyOABbEIYGem8R7Oz6CXiPdTtAfjaboFkhIrRXuhvK', '2025-01-22'),
(11, 'Sas634', 'sas@mail.com', './uploads/users/img_67910b88d8c56.png', '$2y$10$9TVIieu70N5NwsWjMF/9oukDdlMz63LcT3cxoKKsL83eQcNLfGGQi', '2025-01-22'),
(12, 'ML95', 'ml@mail.com', './uploads/users/img_67910bbe7fe29.png', '$2y$10$yl.dF4eWQgINMfkOFw/JsOIv2j0opmqSZ0pcqNDguRYZ0RsWhP5eG', '2025-01-22'),
(13, 'Verogo33', 'verogo@mail.com', './uploads/users/img_67910bfe8ab95.png', '$2y$10$gDk2z9HBrTuqsIlpQ32OwuDAhwWG/cJQFWvBdUtaUWVMD5J.UZkbW', '2025-01-22'),
(14, 'AnnikaBrahms', 'annika@mail.com', './uploads/users/img_67910c37d210e.png', '$2y$10$SfEU3qU6XUqDlXdY3HUqmustQkDlp9EEUwQuNoOjn6m8UW5EVMR6K', '2025-01-22'),
(15, 'Victoirefabre912', 'victoire@mail.com', './uploads/users/img_67910c849a24e.png', '$2y$10$2KhbfvOtLQrhGTOK5XJ0ZuP.XW6gPLaslBS6gRo2mVOgKsD/3cQ/q', '2025-01-22'),
(16, 'Lotrfanclub67', 'lotrfanclub@mail.com', './uploads/users/img_67910d5051aa3.png', '$2y$10$T.cIpa1iilrG9wMEtdtSF.AwPzoriIvJlVnYcVaHN9aklFJ7XOOSa', '2025-01-22');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `fk_books_owner_id` (`owner_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`from_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`to_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
