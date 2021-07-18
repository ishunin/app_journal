<?php
$last_login=get_last_user_login($_COOKIE['id'],$link);
$current_login=get_current_user_login($_COOKIE['id'],$link);
$last_shift_id = get_last_shift_id($link);
$count_news=0;
if ($allow) {
$sql = mysqli_query($link, "SELECT *  FROM `news`  WHERE  Create_date >= '$last_login'  AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
}
else {
  $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
}
if ($sql) {
$num_rows_incidents = mysqli_num_rows($sql);
 $str_note = '';
if ($num_rows_incidents>0) {
  $str_note =    '<span class="badge badge-danger navbar-badge">'.$num_rows_incidents.'</span>';
}

echo '
<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
<i class="far fa-envelope-open"></i>
'.$str_note.'
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
';
;
$str='';
  if ($sql) {
    $count_news=0;
   while ($result = mysqli_fetch_array($sql)) {
    $count_news++;
     $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
     $result_user = mysqli_fetch_array($sql_user);
      $user_id = $result_user['ID'];

      $user_name = get_user_name_by_id($user_id,$link);
      $theme = strip_tags_smart($result['theme']);
      $theme=mb_substr($theme,0,50).'...';
      $create_date=$result['Create_date'];
    $str = "
    <a href='/one_page_news.php?ID=".$result['ID']."' class='dropdown-item'>
    <!-- Message Start -->
    <div class='media'>
      <img src='http://".$_SERVER['SERVER_ADDR']."/dist/img/$user_id.png' alt='User Avatar' class='img-size-50 mr-3 img-circle'>
      <div class='media-body'>
        <h3 class='dropdown-item-title'>
       $user_name
          <span class='".importance_class_star($result['importance'])."'><i class='fas fa-star'></i></span>
        </h3>
        <small>Важность: ".get_importance($result['importance'])."</small>
       <p class='text-sm'> <small>".$theme."</small></p>
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

if ($count_news==0) {
  echo '
  <blockquote class="quote-secondary">
     <small>Нет новостей для отображения.</small>
  </blockquote>
';
}

 echo ' <a href=" /news_new.php" class="dropdown-item dropdown-footer">Смотреть все новости</a>
        </div>
        ';
}
?>