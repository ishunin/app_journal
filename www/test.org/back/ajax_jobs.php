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

<script>
  $(function () {
    // Summernote
    $("#textarea3").summernote();
  })
</script>

 <!-- Для валидации -->


  <?php
  if (!isset($_GET['page_back'])) {
  $_GET['page_back']=0;
}

include ("scripts/conf.php");

if (!isset($_GET['page']) || empty($_GET['page'])){
$page = 1;
}
else {
  $page = $_GET['page'];
}

if (isset($_GET['red_id'])) {
    $sql = mysqli_query($link, 'SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`, `executor`, `start_task`, `end_task`  FROM `jobs` WHERE `ID`='.$_GET['red_id']);
    $result = mysqli_fetch_array($sql);
    $create_date=$result['create_date'];
    $id_user=$result['id_user'];

 $sql = mysqli_query($link, 'SELECT `first_name`, `last_name`  FROM `users` WHERE `ID`='.$id_user);
 $result_user= mysqli_fetch_array($sql);    

 $sql2 = mysqli_query($link, 'SELECT *  FROM `users`');
 $result_user_all= mysqli_fetch_array($sql2);   
 $str_executor =  '<div class="form-group">
 <label>Исполнитель:</label>
 <select class="custom-select" name="Executor">
 <option value="0">Не имеет значения</option>';
 while ($result_user_all = mysqli_fetch_array($sql2)) {
     if ($result['executor']==$result_user_all['ID']) {
        $if_select = 'selected=selected';
     }
     else {
        $if_select = '';
     }
  $str_executor = $str_executor.'<option value="'.$result_user_all['ID'].'" '.$if_select.'>'.$result_user_all['first_name'].' '.$result_user_all['last_name'].'</option>';  
 }
    $str_executor=$str_executor.' </select></div>';



 #
echo '
<form action="edit_jobs.php" method="post" class="needs-validation" novalidate>
<div class="modal-header">
                <h4 class="modal-title">Редактирование Задания</h4> 
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
            
<blockquote class="quote-secondary" style="margin-top: 0px;">
              <p>Информация!</p>
              Следующие поля обязателны к заполнению: <cite title="Source Title">
              Тема, Содержание задания.</cite></small><br/>
              <small>Задание опубликовано: '.$create_date.'</small></br>
              <small>Автор задания: '.$result_user['first_name'].' '.$result_user['last_name'].'</small></br>
              <small>Если есть временные рамки выполнения задания - укажите это в описании задания. Данный функционал, возможно, будет добавлен позднее.</small></br>
           </blockquote>';    
$output = '
<div class="form-group">
    <label for="theme">Тема</label>
    <input type="text" name="Theme" value="'.$result['theme'].'" 
      class="form-control" id="theme" maxlength="200" placeholder="Тема задания" aria-describedby="inputGroupPrepend" required>
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
  if ($result['importance']==1) 
  $output = $output. '  <label class="btn btn-secondary active">
<input type="radio" name="Importance" id="option1" autocomplete="off" checked=""  class="low_importance" value="1"> Низкая
</label>';
else 
$output = $output.' 
    <label class="btn btn-secondary">
      <input type="radio" name="Importance" id="option1" autocomplete="off" class="low_importance" value="1"> Низкая
    </label>';
    if ($result['importance']==2) 
    $output = $output. '  <label class="btn btn-secondary active">
  <input type="radio" name="Importance" id="option2" autocomplete="off" checked=""  class="low_importance" value="2"> Средняя
</label>';
  else 
$output = $output.' <label class="btn btn-secondary">
  <input type="radio" name="Importance" id="option2" autocomplete="off"  class="low_importance" value="2"> Средняя
</label>';

   if ($result['importance']==3) 
    $output = $output. '  <label class="btn btn-secondary active">
  <input type="radio" name="Importance" id="option3" autocomplete="off" checked=""  class="low_importance" value="3"> Высокая
</label>';
  else 
$output = $output.' <label class="btn btn-secondary">
  <input type="radio" name="Importance" id="option3" autocomplete="off"  class="low_importance" value="3"> Высокая
</label>';


if ($result['importance']==4) 
    $output = $output. '  <label class="btn btn-secondary active">
  <input type="radio" name="Importance" id="option4" autocomplete="off" checked=""  class="low_importance" value="4"> Чрезвычайная
</label>';
  else 
$output = $output.' <label class="btn btn-secondary">
  <input type="radio" name="Importance" id="option4" autocomplete="off"  class="low_importance" value="4"> Чрезвычайная
</label>';
  $output = $output. '  
    
  </div>
</div>'.$str_executor.'




<div class="form-group">
          <label>Статус</label>
          <select class="custom-select" name="Status">';
                  if ($result['status']==1) 
                  $output = $output. '  <option value="1" selected="selected">В работе</option>';  
                  else 
                    $output = $output. '  <option value="1">В работе</option>';
                    
                   if ($result['status']==2) 
                   $output = $output. '  <option value="2" selected="selected">В ожидании</option>';  
                   else 
                     $output = $output. '  <option value="2">В ожидании</option>'; 
                   
                     if ($result['status']==3) 
                     $output = $output. '  <option value="3" selected="selected">Выполнено</option>';  
                else 
                  $output = $output. '  <option value="3">Выполнено</option>';   
                       
                       if ($result['status']==4) 
                       $output = $output. '  <option value="4" selected="selected">Закрыто</option>';  
                else 
                  $output = $output. '  <option value="4">Закрыто</option>';    

                  $output = $output. '

                        </select>
        </div>



        <div class="form-group">
          <label>Тип</label>
          <select class="custom-select" name="Type">';
          if ($result['type']==1) 
            $output = $output. '  <option value="1" selected="selected">Наряд на работы</option>';  
          else 
            $output = $output. '  <option value="1">Наряд на работы</option>'; 
            
           if ($result['type']==2) 
            $output = $output. '  <option value="2" selected="selected">Другой тип</option>';  
          else 
            $output = $output. '  <option value="2">Другой тип</option>';   

          $output = $output. '

                </select>
        </div>
       
       <div class="form-group">
           <label for="area_content">Содержание задания</label>
          <textarea name="Area_content" id="textarea3" class="textarea"  required
          placeholder="Содержание задания" 
          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" >'.$result['content'].'</textarea>
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
       if ($result['keep']==1) 
        $output = $output. '
        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Keep" checked>';
        else 
           $output = $output. '
        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Keep">';
        $output=$output.'
        <label class="custom-control-label" for="customSwitch1">Закрепить на панели</label>';
      $output = $output. '
      <input type="hidden" name="id" value='.$_GET['red_id'].'>
      <input type="hidden" name="page_back" value="'.$_GET['page_back'].'">
      <input type="hidden" name="page" value='.$page.'>

      </div>             
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
<button type="submit" class="btn btn-primary">Сохранить</button>
</form> 
              
           ';
           echo $output;
}
 #<input type="text" name="Content" size="50" value="'.$product['Content'].'">

?> 
