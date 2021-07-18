<?php
$last_login = get_last_user_login($_COOKIE['id'], $link);
    $current_login = get_current_user_login($_COOKIE['id'], $link);
    if ($current_user_permissions==1) {
      $sql = mysqli_query($link, "SELECT *  FROM `jobs`  WHERE Create_date >= '$last_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
    }
    else {
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
    }
    /*

    if ($current_user_permissions==1){
      // $sql = mysqli_query($link, "SELECT *  FROM `jobs`  WHERE create_date >= '$last_login' AND create_date <= '$current_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
      $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (`executor`=$current_user_id OR `executor`=0) AND (`status`= 1 OR `status`=2) AND `deleted`=0");
     }
       else if ($current_user_permissions==0){
         //$sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
         $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (`executor`=$current_user_id OR `executor`=0) AND (`status`= 1 OR `status`=2) AND `deleted`=0");
       }
       else if ($current_user_permissions==5){
         $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (`id_user`=$current_user_id) AND (`status`= 1 OR `status`=2 OR `status`=3) AND `deleted`=0");
       }
       else {
         $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (Create_date >= (CURDATE() -1)) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
       }
       */
 ?>      