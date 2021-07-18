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

<?php
if ($_GET['state'] == 3) {
  $state = 'сломанный';
}
if ($_GET['state'] == 2) {
  $state = 'б/у';
}
?>
<form action="/accounting/send_disk_stor.php" method="post" class="needs-validation" novalidate>
  <div class="modal-header">
    <h4 class="modal-title">Уверены что хотите вернуть диск на склад из ЦОДа как <?php echo $state; ?></h4><br>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="form-group">
      <label>Серийный номер диска, установленного вместо этого</label>
      <input required type="text" maxlength="20" name="serial_num_new_disk" value="" class="form-control" id="serial_num_new_disk" placeholder="серийный номер диска, который был установлен вместо этого" aria-describedby="inputGroupPrepend">
      <div class="valid-feedback">
        Верно
      </div>
      <div class="invalid-feedback">
        Пожалуйста, серийный номер диска, который был установлен вместо этого.
      </div>
    </div>
    <textarea name="comment" id="del_disk_textarea" class="textarea" placeholder="Комментарий..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"></textarea>
  </div>
  <div class="modal-footer justify-content-between">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="id_disk" value="<?php echo $_GET['id_disk']; ?>">
    <input type="hidden" name="page_back" value="<?php echo $_GET['page_back']; ?>">
    <input type="hidden" name="state" value="<?php echo $_GET['state']; ?>">
    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Отмена</button>
    <button type="submit" class="btn btn-outline-light">Вернуть на склад</button>
  </div>
</form>