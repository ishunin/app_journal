<?php
 #проверяем наличие прав доступа
 $allow=0;
 $userdata = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM users WHERE ID = '".intval($_COOKIE['id'])."' LIMIT 1")); 
 
   //  if (is_shift_open($id_shift, $link) == 1) {
     $allow = is_allow($userdata['users_hash'], $userdata['ID']);
     if ($allow){
      include "notification.php";
     }

?>