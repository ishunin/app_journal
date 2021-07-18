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
} else {
  $id = 0;
}
if (isset($_GET['id_disk'])) {
  $id_disk = $_GET['id_disk'];
} else {
  $id_disk = 0;
}
$str_disk_exact_descr = '';
$ribbon = '';
$str_disk_descr = '';
$info_str = '';
$control_button = '';

if ($id_disk) {
  #Запрашиваем информацию о типе диска
  $sql = "SELECT * FROM `disk_templ` WHERE `id`=$id_disk";
  $res = mysqli_query($link_account, $sql);
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

    $class_blaquote = '';
    if ($deleted == 1) {
      $class_blaquote = 'quote-secondary';
    }
    
    #формируем строку вывода параметров диска
    $str_disk_descr = '
    <blockquote class="' . $class_blaquote . '">
        <small>
        <p>id: ' . $id_disk . '</p>
        <h5>Модель: ' . $name . '</h5>
        <p>Тип оборудования: ' . $type_equipment . '</p>
        <p>Сегмент: ' . $segment . '</p>
        <p>Фирма: ' . $firm . '</p>
        <p>Интерфейс: ' . $form_factor . '</p>
        <p>rpm: ' . $rpm . '</p>
        <p>Объем: ' . $volume . ' Гб.</p>
        <p>Парт-номер: ' . $part_number . '</p>
        <p>Комментарий: ' . $comment . '</p>        
        </small>
    </blockquote>
    ';
  } else {
    $str_disk_descr = '
    <blockquote class="quote-secondary">
        <p>Не найден диск с указанным ID</p>
    </blockquote>
    ';
    $str_disk_count = '';
  }
  #Запрашиваем информацию о конкретном диске
  $sql = "SELECT * FROM `disk_balance` WHERE `id`=$id";
  $res = mysqli_query($link_account, $sql);
  if ($row = mysqli_fetch_assoc($res)) {
    $serial_num = strip_tags($row['serial_num']);
    $state = get_disk_state($row['state']);
    $status = get_disk_status($row['status']);
    $point = get_disk_point($row['point']);
    $inm = strip_tags($row['INM']);
    $inc = strip_tags($row['INC']);
    $user_name = get_user_name_by_id($row['id_user'], $link);
    $user_icon =  get_user_icon($row['id_user'], $link);
    $comment = strip_tags($row['comment']);
    $deleted = $row['deleted'];
    $serial_num_new_disk = $row['serial_num_new_disk'];
    #Если диск удален - подменяем статус
    $class_div_opacity = '';
    $class_blaquote = '';
    if ($deleted || $row['status'] == 2 || $row['status'] == 7) {
      $class_div_opacity = 'div-opacity';
      $class_blaquote = 'quote-secondary';
    }
    //  Если диск отклонен для ИБ
    if (USER_PERMISSIONS==3 AND $row['status'] != 4 ) {
      $class_div_opacity = 'div-opacity';
      $class_blaquote = 'quote-secondary';
    }



    
    $id_new = '';
    $count_new = 0;
    #Запрашиваем инфу о диске serial_num_new_disk
    if ($serial_num_new_disk && !empty($serial_num_new_disk)) {
      $sql_new = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `serial_num` LIKE '%{$serial_num_new_disk}%'");
      while ($result_new = mysqli_fetch_array($sql_new)) {
        $count_new++;
        $id_new = $result_new['id'];
      }
    }
    #формируем строку вывода параметров диска
    $str_disk_exact_descr = '
    <blockquote class=' . $class_blaquote . '>
        <small>
        <p>id: ' . $id . '</p>
        <h5>Серийный номер: ' . $serial_num . '</h5>
        <p>Состояние: <span class="' . get_class_disk_status($row['state']) . '">' . $state . '</span></p>
        <p>Статус: <span class="' . get_class_disk_status($row['status']) . '">' . $status . '</span></p>
        <p>Поступил: ' . $point . '</p>
        <p>INM: ' . $inm . '</p>
        <p>INC: ' . $inc . '</p>
        <p>Автор прихода: ' . $user_name . '</p> 
        <p>Комментарий: ' . $comment . '</p>        
        <img src="' . $user_icon . '" width="50px"/>
        </small>
    </blockquote>
    ';
    $ribbon = '<div class="ribbon-wrapper ribbon-xl">
            <div class="ribbon ' . get_class_disk_info($row['status']) . ' text-xl">
            ' . $status . '
            </div>
          </div>';
    $info_str = '
    <div class="row">
    <!--
            <div class="col-sm-4 col-md-2">
                <div class="color-palette-set">
                    <div class="bg-success disabled color-palette text-center"><h4> ' . $status . '</h4></div>
                </div>
            </div> 
    -->        
            <div class="col-sm-4 col-md-2">
                <div class="color-palette-set">
                    <div class="' . get_class_disk_info($row['state']) . ' disabled color-palette text-center"><h4> ' . $state . '</h4></div>
                </div>
            </div>          
        </div>';
    //--------------------------------------------------- КНОПКИ УПРАВЛЕНИЯ ----------------------------------------------------------------------------------
    #Кнопки управления для всех
    $control_button_ob = '';
    $send_ibs_button = '';
    $minus_button = '';
    $send_ob_button = '';
    $print_doc_button = '';
    $get_button = '';
    $send_ob_button = '';
    $send_stor_button_as_broken = '';
    $send_stor_button_as_work = '';
    $ob_storage = '';
    $ob_storage_back = '';
    $forgive_button ='';
    $page_back = 'one_disk_exact.php';

    #  $minus_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="add_disk('.$id_disk.',`one_disk.php?id='.$id_disk.'`);"><i class="fas fa-minus"></i> Расход</a>';
    $edit_button = '<a href="#" class="link-black text-sm mr-2" onclick="edit_disk(' . $id . ',' . $id_disk . ',`one_disk_exact.php`);"> <i class="fas fa-edit"></i> Редактировать</a>';
    $del_button = '<a href="#" class="link-black text-sm mr-2" onclick="del_disk(' . $id . ',' . $id_disk . ',`one_disk_exact.php`);"> <i class="fas fa-trash-alt"></i> Удалить</a>';
    $print_button = '<a href="print_one_disk_exact.php?id=' . $id . '&id_disk=' . $id_disk . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>';

    #Диск на складе и новый
    if ($row['state'] == 1 && $row['status'] == 1) {
      $minus_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="charge_disk(' . $id . ',' . $id_disk . ',`' . $page_back . '`);"><i class="fas fa-minus"></i> Расход</a>';
    }

    #Диск в ОБ
    if ($row['status'] == 4) {
      $print_doc_button = '<a href="print_declaration.php?id=' . $id . '&id_new=' . $id_new . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';
    }

    #Диск на складе и сломан
    if ($row['state'] == 3 && $row['status'] == 1) {
      $send_ob_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_ob(' . $id . ',' . $id_disk . ',`' . $page_back . '`);"><i class="fas fa-share"></i> Передать в ОБ на уничтожение</a>';
      $forgive_button =  '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="forgive_disk(' . $id . ',' . $id_disk . ',`' . $page_back . '`);"><i class="fas fa-share"></i> Списать диск</a>';
      $print_doc_button = '<a href="print_declaration.php?id=' . $id . '&id_new=' . $id_new . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';
      
    }
    #Диск на складе и б.у
    if ($row['state'] == 2 && $row['status'] == 1) {
      $send_ob_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_ob(' . $id . ',' . $id_disk . ',`' . $page_back . '`);"><i class="fas fa-share"></i> Передать в ОБ на уничтожение</a>';
      $print_doc_button = '<a href="print_declaration.php?id=' . $id . '&id_new=' . $id_new . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';
    }

    #Диск в цоде в работе
    if ($row['state'] == 5 && $row['status'] == 3) {
      $send_stor_button_as_broken = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_stor(' . $id . ',' . $id_disk . ',`one_disk_exact.php`,3);"><i class="fas fa-share"></i> Вернуть на склад как сломанный</a>';
      $send_stor_button_as_work = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_stor(' . $id . ',' . $id_disk . ',`one_disk_exact.php`,2);"><i class="fas fa-share"></i> Вернуть на склад как б/у</a>';
    }

    #Диск в ОБ и уничтожен
    if ($row['state'] == 4 && $row['status'] == 4) {
      $get_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="get_disk_ob(' . $id . ',' . $id_disk . ',`one_disk_exact.php`);"><i class="fas fa-share"></i> Забрать диск из ОБ на склад</a>';
      $print_doc_button = '<a href="print_one_disk_exact.php?id=' . $id . '&id_disk=' . $id_disk . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';
    }

    #Диск уничтожен и на складе
    if ($row['state'] == 4 && $row['status'] == 1) {
      $send_ibs_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_ibs(' . $id . ',' . $id_disk . ',`one_disk_exact.php`);"><i class="fas fa-share"></i> Передать в IBS</a>';
      $print_doc_button = '<a href="print_declaration.php?id=' . $id . '&id_new=' . $id_new . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';

    }

    #Кнопки управления для ОБ
    $reject_button='';
    $destroy_button='';
    $ob_storage='';
    $ob_storage_back='';
    if ($row['status'] == 4){
    $reject_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="reject_disk_ob(' . $id . ',' . $id_disk . ',`one_disk_exact.php`);"><i class="fas fa-minus"></i> Отклонить</a>';
    $destroy_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="destroy_disk_ob(' . $id . ',' . $id_disk . ',`one_disk_exact.php`);"><i class="fas fa-minus"></i> Уничтожить</a>';
    $ob_storage  =  '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_ob_storage('.$id.','.$id_disk.',`one_disk_exact.php`);"><i class="fas fa-share"></i> Оставить на хранение</a>';
    $ob_storage_back   =  '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_ob_storage_back('.$id.','.$id_disk.',`one_disk_exact.php`);"><i class="fas fa-share"></i> Вернуть в работу</a>';
    }
    if ($row['status'] == 6){
      $ob_storage_back   =  '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="send_disk_ob_storage_back('.$id.','.$id_disk.',`one_disk_exact.php`);"><i class="fas fa-share"></i> Вернуть в работу</a>';

    }
    //--------------------------------------------------- КОНЕЦ КНОПОК УПРАВЛЕНИЯ ----------------------------------------------------------------------------------
   
    $control_button =  $minus_button . $get_button . $send_stor_button_as_broken . $send_stor_button_as_work . $send_ob_button . $forgive_button. $send_ibs_button . $print_doc_button . $edit_button . $print_button . $del_button;
    
    if ($row['state'] != 4 && $row['status']!=6) {
      $control_button_ob =  $reject_button . $destroy_button.$ob_storage;
    } 
    else if ( $row['status']==6) { 
      $control_button_ob = $control_button_ob .$ob_storage_back;
    }     
    else {
      $control_button_ob = "<small>*Диск уничтожен. Нет опции для ИБ.</small>";
    }
      //ХУК - для Акдминистратора разрешаем действия УБИТЬ ДИСК, ОСТАИВТЬ ДИСК НА СОХРАНЕНИИ
      if (USER_PERMISSIONS==5 AND ($row['status'] == 4) || ($row['status'] == 6)) {
        $control_button.='<hr>
        <span class="link-black text-sm mr-2 target="  href="" onclick="#">! Опции ОБ доступные ROOT Администратору</span>
        '.$control_button_ob;
      }
      //----------------------------------------------------------------------
  } else {
    $str_disk_exact_descr = '
    <blockquote class="quote-secondary">
        <p>Не найден диск с указанным ID</p>
    </blockquote>
    ';
  }
} else {
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
    <div class="card-body <?php echo ($class_div_opacity); ?>" style="padding-top:0px;padding-right:0px;">
      <div style="clear:left;">
      </div>

      <?php
      echo '<div class="col-6" style="float:left;">       
            ' . $str_disk_exact_descr . '</div>';
      echo '<div class="col-6" style="float:left;">' . $ribbon . '       
            ' . $str_disk_descr . '</div><div style="clear:left;">     
            </div>
            ' . $info_str . ' 
            ';
      ?>
      <br>
      <?php
      include("dest_disk.php");
      ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <?php
      #Выводим кнопки управления
      $level_access_but = array(1, 2, 4, 5);
      $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
      if ($is_allowed_button) {
        echo ($control_button);
      }
      else {
        echo '<a href="print_one_disk_exact.php?id=' . $id . '&id_disk=' . $id_disk . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>';
      }

      $level_access_but = array(3);
      $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
      if ($is_allowed_button) {
        echo ($control_button_ob);
      }
      ?>
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
        ';
    include("table_disk_balance_exact.php");
    echo '  
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         *
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </div>
  </div>
<div class="card card-primary card-outline ">
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
                        ';
    show_comments($link, $id, 7);
    echo '
                    </div> 
                </div>
            </div>
        <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
          <span class="my_changes_text">
            ' . show_changes($link, $link_account, $id, $id_disk) . '
          
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
    $type_comment = 7;
    $page_comment = "accounting/one_disk_exact.php";
    $page_back_comment = "accounting/one_disk_exact.php?id=" . $id . "&id_disk=" . $id_disk;
    echo '
<div class="card-footer">';
    include("comment_disk_form.php");
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
  function add_disk(id, page_back) {
    $('#modal_add_disk_content').load('ajax_add_disk.php?id_disk=' + id + '&page_back=' + page_back, function() {
      $('#modal_add_disk').modal({
        show: true
      });
    });
  }
</script>

<script type="text/javascript">
  function edit_disk(id, id_disk, page_back) {
    $('#modal_edit_disk_content').load('ajax_edit_disk.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_edit_disk').modal({
        show: true
      });
    });
  }
</script>