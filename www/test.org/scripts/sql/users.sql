
CREATE TABLE `users` (
  `ID` int UNSIGNED NOT NULL,
  `users_login` varchar(30) NOT NULL,
  `users_password` varchar(32) NOT NULL,
  `users_hash` varchar(32) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `permissions` int NOT NULL,
  `deny` boolean
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





