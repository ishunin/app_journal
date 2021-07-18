<?php
session_start();
#настройки соединения с БД
include '../scripts/conf_account.php';
#Общие функции
include '../func.php';
#Устанавливаем разрешения на доступ на уровне страницы
$level_access = array(0, 1, 2, 3, 4, 5);
#Проверка что польщователь залогинен
include("../scripts/check.php");
if (!isset($_GET['id'])) {
	echo 'Не найден заданный id диска';
	exit();
} else {
	$id = $_GET['id'];
}
if (isset($_GET['id_new'])) {
	$id_new = $_GET['id_new'];
}
$count = 0;
$count_new = 0;
$count_charge = 0;
$res_str = '';
$new_disk_destination_str = '';
$new_disk_str = '';
$disk_str = '';
$name = '';
$part_num = '';
//Информация по конкретному диску
$sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id`=$id AND `deleted`=0 ORDER BY `date` DESC");
while ($result = mysqli_fetch_array($sql)) {
	$count++;
	#Инициализируем переменные
	$id = $result['id'];
	$id_disk = $result['id_disk'];
	$serial_num = strip_tags($result['serial_num']);
	$INM = strip_tags($result['INM']);
	$INC = strip_tags($result['INC']);
	$comment = mb_substr(strip_tags($result['comment']), 0, 500);
	$status = get_disk_status($result['status']);
	$state = get_disk_state($result['state']);
	$point = get_disk_point($result['point']);
	$item_class = get_class_item_disk($result['state']);
	$user_name =  get_user_name_by_id($result['id_user'], $link);
}
//Информация по шаблону диска
$sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE  `id`=$id_disk AND `deleted`=0 ORDER BY `id` DESC");
while ($result2 = mysqli_fetch_array($sql2)) {
	$id_templ = $result2['id'];
	$name = strip_tags($result2['name']);
	$part_num = strip_tags($result2['part_number']);
}
if (isset($_GET['id_new']) && !empty($_GET['id_new'])) {
	$id_new = $_GET['id_new'];
	//Информация по конкретному диску
	$sql3 = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id`=$id_new AND `deleted`=0 ORDER BY `date` DESC");
	while ($result3 = mysqli_fetch_array($sql3)) {
		$count_new++;
		#Инициализируем переменные
		$id_new = $result3['id'];
		$id_disk_new = $result3['id_disk'];
		$serial_num_new = strip_tags($result3['serial_num']);
		$INM_new = strip_tags($result3['INM']);
		$INC_new = strip_tags($result3['INC']);
		$comment_new = mb_substr(strip_tags($result3['comment']), 0, 500);
		$status_new = get_disk_status($result3['status']);
		$state_new = get_disk_state($result3['state']);
		$point_new = get_disk_point($result3['point']);
		$item_class_new = get_class_item_disk($result3['state']);
		$user_name_new =  get_user_name_by_id($result3['id_user'], $link);
	}
	//Информация по шаблону диска
	$sql4 = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE  `id`=$id_disk_new AND `deleted`=0 ORDER BY `id` DESC");
	while ($result4 = mysqli_fetch_array($sql4)) {
		$id_templ_new = $result4['id'];
		$name_new = strip_tags($result4['name']);
		$part_num_new = strip_tags($result4['part_number']);
	}
	//Информация рразмещению нового диска		
	$sql5 = mysqli_query($link_account, "SELECT *  FROM `disk_charge` WHERE  `id_disk`=$id_new ORDER BY `id` DESC");
	while ($result5 = mysqli_fetch_array($sql5)) {
		$count_charge++;
		$type_equipment_new = strip_tags($result5['type_equipment']);
		$isn_new = strip_tags($result5['isn']);
		$room_new = strip_tags($result5['room']);
		$rack_new = $result5['rack'];
		$unit_start_new = $result5['unit_start'];
		$unit_end_new = strip_tags($result5['unit_end']);
		$disk_num_new = strip_tags($result5['disk_num']);
	}
}
if ($count_charge > 0) {
	$new_disk_destination_str = '<div>Новый диск уcтановленный в ' . $type_equipment_new . '(ИСН: ' . $isn_new . ') - Расположение: ' . $room_new . '/R' . $rack_new . '/U' . $unit_start_new . '-' . $unit_end_new . ' слот ' . $disk_num_new . '</div>';
}
if ($count_new > 0) {
	$new_disk_str = '<div>Диск <b>' . $name_new . '</b><br>SN: <b>' . $serial_num_new . '</b></div>';
}
if ($count > 0) {
	$disk_str = '<div>Диск на уничтожение<br>
		Диск <b>' . $name . '</b><br>SN: ' . $serial_num . '</b></div>';
}
$response_user = get_user_name_by_id($_COOKIE['id'], $link);
$res_str = $new_disk_destination_str . $new_disk_str . '<br>' . $disk_str . '<p>Ответственный: ' . $response_user . ' ______________________</p>';
$arr = [
	'января',
	'февраля',
	'марта',
	'апреля',
	'мая',
	'июня',
	'июля',
	'августа',
	'сентября',
	'октября',
	'ноября',
	'декабря'
];
// Поскольку от 1 до 12, а в массиве, как мы знаем, отсчет идет от нуля (0 до 11),
// то вычитаем 1 чтоб правильно выбрать уже из нашего массива.  
$month = date('n') - 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=Gtx, initial-scale=1.0">
	<title>Печать заявки на вынос диска</title>
	<link rel="stylesheet" href="../dist/css/main.css">
