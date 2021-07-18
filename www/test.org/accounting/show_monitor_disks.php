<?php
    $sql = mysqli_query($link_account, "SELECT *  FROM `disk_templ` WHERE `deleted`=0 AND `monitor`=1 ORDER BY `id` DESC");
    $str = '';
    $j = 0;
    while ($result = mysqli_fetch_array($sql)) {
        $i = 0;
        
        $id = $result['id'];
        $name = strip_tags($result['name']);
        $part_number = strip_tags($result['part_number']);
        $treshold = strip_tags($result['treshold']);
        $i = 0;
        $sql2 = mysqli_query($link_account, "SELECT *  FROM `disk_balance` WHERE `id_disk`=$id  AND `deleted`=0 AND `state`=1");
        while ($result2 = mysqli_fetch_array($sql2)) {
            $i++;
        }
        if ($i < $treshold) {
            $str .= "id= " . $id . " , <a href='one_disk.php?id=" . $result['id'] . "'>модель диска: " . $name . "</a> , Парт-номер: " . $part_number . " , на складе осталось меньше " . $i . " шт. при установленном пороге мониторинга " . $treshold . " шт.<br/>";
            $j = 1;
        }
    }
    if ($j > 0) {
        echo '
            <h5><i class="icon fas fa-ban"></i> Малое количество дисков на складе</h5>
            ' . $str . '
           ';
    } else {
        echo '
           <blockquote class="quote-secondary">
                Нет дисков отвечающих поиску...
            </blockquote>           ';
    }
