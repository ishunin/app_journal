<!-- Валидация формы комментариев-->
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

<?php
if (isset($_GET['id'])) {
  $id_disk = $_GET['id'];
} else {
  $id_disk = 0;
}
?>
<div class="col-12">
  <div class="row">
    <div class="col-12">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Все диски на в ЦОД (в работе на оборудовании)</h3>
          <a class="btn btn-default" style="float:right;" href="print_ibs_disks.php" target="_blank"><i class="fas fa-print"></i> Печать</a>
        </div>
        <div class="card-body">
          <?php
          include("table_disk_cod.php");
          ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>
</div>
<?php
if (isset($_SESSION['success_action'])) {
  echo get_action_notification($_SESSION['success_action']);
}
?>
<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для создания новой записи инцидента-->
<div id="modal_add_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_add_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы добавления нового диска-->
<!-- Конец блока модальныйх окон страницы-->
<script type="text/javascript">
  function add_disk(id, page_back) {
    $('#modal_add_disk_content').load('ajax_add_disk.php?id_disk=' + id + '&page_back=' + page_back, function() {
      $('#modal_add_disk').modal({
        show: true
      });
    });
  }
</script>