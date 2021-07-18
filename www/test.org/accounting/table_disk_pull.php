 <!-- Выводим таблицу номенклатуры -->
 <table id="example1" class="table table-bordered table-striped col-md-9">
     <thead>
         <tr>
             <!-- Заголовок таблицы -->
             <th class="snorting"></th>
             <th class="snorting">ID</th>
             <th class="snorting">Тип операции</th>
             <th class="snorting">Серийный номер</th>
             <th class="snorting">Состояние</th>
             <th class="snorting">Статус</th>
             <th class="snorting">Точка поступления</th>
             <th class="snorting">INM</th>
             <th class="snorting">INC</th>
             <th class="snorting">Комментарий</th>
             <th class="snorting">Автор операции</th>
             <th class="snorting">Дата операции</th>
         </tr>
     </thead>
     <?php
        $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `type_oper`=6 ORDER BY `date` DESC LIMIT 100");
        echo '<tbody>';
        while ($result = mysqli_fetch_array($sql)) {
            #Инициализируем переменные
            $id_disk = $result['id_disk'];
            $user_name =  get_user_name_by_id($result['id_user'], $link);
            $date =  $result['date'];
            $comment = mb_substr(strip_tags($result['comment']), 0, 500);
            $INM = strip_tags($result['INM']);
            $INC = strip_tags($result['INC']);
            $point = get_disk_point($result['point']);
            $item_class = get_class_item_disk($result['state']);
            $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id`=$id_disk AND `deleted`=0");
            $count_d = 0;
            while ($result2 = mysqli_fetch_array($sql2)) {
                $count_d++;
                $id = $result2['id'];
                $id_disk = $result2['id_disk'];
                $serial_num = strip_tags($result2['serial_num']);
                $status = get_disk_status($result['status']);
                $state = get_disk_state($result['state']);
                $type_oper = get_disk_operation_by_id($result['type_oper']);
                $date = $result['date'];
            }
            if ($count_d > 0) {
                #кнопки управления    
                $show_button = '<a class="dropdown-item" href="one_disk_exact.php?id=' . $id . '&id_disk=' . $id_disk . '" onclick="" ><i class="far fa-eye"></i> Просмотр</a> ';
                $page_back = 'push_disks.php';
                //include ("control_button.php");      
                echo '<tr class="' . $item_class . '">
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
                    "<td>$id_disk</td>" .
                    "<td>$type_oper</td>" .
                    "<td>$serial_num</td>" .
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
        }
        echo ' </tbody> 
                    <tfoot>
                    <tr>
                        <!-- Заголовок таблицы -->
                        <th class="snorting"></th>
                        <th class="snorting">ID</th>
                        <th class="snorting">Тип операции</th>
                        <th class="snorting">Серийный номер</th>
                        <th class="snorting">Состояние</th>
                        <th class="snorting">Статус</th>
                        <th class="snorting">Точка поступления</th>
                        <th class="snorting">INM</th>
                        <th class="snorting">INC</th>
                        <th class="snorting">Комментарий</th>
                        <th class="snorting">Автор операции</th>
                        <th class="snorting">Дата операции</th>      
                    </tr>
                    </tfoot>';
        ?>
 </table>