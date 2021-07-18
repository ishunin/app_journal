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

	$res_str = "
<blockquote $class >
                  <p>Информация о смене id: " . $result['ID'] . " </p>
                  <small>
                  <p>Автор смены: $author </p>
					<p>Дата создания: " . $result['create_date'] . " </p>
					<p>Дата закрытия: $end_date </p>
					<p>Статус: $mes2 </p>

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
	?>             