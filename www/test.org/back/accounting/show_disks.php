

<!-- Выводим таблицу номенклатуры -->
<table id="example1" class="table table-bordered table-striped">
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
      <th class="snorting">Лог</th>
      <th class="snorting">М</th>
      <th class="snorting">Комментарий</th>
      <th class="snorting">Остаток</th>
    </tr>
  </thead>
<?php
$sql = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE `deleted`=0 ORDER BY `id` DESC");
echo '<tbody>';
while ($result = mysqli_fetch_array($sql)) {
  $id=$result['id'];
  #Запрашиваем количество записей на приход по каждой позиции
  $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id";
  $query = mysqli_query($link_account,$sql2);
      if ($query) {
        $row = mysqli_fetch_row($query);
        $total = $row[0]; // Всего записей
      }
      else {
          printf("Ошибка: %s\n", mysqli_error($link_account));
      }
  
  
   if (isset($_COOKIE['user_level'])) {
      $user_level = $_COOKIE['user_level'];
   }
   #Все кнопки ------------------------------------------------------------------------------------------------ 
   $level_button = array(0,1,2,3,5);
   $show_button = check_button_permission('<a class="dropdown-item" href="one_disk.php?id='.$id.'" onclick="" >Просмотр</a>',$user_level,$level_button);
   
   $level_button = array(1,5);
   $plus_button = check_button_permission('<a class="dropdown-item" href="#" onclick="add_disk('.$result['id'].',`overall_disks.php`);">Приход</a>',$user_level,$level_button);

   $minus_button = ' <a class="dropdown-item" href="#" onclick="">Расход</a>';
   $edit_button = ' <a class="dropdown-item" href="#" onclick="edit_disk_templ('.$result['id'].');">Редактировать шаблон диска</a>';
   $del_button = ' <a class="dropdown-item" href="#" onclick="del_disk_templ('.$result['id'].',`overall_disks.php`);">Удалить</a>';
   #Конец блока кнопок кнопки ------------------------------------------------------------------------------------------------ 


echo '<tr>
<td>
<div class="input-group mb-3" style="margin-bottom: 0rem !important;">
<div class="input-group-prepend">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<i class="far fa-arrow-alt-circle-down"></i>
</button>
<div class="dropdown-menu">
'.$show_button.'
'.$plus_button.'
'.$minus_button.'
'.$edit_button.'
'.$del_button.'
</div>
</div>
<!-- /btn-group -->
</div>
</td>'.

"<td>{$result['id']}</td>".
"<td>{$result['name']}</td>".
"<td>{$result['type_equipment']}</td>".
"<td>{$result['segment']}</td>".
"<td>{$result['form_factor']}</td>".
"<td>{$result['firm']}</td>".
"<td>{$result['interface']}</td>".
"<td>{$result['rpm']}</td>".
"<td>{$result['volume']}</td>".
"<td>{$result['part_number']}</td>".
"<td>{$result['monitor']}</td>".
"<td>{$result['logs']}</td>".
"<td>{$result['comment']}</td>".
"<td>$total</td>".
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
      <th class="snorting">Лог</th>
      <th class="snorting">М</th>
      <th class="snorting">Комментарий</th>
      <th class="snorting">Остаток</th>
</tr>
</tfoot>';
?>
</table>

<?php
 include ("../modal_close_shift.php");
?>

<?php 
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
  function add_disk(id,page_back) {
    $('#modal_add_disk_content').load('ajax_add_disk.php?id_disk='+id+'&page_back='+page_back,function(){
      $('#modal_add_disk').modal({show:true});
    });
}
</script>

