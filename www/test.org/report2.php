<?php
session_start();
#настройки соединения с БД
include 'scripts/conf.php';
#Общие функции
include 'func.php';
#Проверка на разлогинивание
include 'check_exit.php';
#Устанавливаем разрешения на доступ на уровне страницы
$level_access = array(0, 1, 2, 4, 5);
#Проверка что польщователь залогинен
include("scripts/check.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Отчет за предыдущую  смену</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css"> <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="dist/css/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="dist/css/fonts.css">
  <link rel="stylesheet" href="dist/css/main.css">
  <script src="plugins/jquery/jquery.min.js"></script>
  <link rel="shortcut icon" href="<?php echo ("http://" . $_SERVER['SERVER_ADDR'] . "/dist/img/favicon.ico"); ?>" type="image/x-icon">

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/index.php" class="nav-link">Домой</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Панель №1</a>
        </li>
      </ul>
      <!-- SEARCH FORM -->
      <?php include("search_form.php"); ?>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <?php include("notification_nav_bar.php"); ?>
        <!-- Левый слайдбар -->
        <?php include("profile_bar.php"); ?>
      </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Блок левого меню -->
    <?php include "left_menu.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4> 
                Отчет за предыдущую смену 
                <?php echo '<a class="btn btn-default" href="print_report2.php" target="_blank" style=""><i class="fas fa-print"></i> Печать</a>'; ?>
                </h4>  
                <?php 
                
                $shif_info =  get_last_shift_info_closed($link);
                if ($shif_info!=0) {           
                echo '<small><a href="profile.php?id='.$shif_info['id_user'].'" class="link-black"><img class="img-circle elevation-2" style="height: auto;
                width: 2.1rem;" src="'.get_user_icon($shif_info['id_user'],$link).'"> '. get_user_name_by_id( $shif_info['id_user'],$link).' </a> <u>'.$shif_info['create_date'].' - '.$shif_info['end_date'].'</u> </small>';            
              }
                ?>
              
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                
                <li class="breadcrumb-item active">Отчет за смену</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Создано                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php include("modal_close_shift.php"); ?>
                <?php
                $i=0;
                include ("report/report_create.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              <?php  echo "<small>Всего: ".$i."</small>"?> 
              </div>
              <!-- /.card-footer -->
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Выполнено                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php
                include ("report/report_complete.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              <?php echo "<small>Всего: ".$i."</small>"?> 
              </div>
              <!-- /.card-footer -->
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Все инциденты Москва                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php
                include ("report/report_all_incidents.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
                <?php echo "<small>Всего: ".$i."</small>"?> 
              </div>
              <!-- /.card-footer -->
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Все инциденты Москва на внешней линии                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php
                include ("report/report_all_incidents_to.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
                <?php echo "<small>Всего: ".$i."</small>"?> 
              </div>
              <!-- /.card-footer -->
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Заявки по оборудованию                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php
                include ("report/report_equipment.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              <?php echo "<small>Всего: ".$i."</small>"?> 
              </div>
              <!-- /.card-footer -->
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Заявки по оборудованию на внешней линии                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php
                include ("report/report_equipment_to.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              <?php echo "<small>Всего: ".$i."</small>"?> 
              </div>
              <!-- /.card-footer -->
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <div class="justify-content-between" style="display: flex;">
               Закрытые заявки по оборудованию                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="padding:0px;">
                <?php
                include ("report/report_equipment_closed.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              <?php echo "<small>Всего: ".$i."</small>"?> 
              <a class="btn btn-default" href="print_report2.php" target="_blank" style="float:right;"><i class="fas fa-print"></i> Печать</a>
              </div>
              <!-- /.card-footer -->
            </div>



            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'footer.php'; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- Подключаем скрипты js-->
  <?php include('js_scripts.php'); ?>
  <script>
    $(function() {
      // Summernote
      $(".textarea").summernote()
    })
  </script>
</body>

</html>