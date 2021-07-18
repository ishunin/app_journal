    <?php
	if (!isset($_GET['ID'])) {
		$id_shift = get_last_shift_id($link);
	} else {
		$id_shift = $_GET['ID'];
	}
	#информация о текущей смене
	$sql = mysqli_query($link, "SELECT * FROM shift WHERE ID=$id_shift");
	$result = mysqli_fetch_array($sql);
	if ($result) {

	$class = '';
	if (is_shift_open($id_shift, $link) == 0) {
		$class = 'class="quote-secondary"';
		$mes = "<span style='color:red'>Смена закрыта</span>";
	} else {
		$mes = "<span style='color:red'>Смена открыта</span>";
	}

	$author = get_user_name_by_id($result['id_user'], $link);
	if ($result['end_date'] == NULL) {
		$end_date = "Не известно";
	} else {
		$end_date = $result['end_date'];
	}

	if ($result['status'] == 0) {
		$mes2 = "<strike><span style='color:red;'>закрыта</span></strike>";
	} else {
		$mes2 = "<span style='color:green;'>открыта</span>";
	}
 $uploads = show_upload_files_shift($link,$id_shift,5,'show_shift_incidents.php?ID='.$id_shift,$id_shift);
 if ($uploads=='') {
	$uploads = "<blockquote $class style='margin: 0.0em'>
	<small>Пользователь еще не приложил отчет за смену</small>
  </blockquote>";
 }
  #Выводим автоотчет за смену######################
  $shif_info = get_shift_info($link,$id_shift);  
  if (!empty($shif_info) AND ($shif_info['end_date']!=NULL)) {
	$auto_report_str = "<blockquote $class  style='margin: 0.0em'><span><i><a href='report3.php?id_shift=$id_shift'>Автоотчет</a></i></span></small>
	</blockquote>";
  } else {
	$auto_report_str = "<blockquote $class  style='margin: 0.0em'><small>Смена еще не закрыта, автоотчет не сформирован...</small>
	</blockquote>";
  }
  #####################################################

	$res_str = "
<blockquote $class >
	<p>Информация о смене id: " . $result['ID'] . " </p>
	<small>
	<p>Автор смены: $author </p>
	<p>Дата создания: " . $result['create_date'] . " </p>
	<p>Дата закрытия: $end_date </p>
	<p>Статус: $mes2 </p>
	<p> $auto_report_str
	$uploads </p>
	</small>
</blockquote>   
";	
}
else {
	$res_str = "
<blockquote class='quote-secondary'>
	<p>Инфориация:</p>
	<small>
	<p>Смена не найдена</p>
	</small>
</blockquote>   
";
}
echo $res_str;
$id_rec = $result['ID'];
$page_back = 'show_shift_incidents.php?ID='.$id_shift;
$type=5;
include ("modal_upload.php");
include ("modal_del_file.php");
?>             