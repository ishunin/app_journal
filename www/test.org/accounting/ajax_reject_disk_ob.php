<?php
#Общие функции
include '../func.php';
include '../scripts/conf_account.php';
?>
<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    $(document).ready(function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      //var forms = document.getElementById('edit_form');
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

<form action="/accounting/reject_disk_from_ob.php" method="post">
  <div class="modal-header">
    <h4 class="modal-title">Уверены что хотите вернуть диск в ЭТИ 1?</h4>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
    <p>Укажите причину возврата диска без уничтожения.</p>
    <p><small>* Важно! ОБ отклоняет диск только после того, как сотрудник ЭТИ1 физически забирает диск из отедла ОБ. В комментарии укажите ФИО сотрудника ОБ, который забрал диск и причину возврата диска.</small></p>
    <textarea name="comment" id="del_disk_textarea" class="textarea" required placeholder="Комментарий*. Укажите причину возврата(обязательно для заполнения)..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"></textarea>
  </div>
  <div class="modal-footer justify-content-between">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="id_disk" value="<?php echo $_GET['id_disk']; ?>">
    <input type="hidden" name="page_back" value="<?php echo $_GET['page_back']; ?>">
    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Отмена</button>
    <button type="submit" class="btn btn-outline-light">Вернуть</button>
  </div>
</form>