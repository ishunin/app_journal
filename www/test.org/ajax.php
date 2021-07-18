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


<script>
  $(function() {
    // Summernote
    $("#textarea2").summernote();
    $("#textarea3").summernote();
  })
</script>
<?php
//Умное вырезание тегов
include("func.php");

if (!isset($_GET['page_back'])) {
  $_GET['page_back'] = 0;
}
include("scripts/conf.php");
if (isset($_GET['red_id'])) {
  $sql = mysqli_query($link, "SELECT `ID`,`id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`, `type`,`keep`,`create_date`,`edit_date`,`delay_date` FROM `list` WHERE `ID`={$_GET['red_id']}");
  while ($result = mysqli_fetch_array($sql)) {
    #Инициализируем переменные
    $ID = $result['ID'];
    $id_user = $result['id_user'];
    $id_rec = strip_tags($result['id_rec']);
    $id_shift = $result['id_shift'];
    $jira_num = strip_tags($result['jira_num']);
    $content = mb_substr(strip_tags_smart($result['content']), 0, 500);

    //(isset($result['action']) && !empty($result['action'])) ? $action = mb_substr(strip_tags_smart($result['action']), 0, 1000) : $action = '';
    //$action = strip_tags_smart($result['action']);
    $content = $result['content'];
    $action = $result['action'];
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $destination = strip_tags($result['destination']);
    $status = $result['status'];
    $importance = $result['importance'];
    $type = $result['type'];
    $keep = $result['keep'];
    $create_date = $result['create_date'];

    if (isset($result['delay_date']) && !empty($result['delay_date']) && $result['delay_date']!='NULL') {
    $delay_date = $result['delay_date'];
    $date = new DateTime($delay_date);
    $day = $date->format('d');
    $month = $date->format('m'); 
    $year = $date->format('Y');
    $delay_date = $month.'/'.$day.'/'.$year;
    }
    else {
      $delay_date = '';
    }  

    echo '
<div class="modal-header">
    <h4 class="modal-title">Редактирование записи об инциденте</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
 </div>
 <div class="modal-body">
    <blockquote class="quote-secondary" style="margin-top: 0px;">
        <small>Следующие поля обязателны к заполнению: <cite title="Source Title">Содержание заявки.</cite>
        </small>
    </blockquote>';
    $output = '
    
        <form action="edit.php" method="post" class="needs-validation" id="edit_form" novalidate>
    <div class="form-group">    
            <label for="jira_num">№ заявки в Jira</label>
            <input type="text" maxlength="9" name="Jira_num" value="' . $jira_num . '" class="form-control" id="jira_num" placeholder="Номер заявки в JIRA" aria-describedby="inputGroupPrepend">
            <div class="valid-feedback">
                      Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
                    </div>
                    <div class="invalid-feedback">
                      Пожалуйста, введите номер заявки.
                    </div>
    </div>
             
            <div class="form-group">
                  <label for="">Расположение</label>
                  <input type="text" maxlength="15" name="Destination" value="' . $destination . '" class="form-control" id="destination" placeholder="Расположение" aria-describedby="inputGroupPrepend">
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
                 ';
    if ($importance == 1)
      $output = $output . '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option1" autocomplete="off" checked=""  class="low_importance" value="1"> Низкая
                  </label>';
    else
      $output = $output . ' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option1" autocomplete="off"  class="low_importance" value="1"> Низкая
                  </label>';

    if ($importance == 2)
      $output = $output . '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option2" autocomplete="off" checked=""  class="low_importance" value="2"> Средняя
                  </label>';
    else
      $output = $output . ' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option2" autocomplete="off"  class="low_importance" value="2"> Средняя
                  </label>';

    if ($importance == 3)
      $output = $output . '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option3" autocomplete="off" checked=""  class="low_importance" value="3"> Высокая
                  </label>';
    else
      $output = $output . ' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option3" autocomplete="off"  class="low_importance" value="3"> Высокая
                  </label>';


    if ($importance == 4)
      $output = $output . '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option4" autocomplete="off" checked=""  class="low_importance" value="4"> Чрезвычайная
                  </label>';
    else
      $output = $output . ' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option4" autocomplete="off"  class="low_importance" value="4"> Чрезвычайная
                  </label>';
    $output = $output . '                 
             </div>
            </div>
            <div class="form-group">
            <label>Тип</label>
            <select class="custom-select" name="Type">';
              if ($type == 1)
              $output = $output . '  <option value="1" selected="selected">Инцидент</option>';
              else
              $output = $output . '  <option value="1">Инцидент</option>';
              if ($type  == 2)
              $output = $output . '  <option value="2" selected="selected">Заметка</option>';
              else
              $output = $output . '  <option value="2">Заметка</option>';
              $output = $output . '
            </select>
          </div>

             <div class="form-group">
                        <label>Статус</label>
                        <select class="custom-select" name="Status" id="option_status" onchange="delay_option();">';
    if ($status == 1)
      $output = $output . '  <option value="1" selected="selected">В работе</option>';
    else
      $output = $output . '  <option value="1">В работе</option>';

    if ($status == 2)
      $output = $output . '  <option value="2" selected="selected">В ожидании</option>';
    else
      $output = $output . '  <option value="2">В ожидании</option>';

    if ($status == 3)
      $output = $output . '  <option value="3" selected="selected">Выполнено</option>';
    else
      $output = $output . '  <option value="3">Выполнено</option>';

    if ($status == 4)
      $output = $output . '  <option value="4" selected="selected">Закрыто</option>';
    else
      $output = $output . '  <option value="4">Закрыто</option>';

//$today = date("d/m/Y");   
//echo $today;
    $output = $output . '
                        </select>
                      </div>

                      <div class="form-group" id="delay_date_div" >
                      <label>В ожидании до:</label>
                      <div class="input-group">

                            <input id="datepicker" name="Delay_date" width="276" autocomplete="off" minlength="10" maxlength="10" autocomplete="off" value="'.$delay_date.'" required/>
                        
                        <div class="valid-feedback">
                        Верно
                        </div>
                        <div class="invalid-feedback">
                        Пожалуйста, дату выхода из ожидания.
                        </div>
                        </div>
                      
                      <!-- /.input group -->
                      </div> 
                  

               <div class="form-group">
                    <label for="area_content">Содержание инцидента</label>
                    <textarea name="Area_content" id="textarea2" class="textarea2" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" required>' . $content . '</textarea>
                        <div class="valid-feedback">
                        Верно
                        </div>
                        <div class="invalid-feedback">
                        Пожалуйста, введите содержание заявки.
                        </div>
                </div> 

                <div class="form-group">
                      <label for="area_action">Выполненное действие</label>
                      <textarea name="Area_action" id="textarea3" class="textarea3" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;">' . $action . '</textarea>
                </div>
                  
                    <div class="form-group">
                      <div class="custom-control custom-switch">
                      ';

                 
    if ($keep == 1)
      $output = $output . '
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Keep" checked>';
    else
      $output = $output . '
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Keep">';
    $output = $output . '
                        <label class="custom-control-label" for="customSwitch1">Закрепить на панели</label>';
    $output = $output . '
                      <input type="hidden" name="id" value=' . $_GET['red_id'] . '>
                      <input type="hidden" name="page_back" value=' . $_GET['page_back'] . '>

                      </div>
                  </div>   
                  <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              <button type="submit" class="btn btn-primary">Сохранить</button> 

          </div>
             
          </form>
            </div>  
              
           ';
    echo $output;
  }
}
?>

<script>
  $(function () {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('')
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })  
    delay_option() 
  })
</script>

<script>
  function delay_option() {
    var objSel = document.getElementById("option_status");
    var objArea = document.getElementById("delay_date_div");
    var objDataP = document.getElementById("datepicker");
    if (objSel.selectedIndex == 1) {
      objArea.style.display = "block";
      objDataP.setAttribute("required", ""); 
    } else {
      objArea.style.display = "none";
      objDataP.value = "";
      objDataP.removeAttribute("required", ""); 
    }
  };
</script>


<script>
  $('#datepicker').datepicker({
    required: " * required: You must enter a destruction date",
    uiLibrary: 'bootstrap4'
  });
</script>
