<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    $(document).ready(function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      //var forms = document.getElementById('edit_form');
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

<script>
  $(function() {
    // Summernote
    $("#textarea2").summernote();
    $("#textarea3").summernote();
  })
</script>

<?php
include("func.php");
if (!isset($_GET['page_back'])) {
  $_GET['page_back'] = 0;
}
include("scripts/conf.php");
if (isset($_GET['red_id'])) {
  $sql = mysqli_query($link, "SELECT `ID`,`id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`,`type`,`keep`,`create_date`,`edit_date`, `delay_date` FROM `list` WHERE `ID`={$_GET['red_id']}");
  while ($result = mysqli_fetch_array($sql)) {
    #Инициализируем переменные
    $ID = $result['ID'];
    $id_user = $result['id_user'];
    $id_rec = strip_tags($result['id_rec']);
    $id_shift = $result['id_shift'];
    $jira_num = strip_tags($result['jira_num']);
    ($jira_num != '') ? : $jira_num = 'б/н';
    $content = mb_substr(strip_tags_smart($result['content']), 0, 500);
    (isset($result['action']) && !empty($result['action'])) ? $action = mb_substr(strip_tags_smart($result['action']), 0, 1000) : $action = '-';
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $destination = strip_tags($result['destination']);
    ($destination != '') ? : $destination = 'б/р';
     ($destination != '') ? : $destination = 'б/р';
    $status = $result['status'];
    $importance = $result['importance'];
    $type= $result['type'];
    $keep = $result['keep'];
    $create_date = $result['create_date'];
    $edit_date = $result['edit_date'];
    (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') ? $delay_date = $result['delay_date'] : $delay_date = ' не указано';
    if ($status==2) {
      $delay_date = ' до '.$delay_date;
    }
    else {
      $delay_date = '';
    }

    if ($type==1) {
      $type_str = 'Инцидент';
    }
    else {
      $type_str = 'Заметка';
    }
    if ($keep == 1) {
      $keep =  'Да';
    } else {
      $keep =  'Нет';
    }
    if ($action == '') {
      $action =  '<p>Ничего не было сделано</p>';
    }
      //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
      $res = is_this_rec_new($link,$ID);
      $new_rec_notify = '';
      if ($res) {
        $new_rec_notify = '<span class="right badge badge-danger">НОВЫЙ!</span>';
      }

    $ribbon = '<div class="ribbon-wrapper ribbon-xl">
    <div class="ribbon ' . get_class_ribbon_record($result['status']) . ' text-xl"> <small>
    ' . get_status_ribbon($status) . '</small>
    </div>
  </div>';

    echo '
<div class="modal-header">
    <h4 class="modal-title">Просмотр информации об инциденте</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
 </div>
 <div class="modal-body" style="padding-top:2px;padding-right:2px;">
  <div style="position: relative;">
 '.$ribbon.'
 </div>
    <small>
    <blockquote class="quote-secondary-info" style="padding-top: 10px;">
    <p>Номер заявки в Jira: ' . $jira_num . '</p>
    <p>Автор: ' . get_user_name_by_id($id_user, $link) . '</p>
    <p>Тип: ' . $type_str . '  '.$new_rec_notify.'</p>
    <p>Расположение: ' . $destination . '</p>
    <p>Важность: ' . get_importance($importance) . '</p>
    <p>Статус:<b> ' . get_status($status) . '</b> <span style="color:blue">'.$delay_date.'</span></p>
    <p>Создано: ' . $create_date . '</p>
    <p>Отредактировано: ' . $edit_date . '</p>
    <p>Отредактировано: ' . $edit_date . '</p>
    <p>Закреплено: ' . $keep . '</p> 
    </blockquote> 
    </small>   
    <h3>Содержание инцидента:</h3>
    <div class="" role="alert">
    ' . $content . '
    </div>
    <h3>Что было сделано:</h3>
    <div>
    ' . $action . '
    </div> 
</div>
<div class="card card-primary card-outline">
  <div class="card-header">
  <h3 class="card-title">
    <i class="fas fa-edit"></i>
    Дополнительная панель:
  </h3>
    </div>
<div class="card-body">
<!--  <h4>Custom Content Below</h4>-->
  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 20px";>
    <li class="nav-item">
      <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Комментарии</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Изменения</a>
    </li>

  </ul>
<!--
  <div class="tab-custom-content">
    <p class="lead mb-0">Custom Content goes here</p>
  </div>
-->   
  <div class="tab-content" id="custom-content-below-tabContent">
    <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
      <div class="row" style="margin-bottom:10px;">
      <div class="col-12" >
      <div >              
';
    #Выводим комментарии !!!!ВАЖНО - ИСПРАВИТЬ ЭТО ПОТОМ, ВЫВОД ЧЕРЕЗ ОДНУ ФУНКЦИЮ!!!!!!!!!!!!
    $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
WHERE `id_rec`="' . $id_rec . '" AND `type`=1
  ');
    $count = 0;
    while ($result2 = mysqli_fetch_array($sql)) {
      $count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . "");
      $result_user = mysqli_fetch_array($sql_user);
      $user_icon =  get_user_icon($result_user['ID'], $link);
      $content_comment = mb_substr(strip_tags_smart($result2['content']), 0, 1000);
      echo '
<div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="' . get_user_icon($result2['id_user'], $link) . '" alt="user image">
                        <span class="username">
                          <a href="#">' . get_user_name_by_id($result2['id_user'], $link) . '</a>
                        </span>
                        <span class="description">Опубликовано- ' . $result2['create_date'] . '</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        ' . $content_comment . '
                      </p>
                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i></a>
                      </p>                    
                    </div>                  
';
    }
    if ($count == 0) {
      echo '
                <blockquote class="quote-secondary">
                  <small>Для данного инцидента еще никто не оставил комментария.</small>           
                </blockquote>          
  ';
    }
    echo '
</div>
</div> 
</div>
</div>
<div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
 <p>Данный раздел в процессе разработки.</p>
</div>
</div>
<a href="one_page.php?ID=' . $ID . '#comment">Оставить комментарий</a>

</div>
<!-- /.card -->
<div class="modal-footer justify-content-between">   
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <a class="btn btn-default" href="one_page_print.php?ID=' . $ID . '" class="link-black text-sm mr-2"> <i class="fas fa-print"></i> Печать</a>
    </div>
    ';
  }
}
?>