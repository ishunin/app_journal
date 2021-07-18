<form action="/accounting/del_disk.php" method="post">

<div class="modal fade" id="modal-del-disk" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h4 class="modal-title">Уверены что хотите удалить диск из системы?</h4>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body"> 
        <p>Важно! Диски из системы удаляются тольо в исключительных случаях. Вы точно понимаете что делаете?</p>
        
        <textarea name="comment" id="dek_disk_textarea" class="textarea" required placeholder="Комментарий*. Укажите причину удаления диска (обязательно для заполнения)..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;" ></textarea>
      </div>

      <div class="modal-footer justify-content-between">
      <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
      <input type="hidden" name="id_templ" value=<?php echo $_GET['id_disk'];?>>
      <input type="hidden" name="page_back" value="one_disk_exact.php">

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
function del_disk(id,id_disk) {
$('#modal-del-disk').modal({show:true});
}
</script>