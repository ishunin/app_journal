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
#include ("message_code_output.php");
include("modal_close_shift.php");
if (isset($_GET['ID']) && (!empty($_GET['ID']))) {
  $id = intval($_GET['ID']);
  $sql = mysqli_query($link, 'SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`,`executor`,`start_task`,`end_task`,`id_user_edited`,`deleted`,`delay_date`  FROM `jobs` WHERE `ID`=' . $id);
  $result = mysqli_fetch_array($sql);
  if ($result) {
    $ID = $result['ID'];
    $id_user = $result['id_user'];
    $id_executor = $result['executor'];
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $theme = mb_substr(strip_tags($result['theme']), 0, 300);
    //Не убирает теги!
    $content = $result['content'];
    $status = $result['status'];
    $importance = $result['importance'];
    $keep = $result['keep'];
    $create_date = $result['Create_date'];
    $edit_date = $result['edit_date'];
    $type = $result['type'];
    $start_task = $result['start_task'];
    $end_task = $result['end_task'];
    $deleted = $result['deleted'];
    $str_user_edited = '';
    (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') ? $delay_date = $result['delay_date'] : $delay_date = ' не указано';
    if ($status==2) {
      $delay_date = ' до '.$delay_date;
    }
    else {
      $delay_date = '';
    }
    if ($result['id_user_edited'] != NULL && $result['id_user_edited'] != 0) {
      $id_user_edited = get_user_name_by_id($result['id_user_edited'], $link);
      $str_user_edited = '<small> <i>(Отредактировано: ' . $id_user_edited . ' в ' . $edit_date . ')</i></small>';
    }
    //запрашиваем пользователя
    $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . "");
    if ($sql_user) {
      $result_user = mysqli_fetch_array($sql_user);
    }
    if ($result['executor'] == 0) {
      $executor = "Не имеет значения";
    } else {
      $sql_user_executor = mysqli_query($link, "SELECT * FROM users WHERE `ID`=" . $id_executor . "");
      if ($sql_user) {
        $result_user_executor = mysqli_fetch_array($sql_user_executor);
        $executor = $result_user_executor['first_name'] . ' ' . $result_user_executor['last_name'];
      }
    }
    $str_class = '';
    if ($status == 3 ||  $status == 4) {
      $str_class = "class='quote-secondary div-opacity'";
    }

    $class_div = get_class_for_div($importance);
    $uploads = show_upload_files($link, $ID, 2, 'one_page_jobs.php?ID=' . $ID,3);
     //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
     $res = is_this_job_new($link,$ID);
     $new_job_notify = '';
     if ($res) {
     $new_job_notify = '<span class="right badge badge-danger">НОВОЕ!</span>&nbsp;';
     }
     $ribbon = '<div class="ribbon-wrapper ribbon-xl">
            <div class="ribbon ' . get_class_ribbon_record($result['status']) . ' text-xl"> <small>
            '.get_status_ribbon($status).'</small>
            </div>
          </div>';
      #Если диск удален - подменяем статус
    $class_div_opacity = '';
    $class_blaquote = '';

    if ($deleted==1 || $status == 3 || $status == 4 || $status == 5) {
      $class_div_opacity = 'div-opacity';
      $class_blaquote = 'quote-secondary';
    }     

    echo '
 <div class="card '.$class_div_opacity.'">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-text-width"></i> Подробный просмотр задания:</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="padding-top:2px;padding-right:2px;">
      <div class="tab-content">
      <div class="active tab-pane" id="activity">
        <!-- Post -->
        <div class="post" style="border-bottom:none;">
        <div style="position: relative;">
        '.$ribbon.'
        </div>
          <div class="user-block" style="padding-top:10px;">
            <img class="img-circle img-bordered-sm" src="' . get_user_icon($id_user, $link) . '" alt="user image">
            <span class="username">
              <a href="#">' . $result_user['first_name'] . ' ' . $result_user['last_name'] . '</a>
            </span>
            <span class="description">Опубликованно - ' . $result['create_date'] . $str_user_edited . '</span>
          </div>
          <!-- /.user-block -->
          <div style="clear:left;"> </div>
          <small>   
          <blockquote '.$str_class.'">
            <p> Исполнитель: ' . $executor . '</p>
            <p> Важность: ' . get_importance($importance) . '</p>
            <p> Статус: ' . get_status($status) . '<span style="color:blue;">'.$delay_date.'</span></p>
            <p> Тип: ' . get_type_jobs($type) . '</p>
      </blockquote>.
      </small>
          <h3>'.$new_job_notify.$theme.'</h3>
          <p>
            ' . $content . '
          </p>
          <p>
          ' . $uploads . '
          </p>
          
        </div>
        <!-- /.post -->
    </div>
    </div>
    </div>
  <!-- /.card-body -->
 <div class="card-footer">    
      <a href="#" class="link-black text-sm mr-2" onclick="showMessage(' . $ID . ');"><i class="far fa-edit"></i>Редактировать</a>
      <a href="#" class="link-black text-sm mr-2" onclick="upload_file(' . $ID . ');"><i class="fas fa-link mr-1"></i>Добавить файл</a>
       <a href="one_page_jobs_print.php?ID=' . $ID . '" target="_blank" class="link-black text-sm mr-2"><i class="fas fa-print"></i> Печать</a>
      <a href="#" class="link-black text-sm mr-2" onclick="showMessage3(' . $ID . ');"><i class="fas fa-trash"></i> Удалить</a>
 </div>
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
            <div class="tab-content" id="custom-content-below-tabContent">
              <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row" style="margin-bottom:10px;">
                <div class="col-12" >
                <div >               
';
    $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
WHERE `id_rec`=' . $result['ID'] . ' AND `type`=3 ORDER BY `create_date` DESC
  ');
    $count = 0;
    if ($sql) {
      while ($result2 = mysqli_fetch_array($sql)) {
        $count++;
        $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $result2['id_user'] . "");
        $result_user = mysqli_fetch_array($sql_user);
        $content = mb_substr(strip_tags($result2['content']), 0, 1000);
        echo '
 <div class="post">
 <small>
  <div class="user-block">

  <img class="img-circle img-bordered-sm" src="' . get_user_icon($result_user['ID'], $link) . '" alt="user image">
  <span class="username">
    <a href="#">' . $result_user['first_name'] . ' ' . $result_user['last_name'] . '</a>
  </span>
  <span class="description">Опубликовано- ' . $result2['create_date'] . '</span>
  </div>
  <!-- /.user-block -->
  <p>
  ' . $content . '
  </p>
<!--
  <p>
  <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Прикрепленный файл</a>
  </p>
  -->
  </small>
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
              '.print_all_jobs_changes($link,$ID).'         
              </div>              
            </div>
          </div>
          <!-- /.card -->
        ';
    echo '         
 <div class="card-footer">
                <form action="create_comment.php" method="post" id="comment" class="needs-validation" novalidate>
                  <img class="img-fluid img-circle img-sm" src="' . get_user_icon($_COOKIE['id'], $link) . '" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">    
                    <div class="input-group input-group-sm mb-0">
                    
                          <input class="form-control form-control-sm" maxlength="1000" placeholder="Введите комментарий..." name="content" required>
                    
                          <div class="input-group-append">
                            <input type="submit" class="btn btn-info" value="Опубликовать">
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
                    <input type="hidden" name="id_rec" value="' . $result['ID'] . '">
                    <input type="hidden" name="type" value="3">
                    <input type="hidden" name="page_back" value="one_page.php?ID=' . $result['ID'] . '">
                    <input type="hidden" name="page" value="one_page_jobs.php">      
                  </div>
                </form>
              </div>
';
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
<!-- HTML-код модального окна для редактирования новости-->
<div id="modal-default2" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_edit">
      <!-- Контент загруженный из файла "remote.php" -->
    </div>
  </div>
</div>

<!-- HTML-код модального окна для удаления новости-->
<form action="delete_jobs.php" method="post">
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
          <input type="hidden" name="page_back" value="jobs.php">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</form>
<!--Модальное окно для редактирования записи-->
<script type="text/javascript">
  function showMessage(id) {
    //  $('.openBtn').on('click',function(){
    $('#modal_edit').load('ajax_jobs.php?red_id=' + id + '&page_back=one_page_jobs.php?ID=' + id, function() {
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
  }
</script>

<?php
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
$id_rec = $id;
$type_rec=3;
$page_back = 'one_page_jobs.php?ID=' . $_GET['ID'];
$type = 2;
include("modal_upload.php");
include("modal_del_file.php");
?>