 <li class="nav-item dropdown">
           <a href="#" class="nav-link" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?php
              if (file_exists($_SERVER['DOCUMENT_ROOT']."/dist/img/".$_COOKIE['id'].".png")) {
                $icon_png = "/dist/img/".$_COOKIE['id'].".png";
                
              }
              else {
                $icon_png = "/dist/img/default.png";
              }
              ?>
              <img src="<?php echo ($icon_png);?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <!-- <span class="hidden-xs">Дмитрий Ишунин</span> -->
            </a>
            
 <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
 
          <a href="<?php $_SERVER['DOCUMENT_ROOT'];?>/profile.php?id=<?php echo($_COOKIE['id']);?>" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">        
              <img src="<?php echo ($icon_png);?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">            
              <div class="media-body">
              
                <h3 class="dropdown-item-title">
                 <?php
                 echo get_user_name_by_id($_COOKIE['id'],$link);
                  ?>
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Дежурный ЭТИ1</p>
                <p class="text-sm" style="color:red; font-weight: 300;">Смена открыта</p>
                <p><?php echo ($examp = date('Y.m.d H:i:s'));?></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Профиль пользователя</p>
                
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          
        
          <div class="dropdown-divider"></div>
     
        <?php  
        if (isset($_COOKIE['permissions']) && $_COOKIE['permissions']==1) {
            echo ' <a href="#" class="dropdown-item dropdown-footer" onclick="showMessage10();">Закончить смену - Выход</a>';
        }
        else {
            echo ' <a href=" /index.php?exit=1" class="dropdown-item dropdown-footer">Выход</a>';
        }
        ?>
         
        </div>
         </li>