<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['id_templ']) && !empty($_POST['id_templ'])) ? $id_templ = $_POST['id_templ'] : $id_templ = 0;
(isset($_POST['serial_num']) && !empty($_POST['serial_num'])) ? $serial_num = trim(preg_replace('/\s+/', ' ', check_input($link_account,$_POST['serial_num'])))  : $serial_num = 'нет';
(isset($_POST['state']) && !empty($_POST['state'])) ? $state = $_POST['state'] : $state = 0;
(isset($_POST['status']) && !empty($_POST['status'])) ? $status = $_POST['status'] : $status = 0;
(isset($_POST['point']) && !empty($_POST['point'])) ? $point = $_POST['point'] : $point = 0;
(isset($_POST['inm']) && !empty($_POST['inm'])) ? $inm = check_input($link_account,$_POST['inm']) : $inm = '';
(isset($_POST['inc']) && !empty($_POST['inc'])) ? $inc = check_input($link_account,$_POST['inc']) : $inc = '';
(isset($_POST['serial_num_new_disk']) && !empty($_POST['serial_num_new_disk'])) ? $serial_num_new_disk = trim(check_input($link_account,$_POST['serial_num_new_disk'])) : $serial_num_new_disk = '';
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';

$total=0;
$sql = mysqli_query($link_account, "SELECT * FROM `disk_balance` WHERE `serial_num`='$serial_num' AND `id`<>$id AND `deleted`=0");
while ($result = mysqli_fetch_array($sql)) {
$total++;
$id=$result['id'];
$id_templ=$result['id_disk'];
$serial_num=$result['serial_num'];
}
    
if ($total>0) {
    header('location:errors.php?type=2&id='.$id.'&id_templ='.$id_templ.'&serial_number='.$serial_number);
    exit();
}
if ($id && $id_templ) {
$sql = "INSERT INTO `disk_movement`(`id_disk`,`id_disk_templ`, `type_oper`,`serial_num`,`state`,`status`,`point`,`INM`,`INC`,`id_user`,`credit_link`,`date`,`comment`,`deleted`) 
VALUES ($id,$id_templ,2,'$serial_num',$state,$status,$point,'$inm','$inc',$id_user,0,NOW(),'$comment',0)";
$query = mysqli_query($link_account,$sql);
    if ($query) {
        #Обновляем
        $sql2 = "
        UPDATE `disk_balance` SET `serial_num`='$serial_num',`state`=$state,`status`=$status,`point`=$point,`INM`='$inm',`INC`='$inc',`id_user`=$id_user,`serial_num_new_disk`='$serial_num_new_disk',`comment`='$comment'
         WHERE `id`=$id";
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
    echo "Не получен id_templ";
}
