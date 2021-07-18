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
    $("#textarea3").summernote();
  })
</script>
<!-- Для валидации -->
<?php
//Умное вырезание тегов
include("func.php");
include("scripts/conf.php");
if (!isset($_GET['page_back'])) {
  $_GET['page_back'] = 0;
}

if (!isset($_GET['page']) || empty($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

if (isset($_GET['red_id'])) {
  $sql = mysqli_query($link, 'SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`, `executor`, `start_task`, `end_task`,`delay_date`  FROM `jobs` WHERE `ID`=' . $_GET['red_id']);
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

    $sql = mysqli_query($link, 'SELECT `first_name`, `last_name`  FROM `users` WHERE `ID`=' . $id_user);
    $result_user = mysqli_fetch_array($sql);

    $sql2 = mysqli_query($link, 'SELECT *  FROM `users`  ORDER BY `last_name` ASC');
    $result_user_all = mysqli_fetch_array($sql2);
    $str_executor =  '<div class="form-group">
 <label>Исполнитель:</label>
 <select class="custom-select" name="Executor">
 <option value="0">Не имеет значения</option>';
    while ($result_user_all = mysqli_fetch_array($sql2)) {
      if ($result['executor'] == $result_user_all['ID']) {
        $if_select = 'selected=selected';
      } else {
        $if_select = '';
      }
      $str_executor = $str_executor . '<option value="' . $result_user_all['ID'] . '" ' . $if_select . '>' . $result_user_all['last_name'] . ' ' . $result_user_all['first_name'] . '</option>';
    }
    $str_executor = $str_executor . ' </select></div>';
    echo '
<form action="edit_jobs.php" method="post" class="needs-validation" novalidate>
<div class="modal-header">
  <h4 class="modal-title">Редактирование Задания</h4> 
   <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
            
<blockquote class="quote-secondary" style="margin-top: 0px;">
              <small>* Следующие поля обязательны к заполнению: <cite title="Source Title">
              Тема, Содержание задания.</cite></small><br/>
              <small>Задание опубликовано: ' . $create_date . '</small></br>
              <small>Автор задания: ' . $result_user['last_name'] . ' ' . $result_user['first_name'] . '</small></br>
              <small>Если есть временные рамки выполнения задания - укажите это в описании задания.</small></br>
           </blockquote>';
    $output = '
<div class="form-group">
    <label for="theme">Тема</label>
    <input type="text" name="Theme" value="' . $theme . '" 
      class="form-control" id="theme" maxlength="300" placeholder="Тема задания" aria-describedby="inputGroupPrepend" required>
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
  <div class="btn-group btn-group-toggle" data-toggle="buttons" style="margin-bottom: 20px;">';
    if ($importance == 1)
      $output = $output . '  <label class="btn btn-secondary active">
<input type="radio" name="Importance" id="option1" autocomplete="off" checked=""  class="low_importance" value="1"> Низкая
</label>';
    else
      $output = $output . ' 
    <label class="btn btn-secondary">
      <input type="radio" name="Importance" id="option1" autocomplete="off" class="low_importance" value="1"> Низкая
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
</div>' . $str_executor . '
<div class="form-group">
          <label>Статус</label>
          <select class="custom-select" name="Status" id="option_status3" onchange="delay_option();">';
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

    $output = $output . '
                        </select>
        </div>

        <div class="form-group" id="delay_date_div3" >
        <label>В ожидании до:</label>
        <div class="input-group">

              <input id="datepicker3" name="Delay_date" width="276" autocomplete="off" minlength="10" maxlength="10" autocomplete="off" value="'.$delay_date.'" required/>
          
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
          <label>Тип</label>
          <select class="custom-select" name="Type">';
    if ($type == 1)
      $output = $output . '  <option value="1" selected="selected">Наряд на работы</option>';
    else
      $output = $output . '  <option value="1">Наряд на работы</option>';

    if ($type == 2)
      $output = $output . '  <option value="2" selected="selected">Другой тип</option>';
    else
      $output = $output . '  <option value="2">Другой тип</option>';

    $output = $output . '
                </select>
        </div>    
       



       <div class="form-group">
          <label for="area_content">Содержание задания</label>
          <textarea name="Area_content" id="textarea3" class="textarea"  required
          placeholder="Содержание задания" 
          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" >' . $result['content'] . '</textarea>
             <div class="valid-feedback">
             Верно
             </div>
             <div class="invalid-feedback">
             Пожалуйста, введите содержание задания.
             </div>
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
      <input type="hidden" name="page_back" value="' . $_GET['page_back'] . '">
      <input type="hidden" name="page" value=' . $page . '>
      </div>             
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
<button type="submit" class="btn btn-primary">Сохранить</button>
</form>              
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
    var objSel = document.getElementById("option_status3");
    var objArea = document.getElementById("delay_date_div3");
    var objDataP = document.getElementById("datepicker3");
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
  $('#datepicker3').datepicker({
    required: " * required: You must enter a destruction date",
    uiLibrary: 'bootstrap4'
  });
</script>

