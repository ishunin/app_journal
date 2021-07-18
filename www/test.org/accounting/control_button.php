<?php
    #Кнопки управления для всех
    $send_ibs_button = '';
    $minus_button = '';
    $send_ob_button='';
    $print_doc_button = '';
    $get_button = '';
    $send_ob_button = '';
    $send_stor_button_as_broken = '';
    $send_stor_button_as_work = '';
    $del_button = '';
    $ob_storage = '';
    $ob_storage_back = '';
    #$minus_button = '<a class="link-black text-sm mr-2 target="_blank"" href="#" onclick="add_disk('.$id_disk.',`one_disk.php?id='.$id_disk.'`);"><i class="fas fa-minus"></i> Расход</a>';
 
    $del_button = '<a href="#" class="dropdown-item" onclick="del_disk2('.$id.','.$id_disk.',`one_disk_exact.php`);"> <i class="fas fa-trash-alt"></i> Удалить</a>';
    $edit_button = '<a href="#" class="dropdown-item" onclick="edit_disk('.$id.','.$id_disk.',`'.$page_back.'`);"> <i class="fas fa-edit"></i> Редактировать</a>';                   
    $print_button = '<a class="dropdown-item" href="print_one_disk_exact.php?id='.$id.'&id_disk='.$id_disk.'" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-print"></i> Печать</a>';    
    $show_button = '<a class="dropdown-item" href="one_disk_exact.php?id='.$id.'&id_disk='.$id_disk.'" onclick="" ><i class="far fa-eye"></i> Просмотр</a> ';
    
    #Диск на складе и новый
    if ($result['state']==1 && $result['status']==1) {
      $minus_button = '<a class="dropdown-item" href="#" onclick="charge_disk('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-minus"></i> Расход</a>';
      }
    
    #Диск на складе и сломан
    if ($result['state']==3 && $result['status']==1) {
    $send_ob_button = '<a class="dropdown-item" href="#" onclick="send_disk_ob('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-share"></i> Передать в ОБ на уничтожение</a>';  
    $print_doc_button = '<a class="dropdown-item" href="print_declaration.php?id='.$id.'&id_disk='.$id_disk.'&serial_num='.$serial_num.'" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';
    }

    #Диск в цоде в работе
    if ($result['state']==5 && $result['status']==3) {
    $send_stor_button_as_broken = '<a class="dropdown-item" href="#" onclick="send_disk_stor('.$id.','.$id_disk.',`'.$page_back.'`,3);"><i class="fas fa-share"></i> Вернуть на склад как сломанный</a>';  
    $send_stor_button_as_work = '<a class="dropdown-item" href="#" onclick="send_disk_stor('.$id.','.$id_disk.',`'.$page_back.'`,2);"><i class="fas fa-share"></i> Вернуть на склад как б/у</a>';  

    }
    
    #Диск в ОБ и уничтожен
    if ($result['state']==4 && $result['status']==4) {
    $get_button = '<a class="dropdown-item" href="#" onclick="get_disk_ob('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-share"></i> Забрать диск из ОБ на склад</a>';
    $print_doc_button = '<a class="dropdown-item" href="print_declaration.php?id='.$id.'&id_disk='.$id_disk.'&serial_num='.$serial_num.'" class="link-black text-sm mr-2" target="_blank"> <i class="fas fa-sign-out-alt"></i> Печать заявление на вынос</a>';  
    }  

    
    
    #Диск уничтожен и на складе
    if ($result['state']==4 && $result['status']==1) {
      $send_ibs_button = '<a class="dropdown-item" href="#" onclick="send_disk_ibs('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-share"></i> Передать в IBS</a>';
    }  

    #Кнопки управления для ОБ
    $reject_button = '<a class="dropdown-item" href="#" onclick="reject_disk_ob('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-minus"></i> Отклонить</a>';
    $destroy_button = '<a class="dropdown-item" href="#" onclick="destroy_disk_ob('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-skull-crossbones"></i> Уничтожить</a>';
    $ob_storage   =  '<a class="dropdown-item" href="#" onclick="send_disk_ob_storage('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-share"></i> Оставить на хранение</a>';
    $ob_storage_back   =  '<a class="dropdown-item" href="#" onclick="send_disk_ob_storage_back('.$id.','.$id_disk.',`'.$page_back.'`);"><i class="fas fa-share"></i> Вернуть в работу</a>';


    $control_button =  $minus_button.$get_button. $send_stor_button_as_broken.$send_stor_button_as_work.$send_ob_button.$send_ibs_button.$print_doc_button.$edit_button.$print_button;
    if ($result['state'] != 4) {
    $control_button_ob = $reject_button.$destroy_button.$ob_storage;
    }  
    $control_button = $show_button;
    $control_button_ob = '';
    #Выводим кнопки управления
    $level_access_but = array(1,2,4,5);
    $is_allowed_button = is_allow($_COOKIE['permissions'],$level_access_but);
    if ($is_allowed_button) {
        $control_button.=$minus_button.$get_button. $send_stor_button_as_broken.$send_stor_button_as_work.$send_ob_button.$send_ibs_button.$print_doc_button.$edit_button.$del_button.$print_button;

    }
    $level_access_but = array(3,5);
    $is_allowed_button = is_allow($_COOKIE['permissions'],$level_access_but);
    if ($is_allowed_button) {
      
        if ($result['state'] != 4 && $result['status']!=6) {
            $control_button_ob =  $reject_button.$destroy_button.$ob_storage;
            
            }  
        if ( $result['status']==6) { 
          $control_button_ob = $control_button_ob .$ob_storage_back;
        }
        
    }

   


