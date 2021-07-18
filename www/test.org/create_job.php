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
(isset($_POST['Executor']) && !empty($_POST['Executor'])) ? $Executor = $_POST['Executor'] : $Executor = 0;

#if (isset($_POST["Area_content"])) {
if (isset($_POST['Theme']) && !empty($_POST['Theme']) && isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {
    $action = 1;
if (empty($_POST['Area_description'])) {
    $_POST['Area_description']=mb_substr($_POST['Area_content'], 0, 420);
}
    //Иначе вставляем данные, подставляя их в запрос
    #$sql = mysqli_query($link, "INSERT INTO `list` (`jira_num`, `content`, `action`, `Author`, `Destination`, `Edit_date`, `Create_date`) VALUES 
    #('{$_POST['Jira_num']}', '{$_POST['Area_content']}', '{$_POST['Action']}','{$_POST['Author']}','{$_POST['Destination']}',123,123)");
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
  $sql = mysqli_query($link, "INSERT INTO `jobs` 
  (`theme`, `description`,`content`,`id_user`, `status`, `importance`,`keep`,`create_date`,`edit_date`,`type`,`executor`,`start_task`,`end_task`,`delay_date`)  VALUES
  ( '$Theme', '$Area_description', '$Area_content', $id_user,
  $Status,$Importance,$Keep, NOW(), NOW(),$Type,$Executor,NULL,NULL,'$Delay_date')");
}
else {
  $sql = mysqli_query($link, "INSERT INTO `jobs` 
  (`theme`, `description`,`content`,`id_user`, `status`, `importance`,`keep`,`create_date`,`edit_date`,`type`,`executor`,`start_task`,`end_task`,`delay_date`)  VALUES
  ( '$Theme', '$Area_description', '$Area_content', $id_user,
  $Status,$Importance,$Keep, NOW(), NOW(),$Type,$Executor,NULL,NULL,NULL)");
}
    if ($sql) {
      $_SESSION['success_action']=1;
      $sql_last_id = mysqli_query($link, "SELECT `ID` FROM `jobs`  WHERE id=LAST_INSERT_ID()");
      $last_id_res = mysqli_fetch_array($sql_last_id);
      $last_id = $last_id_res['ID'];
       #Вносим запись в news_changes######################
       $sql2 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
       ($last_id, 1, $id_user,NOW(),$Status, $Type, $Importance,$Executor,0)");
       if (!$sql2) {
         echo 'ошибка'.mysqli_error($link);
         exit();
       }
       #################################################
      header('location:jobs.php?add='.$action);
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
  else {
  header('location:jobs.php?error=1');
  }
