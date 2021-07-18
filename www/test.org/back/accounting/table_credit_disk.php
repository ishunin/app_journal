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
                    $id_disk=$_GET['id'];
                    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id_disk`=$id_disk ORDER BY `date` DESC");
                    echo '<tbody>';
                    while ($result = mysqli_fetch_array($sql)) {
                    $id=$result['id'];
                    #кнопки управления        
                    $show_button = '<a class="dropdown-item" href="one_disk.php?id='.$id.'" onclick="" >Просмотр</a>';
                    $plus_button = '<a class="dropdown-item" href="#" onclick="add_disk('.$result['id'].');">Приход</a>';
                    $minus_button = ' <a class="dropdown-item" href="#" onclick="">Расход</a>';
                    $user_name =  get_user_name_by_id($result['id_user'],$link);
                    
                    echo '<tr>
                    <td>
                    <div class="input-group mb-3" style="margin-bottom: 0rem !important;">
                    <div class="input-group-prepend">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-arrow-alt-circle-down"></i>
                    </button>
                    <div class="dropdown-menu">
                    '.$show_button.'
                    '.$plus_button.'
                    '.$minus_button.'
                    </div>
                    </div>
                    <!-- /btn-group -->
                    </div>
                    </td>'.

                    "<td>{$result['id']}</td>".
                    "<td>{$result['serial_num']}</td>".
                    "<td>{$result['state']}</td>".
                    "<td>{$result['status']}</td>".
                    "<td>{$result['point']}</td>".
                    "<td>{$result['INM']}</td>".
                    "<td>{$result['INC']}</td>".
                    "<td>{$result['comment']}</td>".
                    "<td>$user_name</td>".
                    "<td>{$result['date']}</td>".
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
