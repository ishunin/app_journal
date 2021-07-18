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
#if (isset($_POST["Area_content"])) {
//if (isset($_POST['Jira_num']) && !empty($_POST['Jira_num']) && isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {

if (isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {
  
  if (isset($_POST['Jira_num']) && trim($_POST['Jira_num'])=='') {
    $_POST['Jira_num']='б/н';
  } 
  if (isset($_POST['Destination']) && trim($_POST['Destination'])=='') {
    $_POST['Destination']='б/р';
  } 
  
  $action = 2;
    //Иначе вставляем данные, подставляя их в запрос
    #$sql = mysqli_query($link, "INSERT INTO `list` (`jira_num`, `content`, `action`, `Author`, `Destination`, `Edit_date`, `Create_date`) VALUES 
    #('{$_POST['Jira_num']}', '{$_POST['Area_content']}', '{$_POST['Action']}','{$_POST['Author']}','{$_POST['Destination']}',123,123)");
  
  #$sql = mysqli_query($link, "UPDATE `list` SET (`id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date`)  VALUES
  #(1, 1, '{$_POST['Jira_num']}', '{$_POST['Area_content']}', '{$_POST['Action']}',1,'{$_POST['Destination']}', {$_POST['Status']}, {$_POST['Importance']},{$_POST['Keep']}, NOW(), NOW())");

  $last_shift_id = get_last_shift_id($link);
  
    $sql = mysqli_query($link, "UPDATE `list` SET `id_shift`= $last_shift_id,`jira_num` = '{$_POST['Jira_num']}',`content` = '{$_POST['Area_content']}',`action` = '{$_POST['Area_action']}',`id_user` = '{$_COOKIE['id']}',`destination` = '{$_POST['Destination']}', `status` = '{$_POST['Status']}', `importance` = '{$_POST['Importance']}', `keep` = '{$_POST['Keep']}', `edit_date` = now()  WHERE `ID`={$_POST['id']}");


  
    if ($sql) {
      $_SESSION['success_action']=2;
      if ((isset($_POST['page_back']) && !empty($_POST['page_back']))) {
        header('location:'.$_POST['page_back']);
      }
      else
    header('location:index.php?add='.$action);
     # echo '<p>Успешно!</p>';

    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }

  }
  else {
  header('location:index.php?error=1');
    #echo "валидация не пройдена";
  }
  

 #}


 ?>