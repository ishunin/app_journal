<?php

$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`  FROM `news` WHERE `deleted`=0 order by `create_date` DESC LIMIT 3");
if ($sql) {
    while ($result = mysqli_fetch_array($sql)) {
      $ID=$result['ID'];
      $id_user = $result['id_user'];
      $user_name =  get_user_name_by_id($result['id_user'],$link);
      $theme = mb_substr(strip_tags($result['theme']), 0, 300);
      $description = trim(mb_substr(strip_tags_smart($result['description']), 0, 1000));  
      $content = mb_substr(strip_tags_smart($result['content']), 0, 1000).' ...';
      $status=$result['status'];
      $importance=$result['importance'];
      $keep=$result['keep'];
      $create_date=$result['create_date'];
      $edit_date=$result['edit_date'];
      $type=$result['type'];
      $count++;  
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$id_user."");
      $result_user = mysqli_fetch_array($sql_user);
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

echo '
    <!-- Post -->
    <div class="post">
      <div class="user-block">
        <img class="img-circle img-bordered-sm" src="dist/img/'. $id_user.'.png" alt="user image">
        <span class="username">
          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
        </span>
        <span class="description">Опубликованно - '.$create_date.'</span>
      </div>
      <div style="clear:left;">
      </div>
      <div>
      <!-- /.user-block -->

      <h3>'.$new_news_notify.$theme.'</h3>
      <p>
        '. $content_sh.'
    </p>
    <a href="one_page_news.php?ID='.$ID.'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
    
    </div>
    </div>
    <!-- /.post -->    
';
}
}
?>