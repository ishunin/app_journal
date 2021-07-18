<!-- Валидация формы комментариев-->
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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
else {
    $id = 0;
}

if (isset($_GET['id_disk'])) {
    $id_disk = $_GET['id_disk'];
}
else {
    $id_disk = 0;
}
$str_disk_exact_descr = '';
$ribbon = '';
$str_disk_descr='';
$info_str='';
$control_button='';

if ($id_disk) {
#Запрашиваем информацию о типе диска
$sql = "SELECT * FROM `disk_templ` WHERE `id`=$id_disk";
$res = mysqli_query($link_account,$sql);
if ($row = mysqli_fetch_assoc($res)) {     
    $name = strip_tags($row['name']);
    $type_equipment = strip_tags($row['type_equipment']);
    $segment = strip_tags($row['segment']);
    $form_factor = strip_tags($row['form_factor']);
    $firm = strip_tags($row['firm']);
    $interface = strip_tags($row['interface']);
    $rpm = strip_tags($row['rpm']);
    $volume = strip_tags($row['volume']);
    $part_number = strip_tags($row['part_number']);
    $comment = strip_tags($row['comment']);
    $monitor = strip_tags($row['monitor']);
    $deleted = ($row['deleted']);
    
    $class_blaquote='';
    if ($deleted==1) {
      $class_blaquote = 'quote-secondary';
    }
    
    #формируем строку вывода параметров диска
    $str_disk_descr = '
    <blockquote class="'.$class_blaquote.'">
        <small>
        <p>id: '.$id_disk.'</p>
        <h5>Модель: '.$name.'</h5>
        <p>Тип оборудования: '. $type_equipment.'</p>
        <p>Сегмент: '.$segment.'</p>
        <p>Фирма: '.$firm.'</p>
        <p>Интерфейс: '.$form_factor.'</p>
        <p>rpm: '.$rpm.'</p>
        <p>Объем: '.$volume.' Гб.</p>
        <p>Парт-номер: '.$part_number.'</p>
        <p>Комментарий: '.$comment.'</p>        
        </small>
    </blockquote>
    ';

   
    }
   else {
    $str_disk_descr = '
    <blockquote class="quote-secondary">
        <p>Не найден диск с указанным ID</p>
    </blockquote>
    ';
    $str_disk_count = '';

   }


#Запрашиваем информацию о конкретном диске
$sql = "SELECT * FROM `disk_balance` WHERE `id`=$id";
$res = mysqli_query($link_account,$sql);
if ($row = mysqli_fetch_assoc($res)) {     
    $serial_num = strip_tags($row['serial_num']);
    $state = get_disk_state($row['state']);
    $status = get_disk_status($row['status']);
    $point = get_disk_point($row['point']);
    $inm = strip_tags($row['INM']);
    $inc = strip_tags($row['INC']);
    $user_name = get_user_name_by_id($row['id_user'],$link);
    $user_icon =  get_user_icon($row['id_user'],$link);
    $comment = strip_tags($row['comment']);
    $deleted = $row['deleted'];
    #Если диск удален - подменяем статус
    $class_div_opacity='';
    $class_blaquote='';
    if ($deleted) {
      $class_div_opacity = 'div-opacity';
      $class_blaquote = 'quote-secondary';
    }
    

    #формируем строку вывода параметров диска
    $str_disk_exact_descr = '
    <blockquote class='.$class_blaquote.'>
        <small>
        <p>id: '.$id.'</p>
        <h5>Серийный номер: '.$serial_num.'</h5>
        <p>Состояние: <span class="'.get_class_disk_status($row['state']).'">'. $state.'</span></p>
        <p>Статус: <span class="'.get_class_disk_status($row['status']).'">'.$status.'</span></p>
        <p>Поступил: '.$point.'</p>
        <p>INM: '.$inm.'</p>
        <p>INC: '.$inc.'</p>
        <p>Автор прихода: '.$user_name.'</p> 
        <p>Комментарий: '.$comment.'</p>        
        <img src="'.$user_icon.'"/>
        </small>
    </blockquote>
    ';
    $ribbon= '<div class="ribbon-wrapper ribbon-xl">
            <div class="ribbon '.get_class_disk_info($row['status']).' text-xl">
            '.$status.'
            </div>
          </div>';
    $info_str = '
    <div class="row">
    <!--
            <div class="col-sm-4 col-md-2">
                <div class="color-palette-set">
                    <div class="bg-success disabled color-palette text-center"><h4> '.$status.'</h4></div>
                </div>
            </div> 
    -->        

            <div class="col-sm-4 col-md-2">
                <div class="color-palette-set">
                    <div class="'.get_class_disk_info($row['state']).' disabled color-palette text-center"><h4> '.$state.'</h4></div>
                </div>
            </div>            
        </div>
    ';    
    
    #Кнопки управления
    $minus_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="add_disk('.$id_disk.',`one_disk.php?id='.$id_disk.'`);"><i class="fas fa-minus"></i> Расход</a>';
    $edit_button = '<a href="#" class="link-black text-sm mr-2" onclick="edit_disk('.$id.','.$id_disk.',`one_disk_exact.php`);"> <i class="fas fa-edit"></i> Редактировать</a>';
    $del_button = '<a href="#" class="link-black text-sm mr-2" onclick="del_disk('.$id.','.$id_disk.',`one_disk_exact.php`);"> <i class="fas fa-trash-alt"></i> Удалить</a>';
    $print_button = '<a href="print_one_disk_exact.php?id='.$id.'&id_disk='.$id_disk.'" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>';

    $print_button = '<a href="print_one_disk_exact.php?id='.$id.'&id_disk='.$id_disk.'" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';
    $control_button =  $minus_button.$edit_button.$del_button.$print_button;
 

   
    }
   else {
    $str_disk_exact_descr = '
    <blockquote class="quote-secondary">
        <p>Не найден диск с указанным ID</p>
    </blockquote>
    ';
   }
} 
else {
    echo '<blockquote class="quote-secondary">
    <p>Не найден диск с указанным ID</p>
    </blockquote>';
} 
?>

