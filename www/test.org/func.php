<?php
include "ldap.php";
//Умное вырезание тегов
include("strip_tags_smart.php");
#
#в функцию запихнули все что смогли в справочнике найти. 
#для вставки в базу хватило бы mysql_real_escape_string, 
#для вывода - htmlspecialchars.
/*
encodedStr = htmlentities($html);
Расшифровать:

$html = html_entity_decode($encodedStr);


1. mysqli_real_escape_string делает данные безопасными для вставки в MySQL (но параметризованные запросы лучше).
2. Htmlentities делает данные безопасными для вывода в HTML-документ (гарантировать, что в выводимой строке ни один участок не будет воспринят как тэг.)
3. srip_tags - удаляет все теги

#Пример - т.к. обрабатываем каждую переменную этой функцией
$username = mysqli_real_escape_string($mysqli,$_POST['username']);
*/
function show_upload_files($link, $id_rec, $type, $page_back, $type_rec)
{
  $str = '';
  $res_str = '';
  $i = 0;
  $sql = mysqli_query($link, "SELECT *  FROM `uploads` WHERE `deleted`=0 AND `type`=$type AND `id_rec`='$id_rec' ORDER BY `id` DESC");
  echo '<tbody>';
  while ($result = mysqli_fetch_array($sql)) {
    $i++;
    $id = strip_tags($result['id']);
    $id_rec = strip_tags($result['id_rec']);
    $name = strip_tags($result['name']);
    $comment = strip_tags($result['comment']);
    $type = $result['type'];
    $name_orig = strip_tags($result['name_orig']);
    $size = round($result['size'] / 1048576, 2);
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $date = $result['date'];
    $type_file = $result['type_file'];
    #Все кнопки ------------------------------------------------------------------------------------------------ 
    $level_access_but = array(1, 5);
    $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
    $del_button = ' <a class="dropdown-item" href="#" onclick="del_file(' . $id . ',`uploads.php`,2);">Удалить</a>';
    $download_button = ' <a class="dropdown-item" href="/upload/' . $name_orig . '">Загрузить</a>';
    if ($is_allowed_button) {
      $control =  $download_button . $del_button;
    }
    $str .= '<small><i><a href="upload/' . $name_orig . '">' . $name . '</a> | Добавлен: ' . $user_name . ' | ' . $date . '</i>
     <a href="#" onclick="del_file(' . $id . ',`' . $page_back . '`,'.$type_rec.');">Удалить</a></small><br>';
  }
  return $str;
}

function show_upload_files_shift($link, $id_rec, $type, $page_back, $id_shift)
{
  $str = '';
  $res_str = '';
  $i = 0;
  $sql = mysqli_query($link, "SELECT *  FROM `uploads` WHERE `deleted`=0 AND `type`=$type AND `id_rec`='$id_rec' ORDER BY `id` DESC");
  echo '<tbody>';
  while ($result = mysqli_fetch_array($sql)) {
    $i++;
    $id = strip_tags($result['id']);
    $id_rec = strip_tags($result['id_rec']);
    $name = strip_tags($result['name']);
    $comment = strip_tags($result['comment']);
    $type = $result['type'];
    $name_orig = strip_tags($result['name_orig']);
    $size = round($result['size'] / 1048576, 2);
    $user_name =  get_user_name_by_id($result['id_user'], $link);
    $date = $result['date'];
    $type_file = $result['type_file'];
    $del_button = '';
    $class = '';
    #Все кнопки ------------------------------------------------------------------------------------------------ 
    $level_access_but = array(1, 5);
    $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
    if (is_shift_open($id_shift, $link)) {
      if ($is_allowed_button) {
        $del_button = ' <a href="#" onclick="del_file(' . $id . ',`' . $page_back . '`,1);">Удалить</a>';
      }
    } else {
      $class = 'class="quote-secondary"';
    }

    $download_button = ' <a class="dropdown-item" href="/upload/' . $name_orig . '">Загрузить</a>';
    if ($is_allowed_button) {
      $control =  $download_button . $del_button;
    }

    $str .= '<small><i><a href="upload/' . $name_orig . '">' . $name . '</a> | Добавлен: ' . $user_name . ' | ' . $date . ' | ' . $del_button . '</i>
    </small><br>';
  }
  if ($i > 0) {
    $str = "<blockquote  $class  style='margin: 0.0em';><small><b>Файлы, приложенные к инциденту:</b></small><br>" . $str . "</blockquote>";
  }
  return $str;
}

function get_file_extension($filename)
{
  return end(explode(".", $filename));
}

/* Выделение цветом */
function choose_color($text, $search, $color)
{
  $text = preg_replace('/' . $search . '/iu', "<span style='background-color:{$color}'>{$search}</span>", $text);
  return $text;
}

function get_list_of_positions($link_account, $table_name, $item)
{
  $res = '';
  if (!isset($item) || (empty($item))) {
    $item = '';
  }
  $sql = mysqli_query($link_account, "SELECT *  FROM `" . $table_name . "` ORDER BY `name` ASC");
  while ($result = mysqli_fetch_array($sql)) {
    if ($result['name'] === $item) {
      $res .= "
        <option selected value='" . $result['name'] . "'>" . $result['name'] . "</option>       
        ";
    } else {
      $res .= "
        <option value='" . $result['name'] . "'>" . $result['name'] . "</option>
        ";
    }
  }
  return $res;
}

function get_list_of_positions_mas($mas, $item)
{
  $res = '';
  if (!isset($item) || (empty($item))) {
    $item = '';
  }
  foreach ($mas as $value) {
    if ($value == $item) {
      $res .= "
      <option selected value='" . $value . "'>" . $value . "</option>       
        ";
    } else {
      $res .= "
      <option value='" . $value . "'>" . $value . "</option>
      ";
    }
  }
  return $res;
}



function get_list_of_positions_mas2($mas, $item)
{
  $res = '';
  if (!isset($item) || (empty($item))) {
    $item = '';
  }
  $i = 0;
  foreach ($mas as $value) {
    if ($value == $item) {
      $res .= "
      <option selected value='" . $value . "'>" . get_disk_state($value) . "</option>       
        ";
    } else {
      $res .= "
      <option value='" . $value . "'>" . get_disk_state($value) . "</option>
      ";
    }
  }
  return $res;
}

function get_list_of_positions_mas3($mas, $item)
{
  $res = '';
  if (!isset($item) || (empty($item))) {
    $item = '';
  }
  $i = 0;
  foreach ($mas as $value) {
    if ($value == $item) {
      $res .= "
      <option selected value='" . $value . "'>" . get_disk_point($value) . "</option>       
        ";
    } else {
      $res .= "
      <option value='" . $value . "'>" . get_disk_point($value) . "</option>
      ";
    }
  }
  return $res;
}

function get_disk_operation_by_id($var)
{
  $res = 0;
  switch ($var) {
    case 1:
      $res = "Приход";
      break;
    case 2:
      $res = "Редактирование";
      break;
    case 3:
      $res = "Расход";
      break;
    case 4:
      $res = "Перемещение в ОБ";
      break;
    case 5:
      $res = "Удаление";
      break;
    case 6:
      $res = "Расход";
      break;
    case 7:
      $res = "Отклонение уничтожения";
      break;
    case 8:
      $res = "Уничтожение";
      break;
    case 9:
      $res = "Перемещение диска на склад из ОБ";
      break;
    case 10:
      $res = "Перемещение диска в IBS";
      break;
    case 10:
      $res = "Передача уничтоженного диска в IBS";
      break;
    case 11:
      $res = "Пермещение из ЦОДа на склад (сломан)";
      break;
    case 12:
      $res = "Перемещение из ЦОДа на склад (б/у)";
      break;
    case 13:
      $res = "Перемещение диска на хранение в ОБ";
      break;
    case 14:
      $res = "Возврат диска в работу со склада ОБ";
      break;
    case 15:
     $res = "Списание диска";
     break;



    default:
      $res = "Неизвестная операция";
      break;
  }
  return $res;
}

