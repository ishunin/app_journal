<?php


#echo $_POST['id_user'];
#echo '<br>';
#echo $data['ID'];


  #echo '<br>'.$data['ID'];
    

#обрабатываем ошибки авторизации сессии
#POSt['error']==1 - обычный сценарий
#POSt['error']==2 - кто-то не закрыл смен
#POSt['error']==3 - текущи пользователь не закрыл смену

#пишем в бд запись о новой смене
echo $_POST['error'];
  #exit();

#echo 'status'.$res['status'];

#последнююоткрытую смену
$sql = mysqli_query($link, "SELECT * FROM `shift` WHERE status=1 LIMIT 1");
$res = mysqli_fetch_array($sql);
$cur_shift_user=0;
if ($res) {
#есть открытая смена, полчаем id пользователя который ее открыл
$cur_shift_user = $res['id_user'];
$is_shift_open=1;
}
else {
	#Нет открытой смен, ставим флаг
$is_shift_open=0;
}

#echo $res['id_user'].' '.$data['ID'];
//exit();


if ($is_shift_open==1) {
#если смена открыта
	if ($cur_shift_user!=$data['ID']) {
		#Если юерз в уже существующей открытой смене не равен текущему - закрываем старую смену, создаем новую смену
		$sql = mysqli_query($link, "UPDATE `shift` SET `status` = 0,`end_date`=NOW() WHERE `status`=1");
		if ($sql) {
     	echo 'смена закрыта';
     	#Открываем новую смену
     	}
     	$sql = mysqli_query($link, "INSERT INTO `shift` 
 		 (`id_user`, `status`,`create_date`)  VALUES
  		(".$data['ID'].", 1,NOW())");
    	if ($sql) {
		 echo 'открыта новая смена';
		 include ("copy_list.php");
     	# echo '<p>Успешно!</p>';
    	} 
	  }
	}

	else {
	#Иначе просто открываем новую смену	
 	$sql = mysqli_query($link, "INSERT INTO `shift` 
	(`id_user`, `status`,`create_date`)  VALUES
	(".$data['ID'].", 1,NOW())");
	if ($sql) {
	echo 'открыта новая смена';
	include ("copy_list.php");
	# echo '<p>Успешно!</p>';
	} else {
 		echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
		}
	}


echo '<br>'.$_POST['error'];
 #exit();
?>