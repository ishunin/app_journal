<?php
if ($id ) {
    $str_dest = '';
    //если диск в ЦОДЕ в работе
    if ($row['state'] == 5 && $row['status']==3) {
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_charge` WHERE `id_disk`=$id ORDER BY `id` DESC LIMIT 1");
    while ($result = mysqli_fetch_array($sql)) {
        #Инициализируем переменные
        (isset($result['type_equipment']) && !empty($result['type_equipment'])) ? $type_equipment = strip_tags($result['type_equipment']) : $type_equipment = 'неизветсно';
        (isset($result['isn']) && !empty($result['isn'])) ? $isn = strip_tags($result['isn']) : $isn = 'не указан';
        (isset($result['room']) && !empty($result['room'])) ? $room = strip_tags($result['room']) : $room = 'не указана';
        (isset($result['rack']) && !empty($result['rack'])) ? $rack =$result['rack'] : $rack = 'не указан';    
        (isset($result['unit_start']) && !empty($result['unit_start'])) ? $unit_start =$result['unit_start'] : $unit_start = 'не указан';   
        (isset($result['unit_end']) && !empty($result['unit_end'])) ? $unit_end =$result['unit_end'] : $unit_end = '';   
        (isset($result['disk_num']) && !empty($result['disk_num'])) ? $disk_num =$result['disk_num'] : $disk_num = 'не указан';   
        }
    $str_dest = '
    <div class="alert alert-warning" style="margin-right:10px;">
    <h5>Расположение диска id='.$id.'</h5>
    <p>Диск установлен в '.$type_equipment.' (ИСН: '.$isn.'), расположение: '.$room.'/'.$rack.'/U'.$unit_start.'-'.$unit_end.' в слот '.$disk_num.' </p>
    </div>
    ';
}
    #Диск сломан / бу /   и на складе
    if (($row['state']==3 || $row['state']==2 || $row['state']==4) && ($row['status']==1 || $row['status']==2 || $row['status']==4)) {
        //$sql = mysqli_query($link_account, "SELECT *  FROM `disk_movement` WHERE `id_disk`=$id AND (`state`=2 OR `state`=3) AND `status`=1 AND `type_oper`=1 ORDER BY `id` DESC LIMIT 1");
        $sql = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id`=$id AND `serial_num_new_disk` IS NOT NULL");
        $count_res=0;
        while ($result = mysqli_fetch_array($sql)) {         
            if (isset($result['serial_num_new_disk']) && !empty($result['serial_num_new_disk'])) {
                $serial_num_new_disk = $result['serial_num_new_disk'];
                $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `serial_num` LIKE '%{$serial_num_new_disk}%'");
                while ($result2 = mysqli_fetch_array($sql2)) {
                    $count_res++;
                    $id_new = $result2['id'];
                    $id_disk_new = $result2['id_disk'];
                    $serial_num_new = strip_tags($result2['serial_num']);
                    //запрашиваем информации о размещении диска
                    $sql3 = mysqli_query($link_account, "SELECT *  FROM `disk_charge` WHERE `id_disk`=$id_new ORDER BY `id` DESC LIMIT 1");
                    $destination_new_disk = '<small>Нет информации о расположении диска</small>';
                    while ($result3 = mysqli_fetch_array($sql3)) {
                        (isset($result3['type_equipment']) && !empty($result3['type_equipment'])) ? $type_equipment_new = strip_tags($result3['type_equipment']) : $type_equipment_new = 'неизветсно';
                        (isset($result3['isn']) && !empty($result3['isn'])) ? $isn_new = strip_tags($result3['isn']) : $isn_new = 'не указан';
                        (isset($result3['room']) && !empty($result3['room'])) ? $room_new = strip_tags($result3['room']) : $room_new = 'не указана';
                        (isset($result3['rack']) && !empty($result3['rack'])) ? $rack_new =$result3['rack'] : $rack_new = 'не указан';    
                        (isset($result3['unit_start']) && !empty($result3['unit_start'])) ? $unit_start_new =$result3['unit_start'] : $unit_start_new = 'не указан';   
                        (isset($result3['unit_end']) && !empty($result3['unit_end'])) ? $unit_end_new =$result3['unit_end'] : $unit_end_new = '';   
                        (isset($result3['disk_num']) && !empty($result3['disk_num'])) ? $disk_num_new =$result3['disk_num'] : $disk_num_new = 'не указан';  
                        $destination_new_disk = 'Установлен в оборудование: '.$type_equipment_new.' | по заявке: <a href="https://servicedesk:8443/browse/TM-18073/'.$isn_new.'">'.$isn_new.'</a> | расположение: '.$room_new.'/R'.$rack_new.'/U'.$unit_start_new.'-'.$unit_end_new.' slot '.$disk_num_new;
                    }
                     //<div class="callout callout-warning">
               $str_dest = '
               <div class="alert alert-success alert-dismissible">
               <h5> Информация о новом диске, который был установлен взамен вышедшего из строя</h5>
               <a href="one_disk_exact.php?id='.$id_new.'&id_disk='.$id_disk_new.'" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>Перейти</a>
               Серийный номер: <b>'.$serial_num_new.'</b> | '.$destination_new_disk.'
              </div>
               ';        

                }                    
        }
    }

    if ($count_res==0) {
        $str_dest =  '
        <div class="alert alert-danger">
        <h5><i class="icon fas fa-ban"></i>Для данного диска с id='.$id.' не найден диск, который был установден вместо данного!</h5>
        <p>* Возможно вы ошиблись при указанийй серийного номера? Нажмите "Редактировать" и укажите корректный номер диска..</p>
        <small>Информация о диске не будет отображена в "заявлении на вынос"</small>
        </div>
        ';
    } 
}
echo $str_dest;
}
