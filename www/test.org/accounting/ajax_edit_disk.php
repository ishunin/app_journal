<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    $(document).ready(function() {
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

<?php
session_start();
include("../func.php");
include("../scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_GET['id']) && !empty($_GET['id'])) ? $id = $_GET['id'] : $id = 0;
(isset($_GET['id_disk']) && !empty($_GET['id_disk'])) ? $id_templ = $_GET['id_disk'] : $id_templ = 0;
#Запрашиваем информацию о типе добавляемого диска
if (isset($id_templ)) {
  $sql = "SELECT `id`, `name`, `type_equipment`, `segment`, `form_factor`, `firm`, `interface`, `rpm`, `volume`, `part_number`,`treshold`, `logs`,`monitor`, `comment`
  FROM `disk_templ` WHERE `id`=$id_templ";
  $query = mysqli_query($link_account, $sql);
  if ($query) {
    $result = mysqli_fetch_array($query);
    (isset($row['comment']) && !empty($row['comment'])) ?: $row['comment'] = 'Нет комментария';
  } else {
    printf("Ошибка: %s\n", mysqli_error($link_account));
  }
} else {
  echo 'Ошибка. Не передан ID диска';
}
(isset($result['name']) && !empty($result['name'])) ? $name = strip_tags($result['name']) : $name = '';
(isset($result['type_equipment']) && !empty($result['type_equipment'])) ? $type_equipment = $result['type_equipment'] : $type_equipment = '';
(isset($result['segment']) && !empty($result['segment'])) ? $segment = $result['segment'] : $segment = '';
(isset($result['form_factor']) && !empty($result['form_factor'])) ? $form_factor = $result['form_factor'] : $form_factor = '';
(isset($result['firm']) && !empty($result['firm'])) ? $firm = $result['firm'] : $firm = '';
(isset($result['interface']) && !empty($result['interface'])) ? $interface = $result['interface'] : $interface = '';
(isset($result['rpm']) && !empty($result['rpm'])) ? $rpm = $result['rpm'] : $rpm = 0;
(isset($result['volume']) && !empty($result['volume'])) ? $volume = $result['volume'] : $volume = 0;
//(isset($result['logs']) && !empty($result['logs'])) ? $log = $result['logs'] : $log = 0;
(isset($result['comment']) && !empty($result['comment'])) ? $comment = substr(strip_tags($result['comment']), 0, 1000) : $comment = '';
(isset($result['monitor']) && !empty($result['monitor']) && $result['monitor'] == 1) ?  $monitor = 1 : $monitor = 0;
(isset($result['part_number']) && !empty($result['part_number'])) ? $part_number = substr(strip_tags($result['part_number']), 0, 100) : $part_number = '';
(isset($result['treshold']) && !empty($result['treshold']) && $monitor == 1) ? $treshold = $result['treshold'] : $treshold = 0;
?>

<form action="edit_disk.php" method="post" class="needs-validation" novalidate>
  <div class="modal-header">
    <h4 class="modal-title">Редактирование диска ранее добавленного на склад</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
  </div>
  <div class="modal-body">
    <blockquote class="quote-secondary" style="margin-top: 0px;">
      <p>Информация о типе диска:</p>
      <small>ID: <cite title="Source Title"><?php echo $id_templ; ?></cite></small><br>
      <small>Модель: <b><cite title="Source Title"><?php echo $name; ?></cite></b></small><br>
      <small>Тип оборудования: <cite title="Source Title"><?php echo $type_equipment; ?></cite></small><br>
      <small>Сегмент: <cite title="Source Title"><?php echo $segment; ?></cite></small><br>
      <small>Форм-фактор: <cite title="Source Title"><?php echo $form_factor; ?></cite></small><br>
      <small>Фирма: <cite title="Source Title"><?php echo $firm; ?></cite></small><br>
      <small>Интерфейс: <cite title="Source Title"><?php echo $interface; ?></cite></small><br>
      <small>RPM: <cite title="Source Title"><?php echo $rpm; ?></cite></small><br>
      <small>Объем: <cite title="Source Title"><?php echo $volume; ?> Гб.</cite></small><br>
      <small>Парт-номер: <cite title="Source Title"><?php echo $part_number; ?></cite></small><br>
      <small>Комментарий: <cite title="Source Title"><?php echo $comment; ?></cite></small><br>
    </blockquote>
    <?php
    if ($id) {
      $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id` = $id");
      while ($result = mysqli_fetch_array($sql)) {
        #Инициализируем переменные   
        (isset($result['id_disk']) && !empty($result['id_disk'])) ? $id_disk = $result['id_disk'] : $id_disk = 0;
        (isset($result['serial_num']) && !empty($result['serial_num'])) ? $serial_num = strip_tags($result['serial_num']) : $serial_num = '';
        (isset($result['state']) && !empty($result['state'])) ? $state = $result['state'] : $state = 0;
        (isset($result['status']) && !empty($result['status'])) ? $status = $result['status'] : $status = 0;
        (isset($result['point']) && !empty($result['point'])) ? $point = $result['point'] : $point = 0;
        (isset($result['INM']) && !empty($result['INM'])) ? $inm = strip_tags($result['INM']) : $inm = '';
        (isset($result['INC']) && !empty($result['INC'])) ? $inc = strip_tags($result['INC']) : $inc = '';
        (isset($result['id_user']) && !empty($result['id_user'])) ? $id_user = $result['id_user'] : $id_user = 0;
        (isset($result['comment']) && !empty($result['comment'])) ? $comment = strip_tags($result['comment']) : $comment = '';
        (isset($result['serial_num_new_disk']) && !empty($result['serial_num_new_disk'])) ? $serial_num_new_disk = strip_tags($result['serial_num_new_disk']) : $serial_num_new_disk = '';
      }
    }
    ?>

    <!-- s/n диска -->
    <div class="form-group">
      <label for="serial_num">Серийный номер</label>
      <input type="text" maxlength="90" name="serial_num" value="<?php echo ($serial_num); ?>" class="form-control" id="serial_num" placeholder="Серийны номер диска" aria-describedby="inputGroupPrepend" required>
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
      <input type="text" maxlength="10" name="inm" value="<?php echo ($inm); ?>" class="form-control" id="jira_num" placeholder="Номер заявки в JIRA" aria-describedby="inputGroupPrepend">
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
      <input type="text" maxlength="20" name="inc" value="<?php echo ($inc); ?>" class="form-control" id="ibs_num" placeholder="Номер заявки в IBS" aria-describedby="inputGroupPrepend">
      <div class="valid-feedback">
        Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите номер заявки Jira.
      </div>
    </div>
    <!-- Точка поступления-->
    <div class="form-group">
      <label>Точка пополнения <small>(*Важно, здесь указана первоначальная точка поступления IBS/ЦОД)</small></label>
      <select id="sel_point2" class="custom-select" name="point" onchange="del_option();">
        <?php
        $mas = array(1, 2, 3, 4);
        echo (get_list_of_positions_mas3($mas, $point));
        ?>
      </select>
    </div>

    <!-- Состояние диска-->
    <div class="form-group">
      <label>Состояние</label>
      <select id="sel_state2" class="custom-select" name="state">
        <?php
        $mas = array(1, 2, 3, 4, 5, 6);
        echo (get_list_of_positions_mas2($mas, $state));
        ?>
      </select>
    </div>

    <!-- s/n диска, установленного вместо этого-->
    <?php
    if (($state == 2 || $state == 3 || $state == 4)  && ($status == 1 || $status == 2 || $status == 4)) {
      echo '
      <div class="form-group" id="new_disk_div"">
      <label>Серийный номер диска, установленного вместо этого</label>
      <input type="text" maxlength="20" name="serial_num_new_disk" value="' . $serial_num_new_disk . '" class="form-control" id="serial_num_new_disk" placeholder="серийный номер диска, который был установлен вместо этого" aria-describedby="inputGroupPrepend">
        <div class="valid-feedback">
            Верно
        </div>
        <div class="invalid-feedback">
            Пожалуйста, серийный номер диска, который был установлен вместо этого.
        </div>
    </div>';
    }
    ?>
    <div class="form-group">
      <label for="area_content">Комментарий</label>
      <!--<textarea name="comment" id="comment213" class="textarea" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ></textarea>-->
      <textarea name="comment" maxlength="1000" id="comment_simple_textare" class="textarea" required placeholder="Комментарий. *Обязательно для заполнения при редактировании" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;" required><?php echo $comment; ?></textarea>

      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите Коментарий.
      </div>
    </div>

    <input type="hidden" name="status" value="<?php echo ($status); ?>">
    <input type="hidden" name="id" value="<?php echo ($id); ?>">
    <input type="hidden" name="id_templ" value="<?php echo ($id_templ); ?>">
    <input type="hidden" name="page_back" value="<?php echo ($_GET['page_back']); ?>">

  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="submit" class="btn btn-primary">Сохранить</button>
  </div>
</form>

<script>
  function del_option() {
    var objSel = document.getElementById("sel_point");
    var objArea = document.getElementById("new_disk_div");
    if (objSel.selectedIndex == 1) {
      objArea.style.display = "block";
      $('#sel_state option[value=3]').prop('selected', true);
      sel_state.options[0].style.display = "none";
      sel_state.options[1].style.display = "block";
      sel_state.options[2].style.display = "block";
      sel_state.options[3].style.display = "none";
      $('#serial_num_new_disk').prop('required', true)
    } else {
      objArea.style.display = "none";
      $('#sel_state option[value=1]').prop('selected', true);
      sel_state.options[0].style.display = "block";
      sel_state.options[1].style.display = "none";
      sel_state.options[2].style.display = "none";
      sel_state.options[3].style.display = "none";
      $('#serial_num_new_disk').prop('required', false)
    }
  };
</script>