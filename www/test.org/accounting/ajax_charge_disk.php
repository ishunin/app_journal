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
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function() {
    // Summernote
    $("#comment").summernote();
  })
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

<!-- required; -->
<form action="charge_disk.php" method="post" class="needs-validation" novalidate>
  <div class="modal-header">
    <h4 class="modal-title">Расход диска в ЦОД</h4>
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
      }
    }
    ?>
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
      <input type="text" maxlength="20" name="ibs_num" value="" class="form-control" id="ibs_num" placeholder="Номер заявки в IBS" aria-describedby="inputGroupPrepend">
      <div class="valid-feedback">
        Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите номер заявки Jira.
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

    <!-- ИСН -->
    <div class="form-group">
      <label for="jira_num" >ИСН</label>
      <input type="text" maxlength="10" name="isn" value="" class="form-control" id="ins" placeholder="ИСН" aria-describedby="inputGroupPrepend" required>
      <div class="valid-feedback">
        Верно (при остутствии ИСН помечается автоматически как "Не на СТО и не на гарантии")
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите номер ИСН.
      </div>
    </div>

    <!--Комната -->
    <div class="form-group">
      <label>Комната</label>
      <select class="custom-select" name="room" required>
        <option value="">Не выбрана</option>
        <option value="3.04">3.04</option>
        <option value="3.05">3.05</option>
        <option value="3.05">3.06</option>
        <option value="3.21">3.21</option>
        <option value="3.22">3.22</option>


      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите номер серверной.
      </div>
    </div>

    <!--Стойка -->
    <div class="form-group">
      <label>Стойка</label>
      <select class="custom-select" name="rack" required>
        <option value="">Не выбрана</option>
        <option value="1">R1</option>
        <option value="2">R2</option>
        <option value="3">R3</option>
        <option value="4">R4</option>
        <option value="5">R5</option>
        <option value="6">R6</option>
        <option value="7">R7</option>
        <option value="8">R8</option>
        <option value="9">R9</option>
        <option value="10">R10</option>
        <option value="11">R11</option>
        <option value="12">R12</option>
        <option value="13">R13</option>
        <option value="14">R14</option>
        <option value="15">R15</option>
        <option value="16">R16</option>
        <option value="17">R17</option>
        <option value="18">R18</option>
        <option value="19">R19</option>
        <option value="20">R20</option>
        <option value="21">R21</option>
        <option value="22">R22</option>
        <option value="23">R23</option>
        <option value="24">R24</option>
        <option value="25">R25</option>
        <option value="26">R26</option>
        <option value="27">R27</option>
        <option value="28">R28</option>
        <option value="29">R29</option>
        <option value="30">R30</option>
        <option value="31">R31</option>
        <option value="32">R32</option>
        <option value="33">R33</option>
        <option value="34">R34</option>
        <option value="35">R35</option>
        <option value="36">R36</option>
        <option value="37">R37</option>
        <option value="38">R38</option>
        <option value="39">R39</option>
        <option value="40">R40</option>
        <option value="41">R41</option>
        <option value="42">R42</option>
        <option value="43">R43</option>
        <option value="44">R44</option>
        <option value="45">R45</option>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите номер стойки.
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <!--Юнит старт -->
        <div class="form-group">
          <label>Юнит с</label>
          <select class="custom-select" name="unit_start" required>
            <option value="">Не выбран</option>
            <option value="1">U1</option>
            <option value="2">U2</option>
            <option value="3">U3</option>
            <option value="4">U4</option>
            <option value="5">U5</option>
            <option value="6">U6</option>
            <option value="7">U7</option>
            <option value="8">U8</option>
            <option value="9">U9</option>
            <option value="10">U10</option>
            <option value="11">U11</option>
            <option value="12">U12</option>
            <option value="13">U13</option>
            <option value="14">U14</option>
            <option value="15">U15</option>
            <option value="16">U16</option>
            <option value="17">U17</option>
            <option value="18">U18</option>
            <option value="19">U19</option>
            <option value="20">U20</option>
            <option value="21">U21</option>
            <option value="22">U22</option>
            <option value="23">U23</option>
            <option value="24">U24</option>
            <option value="25">U25</option>
            <option value="26">U26</option>
            <option value="27">U27</option>
            <option value="28">U28</option>
            <option value="29">U29</option>
            <option value="30">U30</option>
            <option value="31">U31</option>
            <option value="32">U32</option>
            <option value="33">U33</option>
            <option value="34">U34</option>
            <option value="35">U35</option>
            <option value="36">U36</option>
            <option value="37">U37</option>
            <option value="38">U38</option>
            <option value="39">U39</option>
            <option value="40">U40</option>
            <option value="41">U41</option>
            <option value="42">U42</option>
            <option value="43">U43</option>
            <option value="44">U44</option>
            <option value="45">U45</option>
          </select>
          <div class="valid-feedback">
            Верно
          </div>
          <div class="invalid-feedback">
            Пожалуйста, введите номер юнита.
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <!--Юнит энд -->
        <div class="form-group">
          <label>Юнит до</label>
          <select class="custom-select" name="unit_end" required>
            <option value="">Не выбран</option>
            <option value="1">U1</option>
            <option value="2">U2</option>
            <option value="3">U3</option>
            <option value="4">U4</option>
            <option value="5">U5</option>
            <option value="6">U6</option>
            <option value="7">U7</option>
            <option value="8">U8</option>
            <option value="9">U9</option>
            <option value="10">U10</option>
            <option value="11">U11</option>
            <option value="12">U12</option>
            <option value="13">U13</option>
            <option value="14">U14</option>
            <option value="15">U15</option>
            <option value="16">U16</option>
            <option value="17">U17</option>
            <option value="18">U18</option>
            <option value="19">U19</option>
            <option value="20">U20</option>
            <option value="21">U21</option>
            <option value="22">U22</option>
            <option value="23">U23</option>
            <option value="24">U24</option>
            <option value="25">U25</option>
            <option value="26">U26</option>
            <option value="27">U27</option>
            <option value="28">U28</option>
            <option value="29">U29</option>
            <option value="30">U30</option>
            <option value="31">U31</option>
            <option value="32">U32</option>
            <option value="33">U33</option>
            <option value="34">U34</option>
            <option value="35">U35</option>
            <option value="36">U36</option>
            <option value="37">U37</option>
            <option value="38">U38</option>
            <option value="39">U39</option>
            <option value="40">U40</option>
            <option value="41">U41</option>
            <option value="42">U42</option>
            <option value="43">U43</option>
            <option value="44">U44</option>
            <option value="45">U45</option>
          </select>
          <div class="valid-feedback">
            Верно
          </div>
          <div class="invalid-feedback">
            Пожалуйста, введите номер юнита.
          </div>
        </div>
      </div>
    </div>
    <!--Юнит энд -->
    <div class="form-group">
      <label>Номер диска</label>
      <select class="custom-select" name="disk_num" required>
        <option value="" selected>Не выбран</option>
        <option value="1">disk 1</option>
        <option value="2">disk 2</option>
        <option value="3">disk 3</option>
        <option value="4">disk 4</option>
        <option value="5">disk 5</option>
        <option value="6">disk 6</option>
        <option value="7">disk 7</option>
        <option value="8">disk 8</option>
        <option value="9">disk 9</option>
        <option value="10">disk 10</option>
        <option value="11">disk 11</option>
        <option value="12">disk 12</option>
        <option value="13">disk 13</option>
        <option value="14">disk 14</option>
        <option value="15">disk 15</option>
        <option value="16">disk 16</option>
        <option value="17">disk 17</option>
        <option value="18">disk 18</option>
        <option value="19">disk 19</option>
        <option value="20">disk 20</option>
        <option value="21">disk 21</option>
        <option value="22">disk 22</option>
        <option value="23">disk 23</option>
        <option value="24">disk 24</option>
        <option value="25">disk 25</option>
      </select>
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите номер диска.
      </div>
    </div>

   

    <div class="form-group">
      <label for="area_content">Комментарий</label>
      <!--<textarea name="comment" id="comment213" class="textarea" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ></textarea>-->
      <textarea name="comment" id="comment_simple_textare" class="textarea" placeholder="Комментарий. *Обязательно для заполнения при редактированииююю" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"><?php echo $comment; ?></textarea>

      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите Коментарий.
      </div>
    </div>

    <input type="hidden" name="id" value="<?php echo ($id); ?>">
    <input type="hidden" name="id_templ" value="<?php echo ($id_templ); ?>">
    <input type="hidden" name="page_back" value="<?php echo ($_GET['page_back']); ?>">
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="submit" class="btn btn-primary">Сохранить</button>
  </div>
</form>