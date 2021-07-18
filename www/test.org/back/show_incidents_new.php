<div class="card">
            <div class="card-header">
              <h3 class="card-title">
              <i class="fas fa-exclamation-circle"></i> Новые инциденты для текущей смены
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
              #Блок функций

#Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
include ("error_code_output.php");
#блок вывода сообщений об операциях
#include ("message_code_output.php");
include ("modal_close_shift.php");    
?>

<!-- Выводим таблицу инцидентов -->
<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <!-- Заголовок таблицы -->
    <th class="snorting"></th>
    <th class="snorting">№</th>
    <th class="snorting">Содержание инцидента</th>
    <th class="snorting">Выполнено</th>
    <th class="snorting">Автор</th>
    <th class="snorting">Распол.</th>
    <th class="snorting">Статус</th>
    <th class="snorting">Создано</th>
    <th class="snorting"><i class="far fa-comments mr-1"></i> </th>
  </tr>
</thead>

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
       

<!--
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Создать новую запись
</button>
<a href="#" onclick=""> </a>
-->


<!-- HTML-код кнопки (триггер модального окна) -->
<!--
<button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#myModal">Показать модальное окно</button>
    -->
<!-- HTML-код модального окна -->
<div id="modal-default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_edit">
            
            
                <!-- Контент загруженный из файла "remote.php" -->
            
          
        </div>
    </div>
</div>

<!-- Поля таблицы List где храняться инциденты текущей смены 
`ID`, `ID_rec`, `ID_shift`,`Jira_num`, `Content`,`Action`, `ID_user`,
 `Destination`, `Status`,`Importance`,`Keep`,`Create_date`,`Edit_date`
-->
  <?php
if (!isset($_GET['ID'])) {
  $id_shift = get_last_shift_id($link);
}
else {
  $id_shift=$_GET['ID'];
}


 $count=0;
    $last_login=get_last_user_login($_COOKIE['id'],$link);
$current_login=get_current_user_login($_COOKIE['id'],$link);
$last_shift_id = get_last_shift_id($link);


$sql = mysqli_query($link, "SELECT *  FROM `list`  WHERE id_shift=$last_shift_id AND Create_date >= '$last_login' AND Create_date <= '$current_login' ORDER BY create_date DESC") ;
if ($sql) {
    echo '<tbody>';
    while ($result = mysqli_fetch_array($sql)) {
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);

      #подчсет количества комментариев
   $result_comments = mysqli_query($link,'SELECT * FROM `comments` 
  WHERE `id_rec`="'.$result['id_rec'].'" AND `type`=1
    '); 
  $count_comments = mysqli_num_rows($result_comments); 


  $comments_str = '

<span class="float-right">
                          <a href="#" onclick="showMessage4('.$result['ID'].',`'.$result['id_rec'].'`,'.$id_shift.')"; class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> 
                           '.$count_comments.'
                          </a>
  ';


if (is_shift_open($id_shift,$link)==1) {
$action_str='
<a class="dropdown-item" href="#" onclick="showMessage5('.$result['ID'].');" >Просмотр</a>
<a class="dropdown-item" href="one_page.php?ID='.$result['ID'].'">Открыть</a>
                      <a class="dropdown-item" href="#" onclick="showMessage(`'.$result['ID'].'`);" >Редактировать</a>
                      <a class="dropdown-item" href="#" onclick="showMessage3(`'.$result['ID'].'`);">Удалить</a>
';
$coment_str='
<div class="dropdown-divider"></div>
 <a class="dropdown-item" href="one_page.php?ID='.$result['ID'].'#comment">Оставить комментарий</a>
  </div>
';
}
else {
  $action_str='
<a class="dropdown-item" href="one_page.php?ID='.$result['ID'].'">Открыть</a>
';
$coment_str='';
}

$content=mb_substr(strip_tags($result['content']),0,300).' ...';
$action=mb_substr(strip_tags($result['action']),0,300).' ...';

      echo "<tr class=".set_importance_class($result['importance']).">".
            '<td>

<div class="input-group mb-3" style="margin-bottom: 0rem !important;">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <i class="far fa-arrow-alt-circle-down"></i>
                    </button>
                    <div class="dropdown-menu">
                      '.$action_str.'
                      
                 '.$coment_str.'
                   
                  </div>
                  <!-- /btn-group -->
                </div>

            
             </td>' .
            "<td>{$result['jira_num']}</td>" .
            "<td>{$content}</td>" .
            "<td>{$action}</td>" .
            "<td>
             {$result_user['last_name']}
            </td>" .
            "<td>{$result['destination']}</td>" .
            "<td>".get_status($result['status'])."</td>" .
            "<td class='td_row_create_incident'>{$result['create_date']}</td>" .
            "<td>".$comments_str." </td>" .
           '</tr> 
           ';
    }
  }
   echo ' </tbody> 
   <tfoot>
      <tr>
        <th></th>
        <th>№</th>
        <th>Содержание инцидента</th>
        <th>Выполнено</th>
        <th>Автор</th>
        <th>Распол.</th>
        <th>Статус</th>
        <th>Cоздано</th>
        <th><i class="far fa-comments mr-1"></i> </th>
        
      </tr>
   </tfoot>';
              ?>
              
              </table>
 <!--             
