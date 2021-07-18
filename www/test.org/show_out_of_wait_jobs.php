<?php
//всего записей вышло из ожидания
$count_wait_record = 0;
$str_keep='';
    $str = '
    <div class="card blink">
    <div class="card-header">
    <h3 class="card-title area">
        <i class="fas fa-pause"></i> Вышли из ожидания задания
    </h3>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
    </div>
    <div class="card-body" style="padding:0px;" id="blink6">
    ';
  
    $sql = mysqli_query($link, "SELECT * FROM `jobs` WHERE  `status`=2  AND `deleted`=0 AND NOW() > `delay_date`  ORDER BY create_date DESC");
    echo '<tbody>';
    $count_keep_record =0;
    while ($result = mysqli_fetch_array($sql)) {
     
      $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $ID=$result['ID'];
      $result_user = mysqli_fetch_array($sql_user);
      $content=mb_substr(strip_tags_smart($result['content']),0,500).' ...';
      $theme=strip_tags($result['theme']);
      $status = $result['status'];
      $opacity='';
      (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') ? $delay_date = $result['delay_date'] : $delay_date = ' не указано';
        if ($status==2) {
          $delay_date = ' до '.$delay_date;
        }
        else {
          $delay_date = '';
        }
      $uploads = show_upload_files($link,$result['ID'],2,'index.php',3);
      if ($result['status']==3 || $result['status']==4) {
         $opacity = 'div-opacity';
      }
      $executor="Не имеет значения";
      if ($result['executor']!=0) {
      $sql_exec = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['executor']."");
      $result_exec = mysqli_fetch_array($sql_exec);
      $executor=$result_exec['first_name'].' '.$result_exec['last_name'];
      }
      if ($result['executor']==0 || $result['executor']==$_COOKIE['id']) {
        $count_wait_record ++;
   
       //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
       $res = is_this_job_new($link,$ID);
       $new_job_notify = '';
       if ($res) {
       $new_job_notify = '<span class="right badge badge-danger">НОВОЕ!</span>&nbsp;';
       }
   $str.= '
   <div class="alert '.get_class_for_div($result['importance']).' '.$opacity.'" style="margin-bottom:3px;">
   <div class="ribbon-wrapper">
       <div class="ribbon bg-primary">
       <small>'.get_status_for_ribbons_jobs($result['status']).'</small>
       </div>
    </div>
    <h5><i class="fas fa-bolt"> '.$new_job_notify.$theme.'</i></h5> 
    <p style="margin-bottom:0px;">Исполнитель: <u>'.$executor.'</u></p>
    <p> Статус: <b>' . get_status($status) .' '.$delay_date.'</b></p>
    <p style="margin-bottom:0px;">'.$content.'</p>
        '.$uploads.'
      <div style="display:inline;"><small><a href="one_page_jobs.php?ID='.$result['ID'].'"><i class="fas fa-share mr-1"></i>Перейти</h5></a></small></div>
        <div style="text-align:right;display:inline;float:right;"><small>Опубликованно: '.$result_user['first_name'].' '.$result_user['last_name'].' в '.$result['create_date'].'</small>
   </div>
         <div style="clear: right;"></div>
   </div>
   ';
      }
    }


    $str .= '
</div>
<!-- /.card-body -->
<div class="card-footer">
  <small>Вышли из ожидания  ' . ($count_wait_record) . ' заданий' . '</small>
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
';

if ($count_wait_record == 0){
    $str = '';
}
echo $str;
