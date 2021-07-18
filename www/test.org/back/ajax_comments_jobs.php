<?php
include ("scripts/conf.php");
include ("func.php");
#echo $_GET['id_rec'];
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`,`type` FROM `comments` 
WHERE `id_rec`='.$_GET['id'].' AND `type`=3
	'); 
$count=0;
 while ($result = mysqli_fetch_array($sql)) {
 	$count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);  
      $content=mb_substr(strip_tags($result['content']),0,1000);
echo '
 <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.get_user_icon( $result_user['ID'],$link).'" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                        <span class="description">Опубликовано- '.$result['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$content.'
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Прикрепленный файл</a>
                      </p>
                    </div>

';
 }

 if ($count==0) {
 	echo '
                <blockquote class="quote-secondary">
                  <p>Информация:</p>
                  <small>Для данного инцидента еще никто не оставил комментария.</small>
                </blockquote>
 	';
 }  

echo '<a href="one_page_jobs.php?ID='.$_GET['id'].'#comment">Оставить комментарий</a>';

?>