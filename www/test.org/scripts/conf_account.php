<?php
include ($_SERVER['DOCUMENT_ROOT'].'/init.php');
#define ('SERVER_NAME', 'http://localhost/');
define ('DB_HOST', '172.10.1.30');
define ('DB_LOGIN', 'admin');
define ('DB_PASSWORD', 'admin');
#Константа переопределяется ниже в get_db.php
define ('DB_NAME', 'main');
define ('DB_NAME_ACCOUNT', 'account');

$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    echo '<p>
        Обратитесь к Администратору для решения проблемы. Видимо Вашего пользователя нет в списке разрешенных для данной БД.
        </p>';
    exit;
}

if (mysqli_query($link, "set names utf8")) {
    #printf("кодировка utf-8 установлена");
}
else {
    echo "кодировка utf-8 НЕ установлена";
}


if (mysqli_select_db($link, DB_NAME)) {
#echo "база ".DB_NAME." выбрана";
}
else {
    echo 'Ошибка! Не выбрана БД для работы...';
    exit();
}

#Коннектимся к БД учета дисков
$link_account = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME_ACCOUNT);
if (!$link_account) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    echo '<p>
        Обратитесь к Администратору для решения проблемы. Видимо Вашего пользователя нет в списке разрешенных для данной БД.
        </p>';
    exit;
}

if (mysqli_query($link_account, "set names utf8")) {
    #printf("кодировка utf-8 установлена");
}
else {
    echo "кодировка utf-8 НЕ установлена";
}


if (mysqli_select_db($link_account, DB_NAME_ACCOUNT)) {
#echo "база ".DB_NAME." выбрана";
}
else {
    echo 'Ошибка! Не выбрана БД для работы...';
    exit();
}






#echo "Соединение с MySQL установлено!" . PHP_EOL;
#echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;

?>
