<?php 
session_start();
include ("../func.php");
include ("../scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['id_templ']) && !empty($_POST['id_templ'])) ? $id_templ = $_POST['id_templ'] : $id_templ = 0;
(isset($_POST['type_equipment']) && !empty($_POST['type_equipment'])) ? $type_equipment = $_POST['type_equipment'] : $type_equipment = '';
(isset($_POST['isn']) && !empty($_POST['isn'])) ? $isn = $_POST['isn'] : $isn = '';
(isset($_POST['room']) && !empty($_POST['room'])) ? $room = $_POST['room'] : $room = '';
(isset($_POST['rack']) && !empty($_POST['rack'])) ? $rack = $_POST['rack'] : $rack = 0;
(isset($_POST['unit_start']) && !empty($_POST['unit_start'])) ? $unit_start = $_POST['unit_start'] : $unit_start = 0;
(isset($_POST['unit_end']) && !empty($_POST['unit_end'])) ? $unit_end = $_POST['unit_end'] : $unit_end = 0;
(isset($_POST['disk_num']) && !empty($_POST['disk_num'])) ? $disk_num= $_POST['disk_num'] : $disk_num = 0;
(isset($_POST['jira_num']) && !empty($_POST['jira_num'])) ? $jira_num = $_POST['jira_num'] : $jira_num = '';
(isset($_POST['ibs_num']) && !empty($_POST['ibs_num'])) ? $ibs_num = $_POST['ibs_num'] : $ibs_num = '';
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = strip_tags($_POST['comment']) : $comment = '';
if ($id && $id_templ) {
    $sql_charge = "INSERT INTO `disk_charge`(`id_disk`,`type_equipment`, `isn`,`room`,`rack`,`unit_start`,`unit_end`,`disk_num`,`INM`,`INC`) 
    VALUES ($id,'$type_equipment','$isn','$room',$rack,$unit_start,$unit_end,$disk_num,'$jira_num','$ibs_num')";
    $query = mysqli_query($link_account,$sql_charge);
    if ($query) {
        $sql = "INSERT INTO `disk_movement`(`id_disk`,`id_disk_templ`, `type_oper`,`serial_num`,`state`,`status`,`point`,`INM`,`INC`,`id_user`,`credit_link`,`date`,`comment`,`deleted`) 
        VALUES ($id,$id_templ,6,'',5,3,3,'$jira_num','$ibs_num',$id_user,0,NOW(),'$comment',0)";
        $query = mysqli_query($link_account,$sql);
            if ($query) {
                #Обновляем
                $sql2 = "
                UPDATE `disk_balance` SET `status`=3, `state`=5, `point`=3
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
               
                printf("Ошибка: %s\n", mysqli_error($link_account));
            }
        }
        else {
            echo "Не получен id_templ";
        }    

    }
    else {
        printf("Ошибка: %s\n", mysqli_error($link_account));
    }
