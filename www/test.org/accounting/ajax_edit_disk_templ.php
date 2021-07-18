<?php

#Общие функции
include '../func.php';
include '../scripts/conf_account.php';
#Запрашиваем все поля, инициализируем переменные
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
}
if ($id) {
  $sql = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE `id` = $id");
  while ($result = mysqli_fetch_array($sql)) {
    //Инициализируем переменные
    (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
    (isset($result['id']) && !empty($result['id'])) ? $id_templ = $result['id'] : $id_templ = 0;
    (isset($result['name']) && !empty($result['name'])) ? $name = strip_tags($result['name']) : $name = '';
    (isset($result['type_equipment']) && !empty($result['type_equipment'])) ? $type_equipment = $result['type_equipment'] : $type_equipment = '';
    (isset($result['segment']) && !empty($result['segment'])) ? $segment = $result['segment'] : $segment = '';
    (isset($result['form_factor']) && !empty($result['form_factor'])) ? $form_factor = $result['form_factor'] : $form_factor = '';
    (isset($result['firm']) && !empty($result['firm'])) ? $firm = $result['firm'] : $firm = '';
    (isset($result['interface']) && !empty($result['interface'])) ? $interface = $result['interface'] : $interface = '';
    (isset($result['rpm']) && !empty($result['rpm'])) ? $rpm = $result['rpm'] : $rpm = 0;
    (isset($result['volume']) && !empty($result['volume'])) ? $volume = $result['volume'] : $volume = 0;
    (isset($result['logs']) && !empty($result['logs'])) ? $log = $result['logs'] : $log = 0;
    (isset($result['comment']) && !empty($result['comment'])) ? $comment = substr(strip_tags($result['comment']), 0, 1000) : $comment = '';
    (isset($result['monitor']) && !empty($result['monitor']) && $result['monitor'] == 1) ?  $monitor = 1 : $monitor = 0;
    (isset($result['part_number']) && !empty($result['part_number'])) ? $part_number = substr(strip_tags($result['part_number']), 0, 100) : $part_number = '';
    (isset($result['treshold']) && !empty($result['treshold']) && $monitor == 1) ? $treshold = $result['treshold'] : $treshold = 0;
  }
} else {
  echo "Ошибка! Неизвестный ID...";
}
?>
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
<!-- Подключаем реадктор кода-->
<script type="text/javascript">
  /**
   * Функция Скрывает/Показывает блок 
   **/
  function showHide(element_id) {
    //Если элемент с id-шником element_id существует
    if (document.getElementById(element_id)) {
      //Записываем ссылку на элемент в переменную obj
      var obj = document.getElementById(element_id);
      //Если css-свойство display не block, то: 
      if (obj.style.display != "block") {
        obj.style.display = "block"; //Показываем элемент
      } else obj.style.display = "none"; //Скрываем элемент
    }
    //Если элемент с id-шником element_id не найден, то выводим сообщение
    else alert("Элемент с id: " + element_id + " не найден!");
  }
</script>

<!-- required; -->
<form action="edit_disk_templ.php" method="post" class="needs-validation" novalidate>
  <div class="modal-header">
    <h4 class="modal-title">Редактирование номенклатуры диска</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
  </div>
  <div class="modal-body">
    <!-- Модель диска -->
    <div class="form-group">
      <label for="serial_num">Модель диска</label>
      <input type="text" maxlength="60" name="name" value="<?php echo ($name); ?>" class="form-control" id="name" placeholder="Модель диска" aria-describedby="inputGroupPrepend" required>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите серийный номер диска.
      </div>
    </div>
    <!-- Тип оборудования -->
    <div class="form-group">
      <label>Тип оборудования</label>
      <select class="custom-select" name="type_equipment" required>
        <option value="">Не выбран</option>
        <?php
        echo (get_list_of_positions($link_account, 'type_equipment', $type_equipment));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите тип оборудования.
      </div>
    </div>

    <!-- Сегмент -->
    <div class="form-group">
      <label>Сегмент</label>
      <select class="custom-select" name="segment" required>
        <option value="">Не выбран</option>
        <?php
        $mas = array("СХД", "Сервер", "МБД");
        echo (get_list_of_positions_mas($mas, $segment));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите сегмент.
      </div>
    </div>

    <!--Форм-фактор -->
    <div class="form-group">
      <label>Форм-фактор</label>
      <select class="custom-select" name="form_factor" required>
        <option value="">Не выбран</option>
        <?php
        $mas = array("2.5", "3.5");
        echo (get_list_of_positions_mas($mas, $form_factor));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите форм-фактор.
      </div>
    </div>

    <!--Фирма -->
    <div class="form-group">
      <label>Фирма</label>
      <select class="custom-select" name="firm" required>
        <option value="">Не выбран</option>
        <?php
        echo (get_list_of_positions($link_account, 'firm', $firm));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите фирму.
      </div>
    </div>

    <!--Интерфейс -->
    <div class="form-group">
      <label>Интерфейс</label>
      <select class="custom-select" name="interface" required>
        <option value="">Не выбран</option>
        <?php
        $mas = array("SAS","SAS2", "SAS SP", "SAS DP","SATA", "SCSI", "FC", "FC DP");
        echo (get_list_of_positions_mas($mas, $interface));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите интерфейс диска.
      </div>
    </div>

    <!--rpm -->
    <div class="form-group">
      <label>Тип диска</label>
      <select class="custom-select" name="rpm" required>
        <option value="">Не выбран</option>
        <?php
        $mas = array(0,7200, 10000, 15000);
        echo (get_list_of_positions_mas($mas, $rpm));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите тип диска.
      </div>
    </div>

    <!--объем -->
    <div class="form-group">
      <label>Объем, Гб.</label>
      <select class="custom-select" name="volume" required>
        <option value="">Не выбран</option>
        <?php
        $mas = array(72, 100, 146, 200, 300, 320, 450, 500, 600, 900, 1000, 1200, 2000, 3000, 4000, 6000,8000,10000);
        echo (get_list_of_positions_mas($mas, $volume));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите объем диска, * Гб.
      </div>
    </div>

    <!-- парт-номер -->
    <div class="form-group">
      <label for="serial_num">Парт-номер</label>
      <input type="text" maxlength="90" name="part_number" value="<?php echo ($part_number); ?>" class="form-control" id="name" placeholder="Парт-номер" aria-describedby="inputGroupPrepend" required>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите парт номер диска.
      </div>
    </div>

    <!--объем -->
    <div class="form-group">
      <label>Логирование</label>
      <select class="custom-select" name="log" required>
        <?php
        if ($log == 0) {
          echo "
      <option selected value='0'>Не нужен</option>       
      <option value='1'>Нужен</option>    
      ";
        } else {
          echo "
      <option value='0'>Не нужен</option>       
      <option selected selected value='1'>Нужен</option>
      ";
        }
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, укажите логирование.
      </div>
    </div>

    <div class="form-group">
      <label for="area_content">Комментарий</label>
      <!--<textarea name="comment" id="comment213" class="textarea" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ></textarea>-->
      <textarea name="comment" maxlength="1000"  id="comment_simple_textare" class="textarea" required placeholder="Комментарий. *Обязательно для заполнения при редактировании" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"><?php echo $comment; ?></textarea>

      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите Коментарий.
      </div>
    </div>

    <div class="form-group">
      <div class="custom-control custom-switch">
        <?php
        if ($monitor == 0) {
          echo '
          <input type="checkbox" value="0" class="custom-control-input" id="customSwitch2" name="monitor" onclick="showHide(`treshold`)">    
          ';
        } else {
          echo '
          <script>
          showHide(`treshold`);
          </script>
          <input type="checkbox" value="1" class="custom-control-input" id="customSwitch2" name="monitor" onclick="showHide(`treshold`)" checked="checked"> 
          ';
        }
        ?>
        <label class="custom-control-label" for="customSwitch2">Мониторинг остатка на складе</label>
      </div>
    </div>

    <!--Порог для мониторинга -->
    <div class="form-group" id="treshold" style="display:none;">
      <label>Порог для мониторинга, шт.</label>
      <select class="custom-select" name="treshold" required>
        <?php
        $mas = array(1, 2, 3, 4, 5);
        echo (get_list_of_positions_mas($mas, $treshold));
        ?>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, укажите логирование.
      </div>
    </div>
    <input type="hidden" name="page_back" value="/accounting/overall_disks.php">
    <input type="hidden" name="id_templ" value="<?php echo $id_templ; ?>">
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="submit" class="btn btn-primary">Сохранить</button>
  </div>
</form>