<?php
session_start();
include ("func.php");
include ("scripts/conf.php");
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['type']) && !empty($_POST['type'])) ? $type = $_POST['type'] : $type = 0;
(isset($_POST['type_rec']) && !empty($_POST['type_rec'])) ? $type_rec = $_POST['type_rec'] : $type_rec = 0;
(isset($_POST['name']) && !empty($_POST['name'])) ? $name = check_input($link_account,$_POST['name']) : $name = $_FILES["userfile"]["name"];
(isset($_POST['id_rec']) && !empty($_POST['id_rec'])) ? $id_rec = check_input($link_account,$_POST['id_rec']) : $id_rec = '';
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';
(isset($_POST['page_back']) && !empty($_POST['page_back'])) ? $page_back = $_POST['page_back'] : $page_back = '';
$name_orig =  $_FILES["userfile"]["name"];
$size = $_FILES["userfile"]["size"];
$type_file =  get_file_extension($_FILES["userfile"]["name"]);
$blacklist = array(".php", ".phtml", ".php3", ".php4");
 foreach ($blacklist as $item) {
  if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
   echo "Недопустимый тип файла";
   exit;
   }
  }

if ( $_FILES["userfile"]["error"]!= UPLOAD_ERR_OK){
	switch($_FILES["userfile"]["error"]){
		case UPLOAD_ERR_INI_SIZE:
			echo "Превышен максимально допустимый размер"; break;
		case UPLOAD_ERR_FORM_SIZE:
			echo "Превышено значение MAX_FILE_SIZE"; break;
		case UPLOAD_ERR_PARTIAL:
			echo "Файл загружен частично"; break;
		case UPLOAD_ERR_NO_FILE:
			echo "Файл не был загружен"; break;
		case UPLOAD_ERR_NO_TMP_DIR:
			echo "Отсутствует временная папка"; break;
		case UPLOAD_ERR_CANT_WRITE:
			echo "Не удалось записать файл не диск";
	}
} else {
	//файл загружен
	echo "Размер загруженного файла: " . $_FILES["userfile"]["size"];
	echo "Тип загруженного файла: " . $_FILES["userfile"]["type"];
	move_uploaded_file($_FILES["userfile"]["tmp_name"], "upload/" . $_FILES["userfile"]["name"]);
	$sql = "INSERT INTO `uploads`(`id_rec`,`name`,`comment`,`type`,`name_orig`,`size`,`date`,`id_user`,`deleted`,`type_file`) VALUES 
	('$id_rec','$name','$comment',$type,'$name_orig',$size,NOW(),$id_user,0,'$type_file')";
	$query = mysqli_query($link,$sql);
    if ($query) {
		#Вносим запись в news_changes	
		$sql_last_id = mysqli_query($link, "SELECT `id` FROM `uploads`  WHERE id=LAST_INSERT_ID()");
		$last_id_res = mysqli_fetch_array($sql_last_id);
		$id_file = $last_id_res['id'];

		#Пишем изменнеия в разные таблицы изменений исходя из параметра $typr_rec
		if ($type_rec==1){
			$sql = mysqli_query($link, "SELECT `id_rec` FROM `list` WHERE `id`=$id_rec"); 
			$row = mysqli_fetch_assoc($sql);
			if ($row) {
				$id_rec = $row['$id_rec'] ;
			} 
			$sql2 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
			('$id_rec', 7, $id_user, NOW(), 0, 0, 0,$id_file)");
		}
		else if ($type_rec==2){
			$sql2 = mysqli_query($link, "INSERT INTO `news_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
			($id_rec, 7, $id_user, NOW(), 0, 0, 0,$id_file)");
		}
		else if ($type_rec==3){
			$sql2 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
			($id_rec, 7, $id_user, NOW(), 0, 0, 0,0,$id_file)");
		}
        $_SESSION['success_action']=1;
        header('location:'.$page_back);
        }
        else {
            printf("Ошибка: %s\n", mysqli_error($link));
        }

    }
