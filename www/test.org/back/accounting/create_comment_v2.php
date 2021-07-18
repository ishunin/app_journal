<?php
session_start();
$action='';
include("../scripts/conf.php");
include("../func.php");

#инициализируем переменные
/*
if (isset($_POST['id'])) {
  $id_disk = $_POST['id'];
}
else {
  $id_disk = 0;
}
*/
if (isset($_POST['id_comment'])) {
  $id_comment = $_POST['id_comment'];
}
else {
  $id_comment = 0;
}




(isset($_POST['content']) && !empty($_POST['content'])) ? $content = substr(check_input($link,$_POST['content']),0,1000) : $content = '';
$type = $_POST['type'];

if (isset($_POST['content']) && !empty($_POST['content'])) {
   #$type==5 - тип для комментариев в общем чате
     #Комментарий для диска
      $sql = mysqli_query($link, "INSERT INTO `comments` (`id_rec`, `id_user`, `content`, `importance`,`keep`,`create_date`,`edit_date`,`type`)  VALUES
      ('{$_POST['id_rec']}', {$_POST['id_user']}, '{$content}', 0, 0, NOW(), NOW(),'{$_POST['type']}')");
      $page_back = 'location:' .$_POST['page_back'].'#comment';  
  //Иначе вставляем данные, подставляя их в запрос
   if ($sql) {
    $_SESSION['success_action'] = 1;
    header($page_back);
   } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    exit();
    }
} else {
  #Валидация не пройдена, поле комментария не заполнено
  #header('location:one_page.php?ID=' . $_POST['id'] . '&&error=3');
  echo "Ошибка! Не заполнено поле 'Содержание комментария.'";  
  exit();
}
  

 #}
