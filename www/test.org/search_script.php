<?php
$count=0;
if (!isset($_GET['page']) || empty($_GET['page'])){
$_GET['page'] = 1;
}
$page = (int) $_GET['page'];
if(empty($page)) $page = 1; // если страница не задана, показываем первую

include ("scripts/paging.php");
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

function pagePrint($page, $title, $show, $active_class = '',$search = '') {
  #говнокод, удалить потом
  $s_str='';
  if (isset($_GET['search_type']) && ($_GET['search_type']==1)) {
    $s_str = '&search_type=1';
  }
  $active='active';
  #Конец говнокода
    if($show) {
        echo '<li class="paginate_button page-item ">
        <a href="?do=list&page=' . $page . '&search='.$_GET['search'].$s_str.'" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</a>
        </li>
        ';
    } else {
        if(!empty($active_class)) $active = 'class="' . $active_class . '"';
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
   if($search == "" || strlen($search) < 3)
   {
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

if (isset($_GET['search_type']) && $_GET['search_type']==1) {
  if(isset($_GET['search']) )
  {
    if(($search = checkSearch($_GET['search'])) !== false)
    {
       $start = ($page-1)*$page_setting['limit'];
       #$sql= mysqli_query($link, "SELECT *  FROM `news` WHERE theme LIKE '%{$search}%'");
      # $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE theme LIKE '%{$search}%' order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");
       $sql = mysqli_query($link, "SELECT *  FROM `list` WHERE `jira_num` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' OR `destination` LIKE '%{$search}%' ORDER BY `create_date`");
       $count_rec = mysqli_num_rows($sql);
     #  echo $count_rec;
       if(mysqli_num_rows($sql) == 0)
      {
       echo '
            <blockquote class="quote-secondary" style="margin-top: 0px;">
                <p>Нет совпадений</p>
                <small>По вашему запросу ничего не найдено, попробуйте еще раз</small>
             </blockquote>     
       ';
      } else {
  #верхний блок пагинации
  #подсчет количества страниц и проверка основных условий
  #$sql = mysqli_query($link,"SELECT count(*) AS count FROM list WHERE `jira_num` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' OR `destination` LIKE '%{$search}%'");
  $sql = mysqli_query($link, "SELECT  DISTINCT `id_rec` FROM `list` WHERE `jira_num` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' OR `destination` LIKE '%{$search}%'");
  $i_count=0;
  while ($res = mysqli_fetch_array($sql)) {
  //$mas[$i]=$res['id_rec'];
          $sql2 = mysqli_query($link, "SELECT * FROM list WHERE id_rec='".$res['id_rec']."' ORDER BY create_date DESC LIMIT 1");
          while ($res2 = mysqli_fetch_array($sql2)) {
             # echo $res2['ID'].'<br>';
              $sql3 = mysqli_query($link,"SELECT * FROM list WHERE ID=".$res2['ID']." ORDER BY create_date DESC");
              while ($res3 = mysqli_fetch_array($sql3)) {
                  #echo $res3['ID'].' '.$res3['id_rec'].'<br>';
                  $mas[$i_count]=$res3['ID'];
                  $i_count++;
              }
          }
  }
  $row = mysqli_fetch_array($sql);
  #$res = $db->query("SELECT count(*) AS count FROM news {$where}");
  #$row = $res->fetch(PDO::FETCH_ASSOC);
  $page_count = ceil($i_count / $page_setting['limit']); // кол-во страниц
  $page_left = $page - $page_setting['show']; // находим левую границу
  $page_right = $page + $page_setting['show']; // находим правую границу
  $page_prev = $page - 1; // узнаем номер предыдушей страницы
  $page_next = $page + 1; // узнаем номер следующей страницы
  if($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
  if($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
  if($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
  if($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
  if($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
  if($page != $page_count) $page_setting['last_show'] = 1;
  #вывод на экран
  echo '<div class="col-sm-12 col-md-7">
  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
  <ul class="pagination">';    
  pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show'], $search);
  pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active'], $search);
  if($page_left > 2) echo $page_setting['separator'];
  for($i = $page_left; $i <= $page_right; $i++) {
      $page_show = 1;
      if($page == $i) $page_show = 0;
      pagePrint($i, $i, $page_show, $page_setting['class_active'], $search);
  }
  if($page_right < ($page_count - 1)) echo $page_setting['separator'];
  if($page_count != 1) 
    pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active'], $search);
  pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show'], $search);
  echo '</ul></div></div>';
  #конец вернего блока пагинации
  #Вывод новостей
  $start = ($page-1)*$page_setting['limit'];
  #$sql = mysqli_query($link, "SELECT *  FROM `list` WHERE `jira_num` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' OR `destination` LIKE '%{$search}%' order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");
  #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  $sql = mysqli_query($link, "SELECT  DISTINCT `id_rec` FROM `list` WHERE `jira_num` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' OR `destination` LIKE '%{$search}%'");
  $i=0;
  while ($res = mysqli_fetch_array($sql)) {
  //$mas[$i]=$res['id_rec'];
          $sql2 = mysqli_query($link, "SELECT * FROM list WHERE id_rec='".$res['id_rec']."'  ORDER BY ID DESC LIMIT 1");
          while ($res2 = mysqli_fetch_array($sql2)) {
             # echo $res2['ID'].'<br>';
              $sql3 = mysqli_query($link,"SELECT * FROM list WHERE ID=".$res2['ID']."  ORDER BY create_date DESC");
              while ($res3 = mysqli_fetch_array($sql3)) {
                  #echo $res3['ID'].' '.$res3['id_rec'].'<br>';
                  $mas[$i]=$res3['ID'];
                  $i++;
              }
          }
  }
  rsort($mas);
  $mas_length = count($mas);
 echo '
 <blockquote class="quote-secondary" style="margin-top: 0px;">
         <p>Результаты поиска:</p>
         <small>По вашему запросу <i>"'.  $_GET['search'].'"</i> найдено '. $mas_length.' инцидентов</small>
      </blockquote> '; 	

  foreach ( $mas as $value ) {
      $sql3 = mysqli_query($link,"SELECT * FROM list WHERE ID=$value");
      while ($res3 = mysqli_fetch_array($sql3)) {
            #Инициализируем переменные
            $ID=$res3['ID'];
            $id_user = $res3['id_user'];
            $id_rec=strip_tags($res3['id_rec']);
            $id_shift=$res3['id_shift'];
            $jira_num=strip_tags($res3['jira_num']);
            $content = mb_substr(strip_tags_smart($res3['content']), 0, 500) . ' ...';
            $action = mb_substr(strip_tags_smart($res3['action']), 0, 300) . ' ...';
            $user_name =  get_user_name_by_id($res3['id_user'],$link);
            $destination=strip_tags($res3['destination']);
            $status=$res3['status'];
            $importance=$res3['importance'];
            $keep=$res3['keep'];
            $create_date=$res3['create_date'];
            $count++;       
  echo '
  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <!-- Post -->
                      <div class="post">
                        <div class="user-block">
                          <img class="img-circle img-bordered-sm" src="'.get_user_icon( $id_user,$link).'" alt="user image">
                          <span class="username">
                            <a href="#">'.$user_name.'</a>
                            
                          </span>
                          <span class="description">Опубликованно - '.$create_date.'</span>
                        </div>
                        <!-- /.user-block -->
                        <div style="clear: left"></div>
                        <h3>'.choose_color($jira_num, $search, "khaki").'</h3>
                        <p>
                           '.choose_color($content, $search, "khaki").'
                        </p>
                          <a href="one_page.php?ID='.$ID.'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
                      </div>
                      <!-- /.post -->  
  ';
      }
    }
  $page_count = ceil($i_count / $page_setting['limit']); // кол-во страниц
  $page_left = $page - $page_setting['show']; // находим левую границу
  $page_right = $page + $page_setting['show']; // находим правую границу
  $page_prev = $page - 1; // узнаем номер предыдушей страницы
  $page_next = $page + 1; // узнаем номер следующей страницы
  if($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
  if($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
  if($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
  if($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
  if($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
  if($page != $page_count) $page_setting['last_show'] = 1;
   
  #вывод на экран
  echo '<div class="col-sm-12 col-md-7">
  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
  <ul class="pagination">';    
  pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show'], $search);
  pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active'], $search);
  if($page_left > 2) echo $page_setting['separator'];
  for($i = $page_left; $i <= $page_right; $i++) {
      $page_show = 1;
      if($page == $i) $page_show = 0;
      pagePrint($i, $i, $page_show, $page_setting['class_active'], $search);
  }
  if($page_right < ($page_count - 1)) echo $page_setting['separator'];
  if($page_count != 1) 
    pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active'], $search);
  pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show'], $search);
  echo '</ul></div></div>';
  #конец вернего блока пагинации
  
                
      }
     }
  }  
}
else {

if(isset($_GET['search']) )
{
	if(($search = checkSearch($_GET['search'])) !== false)
	{
	   $start = ($page-1)*$page_setting['limit'];
	   #$sql= mysqli_query($link, "SELECT *  FROM `news` WHERE theme LIKE '%{$search}%'");
	  # $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE theme LIKE '%{$search}%' order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");
	   $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE `theme` LIKE '%{$search}%' OR `description` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' ORDER BY `create_date`");
	   $count_rec = mysqli_num_rows($sql);
	 #  echo $count_rec;
	   if(mysqli_num_rows($sql) == 0)
	  {
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
              <small>По вашему запросу <i>"'.$_GET['search'].'"</i> найдено '.$count_rec.' записей</small>
           </blockquote> '; 	

#верхний блок пагинации
#подсчет количества страниц и проверка основных условий
$sql = mysqli_query($link,"SELECT count(*) AS count FROM news WHERE `theme` LIKE '%{$search}%' OR `description` LIKE '%{$search}%' OR `content` LIKE '%{$search}%'");
$row = mysqli_fetch_array($sql);
#$res = $db->query("SELECT count(*) AS count FROM news {$where}");
#$row = $res->fetch(PDO::FETCH_ASSOC);
$page_count = ceil($row['count'] / $page_setting['limit']); // кол-во страниц
$page_left = $page - $page_setting['show']; // находим левую границу
$page_right = $page + $page_setting['show']; // находим правую границу
$page_prev = $page - 1; // узнаем номер предыдушей страницы
$page_next = $page + 1; // узнаем номер следующей страницы
if($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
if($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
if($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
if($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
if($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
if($page != $page_count) $page_setting['last_show'] = 1;
#вывод на экран
echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';    
pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show'], $search);
pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active'], $search);
if($page_left > 2) echo $page_setting['separator'];
for($i = $page_left; $i <= $page_right; $i++) {
    $page_show = 1;
    if($page == $i) $page_show = 0;
    pagePrint($i, $i, $page_show, $page_setting['class_active'], $search);
}
if($page_right < ($page_count - 1)) echo $page_setting['separator'];
if($page_count != 1) 
  pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active'], $search);
pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show'], $search);
echo '</ul></div></div>';
#конец вернего блока пагинации
#Вывод новостей
$start = ($page-1)*$page_setting['limit'];
$sql = mysqli_query($link, "SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`  FROM `news` WHERE `theme` LIKE '%{$search}%' OR `description` LIKE '%{$search}%' OR `content` LIKE '%{$search}%' order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");  
      while ($result = mysqli_fetch_array($sql)) {
      $count++;  
      $ID=$result['ID'];
      $id_user = $result['id_user'];
      $user_name =  get_user_name_by_id($result['id_user'],$link);
      $theme = mb_substr(strip_tags($result['theme']), 0, 300);
      $description = mb_substr(strip_tags_smart($result['description']), 0, 1000);  
      $content = mb_substr(strip_tags_smart($result['content']), 0, 1000).' ...';
      $status=$result['status'];
      $importance=$result['importance'];
      $keep=$result['keep'];
      $create_date=$result['create_date'];
      $edit_date=$result['edit_date'];
      $type=$result['type'];
echo '
<div class="tab-content">
  <div class="active tab-pane" id="activity">
  <!-- Post -->
  <div class="post">
    <div class="user-block">
      <img class="img-circle img-bordered-sm" src="'.get_user_icon($id_user,$link).'" alt="user image">
      <span class="username">
        <a href="#">'.$user_name.'</a>
        
      </span>
      <span class="description">Опубликованно - '.$create_date.'</span>
    </div>
    <!-- /.user-block -->
    <div style="clear: left"></div>
    <h3>'.choose_color($theme, $search, "khaki").'</h3>
    <p>
      '.choose_color($content, $search, "khaki").'
    </p>
      <a href="one_page_news.php?ID='.$ID.'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
  </div>
  <!-- /.post -->                     
';
    }
#верхний блок пагинации
#подсчет количества страниц и проверка основных условий
$sql = mysqli_query($link,"SELECT count(*) AS count FROM news WHERE `theme` LIKE '%{$search}%' OR `description` LIKE '%{$search}%' OR `content` LIKE '%{$search}%'");
$row = mysqli_fetch_array($sql);
#$res = $db->query("SELECT count(*) AS count FROM news {$where}");
#$row = $res->fetch(PDO::FETCH_ASSOC);
$page_count = ceil($row['count'] / $page_setting['limit']); // кол-во страниц
$page_left = $page - $page_setting['show']; // находим левую границу
$page_right = $page + $page_setting['show']; // находим правую границу
$page_prev = $page - 1; // узнаем номер предыдушей страницы
$page_next = $page + 1; // узнаем номер следующей страницы
if($page_left < 2) $page_left = 2; // левая граница не может быть меньше 2, так как 2 - первое целое число после 1
if($page_right > ($page_count - 1)) $page_right = $page_count - 1; // правая граница не может ровняться или быть больше, чем всего страниц
if($page > 1) $page_setting['prev_show'] = 1; // если текущая страница не первая, значит существует предыдущая
if($page != 1) $page_setting['first_show'] = 1; // показываем ссылку на первую страницу, если мы не на ней
if($page < $page_count) $page_setting['next_show'] = 1; // если текущая страница не последняя, значит существуюет следующая
if($page != $page_count) $page_setting['last_show'] = 1;
#вывод на экран
echo '<div class="col-sm-12 col-md-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
<ul class="pagination">';    
pagePrint($page_prev, $page_setting['prev_text'], $page_setting['prev_show'], $search);
pagePrint(1, 1, $page_setting['first_show'], $page_setting['class_active'], $search);
if($page_left > 2) echo $page_setting['separator'];
for($i = $page_left; $i <= $page_right; $i++) {
    $page_show = 1;
    if($page == $i) $page_show = 0;
    pagePrint($i, $i, $page_show, $page_setting['class_active'], $search);
}
if($page_right < ($page_count - 1)) echo $page_setting['separator'];
if($page_count != 1) 
  pagePrint($page_count, $page_count, $page_setting['last_show'], $page_setting['class_active'], $search);
pagePrint($page_next, $page_setting['next_text'], $page_setting['next_show'], $search);
echo '</ul></div></div>';
#конец вернего блока пагинации						
	  }
   }
}
}
include ("modal_close_shift.php");
?>