<?php
session_start();
include "func.php";
#инициализируем в переменную параметр чекбокса 'закрепить'
if (isset($_POST['Keep']) == true) {
  $_POST['Keep'] = 1;
} else {
  $_POST['Keep'] = 0;
}
include("scripts/conf.php");
if (isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {
  (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
  (isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
  (isset($_POST['Jira_num']) && !empty($_POST['Jira_num'])) ? $Jira_num = check_input($link, $_POST['Jira_num']) : $Jira_num = '';
  (isset($_POST['Area_content']) && !empty($_POST['Area_content'])) ? $Area_content = check_input($link, $_POST['Area_content']) : $Area_content = '';
  (isset($_POST['Area_action']) && !empty($_POST['Area_action'])) ? $Action = check_input($link, $_POST['Area_action']) : $Action = '';
  (isset($_POST['Destination']) && !empty($_POST['Destination'])) ? $Destination = check_input($link, $_POST['Destination']) : $Destination = '';
  (isset($_POST['Status']) && !empty($_POST['Status'])) ? $Status = $_POST['Status'] : $Status = 0;
  (isset($_POST['Importance']) && !empty($_POST['Importance'])) ? $Importance = $_POST['Importance'] : $Importance = 0;
  (isset($_POST['Type']) && !empty($_POST['Type'])) ? $Type = $_POST['Type'] : $Type = 1;
  (isset($_POST['Keep']) && !empty($_POST['Keep'])) ? $Keep = $_POST['Keep'] : $Keep = 0;



  $action = 2;
  $last_shift_id = get_last_shift_id($link);

    //Форматируем дату в DateTime
    if (isset($_POST['Delay_date']) && !empty($_POST['Delay_date'])) {
      $string = $_POST['Delay_date']; // наша дата в string
      $format = 'm/d/Y'; // формат даты
      $date = DateTime::createFromFormat($format, $string); // получаем объект datetime
      $day = $date->format('d');
      $month = $date->format('m'); 
      $year = $date->format('Y');
      $Delay_date = $year.'-'.$month.'-'.$day.' 00:00:00';
      $sql2 = mysqli_query($link, "SELECT `id_rec`,`status`,`importance`,`type`  FROM `list` WHERE `ID`=$id"); 
      $sql = mysqli_query($link, "UPDATE `list` SET `id_shift`= $last_shift_id,`jira_num` = '$Jira_num',`content` = '$Area_content',`action` = '$Action',`destination` = '$Destination', `status` = $Status, `importance` = $Importance, `type` = $Type, `keep` = $Keep, `edit_date` = now(), `id_user_edited`=$id_user, `delay_date`='$Delay_date'  WHERE `ID`=$id");
      if ($sql2) {
        while ($result_cur = mysqli_fetch_array($sql2)) {
          $id_rec_cur = $result_cur['id_rec'];
          $delay_date_cur = $result_cur['delay_date'];
          $status_cur = $result_cur['status'];
          $importance_cur = $result_cur['importance'];
          $type_cur = $result_cur['type'];  
          $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
          ('$id_rec_cur', 3, $id_user,NOW(),$Status, $Type, $Importance,0)");
          if ($status_cur != $Status) {
            $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
            ('$id_rec_cur', 4, $id_user,NOW(),$Status, $Type, $Importance,0)");
          }
          if ($importance_cur != $Importance) {
           $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
           ('$id_rec_cur', 5, $id_user,NOW(),$Status, $Type, $Importance,0)");
          }
          if ($type_cur != $Type) {
            $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
           ('$id_rec_cur', 6, $id_user,NOW(),$Status, $Type, $Importance,0)");          
          }
        }  
      }
       #++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    }
      else {
        $sql2 = mysqli_query($link, "SELECT `id_rec`,`status`,`importance`,`type`  FROM `list` WHERE `ID`=$id"); 
        $sql = mysqli_query($link, "UPDATE `list` SET `id_shift`= $last_shift_id,`jira_num` = '$Jira_num',`content` = '$Area_content',`action` = '$Action',`destination` = '$Destination', `status` = $Status, `importance` = $Importance, `type` = $Type, `keep` = $Keep, `edit_date` = now(), `id_user_edited`=$id_user, `delay_date`=NULL  WHERE `ID`=$id");
        if ($sql2) {
          while ($result_cur = mysqli_fetch_array($sql2)) {
            $id_rec_cur = $result_cur['id_rec'];
            $status_cur = $result_cur['status'];
            $importance_cur = $result_cur['importance'];
            $type_cur = $result_cur['type'];  
            $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
            ('$id_rec_cur', 3, $id_user,NOW(),$Status, $Type, $Importance,0)");
            if ($status_cur != $Status) {
              $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
              ('$id_rec_cur', 4, $id_user,NOW(),$Status, $Type, $Importance,0)");
            }
            if ($importance_cur != $Importance) {
             $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
             ('$id_rec_cur', 5, $id_user,NOW(),$Status, $Type, $Importance,0)");
            }
            if ($type_cur != $Type) {
              $sql3 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
             ('$id_rec_cur', 6, $id_user,NOW(),$Status, $Type, $Importance,0)");          
            }
          }  
        }
         #++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      }

  //$sql = mysqli_query($link, "UPDATE `list` SET `id_shift`= $last_shift_id,`jira_num` = '$Jira_num',`content` = '$Area_content',`action` = '$Action',`destination` = '$Destination', `status` = $Status, `importance` = $Importance, `type` = $Type, `keep` = $Keep, `edit_date` = now(), `id_user_edited`=$id_user, `delay_date`='$Delay_date'  WHERE `ID`=$id");
  if ($sql) {
    $_SESSION['success_action'] = 2;
    if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
      header('location:' . $_POST['page_back']);
    } else
      header('location:index.php?add=' . $action);
  } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
  }
} else {
  header('location:index.php?error=1');
  #echo "валидация не пройдена";
}
