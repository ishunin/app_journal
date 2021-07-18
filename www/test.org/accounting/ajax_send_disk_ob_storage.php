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

<form action="/accounting/send_disk_ob_storage.php" method="post">
  <div class="modal-header">
    <h4 class="modal-title">Уверены что хотите оставить диск на хреннии?</h4>
   
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
  <small>*Диск будет храниться в ОБ не уничтоженный, до перевода в статус "вернуть со cклада ОБ"</small>
    <textarea name="comment" id="del_disk_textarea" class="textarea" placeholder="Комментарий..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"></textarea>
  </div>
  <div class="modal-footer justify-content-between">

    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="id_disk" value="<?php echo $_GET['id_disk']; ?>">
    <input type="hidden" name="page_back" value="<?php echo $_GET['page_back']; ?>">
    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Отмена</button>
    <button type="submit" class="btn btn-outline-light">На харнение в ОБ</button>
  </div>
</form>