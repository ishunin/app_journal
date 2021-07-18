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
    $("#textarea5").summernote();
  })
</script>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <i class="far fa-envelope-open"></i></i> Новые новости для текущей смены
    </h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <?php
    #Блок функций
    #include ("func.php"); 
    #Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
    include("error_code_output.php");
    #блок вывода сообщений об операциях
    #include ("message_code_output.php");
    #include ("show_keeped_record.php");
    #include ("modal_close_shift.php");  
    $count = 0;
    if (!isset($_GET['page']) || empty($_GET['page'])) {
      $_GET['page'] = 1;
    }
    $last_login = get_last_user_login($_COOKIE['id'], $link);
    $current_login = get_current_user_login($_COOKIE['id'], $link);
    $last_shift_id = get_last_shift_id($link);
    $allow=0;
    $level_access = array (1);
    $allow = is_allow($_COOKIE['permissions'],$level_access);
    if ($allow) {
    $sql = mysqli_query($link, "SELECT *  FROM `news`  WHERE  create_date >= '$last_login' AND `deleted`=0 ORDER BY create_date DESC");
    }
    else {
      $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
    }
    if ($sql) {
      $count = 0;
      while ($result = mysqli_fetch_array($sql)) {
        $ID=$result['ID'];
        $id_user = $result['id_user'];
        $user_name =  get_user_name_by_id($result['id_user'],$link);
        $theme = mb_substr(strip_tags_smart($result['theme']), 0, 300);
        $description = mb_substr(strip_tags($result['description']), 0, 1000).' ...';  
        $content = mb_substr(strip_tags_smart($result['content']), 0, 1000).' ...';
        $status=$result['status'];
        $importance=$result['importance'];
        $keep=$result['keep'];
        $create_date=$result['Create_date'];
        $edit_date=$result['Edit_date'];
        $type=$result['type'];
        $count++;
        $sql_user = mysqli_query($link, "SELECT `ID`, `first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
        $result_user = mysqli_fetch_array($sql_user);

        $result_comments = mysqli_query($link, 'SELECT * FROM `comments` 
  WHERE `id_rec`="' . $result['ID'] . '" AND `type`=2
    ');
        $count_comments = mysqli_num_rows($result_comments);
        $content = mb_substr(strip_tags($result['content']), 0, 1000) . ' ...';
        $theme = strip_tags($result['theme']);
        //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
       $res = is_this_news_new($link,$ID);
       $new_news_notify = '';
       if ($res) {
         $new_news_notify = '<span class="right badge badge-danger">НОВАЯ!</span>&nbsp;';
       }
        echo '
        <!-- Post -->
        <div class="post">
          <div class="user-block">
          <img class="img-circle img-bordered-sm" src="'.get_user_icon($id_user, $link).'" alt="user image">
          <span class="username">
            <a href="#">' .$result_user['first_name']. ' '.$result_user['last_name'].'</a>
            <a href="#" class="float-right btn-tool"></a>
          </span>
          <span class="description">Опубликованно - '.$create_date.'</span>
        </div>
        <!-- /.user-block -->
        <div style="clear:left;"></div>
        <a href="one_page_news.php?ID='.$ID.'" class="link-black">
        <h3>'.$new_news_notify.$theme.'</h3>
        </a>
        <p>
          '.$content.'
        </p>

        <p>       
          <a href="one_page_news.php?ID=' .$ID. '" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
          <a href="#" class="link-black text-sm mr-2" onclick="showMessage5(' .$ID. ',' . $_GET['page'] . ');"> <i class="far fa-folder-open"></i> Открыть</a>
          <a href="#" class="link-black text-sm mr-2" onclick="showMessage(' .$ID. ',' . $_GET['page'] . ');"> <i class="far fa-edit"></i> Редактировать</a>   
          <a href="#" class="link-black text-sm mr-2" onclick="showMessage3(' .$ID. ');"> <i class="fas fa-trash"></i> Удалить</a>
          <span class="float-right">
            <a href="#" onclick="showMessage4(' .$ID. ')"; class="link-black text-sm">
              <i class="far fa-comments mr-1"></i> Comments 
            '.$count_comments.'
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
        <small>Нет новостей для отображения.</small>
     </blockquote>
        ';
    } else {
      echo '<small>Всего доступно ' . $count . ' новостей</small>';
    }
    ?>
    <!-- HTML-код модального окна для редактирования новости-->
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

    <!-- Модальное окно вывода комментариев -->
    <script type="text/javascript">
      function showMessage4(id) {
        $('#modal_comments').load('ajax_comments.php?id=' + id, function() {
          $('#modal-default3').modal({
            show: true
          });
        });
      }
    </script>
    <!-- HTML-код модального окна для вывода комментариев-->
    <div id="modal-default3" class="modal fade" tabindex="-1">
      <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Комментарии по данной новости</h4>
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
            <input type="hidden" id="del_id2" name="del_id">
          </div>
        </div>
      </div>
    </div>

    <!-- HTML-код модального окна для удаления новости-->
    <form action="delete_news.php" method="post">

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
              <input type="hidden" name="page_back" value="news_new.php">
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
        //});
      }
    </script>

    <!-- Модальное окно для редактирования новости -->
    <script type="text/javascript">
      function showMessage(id, page) {
        $('#modal_edit').load('ajax_news.php?red_id=' + id + '&page=' + page, function() {
          $('#modal-default2').modal({
            show: true
          });
        });
      }
    </script>

    <!-- Модальное окно для просмотра новости -->
    <script type="text/javascript">
      function showMessage5(id, page) {
        $('#modal_edit').load('ajax_news_read.php?red_id=' + id + '&page=' + page, function() {
          $('#modal-default2').modal({
            show: true
          });
        });
      }
    </script>
    <!--Модальное окно для редактирования записи-->
    <script type="text/javascript">
      function showMessage(id) {
        //  $('.openBtn').on('click',function(){
        $('#modal_edit').load('ajax_news.php?red_id=' + id + '&page_back=news_new.php', function() {
          $('#modal-default2').modal({
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