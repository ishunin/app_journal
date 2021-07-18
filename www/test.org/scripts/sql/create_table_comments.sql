CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_rec` int NOT NULL,
  `id_user` int NOT NULL,
  `content` text NOT NULL,
  `importance` int NOT NULL,
  `keep` boolean,
  `create_date` TIMESTAMP NOT NULL,
  `edit_date` TIMESTAMP NOT NULL,

  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;