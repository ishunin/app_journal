<?php
#Общие функции
include '../func.php';
include '../scripts/conf_account.php';
?>
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
                    }
                    else obj.style.display = "none"; //Скрываем элемент
                }
                //Если элемент с id-шником element_id не найден, то выводим сообщение
                else alert("Элемент с id: " + element_id + " не найден!"); 
            }   
        </script>

<!-- required; -->
<form action="add_disk_templ.php" method="post" class="needs-validation" novalidate>
  <div class="modal-header">
    <h4 class="modal-title">Добавление новой номенклатуры диска</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
  </div>
  <div class="modal-body">
    <!-- Модель диска -->
    <div class="form-group">
      <label for="serial_num">Модель диска</label>
      <input type="text" maxlength="60" name="name" value="" class="form-control" id="name" placeholder="Модель диска" aria-describedby="inputGroupPrepend" required>
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
        echo (get_list_of_positions($link_account,'type_equipment',''));
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
      <option value="Сервер">Сервер</option>
      <option value="СХД">СХД</option>
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
      <option value="2.5">2.5</option>
      <option value="3.5">3.5</option>
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
      <option value="IBM">IBM</option>
      <option value="EMC">EMC</option>
      <option value="SUN">SUN</option>
      <option value="HP">HP</option>
      <option value="Terra">Terra</option>
      <option value="KraftWay">KraftWay</option>
      <option value=">CSICO">CSICO</option>
      <option value="Seagate">Seagate</option>
      <option value="Toshiba">Toshiba</option>
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
    <label>Фирма</label>
      <select class="custom-select" name="interface" required>
      <option value="">Не выбран</option>
      <option value="SAS">SAS</option>
      <option value="SAS SP">SAS SP</option>
      <option value="SATA">SATA</option>
      <option value="SCSI">SCSI</option>
      <option value="FC">FC</option>
      <option value="FC DP">FC DP</option>     
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
      <option value="7200">7200</option>
      <option value="10000">10000</option>
      <option value="15000">15000</option>    
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
      <option value="72">72</option>
      <option value="146">146</option>
      <option value="300">300</option>
      <option value="450">450</option>    
      <option value="500">500</option>
      <option value="600">600</option>
      <option value="900">900</option>   
      <option value="2000">2000</option>
      <option value="3000">3000</option>
      <option value="4000">4000</option>
      <option value="6000">6000</option>     
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
      <input type="text" maxlength="60" name="part_number" value="" class="form-control" id="name" placeholder="Парт-номер" aria-describedby="inputGroupPrepend" required>
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
      <option value="0">Лог не нужен</option>
      <option value="1">Лог нужен</option>
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
      <textarea name="comment" id="comment_simple_textare" class="textarea" placeholder="Комментарий" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;" ></textarea>

      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, введите Коментарий.
      </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-switch">
             <input type="checkbox" value="1" class="custom-control-input" id="customSwitch2" name="monitor" onclick="showHide('treshold')">
             <label class="custom-control-label" for="customSwitch2">Мониторинг остатка на складе</label>
        </div>
    </div>  

         <!--Порог для мониторинга -->
    <div class="form-group" id="treshold" style="display:none;">
    <label>Порог для мониторинга, шт.</label>
      <select class="custom-select" name="treshold" required>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>

      </select>
      <div class="valid-feedback">
          Верно 
        </div>
        <div class="invalid-feedback">
          Пожалуйста, укажите логирование.
        </div>
    </div>

    <input type="hidden" name="page_back" value="/accounting/overall_disks.php">



  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="submit" class="btn btn-primary">Сохранить</button> 
  </div>            
</form>