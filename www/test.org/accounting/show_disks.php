<!-- Валидация формы комментариев-->
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
<table id="example1_templ" class="table table-bordered table-striped">
  <thead>
    <tr>
      <!-- Заголовок таблицы -->
      <th class="snorting"></th>
      <th class="snorting">ID</th>
      <th class="snorting">Модель</th>
      <th class="snorting">Тип оборудования</th>
      <th class="snorting">Сегмент</th>
      <th class="snorting">Ф/ф</th>
      <th class="snorting">Фирма</th>
      <th class="snorting">Интерфейс</th>
      <th class="snorting">RPM</th>
      <th class="snorting">Объем</th>
      <th class="snorting">Парт номер</th>
      <th class="snorting">М</th>
      <th class="snorting">Комментарий</th>
      <th class="snorting">Остаток</th>
    </tr>
  </thead>
  <?php
  $sql = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE `deleted`=0 ORDER BY `name` DESC");
  echo '<tbody>';
  while ($row = mysqli_fetch_array($sql)) {
    $id = $row['id'];
    $name = strip_tags($row['name']);
    $type_equipment = strip_tags($row['type_equipment']);
    $segment = strip_tags($row['segment']);
    $form_factor = strip_tags($row['form_factor']);
    $firm = strip_tags($row['firm']);
    $interface = strip_tags($row['interface']);
    $rpm = strip_tags($row['rpm']);
    $volume = strip_tags($row['volume']);
    $part_number = strip_tags($row['part_number']);
    $comment = strip_tags($row['comment']);
    $monitor = strip_tags($row['monitor']);
    $deleted = ($row['deleted']);
    #Запрашиваем количество записей на приход по каждой позиции
    $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id AND `deleted`=0";
    $query = mysqli_query($link_account, $sql2);
    if ($query) {
      $row = mysqli_fetch_row($query);
      $total = $row[0]; // Всего записей
    } else {
      printf("Ошибка: %s\n", mysqli_error($link_account));
    }
    if (isset($_COOKIE['user_level'])) {
      $user_level = $_COOKIE['user_level'];
    }
    #Все кнопки ------------------------------------------------------------------------------------------------ 
    $level_access_but = array(1, 5);
    $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
    $show_button = '<a class="dropdown-item" href="one_disk.php?id=' . $id . '" onclick="" >Просмотр</a>';
    $plus_button = '<a class="dropdown-item" href="#" onclick="add_disk(' . $id . ',`overall_disks.php`);">Приход</a>';
    $minus_button = ' <a class="dropdown-item" href="#" onclick="">Расход</a>';
    $edit_button = ' <a class="dropdown-item" href="#" onclick="edit_disk_templ(' . $id . ');">Редактировать шаблон диска</a>';
    $del_button = ' <a class="dropdown-item" href="#" onclick="del_disk_templ(' . $id . ',`overall_disks.php`);">Удалить</a>';
    if ($is_allowed_button) {
      $control =  $show_button . $plus_button . $edit_button . $del_button;
    } else {
      $control = $show_button;
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
      "<td><a class='dropdown-item' href='one_disk.php?id=" . $id . "' onclick=''>$name</a></td>" .
      "<td>$type_equipment</td>" .
      "<td>$segment</td>" .
      "<td>$form_factor</td>" .
      "<td>$firm</td>" .
      "<td>$interface</td>" .
      "<td>$rpm</td>" .
      "<td>$volume</td>" .
      "<td>$part_number</td>" .
      "<td>$monitor</td>" .
      "<td>$comment</td>" .
      "<td>$total</td>" .
      '</tr> 
';
  }
  echo ' </tbody> 
<tfoot>
<tr>
<th class="snorting"></th>
      <th class="snorting">ID</th>
      <th class="snorting">Модель</th>
      <th class="snorting">Тип оборудования</th>
      <th class="snorting">Сегмент</th>
      <th class="snorting">Ф/ф</th>
      <th class="snorting">Фирма</th>
      <th class="snorting">Интерфейс</th>
      <th class="snorting">RPM</th>
      <th class="snorting">Объем</th>
      <th class="snorting">Парт номер</th>
      <th class="snorting">М</th>
      <th class="snorting">Комментарий</th>
      <th class="snorting">Остаток</th>
</tr>
</tfoot>';
  ?>
</table>

<?php
include("../modal_close_shift.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
?>
<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для создания новой записи инцидента-->
<div id="modal_add_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_add_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы добавления нового диска-->
<!-- Конец блока модальныйх окон страницы-->
<script type="text/javascript">
  function add_disk(id, page_back) {
    $('#modal_add_disk_content').load('ajax_add_disk.php?id_disk=' + id + '&page_back=' + page_back, function() {
      $('#modal_add_disk').modal({
        show: true
      });
    });
  }
</script>