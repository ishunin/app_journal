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
<div class="post clearfix">
    <div class="user-block">
        <img class="img-circle img-bordered-sm" src="<?php echo (get_user_icon($_COOKIE['id'], $link)); ?>" alt="User Image">
        <span class="username">
            <a href="#"><?php echo (get_user_name_by_id($_COOKIE['id'], $link)); ?></a>
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
        <?php
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id_user = $_GET['id'];
        }
        else {
            $id_user = $_COOKIE['id'];
        }    
        ?>
        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
        <input type="hidden" name="page" value="profile.php">
        <input type="hidden" name="type" value="5">
    </form>
</div>
<!-- /.post -->
<?php
$flag_comments = 5;
include("show_comments.php");
?>