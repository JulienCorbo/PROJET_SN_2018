CREATE DATABASE pool3k;
CREATE TABLE `pool3k`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(100) NOT NULL , `pass` VARCHAR(100) NOT NULL , `mail` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `users` (`id`, `login`, `pass`, `mail`) VALUES (NULL, 'admin', '$2y$10$sMqXnjvT6OHBp3hdq09WW.9O4oy7YHXj948fpMNt5mF2TT0MbzU8S', 'admin@pool3k.fr'); -- admin.adminpass
INSERT INTO `users` (`id`, `login`, `pass`, `mail`) VALUES (NULL, 'user', '$2y$10$CAYSD3ym7SMC8Bxy/drM2OuOmNj.yDKfGdUBf7n.37s2DOcFDnX/S', 'user@pool3k.fr'); -- user.pass
CREATE TABLE `pool3k`.`statements` ( `id` INT NOT NULL AUTO_INCREMENT , `date` DATE NOT NULL , `heure` TIME NOT NULL , `ph` INT NOT NULL , `temp` INT NOT NULL , `cl` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;