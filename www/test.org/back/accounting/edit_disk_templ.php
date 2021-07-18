<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");

//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id_templ']) && !empty($_POST['id_templ'])) ? $id_templ = $_POST['id_templ'] : $id_templ = 0;
(isset($_POST['name']) && !empty($_POST['name'])) ? $name = check_input($link_account,$_POST['name']) : $name = '';
(isset($_POST['type_equipment']) && !empty($_POST['type_equipment'])) ? $type_equipment = $_POST['type_equipment'] : $type_equipment = '';
(isset($_POST['segment']) && !empty($_POST['segment'])) ? $segment = $_POST['segment'] : $segment = '';
(isset($_POST['form_factor']) && !empty($_POST['form_factor'])) ? $form_factor = $_POST['form_factor'] : $form_factor = '';
(isset($_POST['firm']) && !empty($_POST['firm'])) ? $firm = $_POST['firm'] : $firm = '';
(isset($_POST['interface']) && !empty($_POST['interface'])) ? $interface = $_POST['interface'] : $interface = '';
(isset($_POST['rpm']) && !empty($_POST['rpm'])) ? $rpm = $_POST['rpm'] : $rpm = 0;
(isset($_POST['volume']) && !empty($_POST['volume'])) ? $volume = $_POST['volume'] : $volume = 0;
(isset($_POST['log']) && !empty($_POST['log'])) ? $log = $_POST['log'] : $log = 0;
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';
(isset($_POST['monitor']) && !empty($_POST['monitor']) && $_POST['monitor']==1) ?  $monitor = 1 : $monitor = 0;
(isset($_POST['part_number']) && !empty($_POST['part_number'])) ? $part_number = check_input($link_account,$_POST['part_number']) : $part_number = '';
(isset($_POST['treshold']) && !empty($_POST['treshold']) && $monitor ==1) ? $treshold = $_POST['treshold'] : $treshold = 0;



if ($id_templ) {
$sql = "INSERT INTO `disk_templ_movement`(`id_templ`,`name`, `type_equipment`, `segment`, `form_factor`, `firm`, `interface`, `rpm`, `volume`, `part_number`, `logs`, `comment`, `monitor`, `treshold`, `id_user`, `deleted`, `type_oper`,`date`) 
VALUES ($id_templ,'$name','$type_equipment','$segment','$form_factor','$firm','$interface',$rpm,$volume,'$part_number',$log,'$comment',$monitor,$treshold,$id_user,0,2,NOW())";
$query = mysqli_query($link_account,$sql);
    if ($query) {
        #Последний ID
        $id_new_disk_templ = mysqli_insert_id($link_account);
        #Добавляем новое движение в таблицу disk_debt
        $sql2 = "
        UPDATE `disk_templ` SET `name`='$name',`type_equipment`='$type_equipment',`segment`='$segment',`form_factor`='$form_factor',`firm`='$firm',`interface`='$interface',`rpm`=$rpm,`volume`=$volume,`part_number`='$part_number',`logs`=$log,`comment`='$comment',`monitor`=$monitor,`treshold`=$treshold,`deleted`=0 WHERE `id`=$id_templ
        ";
        $query2 = mysqli_query($link_account,$sql2);
        if ($query2) {
        $_SESSION['success_action']=2;
        header('location:'.$_POST['page_back']);
        }
        else {
            printf("Ошибка: %s\n", mysqli_error($link_account));
        }
    }
    else {
        echo 'asd';
        printf("Ошибка: %s\n", mysqli_error($link_account));
    }
}
else {
    echo "Не получен id_templ";
}    



?>