<p><a href="?add=new">Добавить новый товар</a></p>
  -->
  <!--
<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"></textarea>
  -->


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
              <input type="hidden" name="page_back" value="incidents_new.php">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
   </form>   


   <!-- HTML-код модального окна для вывода комментариев-->
 <div id="modal-default3" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" >
        <div class="modal-header">
              <h4 class="modal-title">Комментарии по данному инциденту</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body" id="modal_comments">
  <!-- Контент загруженный из файла "remote.php" -->
            </div>
            
              
                <div class="modal-footer justify-content-between">
               <!--<button type="button" class="btn btn-default" data-dismiss="modal">выйти</button>
             <button type="submit" class="btn btn-outline-light">Удалить</button>-->
              <input type="hidden" id="del_id2" name="del_id">
              
            </div>
          
        </div>
    </div>
</div> 

<!-- HTML-код модального окна просмотра-->
<div id="modal-default5" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_show">


      <!-- Контент загруженный из файла "remote.php" -->


    </div>
  </div>
</div>
   <!--
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
</button>
-->

<script type="text/javascript">
  function showMessage(id) {
  //  $('.openBtn').on('click',function(){
    $('#modal_edit').load('ajax.php?red_id='+id + '&page_back=incidents_new.php',function(){
        $('#modal-default2').modal({show:true});
    });
//});
  }

</script>




<script type="text/javascript">
  function showMessage2() {

        $('#modal-default').modal({show:true});

//});
  }

</script>

<script type="text/javascript">
  function showMessage3(id) {

        $('#modal-danger').modal({show:true});
$('#del_id').val(id);

//});
  }

</script>

<!-- Модальное окно для вывода комментариев -->
<script type="text/javascript">
function showMessage4(id,id_rec,id_shift) {
 $('#modal_comments').load('ajax_comments_incidents.php?id='+id+'&&id_rec='+id_rec+'&&id_shift='+id_shift,function(){
 $('#modal-default3').modal({show:true});
});
  }

</script>


<!-- Модальное окно для просмотра инциента-->
<script type="text/javascript">
  function showMessage5(id) {
  //  $('.openBtn').on('click',function(){
    $('#modal_show').load('ajax_show.php?red_id='+id,function(){
      $('#modal-default5').modal({show:true});
    });
//});
}
</script>



<?php 
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
echo get_action_notification($_SESSION['success_action']);
}

#if (isset ($_GET['del']) && ($_GET['del']==1)){
?>

 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
<!--
<a href="#" onclick=" toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')"> qqqq</a>
-->