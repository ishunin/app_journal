<?php
#Функция вывода комментариев - ВАЖНО! ПЕРЕДЛАТЬ и сделать униерсальной!!!!!!!!!!!!!!!!!!!!!
$count = 0;
#Флаг показывает что выводим коммантарии общего чата
if ($flag_comments == 5) {
  $user_option = 'IS NOT NULL';
  //$sql = mysqli_query($link, "SELECT ID, id_rec, id_user, content, create_date FROM comments 
  //WHERE type=5 AND id_user " . $query_option . " ORDER BY create_date DESC LIMIT 10");
  $sql = mysqli_query($link, "SELECT ID, id_rec, id_user, content, create_date FROM comments 
  WHERE type=5 ORDER BY create_date DESC LIMIT 10");
  if ($sql) {
    $str_comment = '';
    while ($result = mysqli_fetch_array($sql)) {
      $count++;
      $user_name = get_user_name_by_id($result['id_user'], $link);
      $content = mb_substr(strip_tags($result['content']), 0, 1000);
      $str_comment .= '
          
    <div class="card-comment">
    <!-- User image -->
    <img class="img-circle img-bordered-sm" src="dist/img/' . $result['id_user'] . '.png" alt="user image">
    <div class="comment-text">
        <span class="username">
        ' . $user_name . '
            <span class="text-muted float-right">' . $result['create_date'] . '</span>
        </span><!-- /.username -->
        ' . $content . '
        <p>
          <a href="#" class="link-black text-sm">
          <small> <i class="fas fa-link mr-1"></i></a></small>
        </p>
    </div>
    <!-- /.comment-text -->
</div>  
';
    }
    if ($count > 0) {
      echo '<!-- Post -->
  <div class="post clearfix" style="margin-bottom:0px;">
  <div class="card-footer card-comments"> 
 ' . $str_comment . '
  </div> 
  </div>
  <!-- /.post -->';
    }
  }
}

if ($count == 0) {
  echo '
  <blockquote class="quote-secondary">
    <p>Информация:</p>
    <small>Для данного инцидента еще никто не оставил комментария.</small>
  </blockquote>
 	';
}
?>