</head>
<body style="margin-top:60px; margin-left:40px;">
	<h3 style="text-align: center; margin-bottom: 20px;">
		Филиал ФКУ «Налог-Сервис»<br>
		ФНС России по ЦОД в г. Москве
	</h3>
	<h3 style="text-align: center;padding-bottom: 0px;">Заявка № <?php echo ($INM); ?>
		<br>
		на вывоз (вынос) материальных ценностей
	</h3>
	<p style="text-align: center; margin-top: 40px; margin-bottom: 40px;">
		<?php echo '<b><u></i>от «' . date('d') . '» ' . $arr[$month] . ' ' . date('Y') . '</u></b>'; ?>
	</p>
	<table class="table-declaration" style="margin-top: 40px; margin-bottom: 40px;">
		<tr>
			<td>
				№
			</td>
			<td>
				Наименование
			</td>
			<td>
				Кол-во, шт.
			</td>
			<td>
				Серийный номер
			</td>
			<td>
				Кол-во (прописью)
			</td>
		</tr>
		<tr>
			<td>
				1
			</td>
			<td style="text-align: left;">
				<?php echo $name; ?>
			</td>
			<td>
				1
			</td>
			<td>
				<?php echo $serial_num; ?>
			</td>
			<td>
				Один
			</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: right;">
				Итого:
			</td>
			<td>
				Один
			</td>
		</tr>
	</table>
	<p>Фамилия, инициалы вывозящего имущество ___________________________________________</p>
	<p>Отдел: Эксплуатации технологической инфраструктуры № 1 _____________________________</p>
	<p>Основание: СТО, замена запчастей____________________________________________________</p>
	<div style="display: block; margin-top:100px;">
		<div style="display: inline;">Начальник отдела ЭТИ №1</div>
		<div style="display: inline;">_________________ / Марченко А.В.</div>
	</div>
	<div style="display: block; margin-top:260px;">
		<h3 style="margin-top: 200px;">Согласовано:</h3>
		<div style="display: inline;">Отдел безопасности</div>
		<div style="display: inline;">_________________ / _________________/</div>
	</div>
	<div style="margin-top: 50px; page-break-before: always;">
	
	<?php echo $res_str; ?>
	</div>
</body>

</html>
<script type="text/javascript">
	window.addEventListener("load", window.print());
</script>