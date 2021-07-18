<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_reject_disk_ob" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-success" id="modal_reject_disk_ob_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function reject_disk_ob(id, id_disk, page_back) {
    $('#modal_reject_disk_ob_content').load('ajax_reject_disk_ob.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_reject_disk_ob').modal({
        show: true
      });
    });
  }
</script>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_destroy_disk_ob" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_destroy_disk_ob_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_destroy_all_disk_ob" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_destroy_all_disk_ob_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_send_disk_ob_storage" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-info" id="modal_send_disk_ob_storage_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<!-- Вернуть диск из склада ОБ обратно в работу-->
<div id="modal_send_disk_ob_storage_back" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-info" id="modal_send_disk_ob_storage_back_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>

<div id="modal_send_all_disk_ob_storage" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-success" id="modal_send_all_disk_ob_storage_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function destroy_disk_ob(id, id_disk, page_back) {
    $('#modal_destroy_disk_ob_content').load('ajax_destroy_disk_ob.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_destroy_disk_ob').modal({
        show: true
      });
    });
  }
</script>

<script type="text/javascript">
  function destroy_all_disk_ob(id, id_disk, page_back) {
    $('#modal_destroy_all_disk_ob_content').load('ajax_destroy_all_disk_ob.php', function() {
      $('#modal_destroy_all_disk_ob').modal({
        show: true
      });
    });
  }
</script>

<script type="text/javascript">
  function send_disk_ob_storage(id, id_disk, page_back) {
    $('#modal_send_disk_ob_storage_content').load('ajax_send_disk_ob_storage.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_send_disk_ob_storage').modal({
        show: true
      });
    });
  }
</script>

<script type="text/javascript">
  function send_all_disk_ob_storage() {
    $('#modal_send_all_disk_ob_storage_content').load('ajax_send_all_disk_ob_storage.php' , function() {
      $('#modal_send_all_disk_ob_storage').modal({
        show: true
      });
    });
  }
</script>



<!-- Вернуть диск из склада ОБ обратно в работу-->
<script type="text/javascript">
  function send_disk_ob_storage_back(id, id_disk, page_back) {
    $('#modal_send_disk_ob_storage_back_content').load('ajax_send_disk_ob_storage_back.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_send_disk_ob_storage_back').modal({
        show: true
      });
    });
  }
</script>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_send_disk_ob" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_send_disk_ob_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->


<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_forgive_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_forgive_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function send_disk_ob(id, id_disk, page_back) {
    $('#modal_send_disk_ob_content').load('ajax_send_disk_ob.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_send_disk_ob').modal({
        show: true
      });
    });
  }
</script>

<script type="text/javascript">
  function forgive_disk(id, id_disk, page_back) {
    $('#modal_forgive_disk_content').load('ajax_forgive_disk.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_forgive_disk').modal({
        show: true
      });
    });
  }
</script>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_get_disk_ob" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-success" id="modal_get_disk_ob_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function get_disk_ob(id, id_disk, page_back) {
    $('#modal_get_disk_ob_content').load('ajax_get_disk_ob.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_get_disk_ob').modal({
        show: true
      });
    });
  }
</script>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_send_disk_ibs" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-success" id="modal_send_disk_ibs_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function send_disk_ibs(id, id_disk, page_back) {
    $('#modal_send_disk_ibs_content').load('ajax_send_disk_ibs.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_send_disk_ibs').modal({
        show: true
      });
    });
  }
</script>

<!-- Модальное окно для удаления шаблона-->
<div id="modal_send_disk_stor" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-success" id="modal_send_disk_stor_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function send_disk_stor(id, id_disk, page_back, state) {
    $('#modal_send_disk_stor_content').load('ajax_send_disk_stor.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back + '&state=' + state, function() {
      $('#modal_send_disk_stor').modal({
        show: true
      });
    });
  }
</script>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для создания прихода диска-->
<div id="modal_add_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_add_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно для создания прихода диска-->
<!-- Конец блока модальныйх окон страницы-->

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для редактирования-->
<div id="modal_edit_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_edit_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окна редактирования диска-->
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

<script type="text/javascript">
  function edit_disk(id, id_disk, page_back) {
    $('#modal_edit_disk_content').load('ajax_edit_disk.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_edit_disk').modal({
        show: true
      });
    });
  }
</script>

<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для редактирования-->
<div id="modal_charge_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_charge_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окна редактирования диска-->

<script type="text/javascript">
  function charge_disk(id, id_disk, page_back) {
    $('#modal_charge_disk_content').load('ajax_charge_disk.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_charge_disk').modal({
        show: true
      });
    });
  }
</script>