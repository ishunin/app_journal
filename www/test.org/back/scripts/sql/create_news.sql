CREATE TABLE IF NOT EXISTS `news` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `theme` text,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `id_user` int NOT NULL,
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` boolean,
  `Create_date` DATETIME NOT NULL,
  `Edit_date` DATETIME NOT NULL,
  `type` int NOT NULL,

  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;