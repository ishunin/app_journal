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
 <table id="example1_ob_storage" class="table table-bordered table-striped " data-sort-name="date" data-sort-order="desc">
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
       <th class="snorting">Комментарий</th>
       <th class="snorting">Автор</th>
       <th class="snorting" aria-label="Статус: activate to sort column descending" data-field="date" data-sortable="true">Дата поступления</th>
     </tr>
   </thead>
   <?php
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `status`=6 AND `deleted`=0 ORDER BY `date` DESC LIMIT 100");
    echo '<tbody>';
    while ($result = mysqli_fetch_array($sql)) {
      #Инициализируем переменные
      $id = $result['id'];
      $id_disk = $result['id_disk'];
      $serial_num = strip_tags($result['serial_num']);
      $INM = strip_tags($result['INM']);
      //$INC = strip_tags($result['INC']);
      //$comment = mb_substr(strip_tags($result['comment']),0,500);                 
      $status = get_disk_status($result['status']);
      $state = get_disk_state($result['state']);
      //$point = get_disk_point($result['point']);
      $item_class = get_class_item_disk_state($result['state']);
      //$user_name =  get_user_name_by_id($result['id_user'],$link);  
      #кнопки управления  
      $page_back = 'ob_dashboard.php';
      $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk`=$id AND `type_oper`=4 ORDER BY `id` LIMIT 1");
      while ($result2 = mysqli_fetch_array($sql2)) {
        $user_name = get_user_name_by_id($result2['id_user'], $link);
        $point = get_disk_point($result2['point']);
        $date = $result2['date'];
        $comment = $result2['comment'];
      }
      include("control_button.php");
      echo '<tr class="' . $item_class . '">
                    <td>
                    <div class="input-group mb-3" style="margin-bottom: 0rem !important;">
                    <div class="input-group-prepend">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-arrow-alt-circle-down"></i>
                    </button>
                    <div class="dropdown-menu">
                    '.$control_button.'
                    '.$control_button_ob.'
                    </div>
                    </div>
                    <!-- /btn-group -->
                    </div>
                    </td>' .
        "<td>$id</td>" .
        "<td><a class='dropdown-item' href='one_disk_exact.php?id=$id&id_disk=$id_disk.' >$serial_num</a></td>" .
        "<td>$state</td>" .
        "<td>$status</td>" .
        "<td>$point</td>" .
        "<td>$INM</td>" .
        "<td>$comment</td>" .
        "<td>$user_name</td>" .
        "<td>$date</td>" .
        '</tr> 
                    ';
    }
    echo ' </tbody> 
                    <tfoot>
                    <tr>
                        <!-- Заголовок таблицы -->
                        <th class="snorting"></th>
                        <th class="snorting">ID</th>
                        <th class="snorting">Серийный номер</th>
                        <th class="snorting">Состояние</th>
                        <th class="snorting">Статус</th>
                        <th class="snorting">Точка поступления</th>
                        <th class="snorting">INM</th>
                        <th class="snorting">Комментарий</th>
                        <th class="snorting">Автор</th>
                        <th class="snorting">Дата поступления</th>      
                    </tr>
                    </tfoot>';
    ?>
 </table>