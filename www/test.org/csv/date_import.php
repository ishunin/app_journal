<?php
include '../scripts/conf_account.php';
$file_handle = fopen("type_equipment.txt", "r");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   echo $line."<br>";

$sql = mysqli_query($link_account, "INSERT INTO `type_equipment` (`name`) VALUES ('".$line."')");
if (!$sql) {
    echo '<p>Произошла ошибка: ' . mysqli_error($link_account) . '</p>';
   } 
}
fclose($file_handle);
?>