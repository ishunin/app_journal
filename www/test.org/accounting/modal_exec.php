<!-- Модальное окно для создания новой номенкалтуры диска-->
<div id="modal_add_disk_templ" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_add_disk_templ_content">
      <!-- Контент загруженный из файла "/accounting/ajax_add_disk_art.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы добавления нового диска-->
<!-- Конец блока модальныйх окон страницы-->

<!-- Модальное окно для редактирования номенкалтуры диска-->
<div id="modal_edit_disk_templ" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content" id="modal_edit_disk_templ_content">
      <!-- Контент загруженный из файла "/accounting/ajax_add_disk_art.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы редактирования нового диска-->
<!-- Конец блока модальныйх окон страницы-->

<script type="text/javascript">
  function add_disk_templ() {
    $('#modal_add_disk_templ_content').load('ajax_add_disk_templ.php', function() {
      $('#modal_add_disk_templ').modal({
        show: true
      });
    });
  }
</script>

<script type="text/javascript">
  function edit_disk_templ(id_templ) {
    $('#modal_edit_disk_templ_content').load('ajax_edit_disk_templ.php?id=' + id_templ, function() {
      $('#modal_edit_disk_templ').modal({
        show: true
      });
    });
  }
</script>