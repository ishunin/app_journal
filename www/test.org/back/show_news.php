<!-- Для валидации -->
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
#include ("func.php"); 
#Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
include ("error_code_output.php");
#блок вывода сообщений об операциях
include ("message_code_output.php");
#include ("show_keeped_record.php");


$count=0;
if (!isset($_GET['page']) || empty($_GET['page'])){
$_GET['page'] = 1;
}


include ("scripts/paging.php");
#вывод новтей с пагинацией
 $page_setting = [
    'limit' => 10, // кол-во записей на странице
    'show'  => 1, // 5 до текущей и после
    'prev_show' => 0, // не показывать кнопку "предыдущая"
    'next_show' => 0, // не показывать кнопку "следующая"
    'first_show' => 0, // не показывать ссылку на первую страницу
    'last_show' => 0, // не показывать ссылку на последнюю страницу
    'prev_text' => 'назад',
    'next_text' => 'вперед',
    'class_active' => 'active',
    'separator' => '<li class="paginate_button page-item ">
        <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link"> ... </a>
        </li> ',
];

$page = (int) $_GET['page'];
if(empty($page)) $page = 1; // если страница не задана, показываем первую


function pagePrint($page, $title, $show, $active_class = '') {
  $active='active';
    if($show) {
        echo '<li class="paginate_button page-item ">
        <a href="?do=list&page=' . $page . '" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</a>
        </li>
        ';
    } else {
        if(!empty($active_class)) $active = 'class="' . $active_class . '"';
       // echo '<span ' . $active . '>' . $title . '</span>';
         echo '<li class="paginate_button page-item active">
        <span aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</span>
        </li>
        ';
    }
    return false;

}

#выборка данных из БД


#подсчет количества страниц и проверка основных условий

$sql = mysqli_query($link,"SELECT count(*) AS count FROM news");
$row = mysqli_fetch_array($sql);


