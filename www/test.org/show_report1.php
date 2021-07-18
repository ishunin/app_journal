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

<!-- Выводим таблицу номенклатуры -->
<?php
$sql = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE `deleted`=0 ORDER BY `id` DESC");
echo '<tbody>';
while ($result = mysqli_fetch_array($sql)) {

    $id_templ = $result['id'];
    #Запрашиваем количество записей на приход по каждой позиции
    $sql3 = "SELECT COUNT(*) FROM `disk_balance` WHERE `id_disk`= $id_templ";
    $query = mysqli_query($link_account, $sql3);
    if ($query) {
        $row = mysqli_fetch_row($query);
        $total = $row[0]; // Всего записей
    } else {
        printf("Ошибка: %s\n", mysqli_error($link_account));
    }
    $str = '
  <div class="card">
    <div class="card-header">
    <h3 class="card-title"></h3>
    <div class="justify-content-between" style="display: flex;">
    <h4>
        ID: ' . $result['id'] . ' | Модель: ' . $result['name'] . ' | Оборудование: ' . $result['type_equipment'] . ' | Сегмент: ' . $result['segment'] . ' | ф\ф ' . $result['form_factor'] . ' | Фирма: ' . $result['firm'] . ' | Интерфейс: ' . $result['interface'] . ' | rpm: ' . $result['rpm'] . ' | Объем, Гб.: ' . $result['volume'] . ' | Парт-номер: ' . $result['part_number'] . ' | ' . $total . ' шт.
    </h5>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
';
    $str .= '
<table id="example4" class="table table-bordered table-striped">
    <thead>
    <tr>
    <!-- Заголовок таблицы -->
    <th class="snorting"></th>
    <th class="snorting">ID</th>
    <th class="snorting">Серийный номер</th>
    <th class="snorting">Состояние</th>
    <th class="snorting">Статус</th>
    <th class="snorting">Точка поступления</th>
    <th class="snorting">INM</th>
    <th class="snorting">INC</th>
    <th class="snorting">Комментарий</th>
    <th class="snorting">Автор</th>
    <th class="snorting">Дата поступления</th>                        
    </tr>
    </thead>
';
    $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id_disk`=$id_templ AND `deleted`=0 ORDER BY `date` DESC");
    echo '<tbody>';
    $i = 0;
    while ($result2 = mysqli_fetch_array($sql2)) {
        $i++;
        #Инициализируем переменные
        $id = $result2['id'];
        $id_disk = $result2['id_disk'];
        $serial_num = strip_tags($result2['serial_num']);
        $INM = strip_tags($result2['INM']);
        $INC = strip_tags($result2['INC']);
        $comment = mb_substr(strip_tags($result2['comment']), 0, 500);
        $status = get_disk_status($result2['status']);
        $state = get_disk_state($result2['state']);
        $point = get_disk_point($result2['point']);
        $item_class = get_class_item_disk($result2['state']);
        $user_name =  get_user_name_by_id($result2['id_user'], $link);
        if ($i > 0) {
            $show_button = '<a class="dropdown-item" href="accounting/one_disk_exact.php?id=' . $id . '&id_disk=' . $id_disk . '" onclick="" ><i class="far fa-eye"></i> Просмотр</a> ';
            $str .= '<tr class="' . $item_class . '">
                    <td>
                    <div class="input-group mb-3" style="margin-bottom: 0rem !important;">
                    <div class="input-group-prepend">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-arrow-alt-circle-down"></i>
                    </button>
                    <div class="dropdown-menu">
                    ' . $show_button . '
                    </div>
                    </div>
                    <!-- /btn-group -->
                    </div>
                    </td>' .
                "<td>{$result['id']}</td>" .
                "<td>{$serial_num}</td>" .
                "<td>{$state}</td>" .
                "<td>{$status}</td>" .
                "<td>{$point}</td>" .
                "<td>{$INC}</td>" .
                "<td>{$INM}</td>" .
                "<td>{$comment}</td>" .
                "<td>$user_name</td>" .
                "<td>{$result['date']}</td>" .
                '</tr> 
                    ';
        }
    }
    $str .= '</tbody> </table>
                
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
            </div>
';
    echo $str;
}
include("modal_close_shift.php");
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