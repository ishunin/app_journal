<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
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


#Блок функций
 include ("func.php"); 
#Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
include ("error_code_output.php");
#блок вывода сообщений об операциях
include ("message_code_output.php");



if (isset($_GET['ID']) && (!empty($_GET['ID']))) {
  $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
    `destination`, `status`,`importance`,`keep`,`create_date`,`edit_date`  FROM `list` WHERE `ID`='.$_GET['ID'].'');
  $result = mysqli_fetch_array($sql);
  if ($result) {

echo '
<script>
$(document).ready ( function(){
 showComments(`'. $result['id_rec'].'`);
});
</script>
';


    //запрашиваем пользователя
     $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      if ($sql_user) {
        $result_user = mysqli_fetch_array($sql_user);
      }    
#значение по умолчанию для полей
if (isset($result['action']) && empty($result['action'])) {
   $result['action']="Ничего не сделано";
} 




$class_div = get_class_for_div($result['importance']); 
echo '
  <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                  Описание инцидента
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <blockquote>
                  <p>Здесь какая-то информация</p>
                  <small>Информация <cite title="Source Title">Здесь</cite></small>
                </blockquote>
                <dl>
                  <dt>Номер заявки в Jira:</dt>
                  <dd>'.$result['jira_num'].'</dd>
                  <dt>Автор инцидента:</dt>
                  <dd>'.$result_user['first_name'].' '.$result_user['last_name'].' </dd>
                  <dt>Содержание инцидента:</dt>
                  <dd>
                  <div class="alert '.$class_div.'" role="alert">
                  '.$result['content'].'</div></dd>
                  <dt>Что было сделано:</dt>
                  <dd>'.$result['action'].'</dd>
                  <dt>Расположение:</dt>
                  <dd>'.$result['destination'].'</dd>
                  <dt>Важность:</dt>
                  <dd>'.get_importance($result['importance']).'</dd>
                  <dt>Статус:</dt>
                  <dd>'.get_status($result['status']).'</dd>
                  <dt>Создано:</dt>
                  <dd>'.$result['create_date'].'</dd>
                   <dt>Отредактировано:</dt>
                  <dd>'.$result['edit_date'].'</dd>





<div>
  <button type="button" onclick="showMessage(`'.$result['ID'].'`);" class="btn btn-block btn-default btn-sm" style="margin-top:10px; width:130px;">Редактировать</button>

  <button type="button" href="#" onclick="showMessage3(`'.$result['ID'].'`);"  class="btn btn-block btn-default btn-sm" style="margin-top:10px; width:130px;">Удалить</button>
</div>
                </dl>
      </div>
       <!-- /.card-body -->
</div>   
';


  }
  else {
    echo '
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Запись не была выбрана!</h5>
    Ошибка при обращении к базе данных либо такой записи не существует.
    </div>
    ';
  }

}

  
echo '

        


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


#echo $_GET['id_rec'];
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
WHERE `id_rec`="'.$result['id_rec'].'" AND `type`=1
  '); 
$count=0;
 while ($result2 = mysqli_fetch_array($sql)) {
  $count++;
      $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['ID']."");
      $result_user = mysqli_fetch_array($sql_user);  

echo '
 <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                        <span class="description">Опубликовано- '.$result2['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$result2['content'].'
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Прикрепленный файл</a>
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
                Данный раздел в процессе разработки.
              
              </div>
              
            </div>
            
            
          
           
          </div>
          <!-- /.card -->
        ';

 /*

<div class="card-footer">
                <form action="#" method="post">
                  <img class="img-fluid img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push" >
                    <input type="text" class="form-control form-control-sm" placeholder="Введите ваш комментарий">
                    <button type="button" onclick="showComments(`'.$result['id_rec'].'`);" class="btn btn-block btn-default btn-sm" style="margin-top:10px; width:10%;">Опубликовать</button>

                  </div>

              

                </form>
              </div>

 */
 echo '         
 <div class="card-footer">
                <form action="create_comment.php" method="post" id="comment" class="needs-validation" novalidate>
                  <img class="img-fluid img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">    
                    <div class="input-group input-group-sm mb-0">
                    
                          <input class="form-control form-control-sm" placeholder="Введите комментарий..." name="content" required>
                    
                          <div class="input-group-append">
                            <input type="submit" class="btn btn-info" value="Опубликовать">
                          </div>
                           <div class="valid-feedback">
                    Верно
                    </div>
                    <div class="invalid-feedback">
                    Пожалуйста, введите текст комментария.
                    </div>
                        </div>

                    <input type="hidden" name="id" value="'.$_GET['ID'].'">
                    <input type="hidden" name="id_user" value="'.$result['id_user'].'">
                    <input type="hidden" name="id_rec" value="'.$result['id_rec'].'">
                    <input type="hidden" name="page" value="one_page.php">
                    <input type="hidden" name="type" value="1">
                  </div>
                </form>
              </div>




';
?>

        </div>




<div id="modal-default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_edit">
            
            
                <!-- Контент загруженный из файла "remote.php" -->
            
          
        </div>
    </div>
</div>

    <!--Модальное окно для редактирования записи-->
    <script type="text/javascript">
  function showMessage(id) {
  //  $('.openBtn').on('click',function(){
    $('#modal_edit').load('ajax.php?red_id='+id+'&page_back=1',function(){
        $('#modal-default2').modal({show:true});
    });
//});
  }

</script>

    <!--Модальное окно для удаления записи-->
<script type="text/javascript">
  function showMessage3(id) {
$('#modal-danger').modal({show:true});
$('#del_id').val(id);
//});
  }

</script>


<script type="text/javascript">
  function showComments(id,comment) {
  //  $('.openBtn').on('click',function(){
    $('#comments').load('comments.php?id_rec='+id,function(){
        
    });
//});
  }
</script>





<!-- Форма удаления записи -->
<form action="delete.php" method="post">   
      <div class="modal fade" id="modal-danger" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Уверены что хотите удалить?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">выйти</button>
              <button type="submit" class="btn btn-outline-light">Удалить</button>
              <input type="hidden" id="del_id" name="del_id">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
   </form>

 <?php 
#include ("action_notifications.php");
 if (isset($_SESSION['success_action'])) {
echo get_action_notification($_SESSION['success_action']);
}


#if (isset ($_GET['del']) && ($_GET['del']==1)){
?>