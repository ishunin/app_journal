<?php
#echo $_GET['id_rec'];
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date` FROM `comments` 
order by `create_date` DESC LIMIT 3;
	'); 
$count=0;
 while ($result = mysqli_fetch_array($sql)) {
 	$count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);  

      $sql_rec = mysqli_query($link, 'SELECT `Jira_num`,`ID` FROM `list` 
      WHERE `ID_rec`="'.$result['id_rec'].'"
        '); 

    $result_rec = mysqli_fetch_array($sql_rec);   
     echo (mysqli_num_rows($sql_rec));
    if (mysqli_num_rows($sql_rec)>0){

echo '
 <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/'.$result_user['ID'].'.png" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                        <span class="description">Опубликовано- '.$result['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$result['content'].'
                      </p>

                      <p>
                        <a href="one_page.php?ID='.$result_rec['ID'].'" class="link-black text-sm">
                        <i class="fas fa-link mr-1"></i> '.$result_rec['Jira_num'].'</a>
                      </p>
                    </div>

';
    }
    else {
echo '
       <div class="post">
                      <div class="user-block">
                       <img class="img-circle img-bordered-sm" src="dist/img/'.$result_user['ID'].'.png" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                        <span class="description">Опубликовано- '.$result['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$result['content'].'
                      </p>

                      <p>
                        <a class="link-black text-sm">
                      <s>  <i class="fas fa-link mr-1"></i>Запись, связанная с данным комментарием была удалена.</a></s>
                      </p>
                    </div>

';
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


?>