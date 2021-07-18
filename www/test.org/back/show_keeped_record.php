<?php
$id_shift = get_last_shift_id($link);
 $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
 `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date`  FROM `list` WHERE  `keep`=1 AND `id_shift`='.$id_shift.' AND `status`!=4 ORDER BY create_date DESC');
 echo '<tbody>';
 while ($result = mysqli_fetch_array($sql)) {
  $count_keep_record ++;
   $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
   $result_user = mysqli_fetch_array($sql_user);
   $opacity='';
   if ($result['status']==3 || $result['status']==4) {
      $opacity = 'div-opacity';
   }
   $content=mb_substr(strip_tags($result['content']),0,500).' ...';
   $jira_num=strip_tags($result['jira_num']);
echo '
<div class="alert '.get_class_for_div($result['importance']).' '.$opacity.'">

<div class="ribbon-wrapper">
    <div class="ribbon bg-primary">
    <small>'.get_status_for_ribbons($result['status']).'</small>
    </div>
 </div>

   <h5><i class="icon fas fa-info"></i>'.$jira_num.'</h5>
   <p>'.$content.' </p>

    <div style="display:inline;"><small><a href="one_page.php?ID='.$result['ID'].'"><i class="fas fa-share mr-1"></i>Перейти</a></small></div>
    <div style="text-align:right;display:inline;float:right;">
    <small>'.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['create_date'].'</small>
    </div>


 </div>
';
 }
?>