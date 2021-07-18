<?php

session_start();
include "func.php";
#инициализируем в переменную параметр чекбокса 'закрепить'
if (isset($_POST['Keep']) == true) {
  $_POST['Keep'] = 1;
} else {
  $_POST['Keep'] = 0;
}
//Если переменная Name передана
#удалить потом, временно
include("scripts/conf.php");
#генерируем уникальный id для записи
$uniq_id = uniqid();
$last_shift_id = get_last_shift_id($link);
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['Jira_num']) && !empty($_POST['Jira_num'])) ? $Jira_num = check_input($link, $_POST['Jira_num']) : $Jira_num = '';
(isset($_POST['Area_content']) && !empty($_POST['Area_content'])) ? $Area_content = check_input($link, $_POST['Area_content']) : $Area_content = '';
(isset($_POST['Area_action']) && !empty($_POST['Area_action'])) ? $Action = check_input($link, $_POST['Area_action']) : $Action = '';
(isset($_POST['Destination']) && !empty($_POST['Destination'])) ? $Destination = check_input($link, $_POST['Destination']) : $Destination = '';
(isset($_POST['Status']) && !empty($_POST['Status'])) ? $Status = $_POST['Status'] : $Status = 0;
(isset($_POST['Importance']) && !empty($_POST['Importance'])) ? $Importance = $_POST['Importance'] : $Importance = 0;
(isset($_POST['Type']) && !empty($_POST['Type'])) ? $Type = $_POST['Type'] : $Type = 1;

(isset($_POST['Keep']) && !empty($_POST['Keep'])) ? $Keep = $_POST['Keep'] : $Keep = 0;
if (isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {
  if (isset($_POST['Jira_num']) && trim($_POST['Jira_num']) == '') {
    $_POST['Jira_num'] = 'б/н';
  }
  if (isset($_POST['Destination']) && trim($_POST['Destination']) == '') {
    $_POST['Destination'] = 'б/р';
  }

  $action = 1;
  //Иначе вставляем данные, подставляя их в запрос
 //Форматируем дату в DateTime
if (isset($_POST['Delay_date']) && !empty($_POST['Delay_date'])) {
  $string = $_POST['Delay_date']; // наша дата в string
  $format = 'm/d/Y'; // формат даты
  $date = DateTime::createFromFormat($format, $string); // получаем объект datetime
  $day = $date->format('d');
  $month = $date->format('m'); 
  $year = $date->format('Y');
  $Delay_date = $year.'-'.$month.'-'.$day.' 00:00:00';
  echo $Delay_date;
  $sql = mysqli_query($link, "INSERT INTO `list` (`id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`, `type`,`keep`,`create_date`,`edit_date`,`delay_date`)  VALUES
  ('$uniq_id', $last_shift_id, '$Jira_num', '$Area_content', '$Action', $id_user,'$Destination', $Status, $Importance,$Type,$Keep, NOW(), NOW(),'$Delay_date')");
  
  $sql2 = mysqli_query($link, "INSERT INTO `checked_record_inc` (`id_record`,`id_user`) VALUES ('$uniq_id', $id_user)");
   if ($sql2) {
  $sql3 = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
   ('$uniq_id', $id_user, 'Принято к сведению.', 0, 0, NOW(), NOW(),'1')"); 
    
    #Вносим запись в news_changes############
   $sql_last_id = mysqli_query($link, "SELECT `ID`,`id_rec` FROM `list`  WHERE id=LAST_INSERT_ID()");
   $last_id_res = mysqli_fetch_array($sql_last_id);
   $sql4 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
   ('$uniq_id', 1, $id_user,NOW(),$Status, $Type, $Importance,0)");
   ###########################################
  }
}
  else {
    echo "Передан неверный формат даты";
   // exit();
  $sql = mysqli_query($link, "INSERT INTO `list` (`id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`, `type`,`keep`,`create_date`,`edit_date`,`delay_date`)  VALUES
  ('$uniq_id', $last_shift_id, '$Jira_num', '$Area_content', '$Action', $id_user,'$Destination', $Status, $Importance,$Type,$Keep, NOW(), NOW(),NULL)");
  $sql2 = mysqli_query($link, "INSERT INTO `checked_record_inc` (`id_record`,`id_user`) VALUES ('$uniq_id', $id_user)");
  if ($sql2) {
  $_SESSION['success_action']=5;
  $sql3 = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
  ('$uniq_id', $id_user, 'Принято к сведению.', 0, 0, NOW(), NOW(),'1')"); 
     #Вносим запись в news_changes############
     $sql_last_id = mysqli_query($link, "SELECT `ID`,`id_rec` FROM `list`  WHERE id=LAST_INSERT_ID()");
     $last_id_res = mysqli_fetch_array($sql_last_id);
     $sql4 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
     ('$uniq_id', 1, $id_user,NOW(),$Status, $Type, $Importance,0)");
     ###########################################
 }  
}
  if ($sql) {
    $_SESSION['success_action'] = 1;
    if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
      header('location:' . $_POST['page_back'] . '.php?add=' . $action);
    } else
      header('location:index.php?add=' . $action);
    # echo '<p>Успешно!</p>';


  } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
  }
} else {
  header('location:index.php?error=1');
}
