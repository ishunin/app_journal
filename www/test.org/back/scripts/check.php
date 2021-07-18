<?php
# подключаем конфиг
#include 'conf.php';  
#Проверяем уровень доступа - если не соответствует - сразу редиирект

if (isset($_COOKIE['user_level']) && $level) {
  if (!in_array($_COOKIE['user_level'], $level)) {
    header('Location:  /permitted.php'); exit();  
  }
}


# проверка авторизации
if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {    
    #echo "<br>".$_COOKIE['id'].$_COOKIE['hash'];
    $userdata = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM users WHERE ID = '".intval($_COOKIE['id'])."' LIMIT 1"));
    #------------------------------
    #сверяемся с базой что последняя запись открытой смены равна текущему пользователю
     $res = mysqli_fetch_assoc(mysqli_query($link,"SELECT ID, id_user, status, create_date, end_date FROM `shift` ORDER BY `ID` DESC LIMIT 1"));
     
     if(($res['id_user']!== $_COOKIE['id']) && @$_COOKIE['permissions']==$_COOKIE['hash'].'1') {
      setcookie('id', '', time() - 60*60*24*30, '/');
      setcookie('hash', '', time() - 60*60*24*30, '/');
      setcookie('errors', 'Тебя то-то кикнул', time() + 60*60*24*30, '/');
      setcookie('permissions', '', time()-60*60*24*30);
      header('Location:  /login.php'); exit();
      }


    #-------------------------------

    if(($userdata['users_hash'] !== $_COOKIE['hash']) or ($userdata['ID'] !== $_COOKIE['id'])) {
    setcookie('id', '', time() - 60*60*24*30, '/');
    setcookie('hash', '', time() - 60*60*24*30, '/');
    setcookie('errors', '2', time() + 60*60*24*30, '/');
    header('Location:  /login.php'); exit();
    }
}
else {
  setcookie('errors', '2', time() + 60*60*24*30, '/');
  header('Location:  /login.php'); exit();
}


?>