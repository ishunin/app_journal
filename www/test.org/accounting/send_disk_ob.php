<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['id_disk']) && !empty($_POST['id_disk'])) ? $id_templ = $_POST['id_disk'] : $id_templ = 0;
(isset($_POST['page_back']) && !empty($_POST['page_back'])) ? $page_back = $_POST['page_back'] : $page_back = '';
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';
if ($id && $id_templ) {
$sql = "INSERT INTO `disk_movement`(`id_disk`,`id_disk_templ`, `type_oper`,`serial_num`,`state`,`status`,`point`,`INM`,`INC`,`id_user`,`credit_link`,`date`,`comment`,`deleted`) 
VALUES ($id,$id_templ,4,'',3,4,3,'','',$id_user,0,NOW(),'$comment',0)";
$query = mysqli_query($link_account,$sql);
    if ($query) {
        #Обновляем
        $sql2 = "
        UPDATE `disk_balance` SET `status`=4 WHERE `id`=$id";
        $query2 = mysqli_query($link_account,$sql2);
        if ($query2) {
        $_SESSION['success_action']=2;
        if ($_POST['page_back']=='one_disk.php') {
            header('location:'.$_POST['page_back'].'?id='.$id_templ);
            exit();
        } 
        header('location:'.$_POST['page_back'].'?id='.$id.'&id_disk='.$id_templ);
        exit();
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
    echo "Не получен id диска";
}
