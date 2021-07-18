 <!-- Выводим таблицу номенклатуры -->
 <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <!-- Заголовок таблицы -->
                        <th class="snorting">ID</th>
                        <th class="snorting">Тип операции</th>
                        <th class="snorting">Серийный номер</th>
                        <th class="snorting">Состояние</th>
                        <th class="snorting">Статус</th>
                        <th class="snorting">Точка поступления</th>
                        <th class="snorting">INM</th>
                        <th class="snorting">INC</th>
                        <th class="snorting">Комментарий</th>
                        <th class="snorting">Автор</th>
                        <th class="snorting">Дата операции</th>                        
                        </tr>
                    </thead>
                    <?php
                    #$id_disk=$_GET['id'];
                    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk`=$id ORDER BY `date` DESC");
                    echo '<tbody>';
                    while ($result = mysqli_fetch_array($sql)) {

                    #Инициализируем переменные
                    $id_move=$result['id'];
                    $serial_num = strip_tags($result['serial_num']);
                    $INM = strip_tags($result['INM']);
                    $INC = strip_tags($result['INC']);
                    $comment = mb_substr(strip_tags($result['comment']),0,1000);                 
                    $status = get_disk_status($result['status']);
                    $state = get_disk_state($result['state']);
                    $point = get_disk_point($result['point']);
                    $item_class = get_class_item_disk($result['type_oper']);
                    
                    #кнопки управления        
                    $show_button = '<a class="dropdown-item" href="#" onclick="edit_disk('.$id.','.$id_disk.',`one_disk_exact.php`);" >Редактировать</a>';
                    $plus_button = '<a class="dropdown-item" href="#" onclick="add_disk('.$id_disk.',`one_disk.php?id='.$id_disk.'`);">Приход</a>';
                    $minus_button = ' <a class="dropdown-item" href="#" onclick="">Расход</a>';
                    $user_name =  get_user_name_by_id($result['id_user'],$link);
                    $type_oper = get_disk_operation_by_id($result['type_oper']);
                    
                    echo '<tr class="'.$item_class.'">'.
                    "<td>{$result['id']}</td>".
                    "<td>{$type_oper}</td>".
                    "<td>{$serial_num}</td>".
                    "<td>{$state}</td>".
                    "<td>{$status}</td>".
                    "<td>{$point}</td>".
                    "<td>{$INC}</td>".
                    "<td>{$INM}</td>".
                    "<td>{$comment}</td>".
                    "<td>$user_name</td>".
                    "<td>{$result['date']}</td>".
                    '</tr> 
                    ';


                    }
                    echo ' </tbody> 
                    <tfoot>
                    <tr>
                        <!-- Заголовок таблицы -->
                        <th class="snorting">ID</th>
                        <th class="snorting">Тип операции</th>
                        <th class="snorting">Серийный номер</th>
                        <th class="snorting">Состояние</th>
                        <th class="snorting">Статус</th>
                        <th class="snorting">Точка поступления</th>
                        <th class="snorting">INM</th>
                        <th class="snorting">INC</th>
                        <th class="snorting">Комментарий</th>
                        <th class="snorting">Автор</th>
                        <th class="snorting">Дата операции</th>       
                    </tr>
                    </tfoot>';
                    ?>
                    </table>
