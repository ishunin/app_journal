<?php
session_start();
include("scripts/conf.php");
  if (isset($_POST['del_id'])) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    //$sql = mysqli_query($link, "DELETE FROM `list` WHERE `ID` = {$_POST['del_id']}");
    //удаляем строку из таблицы
    $id_user = $_COOKIE['id'];
    $sql = "UPDATE `list` SET `deleted`=1, `status`=5 WHERE `ID` = {$_POST['del_id']}";
    $res = mysqli_query($link,$sql);
    if ($sql) {
       #Вносим запись в news_changes############
      $sql2 = mysqli_query($link, "SELECT `ID`, `id_rec` FROM `list` WHERE `ID`={$_POST['del_id']}"); 
      $row = mysqli_fetch_assoc($sql2);
      if ($row) {
        $id_rec = $row['id_rec'] ;
       #Вносим запись в news_changes
      $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
      ('$id_rec', 2,$id_user,NOW(),5, 0, 0,0)");  
      } 
       ###########################################
      $_SESSION['success_action']=3;
      if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
        header('location:'.$_POST['page_back']);
      }
      else
    header('location:index.php?add='.$action);
     # echo '<p>Успешно!</p>';
    } else {
    	#header('location:index.php?error=5');
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
