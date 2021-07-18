
<?php
if(isset($_GET['exit']) && $_GET['exit']==1) {
  SetCookie("id","");
   SetCookie("hash","");
   SetCookie("permissions","");
   #закрываем смену в БД
  $sql = mysqli_query($link, "UPDATE `shift` SET `status` = 0,`end_date`=NOW() WHERE `status`=1");
if ($sql) {
     echo 'смена закрыта';
     # echo '<p>Успешно!</p>';

    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';

    }

   header('Location: login.php'); exit();
   }
?>