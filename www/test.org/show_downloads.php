<!-- Для валидации -->
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
<!-- Выводим таблицу номенклатуры -->
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <!-- Заголовок таблицы -->
      <th class="snorting"></th>
      <th class="snorting">ID</th>
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
  $sql = mysqli_query($link, "SELECT *  FROM `uploads` WHERE `deleted`=0 ORDER BY `id` DESC");
  echo '<tbody>';
  while ($result = mysqli_fetch_array($sql)) {
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

    #Все кнопки ------------------------------------------------------------------------------------------------ 
    $level_access_but = array(1, 5);
    $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
    $del_button = ' <a class="dropdown-item" href="#" onclick="del_file(' . $id . ',`uploads.php`);">Удалить</a>';
    $download_button = ' <a class="dropdown-item" href="/upload/' . $name_orig . '">Загрузить</a>';
    $control = $download_button;
    if ($is_allowed_button) {
      $control .= $del_button;
    }
    #Конец блока кнопок кнопки ------------------------------------------------------------------------------------------------ 
    echo '<tr>
<td>
<div class="input-group mb-3" style="margin-bottom: 0rem !important;">
<div class="input-group-prepend">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<i class="far fa-arrow-alt-circle-down"></i>
</button>
<div class="dropdown-menu">
' . $control . '
</div>
</div>
<!-- /btn-group -->
</div>
</td>' .
      "<td>$id</td>" .
      "<td><a class='dropdown-item' href='/upload/$name_orig.'>$name</td>".
      "<td>$name_orig</td>" .
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
    <th class="snorting"></th>
    <th class="snorting">ID</th>
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
<?php
include("modal_close_shift.php");
include("modal_del_file.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
?>