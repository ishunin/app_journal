<?php
#Уничтожение всех дисков
session_start();
include("../func.php");
include("../scripts/conf.php");
//Инициализируем переменные
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account, $_POST['comment']) : $comment = '';
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
$sql = mysqli_query($link_account,"SELECT * FROM `disk_balance` WHERE `status`=4 AND `state`=4");
    while ($result = mysqli_fetch_array($sql)) {
        $id =  $result['id'];
        $id_templ = $result['id_disk'];
        //echo  $id. ' '.  $id_templ.' '.$id_user. '<br>';        
        $sql2 = "INSERT INTO `disk_movement`(`id_disk`,`id_disk_templ`, `type_oper`,`serial_num`,`state`,`status`,`point`,`INM`,`INC`,`id_user`,`credit_link`,`date`,`comment`,`deleted`) 
        VALUES ($id,$id_templ,9,'',4,1,4,'','',$id_user,0,NOW(),'$comment',0)";
            $query = mysqli_query($link_account, $sql2);
            if ($query) {
                #Обновляем
                $sql3 = "
                UPDATE `disk_balance` SET `status`=1, `point`=4 WHERE `id`=$id";
                $query2 = mysqli_query($link_account, $sql3);
                if (!$query2) {
                    printf("Ошибка: %s\n", mysqli_error($link_account));
                }
            } else {
                printf("Ошибка: %s\n", mysqli_error($link_account));
        }
        
}
header('location:/accounting/security_disks.php');