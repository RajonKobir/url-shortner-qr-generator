CREATE TABLE `urls` (
  `id` int(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `shorturl` varchar(255) NOT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT current_timestamp(6)
)