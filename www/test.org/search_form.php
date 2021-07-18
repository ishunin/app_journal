 <!-- SEARCH FORM -->
 <?php
  $str = '';
  if (isset($_GET['search_type']) && $_GET['search_type'] == 1) {
    $str = 'checked';
  }
  $str_search = '';
  if (isset($_GET['search']) && !empty($_GET['search'])) {
    $str_search = $_GET['search'];
  }
  ?>
 <form class="form-inline ml-3" method="GET" action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/search.php" style="margin-block-end: 0em;">
   <div class="custom-control custom-checkbox">
     <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="search_type" value="1" <?php echo $str; ?>>
     <label title="Поставьте чекбокс для поиска по инцидентам" for="customCheckbox2" class="custom-control-label"></label>
   </div>
   <div class="input-group input-group-sm">
     <input class="form-control form-control-navbar" maxlength="50" type="search" name="search" placeholder="Поиск ..." aria-label="Поиск" value="<?php echo $str_search; ?>">
     <div class="input-group-append">
       <button class="btn btn-navbar" type="submit">
         <i class="fas fa-search"></i>
       </button>
     </div>
   </div>
 </form>