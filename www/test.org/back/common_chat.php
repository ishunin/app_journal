<!-- Общий чат для пользователей -->
<!-- Скрипт валидации формы bootstrap 4 -->
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>



<!-- Post -->
<?php
#Получили параметр GET пользователя по которому сортируем? - проверяем есть ли такой пользователь в БД, иначе обнуляем $_GET['id']
if (isset($_GET['id']) && !empty($_GET['id']) && (get_user_name_by_id($_GET['id'],$link)!==0)) {
        $user_query_id =$_GET['id'];
        $option_str = get_user_name_by_id($_GET['id'],$link);
        $query_option = '='.$user_query_id.' ';
 
    }
    else {
        $option_str = 'Все пользователи';
        #Эта опция используется в файле show_comments.php ниже, пототм переделать!!!
        $query_option = 'IS NOT NULL';
   
    }   




?>
<div class="post clearfix">
    <div class="user-block">
        <img class="img-circle img-bordered-sm" src="dist/img/<?php echo($_COOKIE['id']);?>.png" alt="User Image">
        <div class="input-group-prepend" style="float:right;">
            <button type="button" class="btn btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
               <?php echo ($option_str);?>
            </button>
            <div class="dropdown-menu" style="">
                <?php
            #Запрашиваем всех пользователей
            $sql = mysqli_query($link, 'SELECT *  FROM `users`');
            while ($result = mysqli_fetch_array($sql)) {
            echo ' 
            <a class="dropdown-item" href="profile.php?id='.$result['ID'].'">'.$result['first_name'].' '.$result['last_name'].'</a>
            ';
            }    
            ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="profile.php">Все пользователи</a>
            </div>
        </div>
        <span class="username">
            <a href="#"><?php echo (get_user_name_by_id($_COOKIE['id'],$link));?></a>

        </span>
        <span class="description">Дежурный ЭТИ 1 - вы еще не оставили сообщение...</span>
    </div>
    <!-- /.user-block -->


    <form method="post" action="create_comment.php" class="form-horizontal needs-validation" novalidate>
        <div class="input-group input-group-sm mb-0">
            <input name="content" maxlength="1000" class="form-control form-control-sm" placeholder="Введите сообщение..." required>
            <div class="input-group-append">
                <input type="submit" class="btn btn-danger" value="Опубликовать">
            </div>

            <div class="valid-feedback">
                Верно
            </div>
            <div class="invalid-feedback">
                Пожалуйста, введите текст комментария.
            </div>
        </div>

        <input type="hidden" name="id_user" value="<?php echo($_COOKIE['id']);?>">
        <input type="hidden" name="page" value="profile.php">
        <input type="hidden" name="type" value="5">
    </form>
</div>
<!-- /.post -->
<?php 
$flag_comments = 5;
include ("show_comments.php");
?>