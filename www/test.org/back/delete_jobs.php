<?php
session_start();
include("scripts/conf.php");
  if (isset($_POST['del_id'])) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    $sql = mysqli_query($link, "DELETE FROM `jobs` WHERE `ID` = {$_POST['del_id']}");
    if ($sql) {
    	$_SESSION['success_action']=3;
      if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
        header('location:'.$_POST['page_back']);
      }
      else
    header('location:index.php?add='.$action);
    #  echo "<p>Запись удалена.</p>";
    } else {
    	header('location:jobs.php?error=5');
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }

?>
