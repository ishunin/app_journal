  <?php
  $file = basename($_SERVER['PHP_SELF'], ".php");
  ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php
    #Ссылка лого для всех пользователей
    $a = $_SERVER['DOCUMENT_ROOT'];
    
     $str_link = '<a href="/index.php" class="brand-link">
     <img src="/dist/img/logo.png" alt="ФКУ Налог-Сервис" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text font-weight-light">Дежурные ЭТИ№1</span>
    </a>';

    #Ссылка лого для ОБ
    if (USER_PERMISSIONS==3) {
      $str_link = '<a href="/accounting/ob_dashboard.php" class="brand-link">
      <img src="/dist/img/logo.png" alt="ФКУ Налог-Сервис" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Отдел ОБ</span>
     </a>';
    }
   
 echo $str_link;

    ?>
    
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/dist/img/<?php echo ($_COOKIE['id']); ?>.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php $_SERVER['DOCUMENT_ROOT'];?>/profile.php?id=<?php echo($_COOKIE['id']);?>"" class="d-block">
            <?php
            echo get_user_name_by_id($_COOKIE['id'], $link);
            ?>
          </a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item ">
            <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/index.php" class="nav-link <?php if (USER_PERMISSIONS!=3) {echo 'active';}?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Журнал ЭТИ№1
                
                <?php 
                /*
                //Считаем вколчисетво инцидентов, новостей, заданий
                 $allow=0;
                 $level_access = array (1);
                 $allow = is_allow($_COOKIE['permissions'],$level_access);
                 $count_incidents = get_count_notification_incidents($allow,$link);
                 $count_news = get_count_notification_news($allow,$link);
                 $count_jobs = get_count_notification_jobs($allow,$link);
                 $count_all = $count_incidents + $count_news + $count_jobs;
                 if ($count_incidents>0) {
                  echo '
                  <span class="right badge badge-danger">
                  + '.$count_all.'
                  </span>
                  ';
                }
                */
                ?>
                 
              </p>
            </a>
          </li>

          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview <?php if ($file == 'ob_dashboard' || $file == 'disk_dashboard') {
                                              echo 'menu-open';
                                            } ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Панели
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>\accounting\disk_dashboard.php" class="nav-link  <?php if ($file == 'disk_dashboard') {
                                                                                                                echo 'active';
                                                                                                              } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Учет дисков</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>\accounting\ob_dashboard.php" class="nav-link <?php if ($file == 'ob_dashboard') {
                                                                                                            echo 'active';
                                                                                                          } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Панель ОБ
                  <?php
                  $count_broken_disks = get_count_broken_disk_ob($link_account);
                  if ($count_broken_disks>0) {
                    echo '
                    <span class="right badge badge-danger" style="background-color:#ffc107;">
                    '.$count_broken_disks.'
                    </span>
                    ';
                  }
                  $count_killed_disks =  get_count_killed_disk_ob($link_account);
                  if ($count_killed_disks>0) {
                    echo '
                    <span class="right badge badge-danger" style="right:2.5rem;">
                    '.$count_killed_disks.'
                    </span>
                    ';
                  }
                  ?> 
                  </p>
                </a>
              </li>
            </ul>
          </li>
          

          <li class="nav-item has-treeview <?php if (USER_PERMISSIONS!=3) {echo 'menu-open';}?>">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Заявки
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/shift.php" class="nav-link <?php if ($file == 'shift') {
                                                                                          echo 'active';
                                                                                        } ?>">
                  <i class="fas fa-exchange-alt"></i>
                  <p>Смены</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/incidents.php " class="nav-link <?php if ($file == 'incidents' || $file == 'one_page' || $file == 'show_shift_incidents') {
                                                                                              echo 'active';
                                                                                            } ?>">
                  <i class="fas fa-exclamation-circle"></i>
                  <p>Инциденты
                  <?php 
                  if ($count_incidents>0) {
                    echo '
                    <span class="right badge badge-danger">
                    '.$count_incidents.'
                    </span>
                    ';
                  }
                  ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/news.php" class="nav-link <?php if ($file == 'news' || $file == 'one_page_news') {
                                                                                          echo 'active';
                                                                                        } ?>">
                  <i class="far fa-envelope-open"></i>
                  <p>Новости
                  <?php 
                  if ($count_news>0) {
                    echo '
                    <span class="right badge badge-danger">
                    '.$count_news.'
                    </span>
                    ';
                  }
                  ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/jobs.php" class="nav-link <?php if ($file == 'jobs' || $file == 'one_page_jobs') {
                                                                                          echo 'active';
                                                                                        } ?>">
                  <i class="fas fa-wrench"></i>
                  <p>Задания
                  <?php 
                  $count_jobs = get_count_notification_jobs($allow,$link);
                  if ($count_jobs>0) {
                    echo '
                    <span class="right badge badge-danger">
                    '.$count_jobs.'
                    </span>
                    ';
                  }
                  ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/uploads.php" class="nav-link <?php if ($file == 'uploads') {
                                                                                            echo 'active';
                                                                                          } ?>">
                  <i class="fas fa-file-upload"></i>
                  <p>Загрузки</p>
                </a>
              </li>

            </ul>
          </li>
          <?php
          $c1 = get_notifications_count($link, 1);
          $c2 = get_notifications_count($link, 2);
          $c3 = get_count_notification_jobs($allow,$link);
          $c_all = $c1+ $c2 +$c3;

          ?>
          <li class="nav-item has-treeview <?php echo (is_active($file, 1)); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-bell"></i>
              <p>
                Уведомления
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"><?php echo $c_all; ?></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/incidents_new.php" class="nav-link <?php if ($file == 'incidents_new') {
                                                                                                  echo 'active';
                                                                                                } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Инциденты</p>
                  <span class="badge badge-info right"><?php   echo $c1; ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/news_new.php" class="nav-link <?php if ($file == 'news_new') {
                                                                                              echo 'active';
                                                                                            } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Новости</p>
                  <span class="badge badge-info right"><?php  echo $c2;?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/jobs_new.php" class="nav-link <?php if ($file == 'jobs_new') {
                                                                                              echo 'active';
                                                                                            } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Задания</p>
                  <span class="badge badge-info right"><?php  echo $c3;?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/notifications_new.php" class="nav-link <?php if ($file == 'notifications_new') {
                                                                                                      echo 'active';
                                                                                                    } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Все уведомления</p>
                  <span class="badge badge-info right"><?php  echo ($c_all); ?></span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header "></li>

          <li class="nav-item has-treeview <?php echo (is_active($file, 3)); ?>">
            <a href="#" class="nav-link">
              <i class="far fa-hdd"></i>
              <p>
                Учет дисков
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>

            <ul class="nav nav-treeview ">
              <li class="nav-header ">Номенклатура</li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/overall_disks.php" class="nav-link <?php if ($file == 'overall_disks' || $file == 'one_disk' || $file == 'one_disk_exact' || $file == 'search_disk') {
                                                                                                              echo 'active';
                                                                                                            } ?>">
                  <i class="fas fa-compress-arrows-alt"></i>
                  <p>ZIP</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>
              <li class="nav-header ">Все диски</li>


              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/warehouse_disks_all.php" class="nav-link <?php if ($file == 'warehouse_disks_all') {
                                                                                                                    echo 'active';
                                                                                                                  } ?>">
                  <i class="fas fa-key"></i>
                  <p>На складе (все)</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/warehouse_disks.php" class="nav-link <?php if ($file == 'warehouse_disks') {
                                                                                                                echo 'active';
                                                                                                              } ?>">
                  <i class="fas fa-key"></i>

                  <p>На складе (новые)</p><span class="right badge badge-danger">New</span>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/cod_disks.php" class="nav-link <?php if ($file == 'cod_disks') {
                                                                                                          echo 'active';
                                                                                                        } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>В ЦОДe (в работе)</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/warehouse_broken_disks.php" class="nav-link <?php if ($file == 'warehouse_broken_disks') {
                                                                                                                      echo 'active';
                                                                                                                    } ?>">
                  <i class="fas fa-skull-crossbones"></i>
                  <p>На складе (broken)
                  <?php 
                  $count_broken_disks = get_count_broken_disk_storage($link_account);
                  if ($count_broken_disks>0) {
                    echo '
                    <span class="right badge badge-danger" style="background-color:#ffc107;">
                    '.$count_broken_disks.'
                    </span>
                    ';
                  }
                  
                  $count_killed_disks =  get_count_killed_disk_storage($link_account);
                  if ($count_killed_disks>0) {
                    echo '
                    <span class="right badge badge-danger" style="right:2.5rem;">
                    '.$count_killed_disks.'
                    </span>
                    ';
                  }
                  ?>
                  </p>


                
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/security_disks.php" class="nav-link <?php if ($file == 'security_disks') {
                                                                                                              echo 'active';
                                                                                                            } ?>">
                  <i class="fas fa-shield-alt"></i>
                  <p>В ОБ
                  <?php
                  $count_broken_disks = get_count_broken_disk_ob($link_account);
                  if ($count_broken_disks>0) {
                    echo '
                    <span class="right badge badge-danger" style="background-color:#ffc107;">
                    '.$count_broken_disks.'
                    </span>
                    ';
                  }
                  $count_killed_disks =  get_count_killed_disk_ob($link_account);
                  if ($count_killed_disks>0) {
                    echo '
                    <span class="right badge badge-danger" style="right:2.5rem;" >
                    '.$count_killed_disks.'
                    </span>
                    ';
                  }
                  ?> 
                  </p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/ibs_disks.php" class="nav-link <?php if ($file == 'ibs_disks') {
                                                                                                          echo 'active';
                                                                                                        } ?>">
                  <i class="fas fa-cloud"></i>
                  <p>В IBS</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/forgiven_disks.php" class="nav-link <?php if ($file == 'forgiven_disks') {
                                                                                                          echo 'active';
                                                                                                        } ?>">
                  <i class="fas fa-cloud"></i>
                  <p>Списаны</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-header ">Операции по дискам</li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/all_disks_operations.php" class="nav-link <?php if ($file == 'all_disks_operations') {
                                                                                                                    echo 'active';
                                                                                                                  } ?>">
                  <i class="fas fa-arrows-alt-v"></i>
                  <p>Все операции</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/push_disks.php" class="nav-link <?php if ($file == 'push_disks') {
                                                                                                          echo 'active';
                                                                                                        } ?>">
                  <i class="fas fa-arrow-up"></i>
                  <p>Приход</p>
                  <span class="badge badge-info right"><?php //echo (get_notifications_count_disk_plus($link_account, 2)); 
                                                        ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/accounting/pull_disks.php" class="nav-link <?php if ($file == 'pull_disks') {
                                                                                                          echo 'active';
                                                                                                        } ?>">
                  <i class="fas fa-arrow-down"></i>
                  <p>Расход</p>
                  <span class="badge badge-info right"></span>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-header ">Другое</li>
          <!-- пока не решил как использовать       
          
          <li class="nav-item has-treeview <?php echo (is_active($file, 1)); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
          
              <p>
                Дополнительно
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="empty_page.php" class="nav-link <?php if ($file == 'empty_page') {
                                                            echo 'active';
                                                          } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Вариант 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="empty_page.php" class="nav-link <?php if ($file == 'empty_page') {
                                                            echo 'active';
                                                          } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Вариант 1</p>
                </a>
              </li>
            </ul>
          </li>
     -->
          <li class="nav-item has-treeview <?php echo (is_active($file, 2)); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie "></i>
              <p>
                Отчеты
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/report4.php" class="nav-link <?php if ($file == 'report4') {
                                                                                            echo 'active';
                                                                                          } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Отчет за смену тек.</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/report2.php" class="nav-link <?php if ($file == 'report2') {
                                                                                            echo 'active';
                                                                                          } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Отчет за смену пред. </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/report1.php" class="nav-link <?php if ($file == 'report1') {
                                                                                            echo 'active';
                                                                                          } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Отчет - Все диски</p>
                </a>
              </li>
              


            </ul>
          </li>

          <li class="nav-item">
            <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/sceduler.php" class="nav-link <?php if ($file == 'sceduler') {
                                                                                          echo 'active';
                                                                                        } ?>">
              <i class="far fa-calendar-alt"></i>
              <p>
                График
              </p>
            </a>

          </li>

          <li class="nav-header">Документация</li>
          <li class="nav-item">
            <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/doc.php" class="nav-link <?php if ($file == 'doc') {
                                                                                    echo 'active';
                                                                                  } ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>Документация v.1</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>