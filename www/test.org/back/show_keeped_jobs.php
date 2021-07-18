<?php
$id=$_COOKIE['id'];

if ($id!=0) {
  $sql = mysqli_query($link, "SELECT * FROM `jobs` WHERE  `keep`=1 AND `executor`=$id");
}
else {
  //выводить для всех
 $sql = mysqli_query($link, "SELECT * FROM `jobs` WHERE  `keep`=1");
}
 echo '<tbody>';
 while ($result = mysqli_fetch_array($sql)) {
  $count_keep_record ++;
   $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
   $result_user = mysqli_fetch_array($sql_user);
   $content=mb_substr(strip_tags($result['content']),0,500).' ...';
   $theme=strip_tags($result['theme']);
   $opacity='';
   if ($result['status']==3 || $result['status']==4) {
      $opacity = 'div-opacity';
   }

   $executor="Не имеет значения";
   if ($result['executor']!=0) {
   $sql_exec = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['executor']."");
   $result_exec = mysqli_fetch_array($sql_exec);
   $executor=$result_exec['first_name'].' '.$result_exec['last_name'];
   }
   
echo '
<div class="alert '.get_class_for_div($result['importance']).' '.$opacity.'">
<div class="ribbon-wrapper">
    <div class="ribbon bg-primary">
    <small>'.get_status_for_ribbons_jobs($result['status']).'</small>
    </div>
 </div>
              <h5><i class="fas fa-bolt"> '.$theme.'</i></h5> 
              <p>Исполнитель: <u>'.$executor.'</u></p>
                  <p>'.$content.'</p>
                <div style="display:inline;"><small><a href="one_page_jobs.php?ID='.$result['ID'].'"><i class="fas fa-share mr-1"></i>Перейти</h5></a></small></div>
                     <div style="text-align:right;display:inline;float:right;"><small>Опубликованно: '.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['create_date'].'</small>
</div>
<div style="clear: right;"></div>
 
      </div>

      






';

 }

/*
<div class="callout callout-danger">
  <h5>'.$result['jira_num'].'</h5>
  <p>'.$result['content'].'</p>
  <small>Опубликованно: '.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['create_date'].'</small>
</div>

<div class="'.get_class_for_div($result['importance']).'">
                  <h5><i class="icon fas fa-info"></i>'.$result['jira_num'].'</h5>
                  '.$result['content'].'
                <div style="text-align:right;"><small>Опубликованно: '.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['create_date'].'</small>
</div>

                </div>
*/
?>