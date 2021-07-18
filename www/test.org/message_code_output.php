<?php
#блок вывода сообщений об операциях
if (isset ($_GET['add']) && ($_GET['add']==1)) {
  echo '
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Удачно.</h5>
    <span>Была добавлена новая запись.</span>
  </div>
  '; 
} 
else if (isset ($_GET['add']) && ($_GET['add']==2)) {
  echo '
  <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> ОТредактировано.</h5>
    <span>Запись была отредактирована.</span>
  </div>
  '; 
} 
else if (isset ($_SESSION['del']) && ($_SESSION['del']==1)) {
  echo '
  <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Удаление.</h5>
    <span>Запись была удалена.</span>
  </div>
  '; 
} 
?>