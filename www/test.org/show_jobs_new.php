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

<script>
  $(function() {
    // Summernote
    $("#textarea4").summernote();
  })
</script>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-wrench"></i> Новые задания для текущей смены
    </h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
  <?php
    #Блок функций
    #Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
    include("error_code_output.php");
    #блок вывода сообщений об операциях
    #include ("message_code_output.php");
    #include ("show_keeped_record.php");
    $count = 0;
    if (!isset($_GET['page']) || empty($_GET['page'])) {
      $_GET['page'] = 1;
    }
    include("scripts/paging.php");
    $last_login = get_last_user_login($_COOKIE['id'], $link);
    $current_login = get_current_user_login($_COOKIE['id'], $link);
    $last_shift_id = get_last_shift_id($link);
    $allow=0;
    $level_access = array (1);
    $allow = is_allow($_COOKIE['permissions'],$level_access);
    include "notif_opt.php";
    
    if ($sql) {
      while ($result = mysqli_fetch_array($sql)) {
        $ID = $result['ID'];
        $id_user = $result['id_user'];
        $id_executor = $result['executor'];
        $user_name =  get_user_name_by_id($result['id_user'], $link);
        $theme = mb_substr(strip_tags($result['theme']), 0, 300);
        $description = mb_substr(strip_tags_smart($result['description']), 0, 1000) . ' ...';
        $content = mb_substr(strip_tags_smart($result['content']), 0, 1000) . ' ...';
        $status = $result['status'];
        $importance = $result['importance'];
        $keep = $result['keep'];
        $create_date = $result['create_date'];
        $edit_date = $result['edit_date'];
        $type = $result['type'];
        $start_task = $result['start_task'];
        $end_task = $result['end_task'];
        $num_rows_incidents = mysqli_num_rows($sql);
        $count++;
        $sql_user = mysqli_query($link, "SELECT `ID`, `first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . " ");
        $result_user = mysqli_fetch_array($sql_user);
        $result_comments = mysqli_query($link, 'SELECT * FROM `comments` 
  WHERE `id_rec`="' . $result['ID'] . '" AND `type`=3
    ');
        $count_comments = mysqli_num_rows($result_comments);
        $content = mb_substr(strip_tags($result['content']), 0, 1000) . ' ...';
        $theme = strip_tags($result['theme']);
        if ($result['executor'] == 0) {
          $executor = "Не имеет значения";
        } else {
          $sql_user_executor = mysqli_query($link, "SELECT * FROM users WHERE `ID`=" . $id_executor . "");
          if ($sql_user) {
            $result_user_executor = mysqli_fetch_array($sql_user_executor);
            $executor = $result_user_executor['first_name'] . ' ' . $result_user_executor['last_name'];
          }
        } 
        //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
        $res = is_this_job_new($link,$ID);
        $new_job_notify = '';
        if ($res) {
        $new_job_notify = '<span class="right badge badge-danger">НОВОЕ!</span>&nbsp;';
        }

        echo '
        <!-- Post -->
        <div class="post">
          <div class="user-block">
            <img class="img-circle img-bordered-sm" src="' . get_user_icon($id_user, $link) . '" alt="user image">
            <span class="username">
              <a href="#">' . $result_user['first_name'] . ' ' . $result_user['last_name'] . '</a>
              <a href="#" class="float-right btn-tool"></a>
            </span>
            <span class="description">Опубликованно - ' . $create_date . '</span>
          </div>
          <!-- /.user-block -->
          <div style="clear:left;"></div>
          <a href="one_page_jobs.php?ID='.$ID.'" class="link-black">
          <h3>'. $new_job_notify.$theme.'</h3>
          </a>
          <p>Исполнитель: <u>' . $executor . '</u> | Статус: ' . get_status($status) . '</p>
          
          <p>
             ' . $content . '
          </p>

          <p>
          
            <a href="one_page_jobs.php?ID=' . $ID . '" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
            <a href="#" class="link-black text-sm mr-2" onclick="showMessage5(' . $ID . ',' . $_GET['page'] . ');"><i <i class="far fa-folder-open"></i> Открыть</a>
            <a href="#" class="link-black text-sm mr-2" onclick="showMessage(' . $ID . ',' . $_GET['page'] . ');"><i <i class="far fa-edit"></i> Редактировать</a>
      
            <a href="#" class="link-black text-sm mr-2" onclick="showMessage3(' . $ID . ');"><i class="fas fa-trash"></i> Удалить</a>
            <span class="float-right">
              <a href="#" onclick="showMessage4(' . $ID . ')"; class="link-black text-sm">
                <i class="far fa-comments mr-1"></i> Comments 
               ' . $count_comments . '
              </a>
            </span>
          </p>
        </div>
        <!-- /.post -->                                               
';
      }
    }
    if ($count == 0) {
      echo '
                   <blockquote class="quote-secondary">
                     <p>Информация:</p>
                     <small>Нет заданий для отображения.</small>
                   </blockquote>
        ';
    } else {
      echo '<small>Всего доступно ' . $count . ' заданий</small>';
    }
    #вывод на экран

    ?>

    <!-- HTML-код модального окна для редактирования задания-->
    <div id="modal-default2" class="modal fade" tabindex="-1">
      <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_edit">
          <!-- Контент загруженный из файла "remote.php" -->
        </div>
      </div>
    </div>

    <!-- HTML-код модального окна для просмотра новости-->
    <div id="modal-default2" class="modal fade" tabindex="-1">
      <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_edit">
          <!-- Контент загруженный из файла "remote.php" -->
        </div>
      </div>
    </div>

    <!-- HTML-код модального окна для вывода комментариев-->
    <div id="modal-default3" class="modal fade" tabindex="-1">
      <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Комментарии по данному заданию</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="modal_comments">
            <!-- Контент загруженный из файла "remote.php" -->
          </div>

          <div class="modal-footer justify-content-between">
            <!--<button type="button" class="btn btn-default" data-dismiss="modal">выйти</button>
             <button type="submit" class="btn btn-outline-light">Удалить</button>-->
            <input type="hidden" id="del_id2" name="del_id2">
          </div>
        </div>
      </div>
    </div>

    <!-- HTML-код модального окна для удаления задания-->
    <form action="delete_jobs.php" method="post">

      <div class="modal fade" id="modal-danger" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Уверены что хотите удалить задание?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">выйти</button>
              <button type="submit" class="btn btn-outline-light">Удалить</button>
              <input type="hidden" id="del_id" name="del_id">
              <input type="hidden" name="page_back" value="jobs_new.php">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </form>

    <!-- Модальное окно создания новой новости -->
    <script type="text/javascript">
      function showMessage2() {
        $('#modal-default').modal({
          show: true
        });
      }
    </script>

    <!--Модальное окно для редактирования записи-->
    <script type="text/javascript">
      function showMessage(id) {
        //  $('.openBtn').on('click',function(){
        $('#modal_edit').load('ajax_jobs.php?red_id=' + id + '&page_back=jobs_new.php', function() {
          $('#modal-default2').modal({
            show: true
          });
        });
      }
    </script>

    <!-- Модальное окно для просмотра новости -->
    <script type="text/javascript">
      function showMessage5(id, page) {
        $('#modal_edit').load('ajax_jobs_read.php?red_id=' + id + '&page=' + page, function() {
          $('#modal-default2').modal({
            show: true
          });
        });
      }
    </script>
    <!-- Модальное окно для редактирования новости -->
    <script type="text/javascript">
      function showMessage4(id) {
        $('#modal_comments').load('ajax_comments_jobs.php?id=' + id + '&page_back=jobs_new', function() {
          $('#modal-default3').modal({
            show: true
          });
        });
      }
    </script>

    <!-- Удаление записи -->
    <script type="text/javascript">
      function showMessage3(id) {

        $('#modal-danger').modal({
          show: true
        });
        $('#del_id').val(id);
        //});
      }
    </script>
    <?php
    include("modal_close_shift.php");
    if (isset($_SESSION['success_action'])) {
      echo get_action_notification($_SESSION['success_action']);
    }
    ?>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->