
<!-- Выводим таблицу инцидентов -->
<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <!-- Заголовок таблицы -->
    <th class="snorting">ID</th>
    <th class="snorting">№</th>
    <th class="snorting">Содержание инцидента</th>
    <th class="snorting">Выполненно</th>
    <th class="snorting">Автор</th>
    <th class="snorting">Распол.</th>
    <th class="snorting">Статус.</th>
    <th class="snorting">Создано </th>
    <th class="snorting">Отредакт.</th>
    <th class="snorting"></th>
  </tr>
</thead>

<?php
 include ("func.php"); 
#Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
if (isset ($_GET['error']) && ($_GET['error']==1)) {
  echo '
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Предупреждение</h5>
    <span> Запись не была добавлена.</span>
  </div>
  ';
}
else if (isset ($_GET['add']) && ($_GET['add']==1)) {
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

<!--
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Создать новую запись
</button>
<a href="#" onclick=""> </a>
-->


<!-- HTML-код кнопки (триггер модального окна) -->
<!--
<button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#myModal">Показать модальное окно</button>
    -->
<!-- HTML-код модального окна -->
<div id="modal-default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Модальное окно с Ajax</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">

                <!-- Контент загруженный из файла "remote.php" -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Поля таблицы List где храняться инциденты текущей смены 
`ID`, `ID_rec`, `ID_shift`,`Jira_num`, `Content`,`Action`, `ID_user`,
 `Destination`, `Status`,`Importance`,`Keep`,`Create_date`,`Edit_date`
-->
  <?php
 
    $sql = mysqli_query($link, 'SELECT `ID`, `ID_rec`, `ID_shift`,`Jira_num`, `Content`,`Action`, `ID_user`,
    `Destination`, `Status`,`Importance`,`Keep`,`Create_date`,`Edit_date`  FROM `list`');
    echo '<tbody>';
    while ($result = mysqli_fetch_array($sql)) {
      $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `id_user`=".$result['ID_user']."");
      $result_user = mysqli_fetch_array($sql_user);
      echo '<tr>' .
            "<td>{$result['ID']}</td>" .
            "<td>{$result['Jira_num']}</td>" .
            "<td>{$result['Content']}</td>" .
            "<td>{$result['Action']}</td>" .
            "<td>{$result_user['first_name']} {$result_user['last_name']}</td>" .
            "<td>{$result['Destination']}</td>" .
            "<td>".get_status($result['Status'])."</td>" .
            "<td>{$result['Edit_date']}</td>" .
            "<td>{$result['Create_date']}</td>" .
            '<td>
             <div class="input-group input-group-lg mb-3">
              <div class="input-group-prepend">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                A
                </button>
                <ul class="dropdown-menu" style="">
                   <li class="dropdown-item"><a href="#" onclick="showMessage2();">Открыть</a></li>
                   <li class="dropdown-item"><a href="#" onclick="showMessage2();">Создать</a></li>
                   <li class="dropdown-item"><a href="#" onclick="showMessage(`'.$result['ID'].'`);" >Редактировать</a></li>
                   <li class="dropdown-item"><a href="#" onclick="showMessage3(`'.$result['ID'].'`);">Удалить</a></li>
                 </ul>
               </div>
            </div>
             </td>' .
           '</tr> 
           ';
    }
   echo ' </tbody> 
   <tfoot>
      <tr>
        <th>ID</th>
        <th>№</th>
        <th>Содержание инцидента</th>
        <th>Выполненно</th>
        <th>Автор</th>
        <th>Распол.</th>
        <th>Статус</th>
        <th>Cоздано</th>
        <th>Отредакт</th>
        <th>A</th>
      </tr>
   </tfoot>';
              ?>
              </table>
<p><a href="?add=new">Добавить новый товар</a></p>

<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"></textarea>
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


<!-- Модальное окно для создания нового инцидента-->
<div class="modal fade show" id="modal-default" >
        <div class="modal-dialog" style="max-width: 900px;">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Создать запись</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body2">
              <p>One fine body2…</p>

<form action="create.php" method="post" class="needs-validation" novalidate>


  <table id="example1" class="table table-bordered table-striped">
    <tr>

      <td>INM:</td>
      <td>
<div class="form-group has-feedback">
  <label for="validationCustom01">inm</label>
        <input type="text" name="Jira_num" value="<?= isset($_GET['red_id']) ? $product['Jira_num'] : ''; ?>" 
class="form-control" id="validationCustomUsername" placeholder="Номер заявки в JIRA" aria-describedby="inputGroupPrepend" required
        >
         <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
          Пожалуйста, введите номер заявк.
        </div>

</div>
      </td>

    </tr>
    <tr>
      <td>Содержание:</td>
      <td>
<label for="validationCustomContent">Содержание</label>
<textarea name="Area_content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"><?= isset($_GET['red_id']) ? $product['Content'] : ''; ?></textarea>




<!--

 <label for="validationCustomContent">Содержание</label>
        <input type="text" name="Content" size="50" value="<?= isset($_GET['red_id']) ? $product['Content'] : ''; ?>"
class="form-control" id="validationCustomContent" placeholder="Содержание заявки" aria-describedby="inputGroupPrepend" required
        >

-->

<div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
          Пожалуйста, введите содержание заявки.
        </div>
      </td>
    </tr>
    <tr>
      <td>A</td>
      <td><input type="text" name="Action" size="50" value="<?= isset($_GET['red_id']) ? $product['Action'] : ''; ?>"></td>
    </tr>
    <tr>
      <td>Автор:</td>
      <td><input type="text" name="Author" size="20" value="<?= isset($_GET['red_id']) ? $product['Author'] : ''; ?>"></td>
    </tr>
    <tr>
      <td>Расположение:</td>
      <td><input type="text" name="Destination" size="10" value="<?= isset($_GET['red_id']) ? $product['Destination'] : ''; ?>"></td>
    </tr>

    <tr>
      <td colspan="2"><input type="submit" value="OK">
   <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck"  required>
      <label class="form-check-label" for="invalidCheck">
        Agree to terms and conditions
      </label>
      <div class="invalid-feedback">
        You must agree before submitting.
      </div>
    </div>
  </div>
  <button class="btn btn-primary btn-sm" type="submit">Submit form</button>
      </td>
    </tr>
  </table>

</form>









            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
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
              <button type="button" class="btn btn-outline-light" type="submit">Удалить</button>
              <input type="hidden" id="del_id" name="del_id">
              <input type="submit" name="delete">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
   </form>   

<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
</button>


<script type="text/javascript">
  function showMessage(id) {
  //  $('.openBtn').on('click',function(){
    $('.modal-body').load('ajax.php?red_id='+id,function(){
        $('#modal-default2').modal({show:true});
    });
//});
  }

</script>



<script type="text/javascript">
  function showMessage2() {

        $('#modal-default').modal({show:true});

//});
  }

</script>

<script type="text/javascript">
  function showMessage3(id) {

        $('#modal-danger').modal({show:true});
$('#del_id').val(id);

//});
  }

</script>



<?php 
#if (isset ($_GET['del']) && ($_GET['del']==1)){
  if (isset ($_SESSION['del']) && ($_SESSION['del']==1)){
echo '
<script type="text/javascript">
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`удалено!!!!!!!!!!!!.`)
});
</script>
';
unset($_SESSION['del']);
}
echo 'asdasd';
?>
/*

*/


<a href="#" onclick=" toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')"> qqqq</a>