<?php 
$user_id = $_COOKIE['id'];
$user_icon = get_user_icon($user_id,$link);
echo '
<form action="/accounting/create_comment_v2.php" method="post" id="comment" class="needs-validation" novalidate>
    <img class="img-fluid img-circle img-sm" src="'.$user_icon.'" alt="Alt Text">
    <!-- .img-push is used to add margin to elements next to floating images -->
    <div class="img-push">    
        <div class="input-group input-group-sm mb-0">
            <input class="form-control form-control-sm" placeholder="Введите комментарий..." name="content" required>
            <div class="input-group-append">
                 <input type="submit" maxlength="1000" class="btn btn-info" value="Опубликовать">
            </div>
            <div class="valid-feedback">
                 Верно
            </div>
            <div class="invalid-feedback">
                Пожалуйста, введите текст комментария.
            </div>
        </div>
            <input type="hidden" name="id" value="'.$id_comment.'">
            <input type="hidden" name="id_user" value="'.$user_id.'">
            <input type="hidden" name="id_rec" value="'.$id_comment.'">
            <input type="hidden" name="page_back" value="'.$page_back_comment.'">
            <input type="hidden" name="type" value="'.$type_comment.'">
     </div>
</form>
';
