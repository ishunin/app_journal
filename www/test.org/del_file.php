<?php 
session_start();
include ("func.php");
include ("scripts/conf.php");
//Инициализируем переменные
(isset($_COOKIE['id']) && !empty($_COOKIE['id'])) ? $id_user = $_COOKIE['id'] : $id_user = 0;
(isset($_POST['id']) && !empty($_POST['id'])) ? $id = $_POST['id'] : $id = 0;
(isset($_POST['type_rec']) && !empty($_POST['type_rec'])) ? $type_rec = $_POST['type_rec'] : $type_rec= 0;
(isset($_POST['page_back']) && !empty($_POST['page_back'])) ? $page_back = $_POST['page_back'] : $id = 0;
(isset($_POST['comment']) && !empty($_POST['comment'])) ? $comment = check_input($link_account,$_POST['comment']) : $comment = '';
if ($id ) {
        #Обновляем
        $sql = "UPDATE `uploads` SET `deleted`=1 WHERE `id`=$id";
        $query = mysqli_query($link,$sql);
        if ($query) {
            
            #Вносим запись в news_changes######################
            $sql = mysqli_query($link, "SELECT `id`,`id_rec` FROM `uploads` WHERE `id`=$id"); 
            $row = mysqli_fetch_assoc($sql);
            if ($row) {
                if ($type_rec==1) {
                    $id_rec = $row['id_rec'] ;
                    $sql2 = mysqli_query($link, "INSERT INTO `list_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
                    ('$id_rec', 8, $id_user, NOW(), 0, 0, 0,$id)");
                }
                else if ($type_rec==2) {
                    $id_rec = $row['id_rec'] ;
                    $sql2 = mysqli_query($link, "INSERT INTO `news_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_file`)  VALUES
                    ($id_rec, 8, $id_user, NOW(), 0, 0, 0,$id)");
                }
                else if ($type_rec==3) {
                    $id_rec = $row['id_rec'] ;
                    $sql2 = mysqli_query($link, "INSERT INTO `jobs_changes` (`id_rec`,`id_oper`, `id_user`, `date`, `status`,`type`,`importance`,`id_exec`,`id_file`)  VALUES
                    ($id_rec, 8, $id_user, NOW(), 0, 0, 0,0,$id)");
                }
            } 
            ######################################################
            $_SESSION['success_action']=3;
            header('location: '.$page_back);
        }
        else {
            printf("Ошибка: %s\n", mysqli_error($link));
            exit();
        }
    }
    else {
        echo 'ошибка';
        exit();
    }
