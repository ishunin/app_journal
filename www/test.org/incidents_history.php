<?php
$count = 0;
$sql = mysqli_query($link, "SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
`destination`, `status`,`importance`,`type`,`keep`,`create_date`,`edit_date` FROM `list` WHERE id_user=" . $_COOKIE['id'] . " order by `create_date` DESC LIMIT 50");

while ($result = mysqli_fetch_array($sql)) {
  #   $count++;  
  $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
  $result_user = mysqli_fetch_array($sql_user);
}

$sql = mysqli_query($link, "SELECT  DISTINCT `id_rec` FROM `list` WHERE id_user $query_option");
$i = 0;
while ($res = mysqli_fetch_array($sql)) {
  //$mas[$i]=$res['id_rec'];
  $sql2 = mysqli_query($link, "SELECT * FROM list WHERE id_rec='" . $res['id_rec'] . "' ORDER BY create_date DESC LIMIT 1");
  while ($res2 = mysqli_fetch_array($sql2)) {
    # echo $res2['ID'].'<br>';
    $sql3 = mysqli_query($link, "SELECT * FROM list WHERE ID=" . $res2['ID'] . " ORDER BY create_date DESC");
    while ($res3 = mysqli_fetch_array($sql3)) {
      #echo $res3['ID'].' '.$res3['id_rec'].'<br>';
      $mas[$i] = $res3['ID'];
      $i++;
    }
  }
}
if (!empty($mas)) {
  rsort($mas);
  foreach ($mas as $value) {
    $sql3 = mysqli_query($link, "SELECT * FROM list WHERE ID=$value");
    while ($res3 = mysqli_fetch_array($sql3)) {
      $count++;
      #echo $res3['ID'].' '.$res3['id_rec'].'<br>';
      $content = mb_substr(strip_tags($res3['content']), 0, 1000);
      $jira_num = strip_tags($res3['jira_num']);
      ($jira_num != '') ? : $jira_num = 'б/н';
      $id_user = $res3['id_user'];
      $type= $res3['type'];
      $note = '';
      if ($type==2) {
      $note = '<span class="badge badge-info right">note</span>';
      }
      $user_name = get_user_name_by_id($id_user, $link);
      echo '
      <!-- Post -->
      <div class="post clearfix">
        <div class="user-block">
        <img class="img-circle img-bordered-sm" src="' . get_user_icon($id_user, $link) . '" alt="User Image">
        <span class="username">
          <a href="#">' . $user_name . '</a>
        </span>
      
        <span class="description">' . $res3['create_date'] . '</span>
      </div>
      <!-- /.user-block -->
      <div style="clear:left;"></div>
      <h4>'.$jira_num.'</h4>
      <p>
      ' .$note.' '.$content . '
      </p>
      <small><a href="one_page.php?ID=' . $res3['ID'] . '"><i class="fas fa-share mr-1"></i> Перейти</a></small>
    </div>
    <!-- /.post -->
      ';
    }
  }
}

if ($count == 0) {
  echo '
     <blockquote class="quote-secondary">
        <p>Информация:</p>
         <small>Нет новостей для отображения.</small>
      </blockquote>                
        ';
}
