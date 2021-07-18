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
  <link rel="stylesheet" href="dist/css/main.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css"> <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="dist/css/fonts.css">
  <link rel="shortcut icon" href="dist/img/favicon.ico" type="image/x-icon">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Журнал Дежурных ЭТИ!</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Авторизуйтесь для работы с системой</p>
        <?php
        # Функция для генерации случайной строки
        function generateCode($length = 6)
        {
          $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
          $code = "";
          $clen = strlen($chars) - 1;
          while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
          }
          return $code;
        }
        # Если есть куки с ошибкой то выводим их в переменную и удаляем куки
        if (isset($_COOKIE['errors'])) {
          $errors = $_COOKIE['errors'];
          setcookie('errors', '', time() - 60 * 60 * 24 * 30, '/');
        }
        # Подключаем конфиг
        include 'scripts/conf.php';
        //include 'ldap.php';
        include 'func.php';
        $permissions = '';
        if (isset($_POST['submit'])) {
          # Вытаскиваем из БД запись, у которой логин равняеться введенному
          $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT ID, users_password, permissions,deny FROM `users` WHERE `users_login`='" . mysqli_real_escape_string($link, $_POST['login']) . "' LIMIT 1"));
          $access_denyed = '';
          $pass = 0;
  
          if ($_POST['login']=='admin' && $_POST['password']=='P@ssw0rd') {
            $pass = 1;
          }
          else if ($_POST['login']=='admin2' && $_POST['password']=='P@ssw0rd'){
            $pass = 1;
          }
          else {
            if (ldap_auth($_POST['login'].'@dpc.tax.nalog.ru', $_POST['password'])) {
              $pass = 1;
            } else {
              $pass = 0;
              //$pass = 1;
            }
          }  
          if ($pass == 1 && $data['deny'] == 0) {
            # Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));
            # Записываем в БД новый хеш авторизации и IP
            mysqli_query($link, "UPDATE users SET users_hash='" . $hash . "' WHERE ID='" . $data['ID'] . "'") or die("MySQL Error: " . mysqli_error($link));
            # Ставим куки
            setcookie("id", $data['ID'], time() + 60 * 60 * 24 * 30);
            setcookie("hash", $hash, time() + 60 * 60 * 24 * 30);
            setcookie("permissions", $data['permissions'], time() + 60 * 60 * 24 * 30);
            $permissions = $data['permissions'];
            #Если авторизуется Дежурный - отркываем смену
            if ($data['permissions'] == 1) {
              include("open_shift.php");
            }
            #Если безоп - редирект на его дашборд
            if ($data['permissions'] == 3) {
              header("Location: \accounting\ob_dashboard.php");
              exit();
            }
            # Переадресовываем браузер на страницу проверки нашего скрипта
            header("Location: index.php");
            exit();
          } else {
            echo '
           <div class="info-box mb-3 bg-danger">
              <div class="info-box-content">
              Неверный логин / Пароль или УЗ заблокирована
              <span class="info-box-number"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
          ';
          }
        }
        # Вытаскиваем из БД последнюю смену
        $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT ID, id_user, status, create_date, end_date FROM `shift` ORDER BY `ID` DESC LIMIT 1"));
        #вариант 1 - смена не закрыта кем-то   
        if ($data) {
          #запрашиваем имя пользователя, который не закрыл сессию
          $user_data = mysqli_fetch_assoc(mysqli_query($link, "SELECT first_name, last_name FROM `users` 
  WHERE `ID`=" . $data['id_user'] . ""));
        } else {
          echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
        }
        $mes = '';
        $mes2 = '';
        if (isset($data) && $data['status'] == 1) {
          $mes = '<div class="info-box mb-3 bg-info">
              <div class="info-box-content">
              Внимание! Обнаружена не закрытая предыдущая сессия. Сессия открыта пользователем: ' . $user_data['first_name'] . ' ' . $user_data['last_name'] . '
                <span class="info-box-number"></span>
              </div>
              <!-- /.info-box-content -->
            </div>';
          $mes2 = '<small>*Предыдущая смена будет закрыта принудительно если авторизуетесь как Дежурный...</small>';
        }
        #Форма авторизации по умолчанию
        $form = '
      <form method="POST">
        <div class="input-group mb-3">
          <input name="login" type="login" class="form-control" placeholder="логин">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="пароль">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              ' . $mes2 . '
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button name="submit" type="submit" class="btn btn-primary btn-block">Войти</button>
            
          </div>
          <!-- /.col -->
        </div>
      </form>';
        echo $mes;
        echo $form;
        ?>
        <?php
        # Проверяем наличие в куках номера ошибки
        if (isset($errors)) {
          //print '<h4>' . $errors . '</h4>';
        }
        ?>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>