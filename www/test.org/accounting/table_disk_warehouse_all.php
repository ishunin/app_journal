 <!-- Выводим таблицу номенклатуры -->
 <table id="example1" class="table table-bordered table-striped">
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
     <?php
        $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `status`=1 AND `deleted`=0 ORDER BY `date` DESC LIMIT 100");
        echo '<tbody>';
        while ($result = mysqli_fetch_array($sql)) {
            #Инициализируем переменные
            $id = $result['id'];
            $id_disk = $result['id_disk'];
            $serial_num = strip_tags($result['serial_num']);
            $INM = strip_tags($result['INM']);
            $INC = strip_tags($result['INC']);
            $comment = mb_substr(strip_tags($result['comment']), 0, 500);
            $status = get_disk_status($result['status']);
            $state = get_disk_state($result['state']);
            $point = get_disk_point($result['point']);
            $item_class = get_class_item_disk_state($result['state']);
            $user_name =  get_user_name_by_id($result['id_user'], $link);
            $date = $result['date'];
            #кнопки управления        
            $page_back = 'warehouse_disks_all.php';
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
                "<td><a class='dropdown-item' href='one_disk_exact.php?id=$id&id_disk=$id_disk'>$serial_num</a></td>".
                "<td>$state</td>" .
                "<td>$status</td>" .
                "<td>$point</td>" .
                "<td>$INM</td>" .
                "<td>$INC</td>" .
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
                        <th class="snorting">INC</th>
                        <th class="snorting">Комментарий</th>
                        <th class="snorting">Автор</th>
                        <th class="snorting">Дата поступления</th>      
                    </tr>
                    </tfoot>';
        ?>
 </table>