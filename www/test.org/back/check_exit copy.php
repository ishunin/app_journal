
<?php
if(isset($_GET['exit']) && $_GET['exit']==1) {

  echo $_COOKIE['permissions'];
  exit();
  #закрываем смену в БД только если авторизация была с правами дежурного
if (isset($_COOKIE['permissions']) && $_COOKIE['permissions']==1) {
  $sql = mysqli_query($link, "UPDATE `shift` SET `status` = 0,`end_date`=NOW() WHERE `status`=1");
if ($sql) {
     echo 'смена закрыта';
     # echo '<p>Успешно!</p>';

    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';

    }
  }
  SetCookie("id","");
   SetCookie("hash","");
   SetCookie("permissions","");
   
   header('Location: login.php'); exit();
   }
   else {
     echo 'asd';
     exit();
   }
?>