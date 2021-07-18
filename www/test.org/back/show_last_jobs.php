<?php

$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`,`executor`,`start_task`,`end_task`  FROM `jobs` order by `create_date` DESC LIMIT 3");
if ($sql) {

    while ($result = mysqli_fetch_array($sql)) {
      $count++;  
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);

echo '

                 
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/'.$result_user['ID'].'.png" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                        <span class="description">Опубликованно - '.$result['create_date'].'</span>
                      </div>
                      <div style="clear:left;">
                      </div>
                      <div>
                      <!-- /.user-block -->
                      
                      
                      <h3>'.$result['theme'].'</h3>
                      <p>
                         '.$result['content'].'
                     </p>
                      
                      
                        <a href="one_page_jobs.php?ID='.$result['ID'].'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
                     
                    </div>
                    </div>
                    <!-- /.post -->

                              
      
';
}
}
?>