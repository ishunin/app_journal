<?php
if (isset ($_SESSION['del']) && ($_SESSION['del']==1)){
echo '
<script type="text/javascript">
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Запись удачно удалена...`)
});
</script>
';
unset($_SESSION['del']);
}

if (isset ($_SESSION['edit']) && ($_SESSION['edit']==1)){
echo '
<script type="text/javascript">
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Запись удачно отредактирована...`)
});
</script>
';
unset($_SESSION['del']);
}

if (isset ($_SESSION['create']) && ($_SESSION['create']==1)){
echo '
<script type="text/javascript">
$(document).ready(function() {
//Здесь функция function DleTrackDownload
 toastr.success(`Запись удачно создана...`)
});
</script>
';
unset($_SESSION['del']);
}
