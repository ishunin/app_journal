<?php

 $sql = mysqli_query($link, 'SELECT * FROM `news` WHERE  `keep`=1 ORDER BY create_date DESC');
 echo '<tbody>';
 while ($result = mysqli_fetch_array($sql)) {
  $count_keep_record ++;
   $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
   $result_user = mysqli_fetch_array($sql_user);
   $content=mb_substr(strip_tags($result['content']),0,500).' ...';
   $theme=strip_tags($result['theme']);
echo '
<div class="'.get_class_for_keeped_news($result['importance']).'">
                 <h5><i class="far fa-envelope-open"></i> ' .$theme.'</i></h5>
                  <p>'.$content.'</p>
                <div style="display:inline;"><small><a href="one_page_news.php?ID='.$result['ID'].'">
                <i class="fas fa-share mr-1"></i>Перейти</h5></a></small></div>
                     <div style="text-align:right;display:inline;float:right;"><small>Опубликованно: '.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['Create_date'].'</small>
</div>
<div style="clear: right;"></div>

      </div>
';

 }
?>