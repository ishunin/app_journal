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
    $("#textarea2").summernote();
     $("#textarea3").summernote();
  })
</script>







  <?php
  if (!isset($_GET['page_back'])) {
  $_GET['page_back']=0;
}

include ("scripts/conf.php");
if (isset($_GET['red_id'])) {
    $sql = mysqli_query($link, "SELECT `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date` FROM `list` WHERE `ID`={$_GET['red_id']}");
    $product = mysqli_fetch_array($sql);
 #



echo '
<div class="modal-header">
    <h4 class="modal-title">Редактирование записи об инциденте</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
 </div>
 <div class="modal-body">
    <blockquote class="quote-secondary" style="margin-top: 0px;">
        <p>Информация!</p>
        <small>Следующие поля обязателны к заполнению: <cite title="Source Title">Номер заявки в Jira, Содержание заявки.</cite>
        </small>
    </blockquote>';    
$output = '
    
        <form action="edit.php" method="post" class="needs-validation" id="edit_form" novalidate>
    <div class="form-group">    
            <label for="jira_num">№ заявки в Jira</label>
            <input type="text" maxlength="8" name="Jira_num" value='.$product['jira_num'].' class="form-control" id="jira_num" placeholder="Номер заявки в JIRA" aria-describedby="inputGroupPrepend">
            <div class="valid-feedback">
                      Верно (при остутствии номера заявки автоматически поле помечается как "б/н")
                    </div>
                    <div class="invalid-feedback">
                      Пожалуйста, введите номер заявки.
                    </div>
    </div>
             
            <div class="form-group">
                  <label for="">Расположение</label>
                  <input type="text" maxlength="50" name="Destination" value="'.$product['destination'].'" class="form-control" id="destination" placeholder="Расположение" aria-describedby="inputGroupPrepend">
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
                     if ($product['importance']==1) 
                      $output = $output. '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option1" autocomplete="off" checked=""  class="low_importance" value="1"> Низкая
                  </label>';
                    else 
                  $output = $output.' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option1" autocomplete="off"  class="low_importance" value="1"> Низкая
                  </label>';
                    
                     if ($product['importance']==2) 
                      $output = $output. '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option2" autocomplete="off" checked=""  class="low_importance" value="2"> Средняя
                  </label>';
                    else 
                  $output = $output.' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option2" autocomplete="off"  class="low_importance" value="2"> Средняя
                  </label>';
                  
                     if ($product['importance']==3) 
                      $output = $output. '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option3" autocomplete="off" checked=""  class="low_importance" value="3"> Высокая
                  </label>';
                    else 
                  $output = $output.' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option3" autocomplete="off"  class="low_importance" value="3"> Высокая
                  </label>';
                  

                  if ($product['importance']==4) 
                      $output = $output. '  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option4" autocomplete="off" checked=""  class="low_importance" value="4"> Чрезвычайная
                  </label>';
                    else 
                  $output = $output.' <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option4" autocomplete="off"  class="low_importance" value="4"> Чрезвычайная
                  </label>';
                    $output = $output. '                 
             </div>
            </div>


             <div class="form-group">
                        <label>Статус</label>
                        <select class="custom-select" name="Status">';
                  if ($product['status']==1) 
                    $output = $output. '  <option value="1" selected="selected">В работе</option>';  
                  else 
                    $output = $output. '  <option value="1">В работе</option>'; 

                   if ($product['status']==2) 
                    $output = $output. '  <option value="2" selected="selected">В ожидании</option>';  
                  else 
                    $output = $output. '  <option value="2">В ожидании</option>'; 
                    
                   if ($product['status']==3) 
                    $output = $output. '  <option value="3" selected="selected">Выполнено</option>';  
                  else 
                    $output = $output. '  <option value="3">Выполнено</option>';   

                    if ($product['status']==4) 
                    $output = $output. '  <option value="4" selected="selected">Закрыто</option>';  
                  else 
                    $output = $output. '  <option value="4">Закрыто</option>';   

                  $output = $output. '

                        </select>
                      </div>

               <div class="form-group">
                    <label for="area_content">Содержание инцидента</label>
                    <textarea name="Area_content" id="textarea2" class="textarea2" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" required>'.$product['content'].'</textarea>
                        <div class="valid-feedback">
                        Верно
                        </div>
                        <div class="invalid-feedback">
                        Пожалуйста, введите содержание заявки.
                        </div>
                </div> 

                <div class="form-group">
                      <label for="area_action">Выполненное действие</label>
                      <textarea name="Area_action" id="textarea3" class="textarea3" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;">'.$product['action'].'</textarea>
                </div>
    
                
                    <div class="form-group">
                      <div class="custom-control custom-switch">
                      ';
                       if ($product['keep']==1) 
                        $output = $output. '
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Keep" checked>';
                        else 
                           $output = $output. '
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Keep">';
                        $output=$output.'
                        <label class="custom-control-label" for="customSwitch1">Закрепить на панели</label>';
                      $output = $output. '
                      <input type="hidden" name="id" value='.$_GET['red_id'].'>
                      <input type="hidden" name="page_back" value='.$_GET['page_back'].'>

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
 #<input type="text" name="Content" size="50" value="'.$product['Content'].'">

?> 
 