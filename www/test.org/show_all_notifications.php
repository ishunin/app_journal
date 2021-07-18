<?php
$count_all = $count_incidents+$count_news+$count_jobs+$count_disks;
echo '
<a class="nav-link" data-toggle="dropdown" href="#">
<i class="far fa-bell"></i>
<span class="badge badge-warning navbar-badge">'.$count_all.'</span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<span class="dropdown-item dropdown-header">'.$count_all.' Уведомлений</span>
<a href=" /accounting/push_disks.php" class="dropdown-item">
<i class="far fa-hdd"></i> '.$count_disks.' новых поступлений
</a> 
<a href=" /incidents_new.php" class="dropdown-item">
<i class="fas fa-exclamation-circle"></i> '.$count_incidents.' новых инцидентов
</a>
<a href=" /news_new.php" class="dropdown-item">
<i class="far fa-envelope-open"></i> '.$count_news.' новости
</a>
<a href=" /jobs_new.php" class="dropdown-item">
<i class="fas fa-wrench"></i> '.$count_jobs.' новых задания
</a>
<div class="dropdown-divider"></div>
<a href=" /notifications_new.php" class="dropdown-item dropdown-footer">Смотреть все уведомления</a>
</div>
';
?>
