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
#include("message_code_output.php");
if (isset($_GET['ID']) && (!empty($_GET['ID']))) {
  $_GET['ID'] = intval($_GET['ID']);
  $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
    `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date`  FROM `list` WHERE `ID`=' . $_GET['ID'] . '');
  $result = mysqli_fetch_array($sql);
  if ($result) {
    echo '
    <script>
    $(document).ready ( function(){
     showComments(`' . $result['id_rec'] . '`);
     });
     </script>
     ';
    //запрашиваем пользователя
    $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
    if ($sql_user) {
      $result_user = mysqli_fetch_array($sql_user);
    }
    #значение по умолчанию для полей
    if (isset($result['action']) && empty($result['action'])) {
      $result['action'] = "Ничего не сделано";
    }
    $action_str = '';
    $str_class = '';
   
  #проверяем наличие прав доступа
  $allow=0;
  $userdata = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM users WHERE ID = '".intval($_COOKIE['id'])."' LIMIT 1")); 
  $allow = is_allow($userdata['users_hash'], $userdata['ID']);
  if ($allow){
      $action_str = '
     <div class="card-footer">
    <p>

                        <a href="#" class="link-black text-sm mr-2" onclick="showMessage(`' . $result['ID'] . '`);"> <i class="far fa-edit"></i> Редактировать</a>
                        <a href="one_page_print.php?ID=' . $result['ID'] . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>
                  
                        <a href="#" class="link-black text-sm mr-2" onclick="showMessage3(`' . $result['ID'] . '`);"><i class="fas fa-trash"></i> Удалить</a>
                      </p>
     </div>

     ';
    } else {
      $action_str = '
      <div class="card-footer">
     <p>
         <a href="one_page_print.php?ID=' . $result['ID'] . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>
      </p>
      </div>
 
      ';
      $str_class = "class='quote-secondary'";
    }

    if ($result['status']==3 ||  $result['status']==4) {
      $str_class = "class='quote-secondary'";
    }

    if (empty(trim($result['action']))) {
      $result['action'] = 'Ничего не было сделано по заявке';
    }
    $class_div = get_class_for_div_content($result['importance']);
    echo '
  <div class="card">
  <div class="card-header">
  <h3 class="card-title">
  <i class="fas fa-text-width"></i>
  Описание инцидента
  </h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body '.$class_div.'">

  <div class="user-block">
  <img class="img-circle img-bordered-sm" src="'.get_user_icon($result_user['ID'],$link).'" alt="user image">
  <span class="username">
    <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>

  </span>
  <span class="description">Опубликованно - '.$result['create_date'].'</span>
</div>
<!-- /.user-block -->
<div style="clear:left;"> </div>

  <blockquote ' . $str_class . '>

  <small>
  <p>Номер заявки в Jira: ' . $result['jira_num'] . '</p>
  <p>Расположение: ' . $result['destination'] . '</p>
  <p>Важность: ' . get_importance($result['importance']) . '</p>
  <p>Статус: ' . get_status($result['status']) . '</p>
  <p>Отредактировано: ' . $result['edit_date'] . '</p>
  </small>
  </blockquote>
  <dl> 
  <dt><h4>Содержание инцидента:</h4></dt>
  <dd>
  <div class="" role="alert">
  ' . $result['content'] . '</div></dd>
  <dt><h4>Что было сделано: </h4></dt>
  <dd> <div> ' . $result['action'] . '</div></dd> 
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
  WHERE `id_rec`="' . $result['id_rec'] . '" AND `type`=1
  ');
  
    $count = 0;
    if ($sql) {
    while ($result2 = mysqli_fetch_array($sql)) {
      $count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
      $result_user = mysqli_fetch_array($sql_user);

      $user_icon =  get_user_icon($result_user['ID'], $link);
      $content=mb_substr(strip_tags($result2['content']),0,1000);
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
  ' . $content. '
  </p>

  <p>
  <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> </a>
  </p>
  </div>

  ';
    }
  }
    if ($count == 0) {
      echo '
  <blockquote class="quote-secondary">
  <p>Информация:</p>
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
Данный раздел в процессе разработки.
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
    $('#modal_edit').load('ajax.php?red_id=' + id + '&page_back=one_page.php?ID='+id, function() {
      $('#modal-default2').modal({
        show: true
      });
    });
    //});
  }
</script>

<!--Модальное окно для удаления записи-->
<script type="text/javascript">
  function showMessage3(id) {
    $('#modal-danger').modal({
      show: true
    });
    $('#del_id').val(id);
    //});
  }
</script>

<script type="text/javascript">
  function showComments(id, comment) {
    //  $('.openBtn').on('click',function(){
    $('#comments').load('comments.php?id_rec=' + id, function() {
    });
    //});
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
?>