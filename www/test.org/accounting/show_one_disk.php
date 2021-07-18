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
  $id_disk = $_GET['id'];
} else {
  $id_disk = 0;
}
if ($id_disk) {
  #Запрашиваем информацию о типе диска
  $sql = "SELECT * FROM `disk_templ` WHERE `id`=$id_disk";
  $res = mysqli_query($link_account, $sql);
  if ($row = mysqli_fetch_assoc($res)) {
    $id = strip_tags($row['id']);
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
    $treshold = strip_tags($row['treshold']);

    #Всего 
    $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id_disk AND `status`=1 AND `deleted`=0";
    $res = mysqli_query($link_account, $sql2);
    if ($row = mysqli_fetch_row($res)) {
      $total = $row[0]; // Всего записей
    }
    #Новые
    $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id_disk AND `status`=1 AND `state`=1 AND `deleted`=0";
    $res = mysqli_query($link_account, $sql2);
    if ($row = mysqli_fetch_row($res)) {
      $new = $row[0]; // 
    }

    #б/у
    $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id_disk AND `status`=1 AND `state`=2 AND `deleted`=0";
    $res = mysqli_query($link_account, $sql2);
    if ($row = mysqli_fetch_row($res)) {
      $old = $row[0]; // 
    }

    #Сломанные
    $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id_disk AND `status`=1 AND `state`=3 AND `deleted`=0";
    $res = mysqli_query($link_account, $sql2);
    if ($row = mysqli_fetch_row($res)) {
      $broken = $row[0]; // 
    }

    #Убитые ОБ
    $sql2 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`=$id_disk AND `status`=1 AND `state`=4 AND `deleted`=0";
    $res = mysqli_query($link_account, $sql2);
    if ($row = mysqli_fetch_row($res)) {
      $killed = $row[0]; //
    }

    #формируем строку вывода параметров диска
    $str_disk_descr = '
    <blockquote>
        <small>
        <p>id: ' . $id . '</p>
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

    $str_disk_count = '
    <a name="top_table"></a>
    <div class="row">
            <div class="col-sm-4 col-md-2">
                <h4 class="text-center">Новые</h4>
                <div class="color-palette-set">
                  <a href="one_disk.php?id='.$id.'&state=1#top_table">
                    <div class="bg-success disabled color-palette text-center"><h4>' . $new . '</h4></div>
                  </a>  
                
                    </div>
            </div> 

            <div class="col-sm-4 col-md-2">
                <h4 class="text-center">б/у</h4>
                <div class="color-palette-set">
                <a href="one_disk.php?id='.$id.'&state=2#top_table">
                    <div class="bg-secondary disabled color-palette text-center"><h4>' . $old . '</h4></div>
                </a>      
                </div>
            </div> 

            <div class="col-sm-4 col-md-2">
                <h4 class="text-center">Сломанные</h4>
                <div class="color-palette-set">
                  <a href="one_disk.php?id='.$id.'&state=3#top_table">
                    <div class="bg-orange disabled color-palette text-center"><h4>' . $broken . '</h4></div>
                  </a>   
                </div>
            </div>  

            <div class="col-sm-4 col-md-2">
                <h4 class="text-center">Убитые</h4>
                <div class="color-palette-set">
                  <a href="one_disk.php?id='.$id.'&state=4#top_table">
                    <div class="bg-danger disabled color-palette text-center"><h4>' . $killed . '</h4></div>
                  </a>
                </div>
            </div>   

            <div class="col-sm-4 col-md-2">
                <h4 class="text-center">Всего</h4>
                <div class="color-palette-set">
                  <a href="one_disk.php?id='.$id.'#top_table">
                    <div class="bg-black disabled color-palette text-center"><h4>' . $total . '</h4></div>
                  </a>    
                </div>
            </div>             
        </div>
    
    ';
  } else {
    $str_disk_descr = '
    <blockquote class="quote-secondary">
        <p>Не найден диск с указанным ID</p>
    </blockquote>
    ';
    $str_disk_count = '';
  }
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
    <div class="card-body">
      <div style="clear:left;">
      </div>
      <?php
      if ($id_disk) {
        echo $str_disk_descr;
        echo $str_disk_count;
      } else {
        echo '
          <blockquote class="quote-secondary">
          <p>Не найден диск с указанным ID</p>
          </blockquote>';
      }
      ?>
    </div>
    <!-- /.card-body -->
    <?php
    $plus_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="add_disk(' . $id_disk . ',`one_disk.php?id=' . $id_disk . '`);"><i class="fas fa-plus"></i>Приход</a>';
    $print_button = '<a href="print_one_disk.php?id=' . $id_disk . '" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>';
    $control_button = $print_button;
    $level_access_but = array(1, 2, 4, 5);
    $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
    $page_back = 'one_disk.php';
    ?>
    <div class="card-footer">
      <?php
      if ($is_allowed_button) {
        $control_button = $plus_button . $print_button;
      }
      echo $control_button;
      ?>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Все диски</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <?php
          if ($id_disk) {
            include("table_disk_balance.php");
          }
          ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          ...
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
              <?php show_comments($link, $id_disk, 6); ?>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
          <span class="my_changes_text">
            <?php
            if ($id_disk) {
              echo (show_changes($link, $link_account, '', $id_disk));
            } else {
              echo '
                <blockquote class="quote-secondary">
                <p>Не найден диск с указанным ID</p>
                </blockquote>';
            }
            ?>
            </p>
          </span>
        </div>
      </div>
      <!-- /.card -->

    </div>
    <div class="card-footer">
      <?php
      #Инициализируем переменные для создания комментария
      $id_comment = $id_disk;
      $type_comment = 6;
      $page_comment = 'accounting/one_disk.php';
      $page_back_comment = 'accounting/one_disk.php?id=' . $id_disk;
      include("comment_disk_form.php");
      ?>
    </div>
  </div>

  <?php
  if (isset($_SESSION['success_action'])) {
    echo get_action_notification($_SESSION['success_action']);
  }
  ?>