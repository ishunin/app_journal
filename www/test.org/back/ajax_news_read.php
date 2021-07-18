
<script>
  $(function () {
    // Summernote
    $("#textarea2").summernote();
     $("#textarea3").summernote();
  })
</script>

 <!-- Для валидации -->


  <?php
  include("func.php");
  if (!isset($_GET['page_back'])) {
  $_GET['page_back']=0;
}

include ("scripts/conf.php");

if (!isset($_GET['page']) || empty($_GET['page'])){
$page = 1;
}
else {
  $page = $_GET['page'];
}

if (isset($_GET['red_id'])) {
    $sql = mysqli_query($link, 'SELECT `ID`, `theme`, `description`,`content`, `id_user`,`status`, `importance`,
    `keep`, `Create_date`,`importance`,`keep`,`create_date`,`edit_date`, `type`  FROM `news` WHERE `ID`='.$_GET['red_id']);
    $result = mysqli_fetch_array($sql);
    $create_date=$result['create_date'];
    $id_user=$result['id_user'];

 $sql = mysqli_query($link, 'SELECT `first_name`, `last_name`  FROM `users` WHERE `ID`='.$id_user);
 $result_user= mysqli_fetch_array($sql);    
 #
echo '
<div class="modal-header">
                <h4 class="modal-title">Просмотр новости</h4> 
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
            
<blockquote class="quote-secondary" style="margin-top: 0px;">
              <small>Новость опубликована: '.$create_date.'</small></br>
              <small>Автор новости: '.$result_user['first_name'].' '.$result_user['last_name'].'</small></br>
              <small>Важность: '.get_importance($result['importance']).'</small></br>
              <small>Статус: '.get_status_news($result['status']).'</small></br>
              <small>Тип: '.get_type($result['type']).'</small></br>
              <small>Закреплено: '.is_keep($result['keep']).'</small></br>
           </blockquote>';    
$output = '
   <h3>'.$result['theme'].'</h3>
 <p> '.$result['content'].'</p>  
          
</div>';



           echo $output;

echo '

        


            <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Дополнительная панель:
            </h3>
          </div>
          <div class="card-body">
          <!--  <h4>Custom Content Below</h4>-->
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 20px";>
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Комментарии</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Изменения</a>
              </li>
 
            </ul>
<!--
            <div class="tab-custom-content">
              <p class="lead mb-0">Custom Content goes here</p>
            </div>

 -->   



       

            <div class="tab-content" id="custom-content-below-tabContent">
              <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row" style="margin-bottom:10px;">

                <div class="col-12" >

                <div >  
               
';


#echo $_GET['id_rec'];
$sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_user`, `content`,`create_date` FROM `comments` 
WHERE `id_rec`="'.$result['ID'].'"
  '); 
$count=0;
 while ($result2 = mysqli_fetch_array($sql)) {
  $count++;
      $sql_user = mysqli_query($link, "SELECT `ID`,`first_name`, `last_name` FROM `users` WHERE `ID`=".$result['id_user']."");
      $result_user = mysqli_fetch_array($sql_user);  

echo '
 <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.get_user_icon($result_user['ID'],$link).'" alt="user image">
                        <span class="username">
                          <a href="#">'.$result_user['first_name'].' '.$result_user['last_name'].'</a>
                        </span>
                        <span class="description">Опубликовано21231- '.$result2['create_date'].'</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$result2['content'].'
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Прикрепленный файл</a>
                      </p>
                    </div>

';
 }

 if ($count==0) {
  echo '
                <blockquote class="quote-secondary">
                  <p>Информация:</p>
                  <small>Для данного инцидента еще никто не оставил комментария.</small>
                </blockquote>
  ';
 }  



echo'
               </div>
               </div> 
              </div>
              </div>
              <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                Данный раздел в процессе разработки.
              
              </div>
              
            </div>
            
            
 
<a href="one_page_news.php?ID='.$result['ID'].'#comment">Оставить комментарий</a>         
          </div>
          <!-- /.card -->
        ';


 echo'
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
<a class="btn btn-default" href="one_page_news_print.php?ID='.$result['ID'].'"> <i class="fas fa-print"></i> Печать</a>
</div>       
           ';
}
 #<input type="text" name="Content" size="50" value="'.$product['Content'].'">



#блок коментариев

?> 
