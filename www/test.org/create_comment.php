<?php
session_start();
$action = '';
include("scripts/conf.php");
include("func.php");
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['id_disk']) && !empty($_POST['id_disk'])) ? $id_disk = $_POST['id_disk'] : $id_disk = 0;
(isset($_POST['type']) && !empty($_POST['type'])) ? $type = $_POST['type'] : $type = 0;
(isset($_POST['content']) && !empty($_POST['content'])) ? $content = check_input($link_account, $_POST['content']) : $content = '';
(isset($_POST['id_rec']) && !empty($_POST['id_rec'])) ? $id_rec = check_input($link_account, $_POST['id_rec']) : $id_rec = '';
(isset($_POST['page']) && !empty($_POST['page'])) ? $page = check_input($link_account, $_POST['page']) : $page = '';
if (isset($_POST['content']) && !empty($_POST['content'])) {
  #$type==5 - тип для комментариев в общем чате
  if ($_POST['type'] == 5) {
    $sql = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
  (0, {$_POST['id_user']}, '$content', 0, 0, NOW(), NOW(),5)");
    if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
      $page_back = 'location: profile.php?id=' . $_POST['id_user'];
    } else {
      $page_back = 'location: profile.php';
    }
  } else {
    $sql = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
    ('$id_rec', $id_user, '$content', 0, 0, NOW(), NOW(),'$type')");
    $page_back = 'location:' . $page . '?ID=' . $id . '&&add=' . $action . '#comment';
  }
  $action = 1;
  //Иначе вставляем данные, подставляя их в запрос
  if ($sql) {
    $_SESSION['success_action'] = 4;
    header($page_back);
    # echo '<p>Успешно!</p>';

  } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
  }
} else {
  #Валидация не пройдена, поле комментария не заполнено
  header('location:one_page.php?ID=' . $id . '&&error=3');
}
