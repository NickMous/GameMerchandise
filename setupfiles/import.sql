CREATE DATABASE sdhmerchstore;

USE sdhmerchstore;

CREATE TABLE `gamemerch` (
  `naam` varchar(100) NOT NULL,
  `game` varchar(100) NOT NULL,
  `prijs` float NOT NULL,
  `voorraad` int NOT NULL,
  `id` int NOT NULL,
  `beschrijving` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
);

INSERT INTO `gamemerch` (`naam`, `game`, `prijs`, `voorraad`, `id`, `beschrijving`, `foto`) VALUES
('Pickaxe', 'Fortnite', 9.99, 5, 1, 'Fortnite Pickaxe', 'pickaxe.jpg'),
('Backpack', 'Fortnite', 14.99, 3, 2, 'Fortnite Backpack', 'backpack.jpg'),
('Creeper', 'Minecraft', 4.99, 15, 3, 'Minecraft Creeper', 'creeper.png'),
('ai', 'ai', 2.99, 17, 9, 'geen idee', 'badtoy.jpg');

CREATE TABLE `userdata` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int NOT NULL,
  `admin` enum('no','yes') NOT NULL DEFAULT 'no',
  `pfp` varchar(100) DEFAULT NULL
);

INSERT INTO `userdata` (`username`, `password`, `id`, `admin`, `pfp`) VALUES
('sanderei', '$2y$10$KtxiLXjL.fmuLmBOLfG4u.YRwJy50ohHNpXLV/yHRgHypT2Is293e', 24, 'yes', 'badtoy.jpg'),
('testuser', '$2y$10$3nakWazf9NgpoeUC9/J6vOG2pRA0VLFS8i00uDPsoytooA8KuKV9.', 26, 'no', NULL);


ALTER TABLE `gamemerch`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `gamemerch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `userdata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

