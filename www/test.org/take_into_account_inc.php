<?php
session_start();
include("scripts/conf.php");
  if ((isset($_GET['id_rec']) AND !empty($_GET['id_rec'])) AND (isset($_GET['ID']) AND !empty($_GET['ID']))) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    //mysqli_query($link, "INSERT INTO `jobs` 
  //(`theme`, `description`,`content`,`id_user`, `status`, `importance`,`keep`,`create_date`,`edit_date`,`type`,`executor`,`start_task`,`end_task`)  VALUES
  //( '$Theme', '$Area_description', '$Area_content', $id_user,
  //$Status,$Importance,$Keep, NOW(), NOW(),$Type,$Executor,NULL,NULL)");
    $id_user = $_COOKIE['id'];
    $ID = $_GET['ID'];
    $id_record = $_GET['id_rec'];
    //echo $id_record;
    //echo $id_user;
    //exit();
    $sql = mysqli_query($link, "INSERT INTO `checked_record_inc` (`id_record`,`id_user`) VALUES ('$id_record', $id_user)");
    if ($sql) {
    $_SESSION['success_action']=5;
        $sql2 = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
    ('$id_record', $id_user, 'Принято к сведению.', 0, 0, NOW(), NOW(),'1')");

    header('location:one_page.php?ID='.$ID);
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
?>