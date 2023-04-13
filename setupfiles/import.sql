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

INSERT INTO
  sdhmerchstore.gamemerch (naam, game, prijs, voorraad, beschrijving, foto, id)
VALUES
  (
    'Pickaxe',
    'Fortnite',
    19.99,
    5,
    'Fortnite Pickaxe',
    'pickaxe.jpg',
    1
  ),
  (
    'Backpack',
    'Fortnite',
    14.99,
    3,
    'Fortnite Backpack',
    'backpack.jpg',
    2
  ),
  (
    'Creeper',
    'Minecraft',
    4.99,
    5,
    'Minecraft Creeper',
    'creeper.png',
    3
  ),
  (
    'Toy plushie',
    'Toy Story',
    5.99,
    17,
    'Just a random ass toy',
    'badtoy.jpg',
    4
  ),
  (
    'struisvogel',
    'Struisvogel simulator',
    19.99,
    98,
    'Jeroen de struisvogel',
    'jeroen.jpg',
    5
  );

CREATE TABLE `userdata` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int NOT NULL,
  `admin` enum('no', 'yes') NOT NULL DEFAULT 'no',
  `pfp` varchar(100) DEFAULT NULL
);

INSERT INTO
  `userdata` (`username`, `password`, `id`, `admin`, `pfp`)
VALUES
  (
    'sanderei',
    '$2y$10$KtxiLXjL.fmuLmBOLfG4u.YRwJy50ohHNpXLV/yHRgHypT2Is293e',
    24,
    'yes',
    'badtoy.jpg'
  ),
  (
    'testuser',
    '$2y$10$3nakWazf9NgpoeUC9/J6vOG2pRA0VLFS8i00uDPsoytooA8KuKV9.',
    26,
    'no',
    NULL
  );

ALTER TABLE
  `gamemerch`
ADD
  PRIMARY KEY (`id`);

ALTER TABLE
  `userdata`
ADD
  PRIMARY KEY (`id`);

ALTER TABLE
  `gamemerch`
MODIFY
  `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;

ALTER TABLE
  `userdata`
MODIFY
  `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 27;