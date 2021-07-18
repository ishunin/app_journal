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
#вывод новтей с пагинацией
$page_setting = [
  'limit' => 5, // кол-во записей на странице
  'show'  => 1, // 5 до текущей и после
  'prev_show' => 0, // не показывать кнопку "предыдущая"
  'next_show' => 0, // не показывать кнопку "следующая"
  'first_show' => 0, // не показывать ссылку на первую страницу
  'last_show' => 0, // не показывать ссылку на последнюю страницу
  'prev_text' => 'назад',
  'next_text' => 'вперед',
  'class_active' => 'active',
  'separator' => '<li class="paginate_button page-item ">
        <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link"> ... </a>
        </li>',
];

$page = (int) $_GET['page'];
if (empty($page)) $page = 1; // если страница не задана, показываем первую

function pagePrint($page, $title, $show, $active_class = '')
{
  $active = 'active';
  if ($show) {
    echo '<li class="paginate_button page-item ">
        <a href="?do=list&page=' . $page . '" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</a>
        </li>
        ';
  } else {
    if (!empty($active_class)) $active = 'class="' . $active_class . '"';
    // echo '<span ' . $active . '>' . $title . '</span>';
    echo '<li class="paginate_button page-item active">
        <span aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</span>
        </li>
        ';
  }
  return false;
}
#выборка данных из БД
#подсчет количества страниц и проверка основных условий
$sql = mysqli_query($link, "SELECT count(*) AS count FROM jobs WHERE `deleted`=0");
$row = mysqli_fetch_array($sql);
#$res = $db->query("SELECT count(*) AS count FROM news {$where}");
#$row = $res->fetch(PDO::FETCH_ASSOC);
$page_count = ceil($row['count'] / $page_setting['limit']); // кол-во страниц
$page_left = $page - $page_setting['show']; // находим левую границу
$page_right = $page + $page_setting['show']; // находим правую границу
$page_prev = $page - 1; // узнаем номер предыдушей страницы
$page_next = $page + 1; // узнаем номер следующей страницы
if ($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
if ($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
if ($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
if ($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
if ($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
if ($page != $page_count) $page_setting['last_show'] = 1;
#вывод на экран
echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';
pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show']);
pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active']);
if ($page_left > 2) echo $page_setting['separator'];
for ($i = $page_left; $i <= $page_right; $i++) {
  $page_show = 1;
  if ($page == $i) $page_show = 0;
  pagePrint($i, $i, $page_show, $page_setting['class_active']);
}
if ($page_right < ($page_count - 1)) echo $page_setting['separator'];
if ($page_count != 1)
  pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active']);
pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show']);
echo '</ul></div></div>';
$start = 500;
#Вывод новостей
$start = ($page - 1) * $page_setting['limit'];
$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`,`executor`,`start_task`,`end_task`,`delay_date`  FROM `jobs` WHERE `deleted`=0 AND `status`!=4 order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");
echo '<div class="tab-content"> <div class="active tab-pane" id="activity">';
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
  $create_date = $result['Create_date'];
  $edit_date = $result['edit_date'];
  $type = $result['type'];
  $start_task = $result['start_task'];
  $end_task = $result['end_task'];
  (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') ? $delay_date = $result['delay_date'] : $delay_date = ' не указано';
    if ($status==2) {
      $delay_date = ' до '.$delay_date;
    }
    else {
      $delay_date = '';
    }
  $count++;
  $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_user . "");
  $result_user = mysqli_fetch_array($sql_user);
  $executor = "Не имеет значения";
  if ($result['executor'] != 0) {
    $sql_exec = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $id_executor . "");
    $result_exec = mysqli_fetch_array($sql_exec);
    $executor = $result_exec['first_name'] . ' ' . $result_exec['last_name'];
  }
  $count_comments = 0;
  $result_comments = mysqli_query($link, 'SELECT * FROM `comments` 
  WHERE `id_rec`="' . $ID . '" AND `type`=3
    ');
  if ($result_comments) {
    $count_comments = mysqli_num_rows($result_comments);
  }
  $theme = strip_tags($theme);
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
            <a href="#">' . $user_name . '</a>
          </span>
          <span class="description">Опубликованно - ' . $create_date . '</span>
        </div>
        <!-- /.user-block -->
        <div style="clear:left;"></div>
        <a href="one_page_jobs.php?ID='.$ID.'" class="link-black">
        <h3>'.$new_job_notify.$theme.'</h3>
        </a>
        <p>Исполнитель: <u>' . $executor . '</u> | Статус: ' . get_status($status).' <span style="color:blue;">'.$delay_date.'</span></p>
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
if ($count == 0) {
  echo '
        <blockquote class="quote-secondary">
          <p>Информация:</p>
          <small>Нет заданий для отображения.</small>
        </blockquote>
        ';
}
#вывод на экран
echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';
pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show']);
pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active']);
if ($page_left > 2) echo $page_setting['separator'];
for ($i = $page_left; $i <= $page_right; $i++) {
  $page_show = 1;
  if ($page == $i) $page_show = 0;
  pagePrint($i, $i, $page_show, $page_setting['class_active']);
}
if ($page_right < ($page_count - 1)) echo $page_setting['separator'];
if ($page_count != 1)
  pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active']);
pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show']);
echo '</ul></div></div>';
?>
</div>
</div>
<!-- Модальное окно для создания нового задания-->
<div class="modal fade show" id="modal-default">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Создать новое задание</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body2">
        <blockquote class="quote-secondary" style="margin-top: 0px;">
          <small>Следующие поля обязательны к заполнению: <cite title="Source Title">Тема, Содержание задания.</cite></small>
        </blockquote>

        <!--novalidate -->
        <form action="create_job.php" method="post" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="theme">Тема</label>
            <input type="text" name="Theme" maxlength="300" value="" class="form-control" id="theme" placeholder="Тема задания" aria-describedby="inputGroupPrepend" required>
            <div class="valid-feedback">
              Верно
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите тему задания.
            </div>
          </div>

          <div class="form-group">
            <p class="mb-1"><b>
                Важность</b>
            </p>
            <div class="btn-group btn-group-toggle" data-toggle="buttons" style="margin-bottom: 20px;">
              <label class="btn btn-secondary active">
                <input type="radio" name="Importance" id="option1" autocomplete="off" class="low_importance" value="1"> Низкая
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="Importance" id="option2" autocomplete="off" checked="" class="middle_importance" value="2"> Среднее
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="Importance" id="option3" autocomplete="off" class="high_importance" value="3"> Высокая
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="Importance" id="option3" autocomplete="off" class="high_importance" value="4"> Чрезвычайная
              </label>

            </div>
          </div>

          <div class="form-group">
            <label>Исполнитель:</label>
            <select class="custom-select" name="Executor">
              <option value="0">Не имеет значения</option>
              <?php
              $sql = mysqli_query($link, 'SELECT *  FROM `users` WHERE `department`=1 ORDER BY `last_name` ASC ');
              while ($result = mysqli_fetch_array($sql)) {
                echo ' <option value="' . $result['ID'] . '">' . $result['last_name'] . ' ' . $result['first_name'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Статус</label>
            <select class="custom-select" name="Status" id="option_status"  onchange="delay_option();">
              <option value="1">В работе</option>
              <option value="2">В ожидании</option>
              <option value="3">Выполнено</option>
              <option value="4">Закрыто</option>
            </select>
          </div>

          <div class="form-group" id="delay_date_div">
            <label>В ожидании до:</label>
              <input id="datepicker" name="Delay_date" width="276"  minlength="10" maxlength="10" autocomplete="off" value="" required />              
              <div class="valid-feedback">
                Верно
              </div>
              <div class="invalid-feedback">
                Пожалуйста, дату выхода из ожидания.
              </div>
          </div>

          <div class="form-group">
            <label>Тип</label>
            <select class="custom-select" name="Type">
              <option value="1">Наряд на работы</option>
              <option value="2">Другой тип</option>
            </select>
          </div>

          <div class="form-group">
            <label for="area_content">Содержание задания</label>
            <textarea name="Area_content" id="textarea4" class="textarea" required placeholder="Содержание новости" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"><?= isset($_GET['red_id']) ? $product['Content'] : ''; ?></textarea>
            <div class="valid-feedback">
              Верно
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите содержание задания.
            </div>
          </div>

          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch2" name="Keep" checked>
              <label class="custom-control-label" for="customSwitch2">Закрепить на панели</label>
            </div>
          </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-primary">Создать</button>
        <input type="hidden" name="page_back" value="jobs">
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

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
          <input type="hidden" name="page_back" value="jobs.php">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</form>

<?php
include("modal_close_shift.php");
?>
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
    $('#modal_edit').load('ajax_jobs.php?red_id=' + id + '&page=' + page + '&page_back=jobs.php', function() {
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
    $('#modal_comments').load('ajax_comments_jobs.php?id=' + id, function() {
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
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
?>