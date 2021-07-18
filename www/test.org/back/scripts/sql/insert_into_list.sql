INSERT INTO `list` (`ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date`) VALUES
(1, 1, 1,'INM-1245', '3.06/R3/U28-31/ ЦОД Москва: 1 IBM DS5300#1 Аварийная индикация S/N:78K099H', 'Ничего не делал...',1,'3.22/R23/U12',1,1,1, NOW(), NOW()),
(2, 11,1,'INM-1246', '3.06/R3/U28-31/ ЦОД Москва: 2 IBM DS5300#1 Аварийная индикация S/N:78K099H', 'Ничего не делал...',1,'3.22/R23/U12',1,2,1, NOW(), NOW()),
(3, 12,1,'INM-1247', '3.06/R3/U28-31/ ЦОД Москва: 3 IBM DS5300#1 Аварийная индикация S/N:78K099H', 'Ничего не делал...',1,'3.22/R23/U12',1,2,1, NOW(), NOW());
 
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