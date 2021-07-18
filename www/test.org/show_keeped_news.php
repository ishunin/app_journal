<?php
 $sql = mysqli_query($link, 'SELECT * FROM `news` WHERE  `keep`=1 AND `deleted`=0 ORDER BY create_date DESC');
 echo '<tbody>';
 while ($result = mysqli_fetch_array($sql)) {
  $count_keep_record ++;
  $ID=$result['ID'];
   $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
   $result_user = mysqli_fetch_array($sql_user);
   $description = trim(mb_substr(strip_tags($result['description']), 0, 1000));  
   $content=mb_substr(strip_tags_smart($result['content']),0,500).' ...';
   $theme=strip_tags($result['theme']);
   $uploads = show_upload_files($link,$result['ID'],1,'index.php',2);
   if (isset($description) && !empty($description)) {
      $content_sh = $description;
    }
    else {
      $content_sh = $content;
    }
     //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
     $res = is_this_news_new($link,$ID);
     $new_news_notify = '';
     if ($res) {
       $new_news_notify = '<span class="right badge badge-danger">НОВАЯ!</span>&nbsp;';
     }

 $str_keep .='
<div class="'.get_class_for_keeped_news($result['importance']).'" style="margin-bottom:3px;">
  <h5><i class="far fa-envelope-open"></i> '.$new_news_notify.$theme.'</i></h5>
  <p style="margin-bottom:0px;">'.$content_sh.'</p>
  '.$uploads.'
  <div style="display:inline;"><small><a href="one_page_news.php?ID='.$result['ID'].'">
  <i class="fas fa-share mr-1"></i>Перейти</h5></a></small></div>
    <div style="text-align:right;display:inline;float:right;"><small>Опубликованно: '.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['Create_date'].'</small>
  </div>
  <div style="clear: right;"></div>
</div>
';

 }
 ?>
