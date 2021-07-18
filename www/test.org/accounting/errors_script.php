<?php
(isset($_GET['id']) && !empty($_GET['id'])) ? $id= $_GET['id'] : $id = 0;
(isset($_GET['id_templ']) && !empty($_GET['id_templ'])) ? $id_templ= $_GET['id_templ'] : $id_templ = 0;
(isset($_GET['part_number']) && !empty($_GET['part_number'])) ? $part_number = $_GET['part_number'] : $part_number = '';
(isset($_GET['serial_number']) && !empty($_GET['serial_number'])) ? $serial_number = $_GET['serial_number'] : $serial_number = '';
if ($_GET['type']==1) {
echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
    <h5><i class="icon fas fa-ban"></i> Ошибка</h5>
    Запись с таким part-номером: "'.$part_number.'" уже существует в системе.
    <p> <small>*Проверяйте поиcком парт-номер номер перед добавллением нового шаблона диска в систему</small></p>
    <a href=" /accounting/one_disk.php?id='.$id_templ.'">Ссылка на запись</a><br>
    <a href="#" onclick="javascript:history.back(); return false;">Назад</a><br>
 </div>
';
}
if ($_GET['type']==2) {
    echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
        <h5><i class="icon fas fa-ban"></i> Ошибка</h5>
        Запись с таким серийным номером: "'.$serial_number.'" уже существует в системе.
        <p> <small>*Проверяйте поиcком серийный номер перед добавллением нового диска в систему</small></p>
        <a href=" /accounting/one_disk_exact.php?id='.$id.'&id_disk='.$id_templ.'">Ссылка на запись</a><br>
        <a href="#" onclick="javascript:history.back(); return false;">Назад</a><br>    
     </div>
    ';
}
