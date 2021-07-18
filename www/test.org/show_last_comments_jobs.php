<?php
echo '
<div class="row">
  <div class="col-md-12">
    <div class="card-footer card-comments">';
#echo $_GET['id_rec'];
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`,`type` FROM `comments` WHERE `type`=3 
order by `create_date` DESC LIMIT 3;
  '); 
  if ($sql) {
$count=0;
 while ($result = mysqli_fetch_array($sql)) {
      $count++;
      $id_user = $result['id_user'];
      $id_rec = $result['id_rec'];
      $user_name = get_user_name_by_id($result['id_user'], $link);
      $content = mb_substr(strip_tags($result['content']), 0, 1000);
      $create_date = $result['create_date'];    
      $sql_rec = mysqli_query($link, 'SELECT `ID` FROM `jobs` WHERE `ID`="'.$id_rec.'"
        '); 
    $result_rec = mysqli_fetch_array($sql_rec);   
    if (mysqli_num_rows($sql_rec)>0){
echo '
<div class="card-comment">
  <!-- User image -->
  <img class="img-circle img-bordered-sm" src="dist/img/'.$id_user.'.png" alt="user image">

  <div class="comment-text">
    <span class="username">
      '.$user_name.'
      <span class="text-muted float-right">'.$result['create_date'].'</span>
    </span><!-- /.username -->
  '.$content.'
    <p>
    <a href="one_page_jobs.php?ID='. $id_rec.'" class="link-black text-sm">
    <i class="fas fa-link mr-1"></i> Перейти к заданию...</a>
      </p>
  </div>
  <!-- /.comment-text -->
</div>
';
    }
    else {
echo '
<div class="card-comment">
  <!-- User image -->
  <img class="img-circle img-sm" src="dist/img/user3-128x128.jpg" alt="User Image">

  <div class="comment-text">
    <span class="username">
    '.$user_name.'
      <span class="text-muted float-right">'.$create_date.'</span>
    </span><!-- /.username -->
  '.$content.'
    <p> 
  <s>  <i class="fas fa-link mr-1"> </i>Запись, связанная с новостью была удалена</s>
      </p>
  </div>
  <!-- /.comment-text -->
</div>
';
    }
 }
}
 if ($count==0) {
 	echo '
                <blockquote class="quote-secondary">
                  <p>Информация:</p>
                  <small>Для данного инцидента еще никто не оставил комментария.</small>
                </blockquote>
 	';
 }  
echo '</div>
<!-- /.col -->
</div>
</div>
';
?>
