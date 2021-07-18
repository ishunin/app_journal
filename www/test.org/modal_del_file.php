<!-- Блок модальный хокон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_del_file" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_del_file_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->
<script type="text/javascript">
  function del_file(id, page_back, $type_rec) {
    $('#modal_del_file_content').load('ajax_del_file.php?id=' + id + '&page_back=' + page_back + '&type_rec=' + $type_rec, function() {
      $('#modal_del_file').modal({
        show: true
      });
    });
  }
</script>