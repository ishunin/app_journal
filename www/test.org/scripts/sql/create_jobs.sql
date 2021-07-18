CREATE TABLE IF NOT EXISTS `jobs` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `theme` text,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `id_user` int NOT NULL,
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` boolean,
  `create_date` DATETIME NOT NULL,
  `edit_date` DATETIME NOT NULL,
  `type` int NOT NULL,
  `executor` int NOT NULL,
  `start_task` DATETIME NOT NULL,
  `end_task` DATETIME NOT NULL,

  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;