
<!-- Выводим таблицу инцидентов -->
<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <!-- Заголовок таблицы -->
    <th>Ссылка</th>
    <th class="snorting">ID</th>
    <th class="snorting">Автор смены</th>
    <th class="snorting">Дата открытия</th>
    <th class="snorting">Дата закрытия</th>
    <th class="snorting">Статус</th>
    
  </tr>
</thead>

  <?php
 $count=0;
    $sql = mysqli_query($link, 'SELECT *  FROM `shift` ORDER BY create_date DESC');
    echo '<tbody>';
    while ($result = mysqli_fetch_array($sql)) {
      $sql_user = mysqli_query($link, 
      "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);

if ($result['end_date']==NULL) {
  $result['end_date'] = 'Не зкарыта';
}
if ($result['status']==1) {
  $class_s="class='shift-opened'";
  $result['status']='открыта';
}
else {
   $result['status']='закрыта';
   $class_s="class='shift-closed'";
}

      echo "<tr>".
             "<td><a href='show_shift_incidents.php?ID=".$result['ID']."' class='link-black text-sm mr-2'><i class='fas fa-share mr-1'></i> Перейти</a> </td>" .
             "<td>{$result['ID']}</td>" .
            "<td><img src='dist/img/".$result_user['ID'].".png' class='user-image' alt='User Image'>".$result_user['first_name']." ".$result_user['last_name']."</td>" .
            "<td>{$result['create_date']}</td>" .
            "<td>{$result['end_date']}</td>" .
            "<td ".$class_s.">{$result['status']}</td>" .
           '</tr> 
           ';
    }
   echo ' </tbody> 
   <tfoot>
      <tr>
        <th>Ссылка</th>
        <th>ID</th>
        <th>Автор смены</th>
        <th>Дата открытия</th>
        <th>Дата закрытия</th>
        <th>Статус</th>
        
      </tr>
   </tfoot>';
              ?>
              
              </table>
 


<?php 
#include ("action_notifications.php");
if (isset($_SESSION['success_action'])) {
echo get_action_notification($_SESSION['success_action']);
}

#if (isset ($_GET['del']) && ($_GET['del']==1)){
?>
<?php
 include ("modal_close_shift.php");
?>


<!--
<a href="#" onclick=" toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')"> qqqq</a>
-->


