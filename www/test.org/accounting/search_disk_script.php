<?php
$count = 0;
if (!isset($_GET['page']) || empty($_GET['page'])) {
  $_GET['page'] = 1;
}
$page = (int) $_GET['page'];
if (empty($page)) $page = 1; // если страница не задана, показываем первую

include("../scripts/paging.php");
#вывод новтей с пагинацией
$page_setting = [
  'limit' => 5, // кол-во записей на странице
  'show'  => 5, // 5 до текущей и после
  'prev_show' => 0, // не показывать кнопку "предыдущая"
  'next_show' => 0, // не показывать кнопку "следующая"
  'first_show' => 0, // не показывать ссылку на первую страницу
  'last_show' => 0, // не показывать ссылку на последнюю страницу
  'prev_text' => 'назад',
  'next_text' => 'вперед',
  'class_active' => 'active',
  'separator' => ' <li class="paginate_button page-item ">
    <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link"> ... </a>
    </li> ',
];

function pagePrint($page, $title, $show, $active_class = '', $search = '')
{
  #говнокод, удалить потом
  $s_str = '';
  if (isset($_GET['search_type']) && ($_GET['search_type'] == 1)) {
    $s_str = '&search_type=1';
  }
  $active = 'active';
  #Конец говнокода
  if ($show) {
    echo '<li class="paginate_button page-item ">
        <a href="?do=list&page=' . $page . '&search=' . $_GET['search'] . $s_str . '" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</a>
        </li>
        ';
  } else {
    if (!empty($active_class)) $active = 'class="' . $active_class . '"';
    // echo '<span ' . $active . '>' . $title . '</span>';
    echo '<li class="paginate_button page-item active">
        <span aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</span>
        </li>
        ';
  }
  return false;
}

function checkSearch($search)
{
  if ($search == "" || strlen($search) < 3) {
    echo '
<blockquote class="quote-secondary" style="margin-top: 0px;">
              <p>Запрос некорректен</p>
              <small>Запрос не должен быть пустым и должен содержать не менее 3-х символов</small>
           </blockquote>
	  ';
    return false;
  }
  return $search;
}

