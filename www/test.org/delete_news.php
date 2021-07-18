<?php
session_start();
include("scripts/conf.php");
  if (isset($_POST['del_id'])) { //проверяем, есть ли переменная
    $del_id = $_POST['del_id'];
    $id_user = $_COOKIE['id'];
     #Вносим запись в news_changes
    $sql2 = mysqli_query($link, "INSERT INTO `news_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
    ($del_id, 2,$id_user,NOW(),0, 0, 0,0)");

    //удаляем строку из таблицы
    $sql = "UPDATE `news` SET `deleted`=1, `status`=5 WHERE `ID`=$del_id";
    $res = mysqli_query($link,$sql);
    if ($res) {
    	$_SESSION['success_action']=3;
      if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
        header('location:'.$_POST['page_back']);
      }
      else
    header('location:index.php?add='.$action);
      echo "<p>Запись удалена.</p>";
    } else {
    	header('location:news.php?error=5');
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
