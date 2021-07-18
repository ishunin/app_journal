<?php
function get_status($code_status = 0) {
    switch ($code_status) {
        case 0:
          $res = "В работе";
        case 1:
            $res = "Выполнено";
        case 2:
            $res = "В ожидании";
      }
    return $res;
}
?>