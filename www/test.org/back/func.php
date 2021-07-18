<?php
include "ldap.php";
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

function get_list_of_positions($link_account,$table_name,$item) {
  $res = '';
  if (!isset($item) || (empty($item))) {
      $item = '';
  }
  $sql = mysqli_query($link_account, "SELECT *  FROM `".$table_name."` ORDER BY `id` DESC");
  while ($result = mysqli_fetch_array($sql)) {
      if ($result['name']===$item) {
        $res.="
        <option selected value='".$result['name']."'>".$result['name']."</option>       
        ";  
      }
      else {
        $res.="
        <option value='".$result['name']."'>".$result['name']."</option>
        ";
      }
        
  }
  return $res;
}

function get_list_of_positions_mas($mas,$item) {
  $res = '';
  if (!isset($item) || (empty($item))) {
      $item = '';
  }
foreach ($mas as $value) { 
  if ($value == $item) {
  $res.="
      <option selected value='".$value."'>".$value."</option>       
        "; 
       
  }
    else {
      $res.="
      <option value='".$value."'>".$value."</option>
      ";   
    }
}         
  return $res;
}

function get_list_of_positions_mas2($mas,$item) {
  $res = '';
  if (!isset($item) || (empty($item))) {
      $item = '';
  }
$i=0;  
foreach ($mas as $value) {
  if ($value == $item) {
  $res.="
      <option selected value='".$value."'>".get_disk_state($value)."</option>       
        "; 
       
  }
    else {
      $res.="
      <option value='".$value."'>".get_disk_state($value)."</option>
      ";   
    }
}         
  return $res;
}

function get_list_of_positions_mas3($mas,$item) {
  $res = '';
  if (!isset($item) || (empty($item))) {
      $item = '';
  }
$i=0;  
foreach ($mas as $value) {
  if ($value == $item) {
  $res.="
      <option selected value='".$value."'>".get_disk_point($value)."</option>       
        "; 
       
  }
    else {
      $res.="
      <option value='".$value."'>".get_disk_point($value)."</option>
      ";   
    }
}         
  return $res;
}



function get_disk_operation_by_id ($var) {
  $res=0;
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
        $res = "";
      break;
      case 5:
        $res = "Удаление";
      break;
      default:
          $res = "Неизвестная операция";
      break;
    }
  return $res;  
}



function get_disk_serial_by_id($link_account,$id) {
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
function show_changes($link,$link_account,$id,$id_disk) {
  $res = 0;
    //Запрашиваем последние 20 изменений по всем дискам данного типа
  if (isset($id) && !empty($id)) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk_templ`=$id_disk AND `id_disk`= $id ORDER BY `date` DESC");
  }
  else {
    
  $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk_templ`=$id_disk  ORDER BY `date` DESC");
  }

  $count = 0;
  $res_str = '';
  while ($result = mysqli_fetch_array($sql)) {
  $count++;
  $id=$result['id_disk'];
  $id_templ=$result['id_disk_templ'];
  $type_oper = $result['type_oper'];
  $serial_num = strip_tags($result['serial_num']);
  $INM = strip_tags($result['INM']);
  $INC = strip_tags($result['INC']);
  $comment = mb_substr(strip_tags($result['comment']),0,500);                 
  $status = get_disk_status($result['status']);
  $state = get_disk_state($result['state']);
  $point = get_disk_point($result['point']);
  $INM = strip_tags($result['INM']); 
  $INC = strip_tags($result['INC']);
  $date = $result['date'];
  $user = get_user_name_by_id($result['id_user'],$link);

  switch ($type_oper) {
      case 1:
        #формируем строку по данному изменению
        $res_str.="<span style='color:green; text-decoration:underline;'>id=".$id." id_templ=".$id_templ." <b>Приход</b> | </span>
        диск с s/n: <b>". $serial_num."</b> | пользователем <b>".$user."</b> | Получен: ". $point." в | <b>".$date."</b> | по заявке: ".$INM." (".$INC.") | 
        в состоянии: <span class='".get_class_disk_status($result['state'])."'><b>".$state."</b></span> | Расположение: ". $status." | с комментарием: <i>".$comment."</i>
        <br>";
      break;

      case 2:
        #формируем строку по данному изменению
        $res_str.="<span style='color:blue; text-decoration:underline;'>id=".$id." id_templ=".$id_templ." <b>Редактирование</b> | </span>
        диск с s/n: <b>". $serial_num."</b> | пользователем <b>".$user."</b> | Получен: ". $point." в | <b>".$date."</b> | по заявке: ".$INM." (".$INC.") | 
        в состоянии: <span class='".get_class_disk_status($result['state'])."'><b>".$state."</b></span> | Расположение: ". $status." | с комментарием: <i>".$comment."</i>
        <br>";
      break;
      case 5:
        #формируем строку по данному изменению
        $res_str.="<span style='color:red; text-decoration:underline;'>id=".$id." id_templ=".$id_templ." <b>Удаление</b> | пользователем <b>".$user."</b> | <b>".$date."</b> | с комментарием: <i>".$comment."</i></span>
        <br>";
      break;
      
      default:
          $res_str.= "";
    }
  }  
  if ($count==0) {
    $res_str ='
  <blockquote class="quote-secondary">
  <p>Информация:</p>
  <small>Не данных по заданному типу id ...</small>
  </blockquote>';
  }

  return $res_str;
}


