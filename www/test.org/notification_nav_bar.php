<?php
 #проверяем наличие прав доступа
$allow=0;
$level_access = array (1);
$allow = is_allow($_COOKIE['permissions'],$level_access);
if ($allow){
   include "notification.php";
} 
else {
   include "notification_others.php";
}
?>