<?php
#Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
if (isset ($_GET['error'])) {
  echo '
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Предупреждение</h5>
    <span> '.get_error_by_id ($_GET['error']).'</span>
  </div>
  ';
}
