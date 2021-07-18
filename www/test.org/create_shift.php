<?php
include ("scripts/conf.php");
 $sql = mysqli_query($link, "INSERT INTO `shift` (`id_user`, `is_open`,`create_date`,`end_date`)  VALUES (1, 1, NOW(), NOW())");
if ($sql) {
echo "ok";
}
else {
    echo 'Ошибка при добавлене данных';
}
