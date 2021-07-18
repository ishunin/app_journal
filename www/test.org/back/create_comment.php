<?php
session_start();
$action='';
include("scripts/conf.php");
if (isset($_POST['content']) && !empty($_POST['content'])) {
   #$type==5 - тип для комментариев в общем чате
  if ($_POST['type']==5) {
    $sql = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
  (0, {$_POST['id_user']}, '{$_POST['content']}', 0, 0, NOW(), NOW(),5)");
  $page_back = 'location: profile.php';  
  
}
  else {
    $sql = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
    ('{$_POST['id_rec']}', {$_POST['id_user']}, '{$_POST['content']}', 0, 0, NOW(), NOW(),'{$_POST['type']}')");
    $page_back = 'location:' . $_POST['page'] . '?ID=' . $_POST['id'] . '&&add=' . $action . '#comment';  
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
  header('location:one_page.php?ID=' . $_POST['id'] . '&&error=3');

}
  

 #}
