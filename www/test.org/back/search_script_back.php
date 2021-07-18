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
  $active='active';
    if($show) {
        echo '<li class="paginate_button page-item ">
        <a href="?do=list&page=' . $page . '&search='.$_GET['search'].'" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">' . $title . '</a>
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





/* Выделение цветом */
function choose_color($text, $search, $color) {
$text = preg_replace('/' . $search . '/iu', "<span style='background-color:{$color}'>{$search}</span>", $text);
   return $text;
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



if(isset($_GET['search']) )
{
	if(($search = checkSearch($_GET['search'])) !== false)
	{
	   $start = ($page-1)*$page_setting['limit'];
	   #$sql= mysqli_query($link, "SELECT *  FROM `news` WHERE theme LIKE '%{$search}%'");
	  # $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE theme LIKE '%{$search}%' order by `create_date` DESC LIMIT {$start},{$page_setting['limit']}");
	   $sql = mysqli_query($link, "SELECT *  FROM `news` WHERE `theme` LIKE '%{$search}%' OR `description` LIKE '%{$search}%' OR `content` LIKE '%{$search}%'");
	   $count_rec = mysqli_num_rows($sql);
	   echo $count_rec;
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
      $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);



echo $count;

      echo ($result['ID']);
echo '
<div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Опубликованно - '.$result['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <h3>'.choose_color($result['theme'], $search, "khaki").'</h3>
                      <p>
                         '.choose_color($result['description'], $search, "khaki").'
                      </p>

                      <p>
                      
                        <a href="one_page_news.php?ID='.$result['ID'].'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Перейти</a>
                      </p>
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
?>

