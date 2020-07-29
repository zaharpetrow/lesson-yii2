SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `name`, `email`, `password`, `verify`) VALUES
(1, 'Вася', 'vasya@gmail.com', '$2y$13$I2UPB3HSAsH9SFgBhD9tGeOVWjY02E7ahAe3SfUgjq.KfbcyN9NMG', 0),
(8, 'Владимир', 'gregory@gmail.com', '$2y$13$OAg1QFVM.PnLgSx/Dg3Q.Oz6.JRrbyMh6Le3yzHdsEjQndiUWU/Za', 1),
(10, 'Gregory1', 'gregory1@gmail.com', '$2y$13$ytot9HSVxcWugP2Gz2uTQejW4W.wWyIKi4qbLqwTbfIhav1bNOida', 0),
(11, 'Ivan', 'ivan@gmail.com', '$2y$13$pMe/T/KC4dnHVGFvTHcZUus6zIR/mNbAMUFrFsIgU1Jx.vZ/7mAeO', 1),
(12, 'Tom', 'tom@gmail.com', '$2y$13$9gDmER/T8RnmgbA3C2xU0u0l6IZIweSjCTbXqPsrvJSyt3iFiLTJO', 0),
(13, 'Troll', 'lionsgate@yandex.ru', '$2y$13$Gt9LvwYsb2zqNGSf0Y27mOq6gXPqKTqtWgWiGiPpSMs/RsCJP/s7m', 1),
(14, 'Gregory', 'gregory@gmail.coma', '$2y$13$sNOD8Cru1rqxUxZpvfjlpuf9yeGN6JwxcHesNIsEL6Q8Ulb9x1FVi', 1),
(15, 'Lion', 'lion@gmail.com', '$2y$13$mTV6eoTI3NKBSHFwuvyKWuFp9WUaV8Fs0vEg1nv6l/TIVADwgQUMm', 1),
(16, 'Oleg', 'olegTT@gmail.com', '$2y$13$D7krTFfrDyjgnuRB8bTGu.nN0nmg3RH2.8by9CyoCA3WYybhtVf3O', 1);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;


CREATE TABLE `user_options` (
  `user_id` int(11) NOT NULL,
  `dir_name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_options` (`user_id`, `dir_name`, `img`) VALUES
(8, 'b06a5aa9cf865798ce0701a192fb19f6', '5e5501f60eae6.jpg'),
(10, '95e30178a14e7aead5aeb3ead1291adf', NULL),
(11, '186d8804d2e06d2e1cb3cea9eeb63fe8', '5e43ea4fd200e.png'),
(13, '18e71cc64e5102836a0c4db8d836ec5b', '5e4a6d1bb9004.png'),
(15, '18e71cc64e51lg936a0c4db8gyu6ec5b', NULL),
(16, 'c7b35ea1a440c41b87a68fcea7919167', NULL);

ALTER TABLE `user_options`
  ADD UNIQUE KEY `user_id_unique` (`user_id`);

ALTER TABLE `user_options`
  ADD CONSTRAINT `fk_user_options_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `token` (`user_id`, `token`, `created_at`) VALUES
(8, '1VTbnsZ474_1OmUJb2NM4QraeHGLNg4m', 1583220545),
(11, 'hAXecUqvbzY61FqJbj7KmVOPKlWEFPmv', 1583220590),
(13, '3j1z08peSCY4utZacUgD48b4DhViKvSA', 1583220614);

ALTER TABLE `token`
  ADD UNIQUE KEY `user_id_unique` (`user_id`);

ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