if (isset($_GET['search'])) {
  if (($search = checkSearch($_GET['search'])) !== false) {
    $start = ($page - 1) * $page_setting['limit'];
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `serial_num` LIKE '%{$search}%' OR `INM` LIKE '%{$search}%' OR `INC` LIKE '%{$search}%' OR `comment` LIKE '%{$search}%' ORDER BY `date`");
    $count_rec = mysqli_num_rows($sql);
    #  echo $count_rec;
    if (mysqli_num_rows($sql) == 0) {
      echo '
          <blockquote class="quote-secondary" style="margin-top: 0px;">
              <p>Нет совпадений</p>
              <small>По вашему запросу ничего не найдено, попробуйте еще раз</small>
           </blockquote>     
		 ';
    } else {

      #Найдены записи - вывод списка записей и пагинации
      echo '
	  	<blockquote class="quote-secondary" style="margin-top: 0px;">
        <p>Результаты поиска:</p>
        <small>По вашему запросу <i>"' . $_GET['search'] . '"</i> найдено ' . $count_rec . ' записей</small>
      </blockquote> ';
      #верхний блок пагинации
      #подсчет количества страниц и проверка основных условий
      $sql = mysqli_query($link_account, "SELECT COUNT(*) as count  FROM `disk_balance` WHERE `serial_num` LIKE '%{$search}%' OR `INM` LIKE '%{$search}%' OR `INC` LIKE '%{$search}%' OR `comment` LIKE '%{$search}%' ORDER BY `date`");
      $row = mysqli_fetch_array($sql);
      #$res = $db->query("SELECT count(*) AS count FROM news {$where}");
      #$row = $res->fetch(PDO::FETCH_ASSOC);
      $page_count = ceil($row['count'] / $page_setting['limit']); // кол-во страниц
      $page_left = $page - $page_setting['show']; // находим левую границу
      $page_right = $page + $page_setting['show']; // находим правую границу
      $page_prev = $page - 1; // узнаем номер предыдушей страницы
      $page_next = $page + 1; // узнаем номер следующей страницы
      if ($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
      if ($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
      if ($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
      if ($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
      if ($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
      if ($page != $page_count) $page_setting['last_show'] = 1;

      #вывод на экран
      echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';
      pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show'], $search);
      pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active'], $search);
      if ($page_left > 2) echo $page_setting['separator'];
      for ($i = $page_left; $i <= $page_right; $i++) {
        $page_show = 1;
        if ($page == $i) $page_show = 0;
        pagePrint($i, $i, $page_show, $page_setting['class_active'], $search);
      }
      if ($page_right < ($page_count - 1)) echo $page_setting['separator'];
      if ($page_count != 1)
        pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active'], $search);
      pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show'], $search);
      echo '</ul></div></div>';
      #конец вернего блока пагинации
      #Вывод новостей
      $start = ($page - 1) * $page_setting['limit'];

      $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `serial_num` LIKE '%{$search}%' OR `INM` LIKE '%{$search}%' OR `INC` LIKE '%{$search}%' OR `comment` LIKE '%{$search}%' ORDER BY `date`");
      while ($result = mysqli_fetch_array($sql)) {
        #Инициализируем переменные
        $count++;
        $id = $result['id'];
        $id_disk = $result['id_disk'];
        $user = get_user_name_by_id($result['id_user'], $link);
        $serial_num = strip_tags($result['serial_num']);
        $INM = strip_tags($result['INM']);
        $INC = strip_tags($result['INC']);
        $state = get_disk_state($result['state']);
        $status = get_disk_status($result['status']);
        $point = get_disk_point($result['point']);
        $comment = mb_substr(strip_tags($result['comment']), 0, 500);
        $inm = strip_tags($result['INM']);
        $inc = strip_tags($result['INC']);
        $date = $result['date'];
        $user_icon = get_user_icon($result['id_user'], $link);
        $user = get_user_name_by_id($result['id_user'], $link);
        echo '
<div class="tab-content">
<div class="active tab-pane" id="activity">
  <!-- Post -->
  <div class="post">
    <div style="clear: left"></div>
    <p>
    <h5>Серийный номер: ' . choose_color($serial_num, $search, "khaki") . '</h5>
    <small>
    <p>id: ' . $id . '</p>
    <p>Состояние: <span class="' . get_class_disk_status($result['state']) . '">' . $state . '</span></p>
    <p>Статус: <span class="' . get_class_disk_status($result['status']) . '">' . $status . '</span></p>
    <p>Поступил: ' . $point . '</p>
    <p>INM: ' . choose_color($inm, $search, "khaki") . '</p>
    <p>INC: ' . choose_color($inc, $search, "khaki") . '</p>
    <p>Автор прихода: ' . $user . '</p> 
    <p>Комментарий: ' . $comment . '</p>        
    </small>
    </p>
      <a href="one_disk_exact.php?id=' . $id . '&id_disk=' . $id_disk . '" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
  </div>
  <!-- /.post -->               
';
      }
      #нижний блок пагинации
      #подсчет количества страниц и проверка основных условий
      $sql = mysqli_query($link_account, "SELECT COUNT(*) as count  FROM `disk_balance` WHERE `serial_num` LIKE '%{$search}%' OR `INM` LIKE '%{$search}%' OR `INC` LIKE '%{$search}%' OR `comment` LIKE '%{$search}%' ORDER BY `date`");
      $row = mysqli_fetch_array($sql);
      #$res = $db->query("SELECT count(*) AS count FROM news {$where}");
      #$row = $res->fetch(PDO::FETCH_ASSOC);
      $page_count = ceil($row['count'] / $page_setting['limit']); // кол-во страниц
      $page_left = $page - $page_setting['show']; // находим левую границу
      $page_right = $page + $page_setting['show']; // находим правую границу
      $page_prev = $page - 1; // узнаем номер предыдушей страницы
      $page_next = $page + 1; // узнаем номер следующей страницы
      if ($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
      if ($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
      if ($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
      if ($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
      if ($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
      if ($page != $page_count) $page_setting['last_show'] = 1;

      #вывод на экран
      echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';
      pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show'], $search);
      pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active'], $search);
      if ($page_left > 2) echo $page_setting['separator'];
      for ($i = $page_left; $i <= $page_right; $i++) {
        $page_show = 1;
        if ($page == $i) $page_show = 0;
        pagePrint($i, $i, $page_show, $page_setting['class_active'], $search);
      }
      if ($page_right < ($page_count - 1)) echo $page_setting['separator'];
      if ($page_count != 1)
        pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active'], $search);
      pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show'], $search);
      echo '</ul></div></div>';
      #конец вернего блока пагинации							
    }
  }
}

include("../modal_close_shift.php");
