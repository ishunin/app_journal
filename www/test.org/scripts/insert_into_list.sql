INSERT INTO `list` (`ID`, `ID_rec`, `ID_shift`,`Jira_num`, `Content`,`Action`, `ID_user`, `Destination`, `status`,`importance`,`keep`,`Create_date`,`Edit_date`) VALUES
(1, 1, 1,'INM-1245', '3.06/R3/U28-31/ ЦОД Москва: 1 IBM DS5300#1 Аварийная индикация S/N:78K099H', 'Ничего не делал...',1, '3.22/R23/U12',1,1,1, NOW(), NOW()),
(2, 11,1,'INM-1246', '3.06/R3/U28-31/ ЦОД Москва: 2 IBM DS5300#1 Аварийная индикация S/N:78K099H', 'Ничего не делал...',1, '3.22/R23/U12',1,1,1, NOW(), NOW()),
(3, 12,1,'INM-1247', '3.06/R3/U28-31/ ЦОД Москва: 3 IBM DS5300#1 Аварийная индикация S/N:78K099H', 'Ничего не делал...',2, '3.22/R23/U12',1,1,1, NOW(), NOW());

`ID` int NOT NULL AUTO_INCREMENT,
  `ID_rec` int NOT NULL,
  `ID_shift` int NOT NULL,
  `Jira_num` varchar(10),
  `Content` text NOT NULL,
  `Action` text,
  `ID_user` int NOT NULL,
  `Destination` varchar(60),
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` boolean,
  `Create_date` DATETIME NOT NULL,
  `Edit_date` DATETIME NOT NULL,