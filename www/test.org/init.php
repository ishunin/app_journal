<?php
if (isset($_COOKIE['id']) AND !empty( $_COOKIE['id'])) {
define ('USER_ID', $_COOKIE['id']);
}

if (isset($_COOKIE['permissions']) AND !empty( $_COOKIE['permissions'])) {
    define ('USER_PERMISSIONS', $_COOKIE['permissions']);
}
else {
    define ('USER_PERMISSIONS', 0);
}

?>