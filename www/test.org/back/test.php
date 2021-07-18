<?php
include ("scripts/conf.php");
include ("func.php");
#echo (get_last_shift_id($link));
$sql = mysqli_query($link, "SELECT  DISTINCT `id_rec` FROM `list` WHERE id_user=".$_COOKIE['id']."");
$i=0;
while ($res = mysqli_fetch_array($sql)) {
//$mas[$i]=$res['id_rec'];
        $sql2 = mysqli_query($link, "SELECT * FROM list WHERE id_rec='".$res['id_rec']."' ORDER BY create_date DESC LIMIT 1");
        while ($res2 = mysqli_fetch_array($sql2)) {
           # echo $res2['ID'].'<br>';
            $sql3 = mysqli_query($link,"SELECT * FROM list WHERE ID=".$res2['ID']." ORDER BY create_date DESC");
            while ($res3 = mysqli_fetch_array($sql3)) {
                #echo $res3['ID'].' '.$res3['id_rec'].'<br>';
                $mas[$i]=$res3['ID'];
                $i++;
            }
        }
}
rsort($mas);
foreach ( $mas as $value ) {
    $sql3 = mysqli_query($link,"SELECT * FROM list WHERE ID=$value");
    while ($res3 = mysqli_fetch_array($sql3)) {
      $count++;
        #echo $res3['ID'].' '.$res3['id_rec'].'<br>';
        echo '
<!-- Post -->
<div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.get_user_icon($_COOKIE['id'],$link).'" alt="User Image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                       
                        <span class="description">'.$res3['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <h3>'.substr(($res3['jira_num']),0,500).'</h3>
                      <p>
                       '.substr(($res3['content']),0,500).'
                      </p>
                      <small><a href="one_page.php?ID='.$res3['ID'].'"><i class="fas fa-share mr-1"></i> Перейти</a></small>
                    </div>
                    <!-- /.post -->
';
    } 
}

    
    












?>