<script type="text/javascript">
  function upload_file() {
    $('#modal-upload').modal({
      show: true
    });
    //});
  }
</script>
<!-- Модальное окно для создания новой записи инцидента-->
<div class="modal fade show" id="modal-upload">
  <div class="modal-dialog" style="max-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Прикрепить файл</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body2">
        <blockquote class="quote-secondary" style="margin-top: 0px;">
          <small>Если не заполните имя файла, будет взято имя файла по умолчанию</small></br>
          <small>* Максимальный размер загружаемого фала 100 Мб.</small>
        </blockquote>

        <form action="upload_script.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleInputName">Название файла</label>
            <input type="text" maxlength="60" name="name" value="" class="form-control" id="name" placeholder="Название файла" aria-describedby="inputGroupPrepend">
            <div class="valid-feedback">
              Верно
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите имя файла.
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Файл</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" name="userfile" class="custom-file-input" id="exampleInputFile" required value="sad">
                <label class="custom-file-label" for="exampleInputFile">загружаемый файл...</label>
              </div>
              <div class="valid-feedback">
                Верно
              </div>
              <div class="invalid-feedback">
                Пожалуйста, укажите файл.
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="area_content">Комментарий</label>
            <!--<textarea name="comment" id="comment213" class="textarea" placeholder="Содержание заявки" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ></textarea>-->
            <textarea name="comment" maxlength="1000" id="comment_simple_textare" class="textarea" placeholder="Комментарий" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"></textarea>

            <div class="valid-feedback">
              Верно
            </div>
            <div class="invalid-feedback">
              Пожалуйста, введите Коментарий.
            </div>
          </div>

          <!-- /.card-body -->
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Загрузить</button>
      </div>
      <?php
      if (!isset($type)) {
        $type = 0;
      }
      ?>
      <input type="hidden" name="page_back" value="<?php echo $page_back; ?>" />
      <input type="hidden" name="type" value="<?php echo $type; ?>" />
      <input type="hidden" name="id_rec" value="<?php echo $id_rec; ?>" />
      <input type="hidden" name="id_rec" value="<?php echo $id_rec; ?>" />
      <input type="hidden" name="type_rec" value="<?php echo $type_rec; ?>" />
      </form>
    </div>
  </div>
  <!-- /.modal-content -->
</div>