
<?php
if (isset($_GET['exit']) && $_GET['exit'] == 1) {
  

  #закрываем смену в БД только если авторизация была с правами дежурного
  if (isset($_COOKIE['permissions']) && $_COOKIE['permissions'] == 1) {
    $sql = mysqli_query($link, "UPDATE `shift` SET `status` = 0,`end_date`=NOW() WHERE `status`=1");
    if ($sql) {
      echo 'смена закрыта';
      ##########################
      include "save_report_shift.php";
      ##########################
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
  setcookie('id', '', time() - 60 * 60 * 24 * 30, '/');
  setcookie('hash', '', time() - 60 * 60 * 24 * 30, '/');
  setcookie('permissions', '', time() - 60 * 60 * 24 * 30, '/');
  header('Location: login.php');
  exit();
}
?>