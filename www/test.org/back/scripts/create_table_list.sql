CREATE TABLE IF NOT EXISTS `list` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_rec` int NOT NULL,
  `ID_shift` int NOT NULL,
  `Jira_num` varchar(10),
  `Content` text NOT NULL,
  `Action` text,
  `ID_user` int NOT NULL,
  `Destination` varchar(60),
  `Create_date` DATETIME NOT NULL,
  `Edit_date` DATETIME NOT NULL,

  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;