<?php
session_start();
include "func.php";
include("scripts/conf.php");
#инициализируем в переменную параметр чекбокса 'закрепить'
if ( isset($_POST['Keep']) == true ) {
     $_POST['Keep']=1;
}
else {
    $_POST['Keep']=0;
}
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['Theme']) && !empty($_POST['Theme'])) ? $Theme = check_input($link,$_POST['Theme']) : $Theme = '';
(isset($_POST['Area_description']) && !empty($_POST['Area_description'])) ? $Area_description = check_input($link,$_POST['Area_description']) : $Area_description = '';
(isset($_POST['Area_content']) && !empty($_POST['Area_content'])) ? $Area_content = check_input($link,$_POST['Area_content']) : $Area_content = '';
(isset($_POST['Status']) && !empty($_POST['Status'])) ? $Status = $_POST['Status'] : $Status = 0;
(isset($_POST['Importance']) && !empty($_POST['Importance'])) ? $Importance = $_POST['Importance'] : $Importance = 0;
(isset($_POST['Keep']) && !empty($_POST['Keep'])) ? $Keep = $_POST['Keep'] : $Keep = 0;
(isset($_POST['Type']) && !empty($_POST['Type'])) ? $Type = $_POST['Type'] : $Type = 0;
(isset($_POST['Executor']) && !empty($_POST['Executor'])) ? $Executor = $_POST['Executor'] : $Executor = 0;
(isset($_POST['page']) && !empty($_POST['page'])) ? $page = $_POST['page'] : $page = 0;
if (isset($_POST['Delay_date']) && !empty($_POST['Delay_date'])) {
  $string = $_POST['Delay_date']; // наша дата в string
      $format = 'm/d/Y'; // формат даты
      $date = DateTime::createFromFormat($format, $string); // получаем объект datetime
      $day = $date->format('d');
      $month = $date->format('m'); 
      $year = $date->format('Y');
      $Delay_date = $year.'-'.$month.'-'.$day.' 00:00:00';
      $sql = mysqli_query($link, "UPDATE `jobs` SET `theme` = '$Theme', `description` = '$Area_description',
      `content`='$Area_content', `status` = $Status, `importance` = $Importance,`keep`=$Keep,`edit_date`= now(),`type`=$Type,`executor`=$Executor,`start_task`=NULL,`end_task`=NULL, `id_user_edited`=$id_user, `delay_date`='$Delay_date' WHERE `ID`=$id");
 }
 else {
  $sql = mysqli_query($link, "UPDATE `jobs` SET `theme` = '$Theme', `description` = '$Area_description',
  `content`='$Area_content', `status` = $Status, `importance` = $Importance,`keep`=$Keep,`edit_date`= now(),`type`=$Type,`executor`=$Executor,`start_task`=NULL,`end_task`=NULL, `id_user_edited`=$id_user, `delay_date`=NULL WHERE `ID`=$id");
 }

if (isset($Theme) && !empty($Theme) && isset($Area_content) && !empty($Area_content)) {
    $action = 2;
    $sql2 = mysqli_query($link, "SELECT `status`,`importance`,`type`,`executor`  FROM `jobs` WHERE `ID`=$id");
   
    if ($sql) {
        #Вносим запись в news_changes+++++++++++++++++++++++++++++++     
        if ($sql2) {

          while ($result_cur = mysqli_fetch_array($sql2)) {
            $status_cur = $result_cur['status'];
            $importance_cur = $result_cur['importance'];
            $type_cur = $result_cur['type'];
            $id_exec_cur = $result_cur['executor'];
            $sql3 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
            ($id, 3, $id_user,NOW(),$Status, $Type, $Importance,$Executor,0)");
            if ($status_cur != $Status) {
              $sql3 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
              ($id, 4, $id_user,NOW(),$Status, $Type, $Importance,$Executor,0)");
            }
            if ($importance_cur != $Importance) {
             $sql3 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
             ($id, 5, $id_user,NOW(),$Status, $Type, $Importance,$Executor,0)");
            }
            if ($type_cur != $Type) {
              $sql3 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
             ($id, 6, $id_user,NOW(),$Status, $Type, $Importance,$Executor,0)"); 
            }
            if ($id_exec_cur != $Executor) {
              $sql3 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
             ($id, 9, $id_user,NOW(),$Status, $Type, $Importance,$Executor,0)"); 
             echo $id_exec_cur;
             echo $Executor;
             //exit();
            }
          }  
        }
         #++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      $_SESSION['success_action']=2;
      if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
        header('location:'.$_POST['page_back'].'?page='.$page);
      }
      else
    header('location:index.php?add='.$action);
     # echo '<p>Успешно!</p>';

    }else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      exit();
    }
  }
  else {
  header('location:index.php?error=1');
  }
