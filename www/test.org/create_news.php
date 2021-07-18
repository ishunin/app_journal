<?php 
session_start();
include "func.php";
#инициализируем в переменную параметр чекбокса 'закрепить'
if ( isset($_POST['Keep']) == true ) {
     $_POST['Keep']=1;
}
else {
    $_POST['Keep']=0;
}
 //Если переменная Name передана
#удалить потом, временно
include("scripts/conf.php");
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['Theme']) && !empty($_POST['Theme'])) ? $Theme = check_input($link,$_POST['Theme']) : $Theme = '';
(isset($_POST['Area_description']) && !empty($_POST['Area_description'])) ? $Area_description = check_input($link,$_POST['Area_description']) : $Area_description = '';
(isset($_POST['Area_content']) && !empty($_POST['Area_content'])) ? $Area_content = check_input($link,$_POST['Area_content']) : $Area_content = '';
(isset($_POST['Status']) && !empty($_POST['Status'])) ? $Status = $_POST['Status'] : $Status = 0;
(isset($_POST['Importance']) && !empty($_POST['Importance'])) ? $Importance = $_POST['Importance'] : $Importance = 0;
(isset($_POST['Keep']) && !empty($_POST['Keep'])) ? $Keep = $_POST['Keep'] : $Keep = 0;
(isset($_POST['Type']) && !empty($_POST['Type'])) ? $Type = $_POST['Type'] : $Type = 0;
if (isset($_POST['Theme']) && !empty($_POST['Theme']) && isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {
    $action = 1;
  $sql = mysqli_query($link, "INSERT INTO `news` 
  (`theme`, `description`,`content`,`id_user`, `status`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
  ( '$Theme', '$Area_description', '$Area_content', $id_user,
  $Status,$Importance,$Keep, NOW(), NOW(),$Type)");
    if ($sql) {
      $_SESSION['success_action']=1;
      $sql_last_id = mysqli_query($link, "SELECT `ID` FROM `news`  WHERE id=LAST_INSERT_ID()");
      $last_id_res = mysqli_fetch_array($sql_last_id);
      $last_id = $last_id_res['ID'];
      $sql2 = mysqli_query($link, "INSERT INTO `checked_record` (`id_record`,`id_user`) VALUES ( $last_id, $id_user)");
      $sql3 = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
    ('$last_id', $id_user, 'Принято к сведению.', 0, 0, NOW(), NOW(),'2')");
       #Вносим запись в news_changes######################
       $sql4 = mysqli_query($link, "INSERT INTO `news_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
       ($last_id, 1, $id_user,NOW(),$Status, $Type, $Importance,0)");
       if (!$sql4) {
         echo 'ошибка';
         exit();
       }
       #################################################
 
      header('location:news.php?add='.$action);
     # echo '<p>Успешно!</p>';
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
  else {
  header('location:news.php?error=1');
    #echo "валидация не пройдена";
  }
