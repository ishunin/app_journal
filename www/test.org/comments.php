<?php
include ("scripts/conf.php");
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date` FROM `comments` 
	'); 
$count=0;
 while ($result = mysqli_fetch_array($sql)) {
 	$count++;
      $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['ID']."");
      $result_user = mysqli_fetch_array($sql_user); 
      $content_comment = mb_substr(strip_tags_smart($result2['content']), 0, 1000); 
echo '
<div class="post">
  <div class="user-block">
  <img class="img-circle img-bordered-sm" src="dist/img/user1-128x128.jpg" alt="user image">
  <span class="username">
    <a href="#">'.$result_user['id_user'].'</a>
  </span>
  <span class="description">Опубликовано- '.$result['create_date'].'</span>
  </div>
  <!-- /.user-block -->
  <p>
  '.$content_comment.'
  </p>
  <p>
  <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Прикрепленный файл</a>
  </p>                   
</div>
';
 }
 if ($count=0) {
 	echo '
   <blockquote class="quote-secondary">
      <small>Для данного инцидента еще никто не оставил комментария.</small>
   </blockquote>
 	';
 }
