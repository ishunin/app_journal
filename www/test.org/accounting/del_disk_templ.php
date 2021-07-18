<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';
if ($id ) {
$sql = "INSERT INTO `disk_templ_movement`(`id_templ`,`name`,`type_equipment`,`segment`,`form_factor`,`firm`,`interface`,`rpm`,`volume`,`part_number`,`logs`,`comment`,`monitor`,`treshold`,`id_user`,`deleted`,`type_oper`,`date`) 
VALUES ($id,'','','','','','',0,0,'',0,'$comment',0,0,$id_user,1,5,NOW())";
$query = mysqli_query($link_account,$sql);
    if ($query) {
        #Обновляем
        $sql2 = "
        UPDATE `disk_templ` SET `deleted`=1 WHERE `id`=$id";
        $query2 = mysqli_query($link_account,$sql2);
        if ($query2) {
        $_SESSION['success_action']=3;
        header('location: \accounting\overall_disks.php');
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
