<?php
$current_user_id = $_COOKIE['id'];
$current_user_permissions = $_COOKIE['permissions'];
$last_login=get_last_user_login($_COOKIE['id'],$link);
$current_login=get_current_user_login($_COOKIE['id'],$link);
$last_shift_id = get_last_shift_id($link);

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
$count_jobs=0;
if ($sql) {
$num_rows_incidents = mysqli_num_rows($sql);
 $str_note = '';
if ($num_rows_incidents>0) {
  $str_note =    '<span class="badge badge-danger navbar-badge">'.$num_rows_incidents.'</span>';
}
echo '
<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
         <i class="fas fa-wrench"></i>
        '.$str_note.'
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
';
$count_jobs=0;
$str='';
   #$sql = mysqli_query($link, "SELECT *  FROM `list`  WHERE id_shift=$last_shift_id AND Create_date >= '$last_login' AND Create_date <= '$current_login'") ;
  if ($sql) {
    $count_jobs=0;
   while ($result = mysqli_fetch_array($sql)) {
      $count_jobs++; 
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);
      $user_id = $result_user['ID'];
      $user_name = get_user_name_by_id($user_id,$link);
      $theme = strip_tags_smart($result['theme']);
      $theme=mb_substr($theme,0,50).'...';
      $create_date=$result['create_date'];
if ($result['executor']!=0) {
   $executor = get_user_name_by_id($result['executor'],$link);
}
else {
  $executor = "???? ?????????? ????????????????";
}
    $str = "
    <a href='/one_page_jobs.php?ID=".$result['ID']."' class='dropdown-item'>
    <!-- Message Start -->
    <div class='media'>
      <img src='http://".$_SERVER['SERVER_ADDR']."/dist/img/$user_id.png' alt='User Avatar' class='img-size-50 mr-3 img-circle'>
      <div class='media-body'>
        <h3 class='dropdown-item-title'>
       $user_name
          <span class='".importance_class_star($result['importance'])."'><i class='fas fa-star'></i></span>
        </h3>
         <small>??????????????????????: ".$executor."</small></br>
         <small>??????: ".get_type_jobs($result['type'])."</small></br>
        <small>????????????: ".get_status($result['status'])."</small></br>
        <small>????????????????: ".get_importance($result['importance'])."</small>
     <i>  <p class='text-sm'> <small>".strip_tags($theme)."</small></p></i>
        <p class='text-sm text-muted'><i class='far fa-clock mr-1'></i>$create_date</p>
      </div>
    </div>
    <!-- Message End -->
  </a>
  <div class='dropdown-divider'></div>
    ";
    echo $str;  
 }
}

if ($count_jobs==0) {
  echo '
  <blockquote class="quote-secondary">
                  <small>?????? ?????????????? ?????? ??????????????????????.</small>
                </blockquote>
                ';
}
 
 echo ' <a href=" /jobs_new.php" class="dropdown-item dropdown-footer">???????????????? ?????? ??????????????</a>
        </div>
        ';
}
?>
