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
if (isset($_POST['Theme']) && !empty($_POST['Theme']) && isset($_POST['Area_content']) && !empty($_POST['Area_content'])) {
    $action = 1;
    /*
if (empty($_POST['Area_description'])) {
    $_POST['Area_description']=mb_substr($_POST['Area_content'], 0, 420);
}
*/

    //Иначе вставляем данные, подставляя их в запрос
    #$sql = mysqli_query($link, "INSERT INTO `list` (`jira_num`, `content`, `action`, `Author`, `Destination`, `Edit_date`, `Create_date`) VALUES 
    #('{$_POST['Jira_num']}', '{$_POST['Area_content']}', '{$_POST['Action']}','{$_POST['Author']}','{$_POST['Destination']}',123,123)");
  $sql = mysqli_query($link, "INSERT INTO `news` 
  (`theme`, `description`,`content`,`id_user`, `status`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
  ( '{$_POST['Theme']}', '{$_POST['Area_description']}', '{$_POST['Area_content']}', '{$_COOKIE['id']}',
  {$_POST['Status']},{$_POST['Importance']},{$_POST['Keep']}, NOW(), NOW(),{$_POST['Type']})");


    if ($sql) {
      $_SESSION['success_action']=1;
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
  

 #}


 ?>