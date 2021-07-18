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

if (isset($_POST['error']) && $_POST['error']==2) {
	if ($res['id_user']==$data['ID'] && $res['status']==1) {
	# Существует открытая смена текущего пользователя - просто продолжаем ее	
	echo "сценарий3";
	#exit();
	}
	else if ($res['status']==1){
	#принудительно закрываем смену, открываем новую
	 $sql = mysqli_query($link, "UPDATE `shift` SET `status` = 0,`end_date`=NOW() WHERE `status`=1");
		if ($sql) {
     	echo 'смена закрыта';
     	#Открываем новую смену
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

    	#exit();

    	} else {
      	echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';

    	}	
		echo "сценарий 2";
		#exit();
		}

		else {
				#иначе стандартный сценарий, просто создаем новую смену
			
			$sql = mysqli_query($link, "INSERT INTO `shift` 
			  (`id_user`, `status`,`create_date`)  VALUES
			  (".$data['ID'].", 1,NOW())");
			    if ($sql) {
			     echo 'открыта новая смена';
			     # echo '<p>Успешно!</p>';
				 #exit();
				 include ("copy_list.php");

			    } else {
			      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';

			    }
		}
}

echo '<br>'.$_POST['error'];
 #exit();
?>