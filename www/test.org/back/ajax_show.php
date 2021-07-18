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
  include ("func.php"); 
  if (!isset($_GET['page_back'])) {
  $_GET['page_back']=0;
}

include ("scripts/conf.php");
if (isset($_GET['red_id'])) {
    $sql = mysqli_query($link, "SELECT `ID`,`id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`, `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date` FROM `list` WHERE `ID`={$_GET['red_id']}");
    $product = mysqli_fetch_array($sql);
 #

if ($product['keep']==1) {
    $keep =  'Да';
}
else {
    $keep =  'Нет';
}

if ($product['action']=='') {
    $action =  '<p>Ничего не было сделано</p>';
}
else {
    $action =  $product['action'];
}

echo '
<div class="modal-header">
    <h4 class="modal-title">Просмотр информации об инциденте</h4>
    <button type="button" class="close" data-dismiss="modal">×</button>
 </div>
 <div class="modal-body '.get_class_for_div_content($product['importance']).'" >
    <blockquote class="quote-secondary-info" style="margin-top: 0px;">
    <p>Номер заявки в Jira: '.$product['jira_num'].'</p>
    <p>Автор: '.get_user_name_by_id($product['id_user'],$link).'</p>
    <p>Расположение: '.$product['destination'].'</p>
    <p>Важность: '.get_importance($product['importance']).'</p>
    <p>Статус: '.get_status($product['status']).'</p>
    <p>Создано: '.$product['create_date'].'</p>
    <p>Отредактировано: '.$product['edit_date'].'</p>
    <p>Отредактировано: '.$product['edit_date'].'</p>
    <p>Закреплено:'.$keep.'</p>
    
    </blockquote>    
    <h3>Содержание инцидента:</h3>
    <div class="" role="alert">
    '.$product['content'].'
    </div>
    <h3>Что было сделано:</h3>
    <div>
    '.$action.'
    </div>
    





    
 
    
</div>
<div class="card card-primary card-outline">
  <div class="card-header">
  <h3 class="card-title">
    <i class="fas fa-edit"></i>
    Дополнительная панель:
  </h3>
    </div>
<div class="card-body">
<!--  <h4>Custom Content Below</h4>-->
  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 20px";>
    <li class="nav-item">
      <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Комментарии</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Изменения</a>
    </li>

  </ul>
<!--
  <div class="tab-custom-content">
    <p class="lead mb-0">Custom Content goes here</p>
  </div>

-->   





  <div class="tab-content" id="custom-content-below-tabContent">
    <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
      <div class="row" style="margin-bottom:10px;">

      <div class="col-12" >

      <div >  
               
';

#Выводим комментарии !!!!ВАЖНО - ИСПРАВИТЬ ЭТО ПОТОМ, ВЫВОД ЧЕРЕЗ ОДНУ ФУНКЦИЮ!!!!!!!!!!!!
#echo $_GET['id_rec'];
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
WHERE `id_rec`="'.$product['id_rec'].'" AND `type`=1
  '); 
$count=0;
 while ($result2 = mysqli_fetch_array($sql)) {
  $count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$product['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);

$user_icon =  get_user_icon($result_user['ID'],$link);  
echo '
<div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.get_user_icon($result2['id_user'],$link).'" alt="user image">
                        <span class="username">
                          <a href="#">'.get_user_name_by_id($result2['id_user'],$link).'</a>
                        </span>
                        <span class="description">Опубликовано- '.$result2['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$result2['content'].'
                      </p>
                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i></a>
                      </p>
                     
                    </div>
                    

';
 }


 if ($count==0) {
  echo '
                <blockquote class="quote-secondary">
                  <p>Информация:</p>
                  <small>Для данного инцидента еще никто не оставил комментария.</small>
                 
                </blockquote>
              
  ';
 }  



echo'
</div>
</div> 
</div>
</div>
<div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
 <p>Данный раздел в процессе разработки.</p>

</div>

</div>


<a href="one_page.php?ID='.$product['ID'].'#comment">Оставить комментарий</a>

</div>
<!-- /.card -->
<div class="modal-footer justify-content-between">
    
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

    <a class="btn btn-default" href="one_page_print.php?ID='.$product['ID'].'" class="link-black text-sm mr-2"> <i class="fas fa-print"></i> Печать</a>
    </div>
    ';
}
 #<input type="text" name="Content" size="50" value="'.$product['Content'].'">

?> 
 