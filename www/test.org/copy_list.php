<?php
# Вытаскиваем из БД последнюю смену
$sql = mysqli_query($link, 'SELECT ID  FROM `shift` ORDER BY ID DESC LIMIT 2');
echo '<tbody>';
$i=0;
while ($result = mysqli_fetch_array($sql)) {

$arr[$i]=$result['ID'];	
$i++;
}
echo $arr[1];
$sql = mysqli_query($link, 
"INSERT INTO `list` (ID_rec, ID_shift, Jira_num, Content, Action, ID_user, Destination, Status, Importance, Type, Keep, Create_date, Edit_date, deleted, delay_date) 
SELECT ID_rec, $arr[0], Jira_num, Content, Action, ID_user, Destination, Status, Importance, Type, Keep, Create_date, Edit_date, deleted, `delay_date`
FROM `list` WHERE `ID_shift` = $arr[1] AND Status !=4 AND `deleted`!=1 ");

if ($sql) {
   echo 'OK';
}  
else {
    echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>'; 
}