<div class="col-12">     
  <div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title">    
        <i class="far fa-hdd"></i>
            Описание диска
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
        </div>
    </div>
    
    <!-- /.card-header -->
    <div class="card-body <?php echo($class_div_opacity);?>" style="padding-top:0px;padding-right:0px;">   
        <div style="clear:left;">     
        </div>
     
        <?php
            echo '<div class="col-6" style="float:left;">       
            '.$str_disk_exact_descr.'</div>';           
            echo '<div class="col-6" style="float:left;">'.$ribbon.'       
            '.$str_disk_descr.'</div><div style="clear:left;">     
            </div>
            '.$info_str.' 
            ';       
        ?>
     
    </div>
    <!-- /.card-body -->

    
    
     <div class="card-footer">
        <p>
       <?php 
       #Выводим кнопки управления
       
       echo ($control_button);
       ?>
        </p>
     </div>  
  </div>   

<?php 
if ($id) {
  echo '
  <div class="row">
    <div class="col-12">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Детали движения диска</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
            
          <?php 
          include ("table_disk_balance_exact.php");
          ?>
          
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
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
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 20px" ;="">
        <li class="nav-item">
        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Комментарии</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Изменения</a>
        </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <?php show_comments($link,$id,7);?>
                    </div> 
                </div>
            </div>
        <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
          <span class="my_changes_text">
            <?php echo (show_changes($link,$link_account,$id,$id_disk));?>
          
          </p>
  </span>
    </div>
</div>
<!-- /.card -->    
</div>
';
}
?>
        <?php if ($id) {  
        #Инициализируем переменные для создания комментария
        $id_comment = $id;
        $type_comment=7;
        $page_comment = "one_disk_exact.php";
        $page_back_comment = "one_disk_exact.php?id=".$id."&id_disk=".$id_disk;
        echo '
        <div class="card-footer">';
                         
             include ("comment_disk_form.php");
             
        echo '</div>';
        }
        ?>    
</div>

<?php 
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
?>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для создания прихода диска-->
<div id="modal_add_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_add_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
  <!-- Конец Модального окно для создания прихода диска-->
<!-- Конец блока модальныйх окон страницы-->

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для редактирования-->
<div id="modal_edit_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_edit_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
  <!-- Конец Модального окна редактирования диска-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function add_disk(id,page_back) {
    $('#modal_add_disk_content').load('ajax_add_disk.php?id_disk='+id+'&page_back='+page_back,function(){
      $('#modal_add_disk').modal({show:true});
    });
}
</script>


<script type="text/javascript">
  function edit_disk(id,id_disk,page_back) {
    $('#modal_edit_disk_content').load('ajax_edit_disk.php?id='+id+'&id_disk='+id_disk+'&page_back='+page_back,function(){
      $('#modal_edit_disk').modal({show:true});
    });
}
</script>

