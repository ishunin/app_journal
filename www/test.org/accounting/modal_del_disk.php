
<form action="/accounting/del_disk.php" method="post">
<div class="modal fade" id="modal-del-disk" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h4 class="modal-title">Уверены что хотите удалить диск из системы<?php echo $id;?>?</h4>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"> 
        <p>Важно! Диски из системы удаляются только в исключительных случаях. Вы точно понимаете что делаете?</p>       
        <textarea name="comment" maxlength="1000" id="dek_disk_textarea" class="textarea" required placeholder="Комментарий*. Укажите причину удаления диска (обязательно для заполнения)..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;" ></textarea>
      </div>
      <div class="modal-footer justify-content-between">
      <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="hidden" name="id_templ" value=<?php echo $id_disk;?>>
      <input type="hidden" name="page_back" value="<?php echo $page_back;?>">
      <button type="button" class="btn btn-outline-light" data-dismiss="modal">Отмена</button>
      <button type="submit" class="btn btn-outline-light">Удалить</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</form>   
<script type="text/javascript">
function del_disk(id,id_disk,page_back) {
$('#modal-del-disk').modal({show:true});
}
</script>



<!-- Блок модальный окон страницы-->
<!-- Модальное окно для удаления шаблона-->
<div id="modal_del_disk" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content bg-danger" id="modal_del_disk_content">
      <!-- Контент загруженный из файла "/accounting/ajax_read_disk.php" -->
    </div>
  </div>
</div>
<!-- Конец Модального окно формы удаления шаблона-->
<!-- Конец блока модальныйх окон страницы-->
<script type="text/javascript">
  function del_disk2(id, id_disk, page_back) {
    $('#modal_del_disk_content').load('ajax_del_disk.php?id=' + id + '&id_disk=' + id_disk + '&page_back=' + page_back, function() {
      $('#modal_del_disk').modal({
        show: true
      });
    });
  }
</script>