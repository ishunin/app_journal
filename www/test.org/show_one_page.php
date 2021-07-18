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
<?php
#Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
include("error_code_output.php");
#блок вывода сообщений об операциях
include("modal_close_shift.php");
#include("message_code_output.php");
if (isset($_GET['ID']) && (!empty($_GET['ID']))) {
  $id = intval($_GET['ID']);
  $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
    `destination`, `status`,`importance`,`type`,`keep`,`create_date`,`edit_date`,`id_user_edited`,`delay_date`,`deleted`  FROM `list` WHERE `ID`=' . $_GET['ID'] . '');
  $result = mysqli_fetch_array($sql);
  if ($result) {
    #Инициализируем переменные
    $ID = $result['ID'];
    $id_rec = strip_tags($result['id_rec']);
    $id_shift = $result['id_shift'];
    $jira_num = strip_tags($result['jira_num']);
    ($jira_num != '') ? : $jira_num = 'б/н';
    //Не убирает теги!
    //$content = mb_substr(strip_tags($result['content']), 0, 500) . '...';    
    $content = $result['content'];
    //(isset($result['action']) && !empty($result['action'])) ? $action = mb_substr(strip_tags($result['action']), 0, 300) : $action = '-';
    (isset($result['action']) && !empty($result['action'])) ? $action = $result['action'] : $action = '-';
    $id_user = $result['id_user'];
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $destination = strip_tags($result['destination']);
    ($destination != '') ? : $destination = 'б/р';
    $status = $result['status'];
    $importance = $result['importance'];
    $type = $result['type'];
    $keep = $result['keep'];
    $create_date = $result['create_date'];
    $edit_date = $result['edit_date'];
    $deleted = $result['deleted'];
    (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') ? $delay_date = $result['delay_date'] : $delay_date = ' не указано';
    if ($status==2) {
      $delay_date = ' до '.$delay_date;
    }
    else {
      $delay_date = '';
    }

    $str_user_edited = '';
    if ($result['id_user_edited'] != NULL && $result['id_user_edited'] != 0) {
      $id_user_edited = get_user_name_by_id($result['id_user_edited'], $link);
      $str_user_edited = '<small> <i>(Отредактировано: ' . $id_user_edited . ' в ' . $edit_date . ')</i></small>';
    }
    $id_rec = $result['id_rec'];
    echo '
    <script>
    $(document).ready ( function(){
     showComments(`' . $result['id_rec'] . '`);
     });
     </script>
     ';
    //запрашиваем пользователя
    $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . "");
    if ($sql_user) {
      $result_user = mysqli_fetch_array($sql_user);
    }
    #значение по умолчанию для полей
    if (isset($action) && empty($action)) {
      $result['action'] = "Ничего не сделано";
    }
    $action_str = '';
    $str_class = '';
    $action_str = '';
    $edit_str = '';
    if ($type==1) {
      $type_str = 'Инцидент';
    }
    else {
      $type_str = 'Заметка';
    }

    #Блок Приняток сведению
    $button_taken_into_consideration_str = '';
    $taken_into_consideration = is_record_taken_into_consideration_inc($link,$id_rec,$_COOKIE['id']);
    if ($taken_into_consideration) {
     $taken_into_consideration_str = "Принято к сведению <i class='fas fa-check' style='color:green;'></i>";
    }
    else {
     $taken_into_consideration_str = "Принято к сведению <i class='fas fa-times' style='color:red';></i>";
     $button_taken_into_consideration_str = '<a href="take_into_account_inc.php?ID='.$ID.'&id_rec='.$id_rec.'" class="link-black text-sm mr-2"><i class="fas fa-check"></i> Принять к сведению</a>';
    }
    $mas_users_checked = array();
    $mas_users_checked = who_checked_record_inc($link,$id_rec);

    $user_name_checked_str = '';    
    if (!empty($mas_users_checked)){
    $user_name_checked_str = "<small><blockquote style='border-left: .2rem solid #007bff; margin: 0.0em .0rem; padding: .0em .5rem;'><b> Уже принято к сведению пользователями:</b><br/>";
    foreach ($mas_users_checked as $value) {
    $user_name_checked_str .= '<i class="fas fa-check" style="color:green;"></i> '.get_user_name_by_id($value, $link).'<br>';
    }
    $user_name_checked_str .= "</small></blockquote>";
   }

    #проверяем наличие прав доступа
    $level_access_but = array(1, 5);
    $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
    if ($is_allowed_button) {
    }
    $info_str = '';
    if (is_shift_open($result['id_shift'], $link)) {
      if ($is_allowed_button) {  
        $edit_str .= '
      '.$button_taken_into_consideration_str.'
      <a href="#" class="link-black text-sm mr-2" onclick="showMessage(`' . $ID . '`);"> <i class="far fa-edit"></i> Редактировать</a>
      <a href="#" class="link-black text-sm mr-2" onclick="upload_file(' . $ID . ');"><i class="fas fa-link mr-1"></i>Добавить файл</a>     
      <a href="#" class="link-black text-sm mr-2" onclick="showMessage3(`' . $ID . '`);"><i class="fas fa-trash"></i> Удалить</a>
      ';
      }
      else {
        $info_str = '<small>* Для других опций требуется повышение прав</small>';
      }
    }
    $action_str .= '
      <div class="card-footer">
      ' . $edit_str . '
      '.$button_taken_into_consideration_str.'
      <a href="one_page_print.php?ID=' . $ID . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>'.$info_str.'
      </div>
 
      ';
    $str_class = "'";

    if ($status == 3 ||  $status == 4 || $deleted) {
      $str_class = "class='quote-secondary div-opacity'";
    }

    if (empty(trim($result['action']))) {
      $action = 'Ничего не было сделано по заявке';
    }
    $class_div = get_class_for_div_content($result['importance']);

    $uploads = show_upload_files_shift($link, $id_rec, 3, 'one_page.php?ID=' . $id, $id_shift);

    $ribbon = '<div class="ribbon-wrapper ribbon-xl">
            <div class="ribbon ' . get_class_ribbon_record($result['status']) . ' text-xl"> <small>
            ' . get_status_ribbon($status) . '</small>
            </div>
          </div>';
    //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
    $res = is_this_rec_new($link,$ID);
    $new_rec_notify = '';
    if ($res) {
      $new_rec_notify = '<span class="right badge badge-danger">НОВЫЙ!</span>';
    } 
    

  echo '
  <div class="card">
  <div class="card-header">
  <h3 class="card-title">
  <i class="fas fa-text-width"></i>
  Описание инцидента
  </h3>
  
  </div>
  <!-- /.card-header -->
  <div class="card-body" style="padding-top:2px;padding-right:2px;">
  <div style="clear:left;">
  </div>
  <div style="position: relative;">
 '.$ribbon.'
 </div>
  <div class="user-block" style="padding-top:10px;">
  <img class="img-circle img-bordered-sm" src="' . get_user_icon($id_user, $link) . '" alt="user image">
  <span class="username">
    <a href="#">' . $result_user['first_name'] . ' ' . $result_user['last_name'] . '</a>
  </span>
  <span class="description">Опубликованно - ' . $create_date . $str_user_edited . '</span>
</div>
<!-- /.user-block -->
<div style="clear:left;"> </div>
  <blockquote ' . $str_class . ' >
  <small>
  <p>Тип: ' . $type_str.' '.$new_rec_notify.'</p>
  <p>Номер заявки в Jira: <a class="link-black" target="_blank" href="https://servicedesk:8443/browse/'.$jira_num.'">' . $jira_num . '</a></p>
  <p>Расположение: ' . $destination . '</p>
  <p>Важность: ' . get_importance($importance) . '</p>
  <p>Статус:<b> ' . get_status($status) . '</b> <span style="color:blue">'.$delay_date.'</span></p>
  <p>Отредактировано: ' . $edit_date . '</p>
  </small>
  </blockquote>
  <dl> 
  <dt><h4>Содержание инцидента:</h4></dt>
  <dd>
  <div class="" role="alert">
  ' . $content . '</div>
  </dd>
  <dt><h4>Что было сделано: </h4></dt>
  <dd> <div> ' . $action . '</div></dd> 
  <div>
  ' . $uploads . '
  </div>
  <div style="text-align:right; float:right; padding-right: 1.25rem;">
  <small>
  '. $taken_into_consideration_str.'
  </small>
  </div>
  <small>
  '.$user_name_checked_str.'
  </small>

  </dl>
  </div>
  <!-- /.card-body -->
   ' . $action_str . '
  </div>   

     
  ';
  
    echo '
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
    #echo $_GET['id_rec'];
    $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
  WHERE `id_rec`="' . $result['id_rec'] . '" AND `type`=1 ORDER BY `create_date` DESC
  ');

    $count = 0;
    if ($sql) {
      while ($result2 = mysqli_fetch_array($sql)) {
        $count++;
        $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
        $result_user = mysqli_fetch_array($sql_user);

        $user_icon =  get_user_icon($result_user['ID'], $link);
        $content = mb_substr(strip_tags($result2['content']), 0, 1000);
        echo '
        <div class="post" style="padding-bottom: 0px;">
        <div class="user-block">
        <img class="img-circle img-bordered-sm" src="' . get_user_icon($result2['id_user'], $link) . '" alt="user image">
        <span class="username">
        <a href="#">' . get_user_name_by_id($result2['id_user'], $link) . '</a>
        </span>
        <span class="description">Опубликовано- ' . $result2['create_date'] . '</span>
        </div>
        <!-- /.user-block -->
        <p style="font-size:14px;">
        ' . $content . '
        </p>
        <!--
        <p>
        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> </a>
        </p>
        -->
        </div>
        ';
      }
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
'.print_all_list_changes($link,$id_rec).'
</div>
</div>
</div>
<!-- /.card -->
';
    $author_icon = get_user_icon($_COOKIE['id'], $link);
    $comments_str = '               
              <div class="card-footer">
              <form action="create_comment.php" method="post" id="comment" class="needs-validation" novalidate>
              <img class="img-fluid img-circle img-sm" src="' . $author_icon . '" alt="Alt Text">
              <!-- .img-push is used to add margin to elements next to floating images -->
              <div class="img-push">    
              <div class="input-group input-group-sm mb-0">

              <input class="form-control form-control-sm" placeholder="Введите комментарий..." name="content" required>

              <div class="input-group-append">
              <input type="submit" maxlength="1000" class="btn btn-info" value="Опубликовать">
              </div>
              <div class="valid-feedback">
              Верно
              </div>
              <div class="invalid-feedback">
              Пожалуйста, введите текст комментария.
              </div>
              </div>
              <input type="hidden" name="id" value="' . $_GET['ID'] . '">
              <input type="hidden" name="id_user" value="' . $_COOKIE['id'] . '">
              <input type="hidden" name="id_rec" value="' . $result['id_rec'] . '">
              <input type="hidden" name="page" value="one_page.php">
              <input type="hidden" name="page_back" value="one_page.php">
              <input type="hidden" name="type" value="1">
              </div>
              </form>
              </div>
              ';
    echo  $comments_str;
  } else {
    echo '
  <div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-ban"></i> Запись не была выбрана!</h5>
  Ошибка при обращении к базе данных либо такой записи не существует.
  </div>
  ';
  }
}
?>
</div>

<div id="modal-default2" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_edit">
      <!-- Контент загруженный из файла "remote.php" -->
    </div>
  </div>
</div>



<!--Модальное окно для редактирования записи-->
<script type="text/javascript">
  function showMessage(id) {
    //  $('.openBtn').on('click',function(){
    $('#modal_edit').load('ajax.php?red_id=' + id + '&page_back=one_page.php?ID=' + id, function() {
      $('#modal-default2').modal({
        show: true
      });
    });
  }
</script>

<!--Модальное окно для удаления записи-->
<script type="text/javascript">
  function showMessage3(id) {
    $('#modal-danger').modal({
      show: true
    });
    $('#del_id').val(id);
  }
</script>

<script type="text/javascript">
  function showComments(id, comment) {
    //  $('.openBtn').on('click',function(){
    $('#comments').load('comments.php?id_rec=' + id, function() {});
  }
</script>
<!-- Форма удаления записи -->
<form action="delete.php" method="post">
  <div class="modal fade" id="modal-danger" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Уверены что хотите удалить?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">выйти</button>
          <button type="submit" class="btn btn-outline-light">Удалить</button>
          <input type="hidden" id="del_id" name="del_id">
          <input type="hidden" name="page_back" value="incidents.php">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</form>

<?php
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}

$page_back = 'one_page.php?ID=' . $_GET['ID'];
$type = 3;
$type_rec=1;
include("modal_upload.php");
include("modal_del_file.php");
?>