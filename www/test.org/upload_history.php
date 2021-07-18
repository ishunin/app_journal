 <!-- Выводим таблицу номенклатуры -->
 <table id="example3" class="table table-bordered table-striped" style="table-layout: fixed;">
   <thead>
     <tr>
       <!-- Заголовок таблицы -->
       <th class="snorting">Имя файла</th>
       <th class="snorting">Имя оригинальное</th>
       <th class="snorting">*.*</th>
       <th class="snorting">Размер, Мб.</th>
       <th class="snorting">Кто загрузил</th>
       <th class="snorting">Комментарий</th>
       <th class="snorting">Дата</th>
     </tr>
   </thead>
   <?php
    $sql2 = mysqli_query($link, "SELECT *  FROM `uploads` WHERE `id_user` $query_option ORDER BY `date` DESC LIMIT 100");
    echo '<tbody>';
    while ($result = mysqli_fetch_array($sql2)) {
      $id = strip_tags($result['id']);
      $id_rec = strip_tags($result['id_rec']);
      $name = strip_tags($result['name']);
      $comment = strip_tags($result['comment']);
      $type = $result['type'];
      $name_orig = strip_tags($result['name_orig']);
      $size = round($result['size'] / 1048576, 2);
      $user_name =  get_user_name_by_id($result['id_user'], $link);
      $date = $result['date'];
      $type_file = $result['type_file'];

      echo
        "<td>$name</td>" .
          "<td><a href='/upload/$name_orig'>$name_orig</a></td>" .
          "<td>$type_file</td>" .
          "<td>$size</td>" .
          "<td>$user_name</td>" .
          "<td>$comment</td>" .
          "<td>$date</td>" .
          '</tr> 
                   ';
    }
    echo ' </tbody> 
                   <tfoot>
                   <tr>
                       <!-- Заголовок таблицы -->
                       <th class="snorting">Имя файла</th>
                       <th class="snorting">Имя оригинальное</th>
                       <th class="snorting">*.*</th>
                       <th class="snorting">Размер, Мб.</th>
                       <th class="snorting">Кто загрузил</th>
                       <th class="snorting">Комментарий</th>
                       <th class="snorting">Дата</th>
                   </tr>
                   </tfoot>';
    ?>
 </table>