<?php 
 //Если переменная Name передана
#удалить потом, временно
include("scripts/conf.php");
if (isset($_POST["Area_content"])) {
   if (isset($_POST['Jira_num']) && !empty($_POST['Jira_num'])) {
    //Если это запрос на обновление, то обновляем
    if (isset($_POST['ID'])) {      
        # Код дествия редактирования
        $action=3;
        #`Jira_num`, `Content`, `Action`, `Author`, `Destination`
        $sql = mysqli_query($link, "UPDATE `list` SET `Jira_num` = '{$_POST['Jira_num']}',`Content` = '{$_POST['Area_content']}',`Action` = '{$_POST['Action']}',`Author` = '{$_POST['Author']}',`Destination` = '{$_POST['Destination']}'  WHERE `ID`={$_POST['ID']}");
    } else {
    	$action = 1;
        //Иначе вставляем данные, подставляя их в запрос
        $sql = mysqli_query($link, "INSERT INTO `list` (`Jira_num`, `Content`, `Action`, `Author`, `Destination`, `Edit_date`, `Create_date`) VALUES 
        ('{$_POST['Jira_num']}', '{$_POST['Area_content']}', '{$_POST['Action']}','{$_POST['Author']}','{$_POST['Destination']}',123,123)");
    }
  
    if ($sql) {
  header('location:index.php?add='.$action);
      echo '<p>Успешно!</p>';

    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
  else {
header('location:index.php?error=1');
    echo "валидация не пройдена";
  }
 }