#Выводит комментарии указанного типа
function show_comments($link,$id_rec,$type) {
  $count = 0; 
  echo '<div>';
  $sql= mysqli_query($link, "SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date`, `type` FROM `comments` 
  WHERE `id_rec`='".$id_rec."' AND `type`=".$type);
  if ($sql) {
    while ($result = mysqli_fetch_array($sql)) {
      $count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
      $result_user = mysqli_fetch_array($sql_user);
      $user_icon =  get_user_icon($result_user['ID'], $link);
      $content=mb_substr(strip_tags($result['content']),0,1000);
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
      <p>
      ' . $content. '
      </p>
      <p>
      <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> </a>
      </p>
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

function get_disk_status($var){
  $res=0;
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

    }
  return $res;
}

function get_disk_state($var){
  $res=0;
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
  
    }
  return $res;
}

function get_disk_point($var){
  $res=0;
  switch ($var) {
      case 1:
        $res = "Из IBS";
      break;
      case 2:
          $res = "из ЦОДа";
      break;
      case 3:
          $res = "Из ОБ";
      break;
    }
  return $res;
}

function check_button_permission ($str_button,$user_level,$button_level_ar) {
  if (isset($user_level) && $button_level_ar) {
    if (in_array($user_level, $button_level_ar)) {
        return $str_button;
    }
    else {
      $str_button='';
    }
  }
  return $str_button;
}

function get_access_level_by_id($var){
  $res=0;
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


function get_class_item_disk($var){
  $res=0;
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
        $res = "emergency_importance";      
    break;
      case 5:
        $res = "emergency_importance";      
  break;
    }
  return $res;
}

function get_class_disk_status($var){
  $res=0;
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
    }
  return $res;
}

function get_class_disk_info($var){
  $res=0;
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
    }
  return $res;
}





function check_input($link, $var){
    return mysqli_real_escape_string( $link, $var);
}

function is_allow($users_hash,$id) {
  if(($users_hash === $_COOKIE['hash']) && ($id === $_COOKIE['id'] 
  && isset($_COOKIE['permissions']) && $_COOKIE['permissions']==$_COOKIE['hash'].'1')){
  $allow=1;
  }
  else {
    $allow=0;
  }
  return $allow;
}

function is_active($item,$opt) {
  $res='';
 if ($opt==1) { 
$menu = array("incidents_new", "news_new", "jobs_new", "notifications_new");
}
if ($opt==2) { 
$menu = array("report1", "report2");
}

if ($opt==3) { 
  $menu = array("push_disks", "pull_disks" ,"overall_disks","one_disk","one_disk_exact","warehouse_disks","warehouse_broken_disks","security_disks","ibs_disks","search_disk");
  }
  

if (in_array($item, $menu)) {
    $res='menu-open';
}
return $res;
}

http://".$_SERVER['SERVER_ADDR']."/dist/img/$user_id.png
function get_user_icon($user_id,$link){
  if (isset($user_id) && !empty($user_id)) {
    $res = "http://".$_SERVER['SERVER_ADDR']."/dist/img/".$user_id.'.png';
  }
    else {
      $res = "http://".$_SERVER['SERVER_ADDR']."/dist/img/default.png";
    } 
 return $res;
}

