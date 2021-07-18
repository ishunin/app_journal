<?php
$count = 0;
$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
`keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`,`executor`,`start_task`,`end_task`,`deleted`  FROM `jobs` WHERE id_user $query_option AND `deleted`=0 order by `create_date` DESC LIMIT 50");
while ($result = mysqli_fetch_array($sql)) {
  $count++;
  $content = mb_substr(strip_tags($result['content']), 0, 1000) . ' ...';
  $theme = strip_tags($result['theme']);
  $user_name = get_user_name_by_id($result['id_user'], $link);
  echo '
      <!-- Post -->
      <div class="post clearfix">
        <div class="user-block">
        <img class="img-circle img-bordered-sm" src="' . get_user_icon($result['id_user'], $link) . '" alt="User Image">
        <span class="username">
          <a href="#">' . $user_name . '</a>
        </span>
      
        <span class="description">' . $result['create_date'] . '</span>
      </div>
      <!-- /.user-block -->
      <div style="clear:left;"></div>
      <h3>' . $theme . '</h3>
      <p>
      ' . $content . '
      </p>
      <small><a href="one_page_jobs.php?ID=' . $result['ID'] . '"><i class="fas fa-share mr-1"></i> Перейти</a></small>
    </div>
    <!-- /.post -->
      ';
}
if ($count == 0) {
  echo '
  <blockquote class="quote-secondary">
    <p>Информация:</p>
    <small>Нет новостей для отображения.</small>
  </blockquote>
        ';
}
