<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-exclamation-circle"></i> Новые инциденты для текущей смены
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
    include("modal_close_shift.php");
    ?>
    <!-- Выводим таблицу инцидентов -->
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <!-- Заголовок таблицы -->
          <th class="snorting"></th>
          <th class="snorting">№</th>
          <th class="snorting">Содержание инцидента</th>
          <th class="snorting">Выполнено</th>
          <th class="snorting">Автор</th>
          <th class="snorting">Распол.</th>
          <th class="snorting">Статус</th>
          <th class="snorting">Создано</th>
          <th class="snorting"><i class="far fa-comments mr-1"></i> </th>
        </tr>
      </thead>
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
      <!-- HTML-код модального окна -->
      <div id="modal-default2" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="max-width: 900px;">
          <div class="modal-content" id="modal_edit">
            <!-- Контент загруженный из файла "remote.php" -->
          </div>
        </div>
      </div>
      <?php
      if (!isset($_GET['ID'])) {
        $id_shift = get_last_shift_id($link);
      } else {
        $id_shift = $_GET['ID'];
      }
      $count = 0;
      $last_login = get_last_user_login($_COOKIE['id'], $link);
      $current_login = get_current_user_login($_COOKIE['id'], $link);
      $last_shift_id = get_last_shift_id($link);
      $allow=0;
      $level_access = array (1);
      $allow = is_allow($_COOKIE['permissions'],$level_access);
      if ($allow) {
      $sql = mysqli_query($link, "SELECT *  FROM `list`  WHERE id_shift=$last_shift_id AND Create_date >= '$last_login' AND `deleted`=0 ORDER BY create_date DESC");
      }
      else {
        $sql = mysqli_query($link, "SELECT *  FROM `list` WHERE id_shift=$last_shift_id AND Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
      }
      if ($sql) {
        echo '<tbody>';
        while ($result = mysqli_fetch_array($sql)) {
          #Инициализируем переменные
          $ID = $result['ID'];
          $id_rec = strip_tags($result['id_rec']);
          $id_user = $result['id_user'];
          $id_shift = $result['id_shift'];
          $jira_num = strip_tags($result['jira_num']);
          ($jira_num != '') ? : $jira_num = 'б/н';
          $content = mb_substr(strip_tags_smart($result['content']), 0, 500) . '...';
          (isset($result['action']) && !empty($result['action'])) ? $action = mb_substr(strip_tags($result['action']), 0, 300) : $action = '-';
          $id_user = $result['id_user'];
          $user_name =  get_user_name_by_id($result['id_user'], $link);
          $destination = strip_tags($result['destination']);
          ($destination != '') ? : $destination = 'б/р';
          $status = $result['status'];
          $importance = $result['importance'];
          $type = $result['type'];
          $keep = $result['keep'];
          $create_date = $result['create_date'];
          (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') ? $delay_date = $result['delay_date'] : $delay_date = ' не указано';
          if ($status==2) {
            $delay_date = explode(" ", $delay_date);
            $delay_date = ' до '.$delay_date[0];
          }
          else {
            $delay_date = '';
          }
          $note = '';
          if ($type==2) {
          $note = '<span class="badge badge-info right">NOTE</span>';
          }
          $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . "");
          $result_user = mysqli_fetch_array($sql_user);
          #подчсет количества комментариев
          $result_comments = mysqli_query($link, 'SELECT * FROM `comments` 
  WHERE `id_rec`="' . $id_rec . '" AND `type`=1
    ');
          $count_comments = mysqli_num_rows($result_comments);
          $comments_str = '
<span class="float-right">
                          <a href="#" onclick="showMessage4(' . $ID . ',`' . $id_rec . '`,' . $id_shift . ')"; class="link-black text-sm">
                           ' . $count_comments . '
                          </a>
  ';
          if (is_shift_open($id_shift, $link) == 1) {
            $action_str = '
<a class="dropdown-item" href="#" onclick="showMessage5(' . $ID . ');" >Просмотр</a>
<a class="dropdown-item" href="one_page.php?ID=' . $ID . '">Открыть</a>
<a class="dropdown-item" href="#" onclick="showMessage(`' . $ID . '`);" >Редактировать</a>
<a class="dropdown-item" href="#" onclick="showMessage3(`' . $ID . '`);">Удалить</a>
';
            $coment_str = '
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="one_page.php?ID=' . $ID . '#comment">Оставить комментарий</a>
</div>
';
          } else {
            $action_str = '
<a class="dropdown-item" href="one_page.php?ID=' . $ID . '">Открыть</a>
';
            $coment_str = '';
          }

           //проверяем является ли инцидент новым !! Костыль - лишние запросы к БД !!
    $res = is_this_rec_new($link,$ID);
    $new_rec_notify = '';
    if ($res) {
      $new_rec_notify = '<span class="right badge badge-danger">НОВЫЙ!</span>';
    }

          echo "<tr class=" . set_importance_class($importance) . ">" .
            '<td>
               <div class="input-group mb-3" style="margin-bottom: 0rem !important;">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <i class="far fa-arrow-alt-circle-down"></i>
                    </button>
                    <div class="dropdown-menu">
                      ' . $action_str . '
                 ' . $coment_str . '
                  </div>
                  <!-- /btn-group -->
                </div>           
             </td>' .
            "<td><a class='link-black' target='_blank' href='https://servicedesk:8443/browse/" . $jira_num . "' >$jira_num</a></td>" .
            "<td>
             $new_rec_notify $note $content
            </br>
            <span style='font-size:12px;'><a href='one_page.php?ID=" . $ID . "' class='link-black'><i class='fas fa-share mr-1' ></i>подробнее</a></span>
            </td>" .
            "<td>$action</td>" .
            "<td>
            <a href='profile.php?id=$id_user' class='link-black'> $user_name </a>
            </td>" .
            "<td>$destination</td>" .
            "<td style='width:100px;'><small><b>" . get_status($status) . "</b> <span style='color:blue'> ".$delay_date."</span></small></td>" .
            "<td class='td_row_create_incident'>$create_date</td>" .
            "<td style='width:15px;'>" . $comments_str . " </td>" .
            '</tr> 
           ';
        }
      }
      echo ' </tbody> 
   <tfoot>
      <tr>
        <th></th>
        <th>№</th>
        <th>Содержание инцидента</th>
        <th>Выполнено</th>
        <th>Автор</th>
        <th>Распол.</th>
        <th>Статус</th>
        <th>Cоздано</th>
        <th><i class="far fa-comments mr-1"></i> </th>
        
      </tr>
   </tfoot>';
      ?>
    </table>
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
              <input type="hidden" name="page_back" value="incidents_new.php">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </form>
    <!-- HTML-код модального окна для вывода комментариев-->
    <div id="modal-default3" class="modal fade" tabindex="-1">
      <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Комментарии по данному инциденту</h4>
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
    <!-- HTML-код модального окна просмотра-->
    <div id="modal-default5" class="modal fade" tabindex="-1">
      <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_show">
          <!-- Контент загруженный из файла "remote.php" -->
        </div>
      </div>
    </div>
    <script type="text/javascript">
      function showMessage(id) {
        //  $('.openBtn').on('click',function(){
        $('#modal_edit').load('ajax.php?red_id=' + id + '&page_back=incidents_new.php', function() {
          $('#modal-default2').modal({
            show: true
          });
        });
        //});
      }
    </script>

    <script type="text/javascript">
      function showMessage2() {
        $('#modal-default').modal({
          show: true
        });
        //});
      }
    </script>

    <script type="text/javascript">
      function showMessage3(id) {

        $('#modal-danger').modal({
          show: true
        });
        $('#del_id').val(id);
        //});
      }
    </script>

    <!-- Модальное окно для вывода комментариев -->
    <script type="text/javascript">
      function showMessage4(id, id_rec, id_shift) {
        $('#modal_comments').load('ajax_comments_incidents.php?id=' + id + '&&id_rec=' + id_rec + '&&id_shift=' + id_shift, function() {
          $('#modal-default3').modal({
            show: true
          });
        });
      }
    </script>

    <!-- Модальное окно для просмотра инциента-->
    <script type="text/javascript">
      function showMessage5(id) {
        //  $('.openBtn').on('click',function(){
        $('#modal_show').load('ajax_show.php?red_id=' + id, function() {
          $('#modal-default5').modal({
            show: true
          });
        });
        //});
      }
    </script>
    <?php
    #include ("action_notifications.php");
    if (isset($_SESSION['success_action'])) {
      echo get_action_notification($_SESSION['success_action']);
    }
    ?>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->