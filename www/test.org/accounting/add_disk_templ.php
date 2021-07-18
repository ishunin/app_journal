<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
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
(isset($_POST['part_number']) && !empty($_POST['part_number'])) ? $part_number = trim(preg_replace('/\s+/', ' ', check_input($link_account,$_POST['part_number']))) : $part_number = '';
(isset($_POST['treshold']) && !empty($_POST['treshold']) && $monitor ==1) ? $treshold = $_POST['treshold'] : $treshold = 0;

//Проверяем есть ли уже такой парт номмер диска
$total=0;
$sql = mysqli_query($link_account, "SELECT * FROM `disk_templ` WHERE `part_number`='$part_number' AND `deleted`=0");
while ($result = mysqli_fetch_array($sql)) {
$total++;
$id=$result['id'];
$part_number=$result['part_number'];
}
    
if ($total>0) {
    header('location:errors.php?type=1&id_templ='.$id.'&part_number='.$part_number);
    exit();
}
else {   
$sql = "INSERT INTO `disk_templ`(`name`, `type_equipment`, `segment`, `form_factor`, `firm`, `interface`, `rpm`, `volume`, `part_number`, `logs`, `comment`, `monitor`, `treshold`, `id_user`, `deleted`, `date`) 
VALUES ('$name','$type_equipment','$segment','$form_factor','$firm','$interface',$rpm,$volume,'$part_number',$log,'$comment',$monitor,$treshold,$id_user,0,NOW())";
$query = mysqli_query($link_account,$sql);
    if ($query) {
        #Последний ID
        $id_new_disk_templ = mysqli_insert_id($link_account);
        #Добавляем новое движение в таблицу disk_debt
        $sql2 = "
        INSERT INTO `disk_templ_movement`(`id_templ`,`name`, `type_equipment`, `segment`, `form_factor`, `firm`, `interface`, `rpm`, `volume`, `part_number`, `logs`, `comment`, `monitor`, `treshold`, `id_user`, `deleted`, `type_oper`,`date`) 
VALUES ($id_new_disk_templ,'$name','$type_equipment','$segment','$form_factor','$firm','$interface',$rpm,$volume,'$part_number',$log,'$comment',$monitor,$treshold,$id_user,0,1,NOW())
        ";
        $query2 = mysqli_query($link_account,$sql2);
        if ($query2) {
        $_SESSION['success_action']=1;
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
