<?php
$sql_comments = mysqli_query($link, 'SELECT * FROM `comments` WHERE `id_rec`="'.$result['ID'].'"');   
$result_comments = mysqli_query($link,$sql_comments);
$count = mysqli_num_rows($result_comments); 
echo $count;
?>