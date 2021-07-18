<?php
$jobs_count=0;
$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`,`executor`,`start_task`,`end_task`,`deleted`  FROM `jobs` WHERE `deleted`=0 order by `create_date`  DESC LIMIT 3");
if ($sql) {
  while ($result = mysqli_fetch_array($sql)) {
    $jobs_count++;
    $ID = $result['ID'];
    $id_user = $result['id_user'];
    $id_executor = $result['executor'];
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $theme = mb_substr(strip_tags($result['theme']), 0, 300);
    $description = mb_substr(strip_tags_smart($result['description']), 0, 1000) . ' ...';
    $content = mb_substr(strip_tags_smart($result['content']), 0, 1000) . ' ...';
    $status = $result['status'];
    $importance = $result['importance'];
    $keep = $result['keep'];
    $create_date = $result['Create_date'];
    $edit_date = $result['edit_date'];
    $type = $result['type'];
    $start_task = $result['start_task'];
    $end_task = $result['end_task'];
    $count++;
    $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . "");
    $result_user = mysqli_fetch_array($sql_user);
    
    $sql_user_exec = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$id_executor."");
    $result_user_exec = mysqli_fetch_array($sql_user_exec);
    if ($id_executor > 0) {
    $execurot_name = $result_user_exec['first_name'] . ' '.$result_user_exec['last_name'];
    }
    else {
      $execurot_name = "Исполнитель не имеет значения";
    }
    //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
    $res = is_this_job_new($link,$ID);
    $new_job_notify = '';
    if ($res) {
    $new_job_notify = '<span class="right badge badge-danger">НОВОЕ!</span>&nbsp;';
    }
    echo '
    <!-- Post -->
    <div class="post">
      <div class="user-block">
        <img class="img-circle img-bordered-sm" src="dist/img/' . $id_user . '.png" alt="user image">
        <span class="username">
          <a href="#">' . $result_user['first_name'] . ' ' . $result_user['last_name'] . '</a>
        </span>
        <span class="description">Опубликованно - ' . $create_date . '</span>
      </div>
      <div style="clear:left;">
      </div>
      <div>
      <!-- /.user-block -->  
      <h3>'.$new_job_notify.$theme.'</h3>
      <p>Исполнитель: <u>' .$execurot_name.'</u></p>
      <p>
        ' . $content . '
    </p>

        <a href="one_page_jobs.php?ID=' . $ID . '" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
    </div>
  </div>
  <!-- /.post -->                               
';
  }
}
?>