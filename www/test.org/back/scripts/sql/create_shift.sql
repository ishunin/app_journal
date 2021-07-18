CREATE TABLE IF NOT EXISTS `shift` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `status` boolean,
  `create_date` TIMESTAMP NOT NULL,
  `end_date` TIMESTAMP NOT NULL,

  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;