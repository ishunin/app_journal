<?php
# подключаем конфиг
#include 'conf.php';  
#Проверяем уровень доступа - если не соответствует - сразу редиирект
/*
0 - обычный пользователь
1 - дежурный ИТ
2 - 
3 - ОБ
4 - 
5 - Супер пользователь
*/

#Проверяем разрешен ли доступ на уровне страницы
if (isset($_COOKIE['permissions']) && $level_access) {
  $allow = is_allow($_COOKIE['permissions'],$level_access);
  if (!$allow) {
    header('Location: http://localhost/prohibit.php'); exit();
  }
}

# проверка авторизации
if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {    
    $userdata = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM users WHERE ID = '".intval($_COOKIE['id'])."' LIMIT 1"));
    #------------------------------
    #сверяемся с базой что последняя запись открытой смены равна текущему пользователю
     $res = mysqli_fetch_assoc(mysqli_query($link,"SELECT ID, id_user, status, create_date, end_date FROM `shift` ORDER BY `ID` DESC LIMIT 1"));
     
     if(($res['id_user']!== $_COOKIE['id']) && @$_COOKIE['permissions']==1) {
      setcookie('id', '', time() - 60*60*24*30, '/');
      setcookie('hash', '', time() - 60*60*24*30, '/');
      setcookie('errors', 'Тебя то-то кикнул', time() + 60*60*24*30, '/');
      setcookie('permissions', '', time()-60*60*24*30);
      header('Location: http://localhost/login.php'); exit();
      }
    #-------------------------------
    if(($userdata['users_hash'] !== $_COOKIE['hash']) or ($userdata['ID'] !== $_COOKIE['id'])) {
    setcookie('id', '', time() - 60*60*24*30, '/');
    setcookie('hash', '', time() - 60*60*24*30, '/');
    setcookie('errors', '2', time() + 60*60*24*30, '/');
    header('Location: http://localhost/login.php'); exit();
    }
}
else {
  setcookie('errors', '2', time() + 60*60*24*30, '/');
  header('Location: http://localhost/login.php'); exit();
}


?>