#$res = $db->query("SELECT count(*) AS count FROM news {$where}");
#$row = $res->fetch(PDO::FETCH_ASSOC);
$page_count = ceil($row['count'] / $page_setting['limit']); // кол-во страниц
$page_left = $page - $page_setting['show']; // находим левую границу
$page_right = $page + $page_setting['show']; // находим правую границу
$page_prev = $page - 1; // узнаем номер предыдушей страницы
$page_next = $page + 1; // узнаем номер следующей страницы
if($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
if($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
if($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
if($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
if($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
if($page != $page_count) $page_setting['last_show'] = 1;


#вывод на экран
echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';    

pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show']);
pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active']);
if($page_left > 2) echo $page_setting['separator'];
for($i = $page_left; $i <= $page_right; $i++) {
    $page_show = 1;
    if($page == $i) $page_show = 0;
    pagePrint($i, $i, $page_show, $page_setting['class_active']);
}
if($page_right < ($page_count - 1)) echo $page_setting['separator'];
if($page_count != 1) 
  pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active']);
pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show']);
echo '</ul></div></div>';


$start=500;
#Вывод новостей
$start = ($page-1)*$page_setting['limit'];
$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`  FROM `news` WHERE `status`=1 order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");


    while ($result = mysqli_fetch_array($sql)) {
      $count++;  
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);

      $count_comments=0;
      

  
  $result_comments = mysqli_query($link,'SELECT * FROM `comments` 
  WHERE `id_rec`="'.$result['ID'].'" AND `type`=2
    '); 
    if ($result_comments) {
  $count_comments = mysqli_num_rows($result_comments); 
    }
#echo $count;

      #echo ($result['ID']);
      if (!empty($result['description'])) {
        $content_sh = $result['description'];
      }
      else {
        $content_sh = $result['content'];
      }
      $content_sh=mb_substr(strip_tags($content_sh),0,1000).' ...';
      $theme=strip_tags($result['theme']);
echo '
<div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.get_user_icon($result_user['ID'],$link).'" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                          
                        </span>
                        <span class="description">Опубликованно - '.$result['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                       <div style="clear:left;"></div>
                      <h3>'.$theme.'</h3>
                      <p>
                         '.$content_sh.'
                     </p>
                      <p>
                      
                        <a href="one_page_news.php?ID='.$result['ID'].'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
                        <a href="#" class="link-black text-sm mr-2" onclick="showMessage5('.$result['ID'].','.$_GET['page'].');"> <i class="far fa-folder-open"></i> Открыть</a>
                        <a href="#" class="link-black text-sm mr-2" onclick="showMessage('.$result['ID'].','.$_GET['page'].');"> <i class="far fa-edit"></i> Редактировать</a>
                  
                        <a href="#" class="link-black text-sm mr-2" onclick="showMessage3('.$result['ID'].');"> <i class="fas fa-trash"></i> Удалить</a>
                        <span class="float-right">
                          <a href="#" onclick="showMessage4('.$result['ID'].')"; class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments 
                           '.$count_comments.'
                          </a>
                        </span>
                      </p>
                    </div>
                    <!-- /.post -->

                              
      
';

    }

    if ($count==0) {
        echo '
                   <blockquote class="quote-secondary">
                     <p>Информация:</p>
                     <small>Нет новостей для отображения.</small>
                   </blockquote>
        ';
    }  

    #вывод на экран

echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';    

pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show']);
pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active']);
if($page_left > 2) echo $page_setting['separator'];
for($i = $page_left; $i <= $page_right; $i++) {
    $page_show = 1;
    if($page == $i) $page_show = 0;
    pagePrint($i, $i, $page_show, $page_setting['class_active']);
}
if($page_right < ($page_count - 1)) echo $page_setting['separator'];
if($page_count != 1) 
  pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active']);
pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show']);
echo '</ul></div></div>';

/*
<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">
<li class="paginate_button page-item previous" id="example2_previous">
<a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
<li class="paginate_button page-item ">
<a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
<li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next">
<a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div>
*/
  
      ?>

     </div>
               

                 
      </div>


 
 
  

 <!-- Модальное окно для создания новой записи инцидента-->
<div class="modal fade show" id="modal-default" >
  <div class="modal-dialog" style="max-width: 900px;">
     <div class="modal-content">
         <div class="modal-header">
             <h4 class="modal-title">Создать Новость</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
              </button>
            </div>
         <div class="modal-body2">
          <blockquote class="quote-secondary" style="margin-top: 0px;">
              <p>Информация!</p>
              <small>Следующие поля обязателны к заполнению: <cite title="Source Title">Тема, Содержание новости.</cite></small>
           </blockquote>
          
<!--novalidate -->
           <form action="create_news.php" method="post" class="needs-validation" novalidate>
              <div class="form-group">
                  <label for="theme">Тема</label>
                  <input type="text" name="Theme" value="" 
                    class="form-control" id="theme" maxlength="200" placeholder="Тема новости" aria-describedby="inputGroupPrepend" required>
                    <div class="valid-feedback">
                    Верно
                    </div>
                    <div class="invalid-feedback">
                    Пожалуйста, введите тему новости.
                    </div>
              </div>

            <div class="form-group">
                  <p class="mb-1"><b>
                  Важность</b>
                  </p>
                <div class="btn-group btn-group-toggle" data-toggle="buttons" style="margin-bottom: 20px;">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Importance" id="option1" autocomplete="off" class="low_importance" value="1"> Низкая
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option2" autocomplete="off" checked="" class="middle_importance" value="2"> Среднее
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option3" autocomplete="off" class="high_importance" value="3"> Высокая
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Importance" id="option3" autocomplete="off" class="high_importance" value="4"> Чрезвычайная
                  </label>
                  
                </div>
            </div>

             <div class="form-group">
                        <label>Статус</label>
                        <select class="custom-select" name="Status">
                          <option value="1">Опубликовано</option>
                          <option value="2">Не опубликовано</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Тип</label>
                        <select class="custom-select" name="Type">
                          <option value="1">Новость</option>
                          <option value="2">Задание</option>
                        </select>
                      </div>
                     
                      <div class="form-group">
                         <label for="area_description">Краткое описание</label>
                         <textarea name="Area_description" id="textarea4" class="textarea" placeholder="Краткое описание новости" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"><?= isset($_GET['red_id']) ? $product['Action'] : ''; ?></textarea>
                       </div>

                     <div class="form-group">
                         <label for="area_content">Содержание новости</label>
                        <textarea name="Area_content" id="textarea5" class="textarea"  required
                        placeholder="Содержание новости" 
                        style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ><?= isset($_GET['red_id']) ? $product['Content'] : ''; ?></textarea>
                           <div class="valid-feedback">
                           Верно
                           </div>
                           <div class="invalid-feedback">
                           Пожалуйста, введите содержание заявки.
                           </div>
                     </div> 

                    <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch2" name="Keep">
                        <label class="custom-control-label" for="customSwitch2">Закрепить на панели</label>
                      </div>
                  </div>                  
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              <button type="submit" class="btn btn-primary">Создать</button>
              <input type="hidden" name="page_back" value="news">
              </form>
            </div>
          </div>        
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


 <!-- HTML-код модального окна для редактирования новости-->
<div id="modal-default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_edit">
            
            
                <!-- Контент загруженный из файла "remote.php" -->
            
          
        </div>
    </div>
</div>    

<!-- HTML-код модального окна для просмотра новости-->
<div id="modal-default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" id="modal_edit">
            
            
                <!-- Контент загруженный из файла "remote.php" -->
            
          
        </div>
    </div>
</div>  


 <!-- HTML-код модального окна для вывода комментариев-->
 <div id="modal-default3" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content" >
        <div class="modal-header">
              <h4 class="modal-title">Комментарии по данной новости</h4>
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

<!-- HTML-код модального окна для удаления новости-->
<form action="delete_news.php" method="post">
   
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
              <input type="hidden" name="page_back" value="news.php">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
   </form>  

<?php
 include ("modal_close_shift.php");
?>      

<!-- Модальное окно создания новой новости -->
<script type="text/javascript">
function showMessage2() {
 $('#modal-default').modal({show:true});
//});
}
</script>

<!-- Модальное окно для редактирования новости -->
<script type="text/javascript">
function showMessage(id,page) {
 $('#modal_edit').load('ajax_news.php?red_id='+id+'&page='+page+'&page_back=news.php',function(){
 $('#modal-default2').modal({show:true});
});
  }

</script>

<!-- Модальное окно для просмотра новости -->
<script type="text/javascript">
function showMessage5(id,page) {
 $('#modal_edit').load('ajax_news_read.php?red_id='+id+'&page='+page,function(){
 $('#modal-default2').modal({show:true});
});
  }

</script>


<!-- Модальное окно для редактирования новости -->
<script type="text/javascript">
function showMessage4(id) {
 $('#modal_comments').load('ajax_comments.php?id='+id+'&page_back=news',function(){
 $('#modal-default3').modal({show:true});
});
  }

</script>


<!-- Удаление записи -->
<script type="text/javascript">
  function showMessage3(id) {

$('#modal-danger').modal({show:true});
$('#del_id').val(id);

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