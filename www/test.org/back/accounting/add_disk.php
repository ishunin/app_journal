<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");
//Инициализируем переменные
$id_disk = $_POST['id_disk'];
$state = $_POST['state'];

(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id_disk']) && !empty($_POST['id_disk'])) ? $serial_num = $_POST['id_disk'] : $id_disk = 0;
(isset($_POST['serial_num']) && !empty($_POST['serial_num'])) ? $serial_num = check_input($link_account,$_POST['serial_num']) : $serial_num = 'нет';
(isset($_POST['jira_num']) && !empty($_POST['jira_num'])) ? $jira_num = check_input($link_account,$_POST['jira_num']) : $jira_num = 'нет';
(isset($_POST['ibs_num']) && !empty($_POST['ibs_num'])) ? $ibs_num = check_input($link_account,$_POST['ibs_num']) : $ibs_num = 'нет';
(isset($_POST['point']) && !empty($_POST['point'])) ? $point = check_input($link_account,$_POST['point']) : $point = '0';
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';


if ($id_disk) {
$sql = "INSERT INTO `disk_balance`(`id_disk`, `date`, `serial_num`, `state`,`status`,`point`, `INM`, `INC`, `id_user`, `comment`,`deleted`) VALUES 
($id_disk,NOW(),'$serial_num',$state,1,'$point','$jira_num','$ibs_num',$id_user,'$comment',0)";
$query = mysqli_query($link_account,$sql);
    if ($query) {
        #Последний ID
        $id_new_disk = mysqli_insert_id($link_account);
        #Добавляем новое движение в таблицу disk_debt
        $sql2 = "INSERT INTO `disk_movement`(`id_disk`,`id_disk_templ`,`type_oper`, `serial_num`, `state`, `status`,`point`, `INM`, `INC`, `id_user`, `credit_link`, `date`, `comment`,`deleted`) VALUES 
        ($id_new_disk,$id_disk,1,'$serial_num',$state,1,$point,'$jira_num','$ibs_num',$id_user,0,NOW(),'$comment',0)";
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
        printf("Ошибка: %s\n", mysqli_error($link_account));
    }
}


?>