function get_disk_serial_by_id($link_account, $id)
{
  $res = 'не известен';
  //Запрашиваем последние 20 изменений по всем дискам данного типа
  if (isset($id) && !empty($id)) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id`=$id");
    while ($result = mysqli_fetch_array($sql)) {
      $res = strip_tags($result['serial_num']);
    }
  }
  return $res;
}

#выводит все движения по дискам: тип 1 - все изменения в разрезе номенклатуры, тип 2- все изменения в разрезе конкретного диска
function show_changes($link, $link_account, $id, $id_disk)
{
  $res = 0;
  //Запрашиваем последние 20 изменений по всем дискам данного типа
  if (isset($id) && !empty($id)) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk_templ`=$id_disk AND `id_disk`= $id ORDER BY `date` DESC LIMIT 25");
  } else if (isset($id_disk) && !empty($id_disk)) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk_templ`=$id_disk  ORDER BY `date` DESC LIMIT 25");
  } else {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` ORDER BY `date` DESC LIMIT 25");
  }
  $count = 0;
  $res_str = '';
  while ($result = mysqli_fetch_array($sql)) {
    $count++;
    $id = $result['id_disk'];
    $id_templ = $result['id_disk_templ'];
    $type_oper = $result['type_oper'];
    $serial_num = strip_tags($result['serial_num']);
    $INM = strip_tags($result['INM']);
    $INC = strip_tags($result['INC']);
    $comment = mb_substr(strip_tags($result['comment']), 0, 1000);
    $status = get_disk_status($result['status']);
    $state = get_disk_state($result['state']);
    $point = get_disk_point($result['point']);
    $INM = strip_tags($result['INM']);
    $INC = strip_tags($result['INC']);
    $date = $result['date'];
    $user = get_user_name_by_id($result['id_user'], $link);
    $new_disk_desc_str = '';
    switch ($type_oper) {
      case 1:
        if ($result['point'] == 2) {
          $new_disk_desc_str = '<b>: ' . $new_disk_desc_str . '</b>';
        }
        #формируем строку по данному изменению
        $res_str .= "<span style='color:green;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a>  <b>Приход</b>| </span>
      диск с s/n: <b>" . $serial_num . "</b> | пользователем <b>" . $user . "</b> | Получен " . $point . " " . $new_disk_desc_str . " | <b>" . $date . "</b> | по заявке: " . $INM . " (" . $INC . ") | 
      в состоянии: <span class='" . get_class_disk_status($result['state']) . "'><b>" . $state . "</b></span> | Расположение: " . $status . " | с комментарием: <i>" . $comment . "</i>
      <br>";
        break;

      case 2:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a><b> Редактирование</b> | </span>
      диск с s/n: <b>" . $serial_num . "</b> | пользователем <b>" . $user . "</b> | Получен:" . $point . " | <b>" . $date . "</b> | по заявке: " . $INM . " (" . $INC . ") | 
      в состоянии: <span class='" . get_class_disk_status($result['state']) . "'><b>" . $state . "</b></span> | Расположение: " . $status . " | с комментарием: <i>" . $comment . "</i>
      <br>";
        break;

      case 4:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a> <b>Перемещение в ОБ</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;

      case 5:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a> <b>Удаление</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;

      case 6:
        #формируем строку по данному изменению
        $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_charge` WHERE `id_disk`=$id ORDER BY `id` DESC LIMIT 1");
        while ($row = mysqli_fetch_array($sql2)) {
          #Инициализируем переменные
          (isset($row['type_equipment']) && !empty($row['type_equipment'])) ? $type_equipment = strip_tags($row['type_equipment']) : $type_equipment = 'неизветсно';
          (isset($rowt['isn']) && !empty($row['isn'])) ? $isn = strip_tags($row['isn']) : $isn = 'не указан';
          (isset($row['room']) && !empty($row['room'])) ? $room = strip_tags($row['room']) : $room = 'не указана';
          (isset($row['rack']) && !empty($row['rack'])) ? $rack = $row['rack'] : $rack = 'не указан';
          (isset($row['unit_start']) && !empty($row['unit_start'])) ? $unit_start = $row['unit_start'] : $unit_start = 'не указан';
          (isset($row['unit_end']) && !empty($row['unit_end'])) ? $unit_end = $row['unit_end'] : $unit_end = '';
          (isset($row['disk_num']) && !empty($row['disk_num'])) ? $disk_num = $row['disk_num'] : $disk_num = 'не указан';
        }
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a> <b>Расход</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | диск установлен в <b>" . $type_equipment . "(ИСН: " . $isn . ")</b> | Расположение: <b>" . $room . "/" . $rack . "/" . $unit_start . "-" . $unit_end . "</b> в слот <b>" . $disk_num . "</b> с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 7:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Диск уничтожен ОБ</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 8:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Диск уничтожен</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;

      case 9:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Пермещение уничтоженного диска от ОБ на склад</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 10:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Передача уничтоженного диска в IBS</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 11:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска из ЦОДа на склад как сломанный</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 12:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска из ЦОДа на склад как б/у</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 13:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска на склад ОБ</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
        <br>";
        break;
      case 14:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска из Склада ОБ в работу</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
        <br>";
        break;
     case 14:
     #формируем строку по данному изменению
     $res_str .= "<span style='color:grey;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Списание диска</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
     <br>";
      break;  
      default:
        $res_str .= "Неизвестная операция<br>";
    }
  }
  if ($count == 0) {
    $res_str = '
  <blockquote class="quote-secondary">
  <p>Информация:</p>
  <small>Не данных по заданному типу id ...</small>
  </blockquote>';
  }

  return $res_str;
}

#выводит все движения по дискам: тип движения - перемещение в ОБ
function show_changes_ob($link, $link_account)
{
  $res = 0;
  //Запрашиваем последние 20 изменений по всем дискам данного типа
  if (isset($id) && !empty($id)) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk_templ`=$id_disk AND `id_disk`= $id ORDER BY `date` DESC LIMIT 25");
  } else if (isset($id_disk) && !empty($id_disk)) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk_templ`=$id_disk  ORDER BY `date` DESC LIMIT 25");
  } else {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` ORDER BY `date` DESC LIMIT 25");
  }
  $count = 0;
  $res_str = '';
  while ($result = mysqli_fetch_array($sql)) {
    $count++;
    $id = $result['id_disk'];
    $id_templ = $result['id_disk_templ'];
    $type_oper = $result['type_oper'];
    $serial_num = strip_tags($result['serial_num']);
    $INM = strip_tags($result['INM']);
    $INC = strip_tags($result['INC']);
    $comment = mb_substr(strip_tags($result['comment']), 0, 1000);
    $status = get_disk_status($result['status']);
    $state = get_disk_state($result['state']);
    $point = get_disk_point($result['point']);
    $INM = strip_tags($result['INM']);
    $INC = strip_tags($result['INC']);
    $date = $result['date'];
    $user = get_user_name_by_id($result['id_user'], $link);

    switch ($type_oper) {
      case 1:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:green;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a>  <b>Приход</b>| </span>
      диск с s/n: <b>" . $serial_num . "</b> | пользователем <b>" . $user . "</b> | Получен: " . $point . " в | <b>" . $date . "</b> | по заявке: " . $INM . " (" . $INC . ") | 
      в состоянии: <span class='" . get_class_disk_status($result['state']) . "'><b>" . $state . "</b></span> | Расположение: " . $status . " | с комментарием: <i>" . $comment . "</i>
      <br>";
        break;

      case 2:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a><b>Редактирование</b> | </span>
      диск с s/n: <b>" . $serial_num . "</b> | пользователем <b>" . $user . "</b> | Получен: " . $point . " в | <b>" . $date . "</b> | по заявке: " . $INM . " (" . $INC . ") | 
      в состоянии: <span class='" . get_class_disk_status($result['state']) . "'><b>" . $state . "</b></span> | Расположение: " . $status . " | с комментарием: <i>" . $comment . "</i>
      <br>";
        break;

      case 4:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a> <b>Перемещение в ОБ</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;

      case 5:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a> <b>Удаление</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;

      case 6:
        #формируем строку по данному изменению
        $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_charge` WHERE `id_disk`=$id ORDER BY `id` DESC LIMIT 1");
        while ($row = mysqli_fetch_array($sql2)) {
          #Инициализируем переменные
          (isset($row['type_equipment']) && !empty($row['type_equipment'])) ? $type_equipment = strip_tags($row['type_equipment']) : $type_equipment = 'неизветсно';
          (isset($rowt['isn']) && !empty($row['isn'])) ? $isn = strip_tags($row['isn']) : $isn = 'не указан';
          (isset($row['room']) && !empty($row['room'])) ? $room = strip_tags($row['room']) : $room = 'не указана';
          (isset($row['rack']) && !empty($row['rack'])) ? $rack = $row['rack'] : $rack = 'не указан';
          (isset($row['unit_start']) && !empty($row['unit_start'])) ? $unit_start = $row['unit_start'] : $unit_start = 'не указан';
          (isset($row['unit_end']) && !empty($row['unit_end'])) ? $unit_end = $row['unit_end'] : $unit_end = '';
          (isset($row['disk_num']) && !empty($row['disk_num'])) ? $disk_num = $row['disk_num'] : $disk_num = 'не указан';
        }
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . "</a> <b>Расход</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | диск установлен в <b>" . $type_equipment . "(ИСН: " . $isn . ")</b> | Расположение: <b>" . $room . "/" . $rack . "/" . $unit_start . "-" . $unit_end . "</b> в слот <b>" . $disk_num . "</b> с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 7:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Диск уничтожен ОБ</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 8:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Диск перемещен на склад</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;

      case 9:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Пермещение уничтоженного диска от ОБ на склад</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 10:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:red;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Передача уничтоженного диска в IBS</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 11:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска из ЦОДа на склад как сломанный</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 12:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска из ЦОДа на склад как б/у</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 13:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска на склад ОБ</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 14:
        #формируем строку по данному изменению
        $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Перемещение диска из Склада ОБ в работу</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
      <br>";
        break;
      case 15:
      #формируем строку по данному изменению
       $res_str .= "<span style='color:blue;'><a href='one_disk_exact.php?id=" . $id . "&id_disk=" . $id_templ . "'>id=" . $id . " id_templ=" . $id_templ . " </a> <b>Списание диска</b> | пользователем <b>" . $user . "</b> | <b>" . $date . "</b> | с комментарием: <i>" . $comment . "</i></span>
        <br>";
          break;
      default:
        $res_str .= "";
    }
  }
  if ($count == 0) {
    $res_str = '
  <blockquote class="quote-secondary">
  <p>Информация:</p>
  <small>Не данных по заданному типу id ...</small>
  </blockquote>';
  }

  return $res_str;
}
#Выводит комментарии указанного типа
#type_comment = 10 - коммаентарии на дашборде безопов
#type_comment = 11 - коммаентарии на ZIP
function show_comments($link, $id_rec, $type)
{
  $count = 0;
  echo '<div>';
  if (isset($id_rec) && !empty($id_rec)) {
    $sql = mysqli_query($link, "SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
  WHERE `id_rec`='" . $id_rec . "' AND `type`=" . $type . " ORDER BY `create_date` DESC LIMIT 10");
  } else {
    $sql = mysqli_query($link, "SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
    WHERE `type`=" . $type . " ORDER BY `create_date` DESC LIMIT 10");
  }
  if ($sql) {
    while ($result = mysqli_fetch_array($sql)) {
      $count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
      $result_user = mysqli_fetch_array($sql_user);
      $user_icon =  get_user_icon($result_user['ID'], $link);
      $content = mb_substr(strip_tags($result['content']), 0, 1000);
      echo '
      <div class="post">
      <div class="user-block">
      <img class="img-circle img-bordered-sm" src="' . get_user_icon($result['id_user'], $link) . '" alt="user image">
      <span class="username">
      <a href="#">' . get_user_name_by_id($result['id_user'], $link) . '</a>
      </span>
      <span class="description">Опубликовано- ' . $result['create_date'] . '</span>
      </div>
      <!-- /.user-block -->
      <p><small>
      ' . $content . '
      </small>
      </p>
      <!--
      <p>
      <a href="#" class="link-black text-sm">  
      <i class="fas fa-link mr-1"></i> </a>
      </p>
      -->
      </div> 
      ';
    }
  }
  if ($count == 0) {
    echo '
  <blockquote class="quote-secondary">
  <p>Информация:</p>
  <small>Для данного инцидента еще никто не оставил комментария.</small>
  </blockquote>
  ';
  }
  echo ' 
  </div>';
}

function get_disk_status($var)
{
  $res = 0;
  switch ($var) {
    case 1:
      $res = "На складе";
      break;
    case 2:
      $res = "В IBS";
      break;
    case 3:
      $res = "В ЦОДе";
      break;
    case 4:
      $res = "в ОБ";
      break;
    case 5:
      $res = "УДАЛЕН";
      break;
    case 6:
      $res = "В ОБ на хранении";
      break;
    case 7:
    $res = "ВНЕ ЦОДА";
    break;  
  }

  return $res;
}

function get_disk_state($var)
{
  $res = 0;
  switch ($var) {
    case 1:
      $res = "Новый";
      break;
    case 2:
      $res = "б/у";
      break;
    case 3:
      $res = "Сломан";
      break;
    case 4:
      $res = "Убит";
      break;
    case 5:
      $res = "В работе";
      break;
    case 6:
    $res = "Списан";
    break;  
  }
  return $res;
}

function get_disk_point($var)
{
  $res = 0;
  switch ($var) {
    case 1:
      $res = "из IBS";
      break;
    case 2:
      $res = "из ЦОД";
      break;
    case 3:
      $res = "из Склада";
      break;
    case 4:
      $res = "из ОБ";
      break;
  }
  return $res;
}

function check_button_permission($str_button, $user_level, $button_level_ar)
{
  if (isset($user_level) && $button_level_ar) {
    if (in_array($user_level, $button_level_ar)) {
      return $str_button;
    } else {
      $str_button = '';
    }
  }
  return $str_button;
}

function get_access_level_by_id($var)
{
  $res = 0;
  switch ($var) {
    case 0:
      $res = "Обычный пользователь";
      break;
    case 1:
      $res = "Дежурный ИТ Москва";
      break;
    case 2:
      $res = "Администратор безопасности";
      break;
    case 3:
      $res = "";
      break;
    case 5:
      $res = "Супер пользователь";
      break;
    default:
      $res = "Неизвестный тип пользователя";
  }
  return $res;
}

function get_class_item_disk($var)
{
  $res = 0;
  switch ($var) {
    case 1:
      $res = "middle_importance";
      break;
    case 2:
      $res = "low_importance";
      break;
    case 3:
      $res = "high_importance";
      break;
    case 4:
      $res = "pre_emergency_importance";
      break;
    case 5:
      $res = "high_importance";
      break;
    case 6:
      $res = "high_importance";
      break;
    case 7:
      $res = "pre_emergency_importance";
      break;
    case 8:
      $res = "emergency_importance";
      break;
    case 9:
      $res = "emergency_importance";
      break;
    case 10:
      $res = "emergency_importance";
      break;
    case 11:
      $res = "low_importance";
      break;
    case 12:
      $res = "low_importance";
      break;
    case 15:
      $res = "emergency_importance";
      break;
  }
  return $res;
}

function get_class_item_disk_state($var)
{
  $res = 0;
  switch ($var) {
    case 1:
      $res = "middle_importance";
      break;
    case 2:
      $res = "low_importance";
      break;
    case 3:
      $res = "pre_emergency_importance";
      break;
    case 4:
      $res = "emergency_importance";
      break;
    case 5:
      $res = "high_importance";
      break;
  }
  return $res;
}

function get_class_disk_status($var)
{
  $res = 0;
  switch ($var) {
    case 0:
      $res = "content-success-str";
      break;
    case 1:
      $res = "content-success-str";
      break;
    case 2:
      $res = "content-secondary-str";
      break;
    case 3:
      $res = "content-warning-str";
      break;
    case 4:
      $res = "content-danger-str";
      break;
    case 5:
      $res = "content-warning-str";
      break;
    case 6:
      $res = "content-danger-str";
      break;
    case 7:
      $res = "content-danger-str";
      break;  
  }
  return $res;
}

function get_class_disk_info($var)
{
  $res = 0;
  switch ($var) {
    case 0:
      $res = "bg-success";
      break;
    case 1:
      $res = "bg-success";
      break;
    case 2:
      $res = "bg-primary";
      break;
    case 3:
      $res = "bg-warning";
      break;
    case 4:
      $res = "bg-danger";
      break;
    case 5:
      $res = "bg-danger";
      break;
    case 6:
      $res = "bg-danger";
      break;
  }
  return $res;
}

function get_class_ribbon_record($var)
{
  $res = 0;
  switch ($var) {
    case 0:
      $res = "bg-success";
      break;
    case 1:
      $res = "bg-success";
      break;
    case 2:
      $res = "bg-primary";
      break;
    case 3:
      $res = "bg-danger-strike";
      break;
    case 4:
      $res = "bg-unimportant-strike";
      break;
    case 5:
      $res = "ribbon bg-secondary";
      break;  
    default:
      $res = "bg-success";
      break;
  }
  return $res;
}

function check_input($link, $var)
{
  return mysqli_real_escape_string($link, $var);
}

function is_allow($user_permission, $level_access)
{
  $res = 0;
  if (isset($user_permission) && $level_access) {
    if (in_array($user_permission, $level_access)) {
      $res = 1;
    }
  }
  return $res;
}

function is_active($item, $opt)
{
  $res = '';
  if ($opt == 1) {
    $menu = array("incidents_new", "news_new", "jobs_new", "notifications_new");
  }
  if ($opt == 2) {
    $menu = array("report1", "report2","report4");
  }

  if ($opt == 3) {
    $menu = array("push_disks", "pull_disks", "all_disks_operations", "overall_disks", "one_disk", "one_disk_exact", "warehouse_disks", "warehouse_disks_all", "warehouse_broken_disks", "security_disks", "ibs_disks", "search_disk", "cod_disks", "forgiven_disks");
  }

  if (in_array($item, $menu)) {
    $res = 'menu-open';
  }
  return $res;
}

function get_user_icon($user_id, $link)
{
  if (file_exists($_SERVER['DOCUMENT_ROOT']."/dist/img/".$user_id.".png")) {
    $res = "/dist/img/".$user_id.".png";
    
  }
  else {
    $res = "/dist/img/default.png";
  }

  return $res;
}

function get_notifications_count($link, $opt)
{
  $count_incidents[0] = 0;
  $count_news[0] = 0;
  $count_jobs[0] = 0;
  $last_login = get_last_user_login($_COOKIE['id'], $link);
  $current_login = get_current_user_login($_COOKIE['id'], $link);
  $last_shift_id = get_last_shift_id($link);

  #проверяем наличие прав доступа
  $allow = 0;
  $level_access = array(1);
  $allow = is_allow($_COOKIE['permissions'], $level_access);

  if ($allow) {
    $sql1 = mysqli_query($link, "SELECT COUNT(*)  FROM `list`  WHERE id_shift=$last_shift_id AND Create_date >= '$last_login'  AND `deleted`=0");
    $sql2 = mysqli_query($link, "SELECT COUNT(*)  FROM `news`  WHERE  Create_date >= '$last_login'  AND `deleted`=0");
    $sql3 = mysqli_query($link, "SELECT COUNT(*)  FROM `jobs`  WHERE  create_date >= '$last_login' AND `deleted`=0");
  } else {
    # Все другие, не дежурные
    $sql1 = mysqli_query($link, "SELECT COUNT(*)  FROM `list` WHERE id_shift=$last_shift_id AND Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
    $sql2 = mysqli_query($link, "SELECT COUNT(*)  FROM `news` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
    $sql3 = mysqli_query($link, "SELECT COUNT(*)  FROM `jobs` WHERE create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
  }

  if ($sql1) {
    $count_incidents = mysqli_fetch_array($sql1);
  }
  if ($sql2) {
    $count_news = mysqli_fetch_array($sql2);
  }
  if ($sql3) {
    $count_jobs = mysqli_fetch_array($sql3);
  }

  if ($opt == 1) {
    return $res = $count_incidents[0];
  }

  if ($opt == 2) {
    return $res = $count_news[0];
  }

  if ($opt == 3) {
    return $res = $count_jobs[0];
  }

  $res = $count_incidents[0] + $count_news[0] + $count_jobs[0];
  return $res;
}

//Возвращает поступление новыйх дисков за период
function get_notifications_count_disk_plus($link, $interval)
{
  #Новые
  $sql = "SELECT COUNT(*) FROM `disk_movement` WHERE `state`=1 AND `status`=1 AND `type_oper`=1 AND  `date`>= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)";
  $res = mysqli_query($link, $sql);
  if ($row = mysqli_fetch_row($res)) {
    $res2 = $row[0]; // 
  } else {
    $res2 = 0;
  }
  return $res2;
}

function importance_class_star($importance)
{
  switch ($importance) {
    case 1:
      $res = "float-right text-sm text-muted";
      break;
    case 2:
      $res = "float-right text-sm text-muted";
      break;
    case 3:
      $res = "float-right text-sm text-warning";
      break;
    case 4:
      $res = "float-right text-sm text-danger";
      break;
  }
  return $res;
}

function is_shift_open($id_shift, $link)
{
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT end_date  FROM `shift` WHERE ID=$id_shift"));
  if ($data) {
    $res = $data['end_date'];
    if ($res != NULL) {
      $res = 0;
    } else {
      $res = 1;
    }
  } else {
    $res = 0;
  }
  return $res;
}

function get_last_user_login($id_user, $link)
{
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT end_date  FROM `shift` WHERE id_user=$id_user AND end_date IS NOT NULL  ORDER BY end_date DESC LIMIT 1"));
  if ($data) {
    $res = $data['end_date'];
  } else {
    $res = 0;
  }
  return $res;
}

function get_current_user_login($id_user, $link)
{
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT *  FROM `shift` WHERE id_user=$id_user ORDER BY create_date DESC LIMIT 1"));
  if ($data) {
    $res = $data['create_date'];
  } else {
    $res = 0;
  }
  return $res;
}

function get_last_shift_id($link)
{
  $data = mysqli_fetch_assoc(mysqli_query($link, 'SELECT ID  FROM `shift` ORDER BY ID DESC LIMIT 1'));
  if ($data) {
    $res = $data['ID'];
  } else {
    $res = 0;
  }
  return $res;
}

//$data = mysqli_fetch_assoc(mysqli_query($link, 'SELECT *  FROM `shift` WHERE `status`=0 ORDER BY ID DESC LIMIT 1'));

function get_last_shift_info_closed($link)
{
  $sql1 = 'SELECT *  FROM `shift` WHERE `status`=0 ORDER BY ID DESC LIMIT 1';
  $sql2 = 'SELECT *  FROM `shift` WHERE `status`=1 ORDER BY ID DESC LIMIT 1';

  $data = mysqli_fetch_assoc(mysqli_query($link, $sql2));
  if ($data) {
    $cur_user = $data['id_user'];
    $sql1 = "SELECT *  FROM `shift` WHERE `status`=0 AND `id_user`<>$cur_user ORDER BY ID DESC LIMIT 1";
  }

  $data2 = mysqli_fetch_assoc(mysqli_query($link, $sql1));
  if ($data2) {
    $res = array("id" => $data2['ID'], "id_user" => $data2['id_user'], "create_date" => $data2['create_date'], "end_date" => $data2['end_date']);
  } else {
    $res = 0;
  }
  //echo  $res['end_date'];

  return $res;
}

function get_cur_shift_info($link)
  {
    date_default_timezone_set("Europe/Moscow");
    $sql1 = 'SELECT *  FROM `shift` WHERE `status`=1 ORDER BY ID DESC LIMIT 1';
    $data2 = mysqli_fetch_assoc(mysqli_query($link, $sql1));
    if ($data2) {
      $res = array("id" => $data2['ID'], "id_user" => $data2['id_user'], "create_date" => $data2['create_date'], "end_date" => date("Y-m-d H:i:s"));
    } else {
      $res = 0;
    }
    return $res;
  }

function get_shift_info($link,$id_shift)
{
  $sql = "SELECT *  FROM `shift` WHERE `id`=$id_shift";
  $res=array();
  $data = mysqli_fetch_assoc(mysqli_query($link, $sql));
  if ($data) {
    $res = $data;   
  }
  return $res;
}



# находит последнюю id последней смены, открытую ползователем не равным тому, что передали в параметре
#доработать на случай случайного закрытия смены пользователем
function get_last_shift_id_v2($link, $id_user)
{
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT ID  FROM `shift` WHERE id_user<>$id_user ORDER BY ID DESC LIMIT 1"));
  if ($data) {
    $res = $data['ID'] - 1;
  } else {
    $res = 0;
  }
  return $res;
}

function get_user_name_by_id($id, $link)
{
  $res = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=$id");
  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $res_str = $row['first_name'] . ' ' . $row['last_name'];
  } else {
    $res_str = 'Неизвестный пользователь';
  }
  return $res_str;
}

function get_user_login_by_id($id, $link)
{
  $res = mysqli_query($link, "SELECT `users_login` FROM `users` WHERE `ID`=$id");
  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $res_str = $row['users_login'];
  } else {
    $res_str = 0;
  }
  return $res_str;
}

function get_error_by_id($value = 0)
{

  switch ($value) {
    case 1:
      $res = "Запись не была добавлена в журнал инцидентов. Не заполнено одно из обязательных полей: Jira_num, Area_content";
      break;
    case 2:
      break;
    case 3:
      $res = "Запись не была добавлена в журнал инцидентов. Не заполнено обязательное поле 'комментарий'";
      break;
    default:
      $res = "Неизветсная ошибка";
      break;
  }

  return $res;
}
function get_status($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "<span style='color:green;'>В работе</span>";
      break;
    case 2:
      $res = "<span style='color:blue;'>В ожидании</span>";
      break;
    case 3:
      $res = "<span style='color:red;'><strike>Выполнено</strike></span>";
      break;
    case 4:
      $res = "<span style='color:grey;'><strike>Закрыто</strike></span>";
      break;
    case 5:
      $res = "<span style='color:grey;'><strike>Удален</strike></span>";
      break;
  }
  return $res;
}

function get_status_ribbon($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "<span style='color:white;'>В работе</span>";
      break;
    case 2:
      $res = "<span style='color:white;'>В ожидании</span>";
      break;
    case 3:
      $res = "<span style='color:white;'><strike>Выполнено</strike></span>";
      break;
    case 4:
      $res = "<span style='color:white;'><strike>Закрыто</strike></span>";
      break;
    case 5:
      $res = "<span style='color:white;'><strike>Удален</strike></span>";
      break;  
  }
  return $res;
}

function get_status_for_ribbons($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "В работе";
      break;
    case 2:
      $res = "Ожидание";
      break;
    case 3:
      $res = "<strike>Выполнено</strike>";
      break;
    case 4:
      $res = "<strike>Закрыто</strike>";
      break;
  }
  return $res;
}

function is_keep($code_status = 0)
{
  switch ($code_status) {
    case 0:
      $res = "Нет";
      break;
    case 1:
      $res = "Да";
      break;
  }
  return $res;
}

function get_type($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "Новость";
      break;
    case 2:
      $res = "Задание";
      break;
  }
  return $res;
}

function get_type_inc($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "Инцидент";
      break;
    case 2:
      $res = "Заметка";
      break;
  }
  return $res;
}

function get_type_jobs($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "Наряд на работы";
      break;
    case 2:
      $res = "Другой тип задания";
      break;
  }
  return $res;
}

function get_status_news($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "Опубликовано";
      break;
    case 2:
      $res = "Не опубликовано";
      break;
  }
  return $res;
}

function get_status_jobs($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "<span style='color:green;'>В работе</span>";
      break;
    case 2:
      $res = "<span style='color:blue;'>В ожидании</span>";
      break;
    case 3:
      $res = "<span style='color:red;'>Выполнено</span>";
      break;
    case 4:
      $res = "<span style='color:grey;'><strike>Закрыто</strike></span>";
      break;
  }
  return $res;
}

function get_status_for_ribbons_jobs($code_status = 0)
{
  switch ($code_status) {
    case 1:
      $res = "В работе";
      break;
    case 2:
      $res = "Ожидании";
      break;
    case 3:
      $res = "<strike>Выполнено</strike>";
      break;
    case 4:
      $res = "<strike>Закрыто</strike>";
      break;
  }
  return $res;
}

function get_importance($value = 2)
{
  switch ($value) {
    case 1:
      $res = "<span style='color:grey;'>Низкий</span>";
      break;
    case 2:
      $res = "<span style='color:green;'>Средний</span>";
      break;
    case 3:
      $res = "<span style='color:#FF4500';>Высокий</span>";
      break;
    case 4:
      $res = "<span style='color:red';><b>Чрезвачайный</b></span>";
      break;
  }
  return $res;
}
/*
  $res = "bg-success";
break;
case 1:
$res = "bg-success";
break;
case 2:
$res = "bg-primary";
break;
case 3:
$res = "bg-warning";
break;
case 4:
$res = "bg-danger";
break;
case 5:
$res = "bg-danger";
break;
case 6:
$res = "bg-success";
*/

function get_jira_issue_class_priority($value)
{
  switch ($value) {
    case 0:
      $res = "bg-danger";
      break;
    case 1:
      $res = "bg-danger";
      break;
    case 2:
      $res = "bg-warning";
      break;
    case 3:
      $res = "bg-success";
      break;
    case 10001:
      $res = "bg-secondary";
      break;
    default:
      $res = "bg-success";
      break;
  }
  #Значение по умолчанию  
  return $res;
}

function set_importance_class($value = 'middle_importance')
{
  switch ($value) {
    case 1:
      $res = "low_importance";
      break;
    case 2:
      $res = "middle_importance";
      break;
    case 3:
      $res = "high_importance";
      break;
    case 3:
      $res = "high_importance";
      break;
    case 4:
      $res = "emergency_importance";
      break;
  }

  return $res;
}

function get_action_notification($value = 0)
{
  switch ($value) {
    case 1:
      $res = "
          <script type='text/javascript'>
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Запись удачно создана...`)
});
</script>
          ";
      break;
    case 2:
      $res = "
            <script type='text/javascript'>
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Запись удачно отредактирована...`)
});
</script>
            ";
      break;
    case 3:
      $res = "
            <script type='text/javascript'>
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Запись удачно удалена...`)
});
</script>
            ";
      break;
    case 4:
      $res = "
            <script type='text/javascript'>
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Комментарий удачно добавлен...`)
});
</script>    
";
  case 5:
    $res = "
          <script type='text/javascript'>
  $(document).ready(function() {
  //Здесь функция function DleTrackDownload
  toastr.success(`Информация принята к сведению...`)
  });
  </script>    
  ";
      break;
  }
  unset($_SESSION['success_action']);
  return $res;
}

function get_class_for_div($value = 0)
{
  switch ($value) {
    case 1:
      $res = "alert-secondary";
      break;
    case 2:
      $res = "alert-success";
      break;
    case 3:
      $res = "alert-warning";
      break;
    case 4:
      $res = "alert-danger";
      break;
  }

  return $res;
}

function get_class_for_div_content($value = 0)
{
  switch ($value) {
    case 1:
      $res = "content-secondary";
      break;
    case 2:
      $res = "content-success";
      break;
    case 3:
      $res = "content-warning";
      break;
    case 4:
      $res = "content-danger";
      break;
  }

  return $res;
}


function get_class_for_keeped_news($value = 0)
{
  switch ($value) {
    case 1:
      $res = "callout callout-info";
      break;
    case 2:
      $res = "callout callout-success";
      break;
    case 3:
      $res = "callout callout-warning";
      break;
    case 4:
      $res = "callout callout-danger";
      break;
  }

  return $res;
}

function generate_uniq_id()
{
  $stamp = date("Ymdhis");
  $ip = $_SERVER['REMOTE_ADDR'];
  $id = "$stamp.$ip";
  $id = str_replace(".", "", "$id");
  return $id;
}


function get_count_notification_incidents($access_level, $link)
{
  $count = 0;
  $last_login = get_last_user_login($_COOKIE['id'], $link);
  $current_login = get_current_user_login($_COOKIE['id'], $link);
  $last_shift_id = get_last_shift_id($link);
  $count_incidents = 0;
  if ($access_level) {
    $sql = mysqli_query($link, "SELECT *  FROM `list`  WHERE id_shift=$last_shift_id  AND Create_date <= '$current_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
  } else {
    $sql = mysqli_query($link, "SELECT *  FROM `list` WHERE id_shift=$last_shift_id AND Create_date >= (CURDATE() -1) AND `deleted`=0");
  }
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);


    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}


function get_count_notification_news($access_level, $link)
{
  $count = 0;
  $last_login = get_last_user_login($_COOKIE['id'], $link);
  $current_login = get_current_user_login($_COOKIE['id'], $link);
  $last_shift_id = get_last_shift_id($link);
  $count_incidents = 0;
  if ($access_level) {
    $sql = mysqli_query($link, "SELECT *  FROM `news`  WHERE  Create_date >= '$last_login'  AND `deleted`=0");
  } else {
    $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0");
  }
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);

    // $num_rows_incidents = 1;
    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}

function get_count_notification_jobs($access_level, $link)
{
  $count = 0;
  $current_user_id = $_COOKIE['id'];
  $current_user_permissions = $_COOKIE['permissions'];
  $last_login = get_last_user_login($_COOKIE['id'], $link);
  $current_login = get_current_user_login($_COOKIE['id'], $link);
  $last_shift_id = get_last_shift_id($link);
  $count_incidents = 0;
  if ($current_user_permissions==1) {
    $sql = mysqli_query($link, "SELECT *  FROM `jobs`  WHERE Create_date >= '$last_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
  }
  else {
  $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
  }
   /*
  if ($current_user_permissions == 1) {
    // $sql = mysqli_query($link, "SELECT *  FROM `jobs`  WHERE create_date >= '$last_login' AND create_date <= '$current_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (`executor`=$current_user_id OR `executor`=0) AND (`status`= 1 OR `status`=2) AND `deleted`=0");
  } else if ($current_user_permissions == 0) {
    //$sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (`executor`=$current_user_id OR `executor`=0) AND (`status`= 1 OR `status`=2) AND `deleted`=0");
  } else if ($current_user_permissions == 5) {
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (`id_user`=$current_user_id) AND (`status`= 1 OR `status`=2 OR `status`=3) AND `deleted`=0");
  } else {
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE (Create_date >= (CURDATE() -1)) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
  }
  */
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);

    //$num_rows_incidents = 1;
    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}

function get_count_notification_all($access_level, $link)
{
  $count = 0;
  $incidents = get_count_notification_incidents($access_level, $link);
  $news = get_count_notification_news($access_level, $link);
  $jobs = get_count_notification_jobs($access_level, $link);
  $count = $incidents + $news + $jobs;
  return $count;
}

function get_count_broken_disk_storage($link)
{
  $count = 0;
  $sql = mysqli_query($link, "SELECT *  FROM `disk_balance` WHERE `status`=1 AND `state`=3  AND `deleted`=0");
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);
    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}

function get_count_killed_disk_storage($link)
{
  $count = 0;
  $sql = mysqli_query($link, "SELECT *  FROM `disk_balance` WHERE `status`=1 AND `state`=4  AND `deleted`=0");
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);
    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}

function get_count_broken_disk_ob($link)
{
  $count = 0;
  $sql = mysqli_query($link, "SELECT *  FROM `disk_balance` WHERE `status`=4 AND `state`=3  AND `deleted`=0");
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);
    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}

function get_count_killed_disk_ob($link)
{
  $count = 0;
  $sql = mysqli_query($link, "SELECT *  FROM `disk_balance` WHERE `status`=4 AND `state`=4  AND `deleted`=0");
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);
    if ($num_rows_incidents > 0) {
      $count = $num_rows_incidents;
    }
  }
  return $count;
}
function is_this_rec_new($link,$id) {
$last_login = get_last_user_login($_COOKIE['id'], $link);
$current_login = get_current_user_login($_COOKIE['id'], $link);
$last_shift_id = get_last_shift_id($link);
$permissions = $_COOKIE['permissions'];
if ($permissions==1) {
  $sql = mysqli_query($link, "SELECT *  FROM `list`  WHERE ID=$id AND id_shift=$last_shift_id  AND Create_date >= '$last_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
} else {
  $sql = mysqli_query($link, "SELECT *  FROM `list` WHERE ID=$id AND id_shift=$last_shift_id AND Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
}
if ($sql) {
  $num_rows_incidents = mysqli_num_rows($sql);
  $str_note = '';
  if ($num_rows_incidents > 0) {
    return 1;
  }
return 0;  
}
}

function is_this_news_new($link,$id) {
  $last_login = get_last_user_login($_COOKIE['id'], $link);
  $current_login = get_current_user_login($_COOKIE['id'], $link);
  $last_shift_id = get_last_shift_id($link);
  $permissions = $_COOKIE['permissions'];
  if ($permissions==1) {
    $sql = mysqli_query($link, "SELECT *  FROM `news`  WHERE ID=$id AND Create_date >= '$last_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
}
else {
  $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE ID=$id AND Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
}
  
  if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);
    $str_note = '';
    if ($num_rows_incidents > 0) {
      return 1;
    }
  return 0;  
  }
  }


  function is_this_job_new_v2($link,$id) {
    $current_user_id = $_COOKIE['id'];
    $last_login = get_last_user_login($_COOKIE['id'], $link);
    $current_login = get_current_user_login($_COOKIE['id'], $link);
    $last_shift_id = get_last_shift_id($link);
    $permissions = $_COOKIE['permissions'];
    if ($permissions==1) {
      // $sql = mysqli_query($link, "SELECT *  FROM `jobs`  WHERE create_date >= '$last_login' AND create_date <= '$current_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
  $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE ID=$id AND (`executor`=$current_user_id OR `executor`=0) AND (`status`= 1 OR `status`=2) AND `deleted`=0");
}
  else if ($permissions==0){
    //$sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE ID=$id AND (`executor`=$current_user_id OR `executor`=0) AND (`status`= 1 OR `status`=2) AND `deleted`=0");
  }
  else if ($permissions==5){
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE ID=$id AND (`id_user`=$current_user_id) AND (`status`= 1 OR `status`=2 OR `status`=3) AND `deleted`=0");
  }
  else {
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE ID=$id AND (Create_date >= (CURDATE() -1)) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
  }
    if ($sql) {
      $num_rows_incidents = mysqli_num_rows($sql);
      $str_note = '';
      if ($num_rows_incidents > 0) {
        return 1;
      }
    return 0;  
    }
  }

  function is_this_job_new($link,$id) {
    $current_user_id = $_COOKIE['id'];
    $last_login = get_last_user_login($_COOKIE['id'], $link);
    $current_login = get_current_user_login($_COOKIE['id'], $link);
    $last_shift_id = get_last_shift_id($link);
    $permissions = $_COOKIE['permissions'];
    if ($permissions==1) {
      $sql = mysqli_query($link, "SELECT *  FROM `jobs`  WHERE ID=$id AND Create_date >= '$last_login' AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10") ;
  }
  else {
    $sql = mysqli_query($link, "SELECT *  FROM `jobs` WHERE ID=$id AND Create_date >= (CURDATE() -1) AND `deleted`=0 ORDER BY Create_date DESC LIMIT 10");
  }

    if ($sql) {
      $num_rows_incidents = mysqli_num_rows($sql);
      $str_note = '';
      if ($num_rows_incidents > 0) {
        return 1;
      }
    return 0;  
    }
  }

  function is_record_taken_into_consideration ($link, $id_record, $id_user) {
    $sql = mysqli_query($link, "SELECT *  FROM `checked_record` WHERE id_user=$id_user AND id_record=$id_record");
    if ($sql) {
    $num_rows_incidents = mysqli_num_rows($sql);
    $str_note = '';
    if ($num_rows_incidents > 0) {
    return 1;
    }
  }
return 0;
} 

function who_checked_record ($link, $id_record) {
  $i=0;
  $mas = array();
  $sql = mysqli_query($link, "SELECT DISTINCT `id_user` FROM `checked_record` WHERE id_record=$id_record");
  if ($sql) {
  while ($result = mysqli_fetch_array($sql)) {
    $mas[$i] = $result['id_user'];
    $i++;
    } 
  }
  return $mas;      
} 

function is_record_taken_into_consideration_inc ($link, $id_record, $id_user) {
  $sql = mysqli_query($link, "SELECT *  FROM `checked_record_inc` WHERE id_user=$id_user AND id_record='$id_record'");
  if ($sql) {
  $num_rows_incidents = mysqli_num_rows($sql);
  $str_note = '';
  if ($num_rows_incidents > 0) {
  return 1;
  }
}
return 0;
} 

function who_checked_record_inc($link, $id_record) {
$i=0;
$mas = array();
$sql = mysqli_query($link, "SELECT DISTINCT `id_user` FROM `checked_record_inc` WHERE id_record='$id_record'");
if ($sql) {
while ($result = mysqli_fetch_array($sql)) {
  $mas[$i] = $result['id_user'];
  $i++;
  } 
}
return $mas;      
} 


function get_type_oper_by_id($id_oper = 0)
{
  switch ($id_oper) {
    case 1:
      $res = "Создание";
      break;
    case 2:
      $res = "zzz";
      break;
    default:
      $res = 0;
      break;  
  }
  return $res;
}

function print_all_news_changes ($link,$id) {
$res = "";
$i=0;
if ($id!=0){
  $sql = mysqli_query($link, "SELECT * FROM `news_changes` WHERE id_rec=$id");
}
else {
  $sql = mysqli_query($link, "SELECT * FROM `news_changes` ORDER BY `id` DESC");  
}
if ($sql) {
  while ($result = mysqli_fetch_array($sql)) {
    #Инициализируем переменные
    $id_rec =  $result['id_rec'];
    $id_oper= $result['id_oper'];
    $id_user = $result['id_user'];
    $id_file = $result['id_file'];
    $date = $result['date'];
    $status = $result['status'];
    $type = $result['type'];
    $importance = $result['importance'];
    
    #Формируем строку для каждой операции по данной записи 
    switch ($id_oper) {
      case 1:
        $res .= "<span style='color:green;'><b>Создание новости</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Статус: <b>".get_status_news($status)."</b> | Важность: <b>".get_importance($importance)."</b></br>";
        break;
      case 2:
        $res .= "<span style='color:red;'><b>Удаление новости</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
        break;
      case 3:
        $res .= "<span style='color:blue;'><b>Редактировнание новости</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
        break; 
      case 4:
        $res .= "<small>----------<span style='color:blue;'><b>Изменение статуса</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Статус: <b>".get_status_news($status)."</b></small></br>";
         break;
      case 5:
        $res .= "<small>----------<span style='color:blue;'><b>Изменение важности</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Важность: <b>".get_importance($importance)."</b></small></br>";
        break;
      case 6:
        $res .= "<small>----------<span style='color:blue;'><b>Изменение типа</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Тип: <b>".get_type_inc($type)."</b></small></br>";
        break; 
      case 7:
        $res .= "<span style='color:green;'><b>Добавление файла: </span>".get_filename_by_id($link,$id_file)."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
        break; 
      case 8:
        $res .= "<span style='color:red; text-decoration:line-through;'><b>Удаление файла: </span>".get_filename_by_id($link,$id_file)."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
        break;   
      default:
        $res .= "Неизвестная операция";
        break;  
    } 
$i++;    
} 

if ($i==0){
  $res = " 
      Нет изменений
  ";    
}
}
$res = '
<small>
  <blockquote>
    '.$res.'
  </blockquote>  
</small>';

return $res;  
}

function print_all_list_changes ($link,$id) {
  $res = "";
  $i=0;
if (!$id==0) {
  $sql = mysqli_query($link, "SELECT * FROM `list_changes` WHERE `id_rec`='$id'");
}
else {
  $sql = mysqli_query($link, "SELECT * FROM `list_changes` ORDER by `id` DESC LIMIT 50");
}
  if ($sql) {
    while ($result = mysqli_fetch_array($sql)) {
      #Инициализируем переменные
      $id_rec =  $result['id_rec'];
      $id_oper= $result['id_oper'];
      $id_user = $result['id_user'];
      $id_file = $result['id_file'];
      $date = $result['date'];
      $status = $result['status'];
      $type = $result['type'];
      $importance = $result['importance'];
      
      #Формируем строку для каждой операции по данной записи 
      switch ($id_oper) {
        case 1:
          $res .= "<span style='color:green;'><b>Создание инцидента</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Статус: <b>".get_status_news($status)."</b> | Важность: <b>".get_importance($importance)."</b></br>";
          break;
        case 2:
          $res .= "<span style='color:red;'><b>Удаление инцидента</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
          break;
        case 3:
          $res .= "<span style='color:blue;'><b>Редактировнание инцидента</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
          break; 
        case 4:
          $res .= "<small>----------<span style='color:blue;'><b>Изменение статуса</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Статус: <b>".get_status($status)."</b></small></br>";
           break;
        case 5:
          $res .= "<small>----------<span style='color:blue;'><b>Изменение важности</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Важность: <b>".get_importance($importance)."</b></small></br>";
          break;
        case 6:
          $res .= "<small>----------<span style='color:blue;'><b>Изменение типа</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Тип: <b>".get_type_inc($type)."</b></small></br>";
          break; 
        case 7:
          $res .= "<span style='color:green;'><b>Добавление файла: </span>".get_filename_by_id($link,$id_file)."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
          break; 
        case 8:
          $res .= "<span style='color:red; text-decoration:line-through;'><b>Удаление файла: </span>".get_filename_by_id($link,$id_file)."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
          break;   
        default:
          $res .= "Неизвестная операция";
          break;  
      } 
  $i++;    
  } 
  
  if ($i==0){
    $res = " 
        Нет изменений
    ";    
  }
  }
  $res = '
  <small>
    <blockquote>
      '.$res.'
    </blockquote>  
  </small>';
  
  return $res;  
  }

  function print_all_jobs_changes ($link,$id) {
    $res = "";
    $i=0;
    if ($id!=0){
      $sql = mysqli_query($link, "SELECT * FROM `jobs_changes` WHERE id_rec=$id");
    }
    else {
      $sql = mysqli_query($link, "SELECT * FROM `jobs_changes` ORDER BY `id` DESC");
    }
    if ($sql) {
      while ($result = mysqli_fetch_array($sql)) {
        #Инициализируем переменные
        $id_rec =  $result['id_rec'];
        $id_oper= $result['id_oper'];
        $id_user = $result['id_user'];
        $id_file = $result['id_file'];
        $date = $result['date'];
        $status = $result['status'];
        $type = $result['type'];
        $importance = $result['importance'];
        $executor = $result['id_exec'];
        if ($executor==0) {
          $executor = 'Не имеет значения';
        }
        else {
          $executor = get_user_name_by_id($executor,$link);
        }
        
        #Формируем строку для каждой операции по данной записи 
        switch ($id_oper) {
          case 1:
            $res .= "<span style='color:green;'><b>Создание задания</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Исполнитель: <b>".$executor."</b> | Статус: <b>".get_status_news($status)."</b> | Важность: <b>".get_importance($importance)."</b></br>";
            break;
          case 2:
            $res .= "<span style='color:red;'><b>Удаление задания</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
            break;
          case 3:
            $res .= "<span style='color:blue;'><b>Редактировнание задания</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
            break; 
          case 4:
            $res .= "<small>----------<span style='color:blue;'><b>Изменение статуса</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Статус: <b>".get_status_jobs($status)."</b></small></br>";
             break;
          case 5:
            $res .= "<small>----------<span style='color:blue;'><b>Изменение важности</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Важность: <b>".get_importance($importance)."</b></small></br>";
            break;
          case 6:
            $res .= "<small>----------<span style='color:blue;'><b>Изменение типа</span></b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b> | Тип: <b>".get_type_jobs($type)."</b></small></br>";
            break; 
          case 7:
            $res .= "<span style='color:green;'><b>Добавление файла: </span>".get_filename_by_id($link,$id_file)."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
            break; 
          case 8:
            $res .= "<span style='color:red; text-decoration:line-through;'><b>Удаление файла: </span>".get_filename_by_id($link,$id_file)."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></br>";
            break;  
          case 9:
            $res .= "<small>----------<span style='color:blue;'><b>Изменение исполнителя на : </span>".$executor."</b> пользователем <b>".get_user_name_by_id($id_user,$link)." ".$date."</b></small></br>";
            break;    
          default:
            $res .= "Неизвестная операция";
            break;  
        } 
    $i++;    
    } 
    
    if ($i==0){
      $res = " 
          Нет изменений
      ";    
    }
    }
    $res = '
    <small>
      <blockquote>
        '.$res.'
      </blockquote>  
    </small>';
    
    return $res;  
    }  

function get_filename_by_id($link, $id){
  $res = 'Неизвестный файл';
  $sql = mysqli_query($link, "SELECT `id`, `name` FROM `uploads` WHERE `id`=$id"); 
  $row = mysqli_fetch_assoc($sql);
  if ($row) {
    $res = $row['name'] ;
  } 
  return $res;
}

function print_exact_report_shift($link,$id_shift,$id_group) {
$res_str=array();
$i=0;
$sql = mysqli_query($link, "SELECT * FROM `report_shift` WHERE id_shift=$id_shift AND id_group=$id_group");
if ($sql) {
  $res['str']='<table class="table table-bordered table-striped table_inc_class dataTable dtr-inline collapsed">
  <tbody>';
  while ($result = mysqli_fetch_array($sql)) {
    #Инициализируем переменные
    $id_shift =  $result['id_shift'];
    $jira_num =  $result['jira_num'];
    $topic =  $result['topic'];
    $id_group =  $result['id_group'];
    $id_user =  $result['id_user'];
    $priority =  $result['priority'];

    $res['str'] .= '
    <tr class="'.get_jira_issue_class_priority($priority).'">
				<td><a class="link-black" style="color:white;" href="https://servicedesk:8443/browse/'.$jira_num.'" target="_blank" > '.sprintf("%s \n",$jira_num).'</a></td>
        <td>'.$topic.'</td>
		</tr>
    ';
  $i++;  
  }
  if ($i==0) {
    $res['str'] .='
    <tr>
    <td colspan="2" style="text-align:center;">Нет записей для отображения</td>
    </tr>';
  }
}
else {
  echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
  exit(); 
}  
$res['str'] .= '</tbody></table>';
$res['count'] = $i;
return $res;
}

