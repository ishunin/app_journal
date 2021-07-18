<?php
 #Новые
$str = '';
$str_note = '';
$count_disks=0;
$sql = mysqli_query($link_account, "SELECT * FROM `disk_movement` WHERE `state`=1 AND `status`=1 AND `type_oper`=1 AND  `date`>= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)  ORDER BY `date` DESC LIMIT 10");
while ($result = mysqli_fetch_array($sql)) {
#Инициализируем переменные
$id_disk=$result['id_disk'];
$id_disk_templ=$result['id_disk_templ'];
$type_oper=$result['type_oper'];

$serial_num = strip_tags($result['serial_num']);
$INM = strip_tags($result['INM']);
$INC = strip_tags($result['INC']);
$comment = mb_substr(strip_tags($result['comment']),0,500);                 
$status = get_disk_status($result['status']);
$state = get_disk_state($result['state']);
$point = get_disk_point($result['point']);
$item_class = get_class_item_disk($result['state']);
$user_name =  get_user_name_by_id($result['id_user'],$link);
$user_icon =  get_user_icon($result['id_user'],$link);
$date = $result['date'];
       
$str.= "
<a href='/accounting/one_disk_exact.php?id=".$id_disk."&id_disk=".$id_disk_templ."' class='dropdown-item'>
<!-- Message Start -->
<div class='media'>
  <img src='".$user_icon."' alt='User Avatar' class='img-size-50 mr-3 img-circle'>
  <div class='media-body'>
    <h3 class='dropdown-item-title'>
   $user_name
    </h3>
    <small>Операция: <span style='color:green;'><b>".get_disk_operation_by_id ($type_oper)."</b></span></small></br>
    <small>S/N: ".$serial_num."</small></br>
    <small>Состояние: <span class='".get_class_disk_status($result['state'])."'>".$state."</span></small></br>
    <small>Статус: <span class='".get_class_disk_status($result['status'])."'>".$status."</span></small></br>
    <small>Поступление: ".$point."</small></br>
    <small>INM: ".$INM."</small></br>
    <small>INC: ".$INC."</small></br>
    <p class='text-sm text-muted'><i class='far fa-clock mr-1'></i>$date</p>
  </div>
</div>
<!-- Message End -->
</a>
<div class='dropdown-divider'></div>
";
$count_disks++;
}
$str_note =    '<span class="badge badge-danger navbar-badge">'.$count_disks.'</span>';
$str.='';


if ($count_disks==0) {
    $str ='
    <blockquote class="quote-secondary">
        <small>Нет новых поступлений дисков.</small>
     </blockquote>';
  }

echo '
<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
    <i class="far fa-hdd"></i>
    '.$str_note.'
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">'
.$str.
'<a href="/accounting/push_disks.php" class="dropdown-item dropdown-footer">Смотреть все поступления</a>
</div>';
