<?php
session_start();
#настройки соединения с БД
include 'scripts/conf.php';
#Общие функции
include 'func.php';
#Проверка на разлогинивание
include 'check_exit.php';
#Проверка что польщователь залогинен
include("scripts/check.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Главная</title>
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
  <link rel="shortcut icon" href="dist/img/favicon.ico" type="image/x-icon">
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
    <div class="content-wrapper" style="min-height: 1398.23px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Профиль пользователя</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                <li class="breadcrumb-item active">Профиль пользователя</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?php echo (get_user_icon($_COOKIE['id'], $link)); ?>" alt="User profile picture">
                  </div>

                  <h3 class="profile-username text-center"></h3>

                  <p class="text-muted text-center">Дежурный ЭТИ№1</p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">

                      <?php
                      $sql = mysqli_query($link, "SELECT  COUNT(DISTINCT `id_rec`) FROM `list` WHERE id_user=" . $_COOKIE['id'] . "");
                      $res = mysqli_fetch_array($sql);
                      if ($res) {
                        $coun_incident = $res[0];
                        #echo $res[0];
                      } else {
                        echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                      }

                      $sql = mysqli_query($link, "SELECT  COUNT(ID) FROM `news` WHERE id_user=" . $_COOKIE['id'] . "");
                      $res = mysqli_fetch_array($sql);
                      if ($res) {
                        $coun_news = $res[0];
                        #echo $res[0];
                      } else {
                        echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                      }

                      $sql = mysqli_query($link, "SELECT  COUNT(ID) FROM `jobs` WHERE id_user=" . $_COOKIE['id'] . "");
                      $res = mysqli_fetch_array($sql);
                      if ($res) {
                        $coun_jobs = $res[0];
                        #echo $res[0];
                      } else {
                        echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                      }
                      ?>


                      <b>Создано инцидентов</b> <a class="float-right"><?php echo ($coun_incident); ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Создано новостей</b> <a class="float-right"><?php echo ($coun_news); ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Создано задач</b> <a class="float-right"><?php echo ($coun_jobs); ?></a>
                    </li>
                  </ul>
                  <a href="#" class="btn btn-primary btn-block"><b>Перейти</b></a>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">О пользователе</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <strong><i class="fas fa-book mr-1"></i> Информация 1</strong>

                  <p class="text-muted">
                    Дата рождения: 11.04.1988
                  </p>
                  <hr>
                  <strong><i class="fas fa-pencil-alt mr-1"></i> Был последний раз</strong>
                  <p class="text-muted">
                    <span class="tag tag-warning">12.12.2020 в 8.00</span>
                  </p>
                  <hr>
                  <strong><i class="far fa-file-alt mr-1"></i> Примечание</strong>
                  <p class="text-muted">Здесь тоже информация...</p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity1" data-toggle="tab">Общий чат</a></li>
                    <li class="nav-item"><a class="nav-link" href="#activity2" data-toggle="tab">Инциденты</a></li>
                    <li class="nav-item"><a class="nav-link" href="#activity3" data-toggle="tab">Новости</a></li>
                    <li class="nav-item"><a class="nav-link" href="#activity4" data-toggle="tab">Задания</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Настройки</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="active tab-pane" id="activity1">
                      <?php include("common_chat.php"); ?>
                    </div>
                    <!-- /.tab-pane -->
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="activity2">
                      <?php include("incidents_history.php"); ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="activity3">
                      <?php include("news_history.php"); ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="activity4">
                      <?php include("jobs_history.php"); ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="settings">
                      Здесь будут настройки пользователя (Настройка дашборда под себя).
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    
    <?php include 'footer.php'; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php include ("modal_close_shift.php");?>
  <?php include('js_scripts.php'); ?>
  <script>
    $(function() {
      // Summernote
      $(".textarea").summernote()
    })
  </script>
  <?php
  if (isset($_SESSION['success_action'])) {
    echo get_action_notification($_SESSION['success_action']);
  }
  ?>
</body>

</html>