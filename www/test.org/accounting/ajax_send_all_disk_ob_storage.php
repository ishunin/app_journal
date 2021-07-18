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

<form action="/accounting/get_all_disk_ob.php" method="post">
  <div class="modal-header">
    <h4 class="modal-title">Уверены что вы уже забрали ВСЕ ДИСКИ на склад?</h4>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>

  <div class="modal-body">
    <textarea name="comment" id="del_disk_textarea" class="textarea" placeholder="Комментарий..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"></textarea>
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Отмена</button>
    <button type="submit" class="btn btn-outline-light">Забрать все диски на склад</button>
  </div>
</form>