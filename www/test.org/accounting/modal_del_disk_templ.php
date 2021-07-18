<!-- Блок модальный окон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_del_disk_templ" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_del_disk_templ_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->
<script type="text/javascript">
  function del_disk_templ(id, page_back) {
    $('#modal_del_disk_templ_content').load('ajax_del_disk_templ.php?id=' + id + '&page_back=' + page_back, function() {
      $('#modal_del_disk_templ').modal({
        show: true
      });
    });
  }
</script>