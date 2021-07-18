<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>
<!-- Выводим таблицу инцидентов -->
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <!-- Заголовок таблицы -->
      <th>Ссылка</th>
      <th class="snorting">ID</th>
      <th class="snorting">Автор смены</th>
      <th class="snorting">Дата открытия</th>
      <th class="snorting">Дата закрытия</th>
      <th class="snorting">Статус</th>
      <th class="snorting">Автоотчет | Отчет</th>
    </tr>
  </thead>
  <?php
  $count = 0;
  $sql = mysqli_query($link, 'SELECT *  FROM `shift` ORDER BY create_date DESC LIMIT 100');
  echo '<tbody>';
  while ($result = mysqli_fetch_array($sql)) {
    $id_rec = $result['ID'];
    #Кстыль - id_shift передается как id_rec для получения загруженных файлов. Может неверно себя вести в дальнейшем. ПЕРЕДАЛАТЬ!
    $id_shift =  $result['ID'];

    $sql_user = mysqli_query(
      $link,
      "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . ""
    );
    $result_user = mysqli_fetch_array($sql_user);

    if ($result['end_date'] == NULL) {
      $result['end_date'] = 'Не закрыта';
    }
    if ($result['status'] == 1) {
      $class_s = "class='shift-opened'";
      $result['status'] = 'открыта';
    } else {
      $result['status'] = 'закрыта';
      $class_s = "class='shift-closed'";
    }
    $str_link_report = '';

    $i = 0;
    $sql2 = mysqli_query($link, "SELECT *  FROM `uploads` WHERE `deleted`=0 AND `type`=5 AND `id_rec`='$id_rec' ORDER BY `id` DESC");
    while ($result2 = mysqli_fetch_array($sql2)) {
      $i++;
      $name = strip_tags($result2['name']);
      $name_orig = strip_tags($result2['name_orig']);
      $size = round($result2['size'] / 1048576, 2);
      $user_name =  get_user_name_by_id($result2['id_user'], $link);
      $date = $result2['date'];
      $type_file = $result2['type_file'];
      $str_link_report .= '<small><i><a href="upload/' . $name_orig . '">' . $name . '</a></i></small><br>';
    }
    if ($i == 0) {
      $str_link_report = '<span '.$class_s.'">НЕТ</span>';
    }
    
    #Выводим автоотчет за смену######################
    $shif_info = get_shift_info($link,$id_shift);  
    if (!empty($shif_info) AND ($shif_info['end_date']!=NULL)) {
      $auto_report_str = '<span><i><a href="report3.php?id_shift='.$id_shift.'">Автоотчет</a></i></span>';
    } else {
      $auto_report_str = '<span '.$class_s.'">НЕТ</span>';
    }
    #####################################################



    echo "<tr>" .
      "<td><a href='show_shift_incidents.php?ID=" . $result['ID'] . "' class='link-black text-sm mr-2'><i class='fas fa-share mr-1'></i> Перейти</a> </td>" .
      "<td>{$result['ID']}</td>" .
      "<td><img src='dist/img/" . $result_user['ID'] . ".png' class='user-image' alt='User Image'>" . $result_user['first_name'] . " " . $result_user['last_name'] . "</td>" .
      "<td>{$result['create_date']}</td>" .
      "<td>{$result['end_date']}</td>" .
      "<td " . $class_s . "> {$result['status']}</td>" .
      "<td> $auto_report_str | $str_link_report</td>" .
      '</tr> 
           ';
  }
  echo ' </tbody> 
   <tfoot>
      <tr>
        <th>Ссылка</th>
        <th>ID</th>
        <th>Автор смены</th>
        <th>Дата открытия</th>
        <th>Дата закрытия</th>
        <th>Статус</th>
        <th class="snorting">Автоотчет | Отчет</th>        
      </tr>
   </tfoot>';
  ?>

</table>
<?php
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
?>
<?php
include("modal_close_shift.php");
?>