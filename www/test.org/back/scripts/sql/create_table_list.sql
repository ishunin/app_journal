CREATE TABLE IF NOT EXISTS `list` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_rec` int NOT NULL,
  `id_shift` int NOT NULL,
  `jira_num` varchar(10),
  `content` text NOT NULL,
  `action` text,
  `id_user` int NOT NULL,
  `destination` varchar(60),
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` boolean,
  `create_date` TIMESTAMP NOT NULL,
  `edit_date` TIMESTAMP NOT NULL,

  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;