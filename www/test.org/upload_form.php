<div class="card-body">
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
      <textarea name="comment" id="comment_simple_textare" class="textarea" placeholder="Комментарий" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;"></textarea>

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
<input type="hidden" name="page_back" value="uploads.php" />
<input type="hidden" name="type" value="0" />
</form>