function get_notifications_count($link,$opt){

$count_incidents[0] = 0;
$count_news[0] = 0;
$count_jobs[0] =0;

$last_login=get_last_user_login($_COOKIE['id'],$link);
$current_login=get_current_user_login($_COOKIE['id'],$link);
$last_shift_id = get_last_shift_id($link);


$sql1 = mysqli_query($link, "SELECT COUNT(*)  FROM `list`  WHERE id_shift=$last_shift_id AND Create_date >= '$last_login' AND Create_date <= '$current_login'") ;
$sql2 = mysqli_query($link, "SELECT COUNT(*)  FROM `news`  WHERE  Create_date >= '$last_login' AND Create_date <= '$current_login'");
$sql3 = mysqli_query($link, "SELECT COUNT(*)  FROM `jobs`  WHERE  create_date >= '$last_login' AND create_date <= '$current_login'");

if ($sql1) {
  $count_incidents = mysqli_fetch_array($sql1);
}
if ($sql2) {
$count_news = mysqli_fetch_array($sql2);
}
if ($sql3){
$count_jobs = mysqli_fetch_array($sql3);
}


if ($opt==1) {
  return $res= $count_incidents[0];
}

if ($opt==2) {
  return $res= $count_news[0];
}

if ($opt==3) {
  return $res= $count_jobs[0];
}

$res= $count_incidents[0]+$count_news[0] +$count_jobs[0];
return $res;
}

//Возвращает поступление новыйх дисков за период
function get_notifications_count_disk_plus($link,$interval) {
   #Новые
   $sql = "SELECT COUNT(*) FROM `disk_movement` WHERE `state`=1 AND `status`=1 AND `type_oper`=1 AND  `date`>= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)";
   $res = mysqli_query($link,$sql);
   if ($row = mysqli_fetch_row($res)) {  
       $res2 = $row[0]; // 
   }
   else {
     $res2 = 0;
   }
  return $res2;
}

function importance_class_star($importance){
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

function is_shift_open($id_shift,$link) {
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT end_date  FROM `shift` WHERE ID=$id_shift"));
  if ($data) {
    $res = $data['end_date'];
    if ($res!=NULL) {
      $res=0;
    }
    else{
      $res=1;
    }
  }
  else {
    $res=0;
  }
  return $res;
  }

function get_last_user_login($id_user,$link) {
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT end_date  FROM `shift` WHERE id_user=$id_user AND end_date IS NOT NULL  ORDER BY end_date DESC LIMIT 1"));
  if ($data) {
    $res = $data['end_date'];
  }
  else {
    $res=0;
  }
  return $res;
  }

  function get_current_user_login($id_user,$link) {
    $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT *  FROM `shift` WHERE id_user=$id_user ORDER BY create_date DESC LIMIT 1"));
    if ($data) {
      $res = $data['create_date'];
    }
    else {
      $res=0;
    }
    return $res;
    }

function get_last_shift_id($link) {
$data = mysqli_fetch_assoc(mysqli_query($link, 'SELECT ID  FROM `shift` ORDER BY ID DESC LIMIT 1'));
if ($data) {
  $res = $data['ID'];
}
else {
  $res=0;
}
return $res;
}

# находит последнюю id последней смены, открытую ползователем не равным тому, что передали в параметре
#доработать на случай случайного закрытия смены пользователем
function get_last_shift_id_v2($link,$id_user) {
$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT ID  FROM `shift` WHERE id_user<>$id_user ORDER BY ID DESC LIMIT 1"));
if ($data) {
  $res = $data['ID']-1;
}
else {
  $res=0;
}
return $res;
}

function get_user_name_by_id($id,$link) {
  $res = mysqli_query($link,"SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=$id"); 
  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $res_str = $row['first_name'].' '.$row['last_name'];
  }
  else {
    $res_str='123';
  }
  return $res_str;
}




function get_error_by_id ($value=0) {

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


function get_status($code_status = 0) {
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
      }
    return $res;
}


function get_status_for_ribbons($code_status = 0) {
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


function is_keep($code_status = 0) {
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


function get_type($code_status = 0) {
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

function get_type_jobs($code_status = 0) {
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
 
 function get_status_news($code_status = 0) {
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

function get_status_jobs($code_status = 0) {
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
function get_status_for_ribbons_jobs($code_status = 0) {
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
 

function get_importance($value=2) {
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
    #Значение по умлочанию  
   
    return $res;
}



function set_importance_class($value='middle_importance') {
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

function get_action_notification($value=0) {
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
        break;
      }
   unset($_SESSION['success_action']);
   return $res;
}

function get_class_for_div($value=0) {
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

function get_class_for_div_content($value=0) {
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


function get_class_for_keeped_news($value=0) {
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


function generate_uniq_id () {
$stamp = date("Ymdhis");
$ip = $_SERVER['REMOTE_ADDR'];
$id = "$stamp.$ip";
$id = str_replace(".", "", "$id");
return $id;
}





?>