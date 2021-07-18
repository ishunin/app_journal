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
      <th class="snorting">Создано&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
      <th class="snorting"><i class="far fa-comments mr-1"></i> </th>
    </tr>
  </thead>
 
  <!-- HTML-код модального окна -->
  <div id="modal-default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
      <div class="modal-content" id="modal_edit">
        <!-- Контент загруженный из файла "remote.php" -->
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

  <?php
  if (!isset($_GET['ID'])) {
    $id_shift = get_last_shift_id($link);
  } else {
    $id_shift = $_GET['ID'];
  }
  $count = 0;
  $sql = mysqli_query($link, "SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
    `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date`  FROM `list` WHERE id_shift=$id_shift ORDER BY create_date DESC");
  echo '<tbody>';
  while ($result = mysqli_fetch_array($sql)) {
    $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name`,`users_hash` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
    $result_user = mysqli_fetch_array($sql_user);

    #подчсет количества комментариев
    $result_comments = mysqli_query($link, 'SELECT * FROM `comments` 
  WHERE `id_rec`="' . $result['id_rec'] . '" AND `type`=1
    ');
    $count_comments=0;
    if ( $result_comments) {
    $count_comments = mysqli_num_rows($result_comments);
    }

    $comments_str = '

<span class="float-right">
                          <a href="#" onclick="showMessage4(' . $result['ID'] . ',`' . $result['id_rec'] . '`,' . $id_shift . ')"; class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> 
                           ' . $count_comments . '
                          </a>
  ';
    
 #проверяем наличие прав доступа
$allow=0;
$userdata = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM users WHERE ID = '".intval($_COOKIE['id'])."' LIMIT 1")); 

  //  if (is_shift_open($id_shift, $link) == 1) {
    $allow = is_allow($userdata['users_hash'], $userdata['ID']);
    if ($allow){
      $action_str = '
<a class="dropdown-item" href="#" onclick="showMessage5(`' . $result['ID'] . '`);" >Просмотр</a>
<a class="dropdown-item" href="one_page.php?ID=' . $result['ID'] . '">Открыть</a>
                      <a class="dropdown-item" href="#" onclick="showMessage2();">Создать</a>
                      <a class="dropdown-item" href="#" onclick="showMessage(`' . $result['ID'] . '`);" >Редактировать</a>
                      <a class="dropdown-item" href="#" onclick="showMessage3(`' . $result['ID'] . '`);">Удалить</a>
';
      $coment_str = '
<div class="dropdown-divider"></div>
 <a class="dropdown-item" href="one_page.php?ID=' . $result['ID'] . '#comment">Оставить комментарий</a>
  </div>
';
    } else {
      $action_str = '
<a class="dropdown-item" href="one_page.php?ID=' . $result['ID'] . '">Открыть</a>
';
      $coment_str = '';
    }

    

    $content=mb_substr(strip_tags($result['content']),0,300).' ...';
    $action=mb_substr(strip_tags($result['action']),0,300).' ...';

    #Понадобится потом
#<div class="input-group mb-3">
#<img class='img-circle img-bordered-sm' src=".get_user_icon($result_user['ID'],$link)." alt='user image' width='50'>
#{$result_user['last_name']}  
    echo "<tr class=" . set_importance_class($result['importance']) . ">" .
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
      "<td>{$result['jira_num']}</td>" .
      "<td>{$content}</td>" .
      "<td>{$action}</td>" .
      "<td>     
      {$result_user['last_name']} 
      </td>" .
      "<td>{$result['destination']}</td>" .
      "<td>" . get_status($result['status']) . "</td>" .
      "<td class='td_row_create_incident'>{$result['create_date']}</td>" .
      "<td>" . $comments_str . " </td>" .
      '</tr> 
           ';
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
<!--             
<p><a href="?add=new">Добавить новый товар</a></p>
  -->
<!--
<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"></textarea>
  -->


<!-- Модальное окно для создания новой записи инцидента-->
<div class="modal fade show" id="modal-default">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Создать Новую запись в журнале</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body2">
        <!-- Информационный блок -->
        <!-- 
          <div class="callout callout-info">
                  <h5>Информация!</h5>

                  <p>Следующие поля обязателны к заполнению: Номер заявки в Jira, Содержание заявки.</p>
          </div>-->
        <blockquote class="quote-secondary" style="margin-top: 0px;">
          <p>Информация!</p>
          <small>Следующие поля обязателны к заполнению: <cite title="Source Title">Номер заявки в Jira, Содержание заявки.</cite></small>
        </blockquote>

        <!--novalidate -->
        <form action="create.php" method="post" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="jira_num">№ заявки в Jira</label>
            <input type="text" name="Jira_num" maxlength="8" value="<?= isset($_GET['red_id']) ? $product['jira_num'] : ''; ?>" class="form-control" id="jira_num" placeholder="Номер заявки в JIRA" aria-describedby="inputGroupPrepend">
            <div class="valid-feedback">
            Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите номер заявки.
            </div>
          </div>


          <div class="form-group">
            <label for="">Расположение</label>
            <input type="text" name="Destination" value="<?= isset($_GET['red_id']) ? $product['destination'] : ''; ?>" class="form-control" id="destination" placeholder="Расположение" aria-describedby="inputGroupPrepend">
            <div class="valid-feedback">
                      Верно (при отсутствии расположения поле автоматически помечается как "б/р")
                    </div>
                    <div class="invalid-feedback">
                      Пожалуйста, введите расположение.
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
            <label>Статус</label>
            <select class="custom-select" name="Status">
              <option value="1">В работе</option>
              <option value="2">В ожидании</option>
              <option value="3">Выполнено</option>
              <option value="3">Закрыто</option>
            </select>
          </div>

          <div class="form-group">
            <label for="area_content">Содержание инцидента</label>
            <textarea name="Area_content" id="area_content" class="textarea" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" required></textarea>
            <div class="valid-feedback">
              Верно
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите содержание заявки.
            </div>
          </div>

          <div class="form-group">
            <label for="area_action">Выполненное действие</label>
            <textarea name="Area_action" id="area_action" class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"><?= isset($_GET['red_id']) ? $product['Action'] : ''; ?></textarea>
          </div>


          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch2" name="Keep">
              <label class="custom-control-label" for="customSwitch2">Закрепить на панели</label>
            </div>
          </div>


      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-primary">Создать</button>
        <input type="hidden" name="page_back" value="incidents">
        </form>
      </div>
    </div>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



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
          <input type="hidden" id="page_back" name="page_back" value="incidents.php">
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

<!--
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
</button>
-->
<?php
include("modal_close_shift.php");
?>

<script type="text/javascript">
  function showMessage(id) {
    //  $('.openBtn').on('click',function(){
    $('#modal_edit').load('ajax.php?red_id=' + id + '&page_back=incidents.php', function() {
      $('#modal-default2').modal({
        show: true
      });
    });
    //});
  }
</script>

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



<?php
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}

#if (isset ($_GET['del']) && ($_GET['del']==1)){
?>


<!--
<a href="#" onclick=" toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')"> qqqq</a>
-->