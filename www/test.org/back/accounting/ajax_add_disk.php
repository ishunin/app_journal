<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
 $(document).ready(function()  {
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
<!-- Подключаем реадктор кода-->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script>
    $(function() {
      // Summernote
      $("#comment").summernote();
    })
</script>


<?php
session_start();
include ("../func.php");
include ("../scripts/conf.php");
  #Запрашиваем информацию о типе добавляемого диска
  if (isset($_GET['id_disk'])) {
  $sql = "SELECT `id`, `name`, `type_equipment`, `segment`, `form_factor`, `firm`, `interface`, `rpm`, `volume`, `part_number`, `logs`, `comment` 
  FROM `disk_templ` WHERE `id`=".$_GET['id_disk'];
  $query = mysqli_query($link_account,$sql);
      if ($query) {
          $row = mysqli_fetch_array($query);       
          (isset($row['comment']) && !empty($row['comment'])) ? : $row['comment'] = 'Нет комментария';
      }
      else {
          printf("Ошибка: %s\n", mysqli_error($link_account));
      }
  }
  else {
    echo 'Ошибка. Не передан ID диска';
  }
?>


<!-- required; -->
<form action="add_disk.php" method="post" class="needs-validation" novalidate>
  <div class="modal-header">
    <h4 class="modal-title">Добавление нового диска на склад</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
  </div>
  <div class="modal-body">
    <blockquote class="quote-secondary" style="margin-top: 0px;">
      <p>Информация о типе диска:</p>
      <small>ID: <cite title="Source Title"><?php echo $row['id']; ?></cite></small><br>
      <small>Модель: <b><cite title="Source Title"><?php echo $row['name']; ?></cite></b></small><br>
      <small>Тип оборудования: <cite title="Source Title"><?php echo $row['type_equipment']; ?></cite></small><br>
      <small>Сегмент: <cite title="Source Title"><?php echo $row['segment']; ?></cite></small><br>
      <small>Форм-фактор: <cite title="Source Title"><?php echo $row['form_factor']; ?></cite></small><br>
      <small>Фирма: <cite title="Source Title"><?php echo $row['firm']; ?></cite></small><br>
      <small>Интерфейс: <cite title="Source Title"><?php echo $row['interface']; ?></cite></small><br>
      <small>RPM: <cite title="Source Title"><?php echo $row['rpm']; ?></cite></small><br>
      <small>Объем: <cite title="Source Title"><?php echo $row['volume']; ?> Гб.</cite></small><br>
      <small>Парт-номер: <cite title="Source Title"><?php echo $row['part_number']; ?></cite></small><br>
      <small>Комментарий: <cite title="Source Title"><?php echo $row['comment']; ?></cite></small><br>




    </blockquote>     
    <!-- s/n диска -->
    <div class="form-group">
      <label for="serial_num">Серийный номер</label>
      <input type="text" maxlength="30" name="serial_num" value="" class="form-control" id="serial_num" placeholder="Серийны номер диска" aria-describedby="inputGroupPrepend" >
        <div class="valid-feedback">
          Верно 
        </div>
        <div class="invalid-feedback">
          Пожалуйста, введите серийный номер диска.
        </div>
    </div>
    <!-- № заявки в Jira -->           
    <div class="form-group">
      <label for="jira_num">№ заявки в Jira</label>
      <input type="text" maxlength="10" name="jira_num" value="" class="form-control" id="jira_num" placeholder="Номер заявки в JIRA" aria-describedby="inputGroupPrepend">
        <div class="valid-feedback">
          Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
        </div>
        <div class="invalid-feedback">
          Пожалуйста, введите номер заявки Jira.
        </div>
    </div>
    <!-- № заявки в IBS -->  
    <div class="form-group">
      <label for="jira_num">№ заявки в IBS</label>
      <input type="text" maxlength="10" name="ibs_num" value="" class="form-control" id="ibs_num" placeholder="Номер заявки в IBS" aria-describedby="inputGroupPrepend">
        <div class="valid-feedback">
            Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
        </div>
        <div class="invalid-feedback">
            Пожалуйста, введите номер заявки Jira.
        </div>
    </div>
    <!-- Состояние диска-->  
    <div class="form-group">
      <label>Состояние</label>
      <select class="custom-select" name="state">
        <option value="1">Новый</option>
        <option value="2">Б/у</option>
        <option value="3">Сломанный</option>
        <option value="4">Убит</option>
      </select>
    </div>

      <!-- Точка поступления-->  
      <div class="form-group">
      <label>Точка пополнения</label>
      <select class="custom-select" name="point">
        <option value="1">Из IBS</option>
        <option value="2">Из ЦОД</option>
        <option value="3">Из ОБ</option>
      </select>
    </div>


    <div class="form-group">
      <label for="area_content">Комментарий</label>
      <!--<textarea name="comment" id="comment213" class="textarea" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ></textarea>-->
      <textarea name="comment" id="comment_simple_textare" class="textarea" placeholder="Комментарий" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;" ></textarea>

      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите Коментарий.
      </div>
    </div> 

    <input type="hidden" name="id_disk" value="<?php echo($_GET['id_disk']); ?>">
    <input type="hidden" name="page_back" value="<?php echo($_GET['page_back']); ?>">
 
    
  
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="submit" class="btn btn-primary">Сохранить</button> 
  </div>            
</form>


 