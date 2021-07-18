<div id="modal_add_disk_revise" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_add_disk_content_revise">
      <!-- required; -->
      <form action="edit_disk_templ.php" method="post" class="needs-validation" novalidate>
        <div class="modal-header">
          <h4 class="modal-title">Создание номенклатуры диска</h4>
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
              $mas = array("СХД", "Сервер");
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
              $mas = array("SAS", "SAS SP", "SATA", "SCSI", "FC", "FC DP");
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
            <label>RPM</label>
            <select class="custom-select" name="rpm" required>
              <option value="">Не выбран</option>
              <?php
              $mas = array(7200, 10000, 15000);
              echo (get_list_of_positions_mas($mas, $rpm));
              ?>
            </select>
            <div class="valid-feedback">
              Верно
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите скорость вращения шпенделя диска.
            </div>
          </div>

          <!--объем -->
          <div class="form-group">
            <label>Объем, Гб.</label>
            <select class="custom-select" name="volume" required>
              <option value="">Не выбран</option>
              <?php
              $mas = array(72, 146, 300, 450, 500, 600, 900, 2000, 3000, 4000, 6000);
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
            <input type="text" maxlength="60" name="part_number" value="<?php echo ($part_number); ?>" class="form-control" id="name" placeholder="Парт-номер" aria-describedby="inputGroupPrepend" required>
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
            <textarea name="comment" id="comment_simple_textare" class="textarea" required placeholder="Комментарий. *Обязательно для заполнения при редактировании" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"><?php echo $comment; ?></textarea>

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
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $("#modal_add_disk_revise").modal('show');
  });
</script>