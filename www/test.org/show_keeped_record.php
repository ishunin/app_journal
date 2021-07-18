<?php
$id_shift = get_last_shift_id($link);
 $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
 `destination`, `status`,`importance`,`type`,`keep`,`create_date`,`edit_date`  FROM `list` WHERE  `keep`=1 AND `id_shift`='.$id_shift.' AND `status`!=4 AND `deleted`=0 ORDER BY create_date DESC');
 echo '<tbody>';
 while ($result = mysqli_fetch_array($sql)) {
  $count_keep_record ++;
   $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
   $result_user = mysqli_fetch_array($sql_user);
   $opacity='';
   if ($result['status']==3 || $result['status']==4) {
      $opacity = 'div-opacity';
   }
   $ID=$result['ID'];
   $content=mb_substr(strip_tags_smart($result['content']),0,500).' ...';
   $jira_num=strip_tags($result['jira_num']);
   ($jira_num != '') ? : $jira_num = 'б/н';
   $uploads = show_upload_files($link,$result['id_rec'],3,'index.php',1);  
   $type= $result['type'];
   $note = '';
   if ($type==2) {
   $note = '<span class="badge badge-info right">NOTE</span>';
   }
   //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
   $res = is_this_rec_new($link,$ID);
   $new_rec_notify = '';
   if ($res) {
     $new_rec_notify = '<span class="right badge badge-danger">НОВЫЙ!</span>&nbsp;';
   }

 $str_keep.= '
<div class="alert '.get_class_for_div($result['importance']).' '.$opacity.'" style="margin-bottom:0px;">
   <div class="ribbon-wrapper">
    <div class="ribbon bg-primary">
    <small>'.get_status_for_ribbons($result['status']).'</small>
    </div>
 </div>
   <h5><i class="icon fas fa-info"></i> <a class="link-black" target="_blank" href="https://servicedesk:8443/browse/'.$jira_num.'">' . $jira_num . '</a></h5>
   <p style="margin-bottom:0px;">'.$new_rec_notify.$note.' '.$content.' </p>
   '.$uploads.'
    <div style="display:inline;"><small><a href="one_page.php?ID='.$result['ID'].'"><i class="fas fa-share mr-1"></i>Перейти</a></small></div>
    <div style="text-align:right;display:inline;float:right;">
    <small>'.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['create_date'].'</small>
    </div>
 </div>
';
 }
?>