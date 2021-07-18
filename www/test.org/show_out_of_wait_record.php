<?php
//всего записей вышло из ожидания
$count_wait_record = 0;
    $str = '
    <div class="card blink">
    <div class="card-header">
    <h3 class="card-title area">
        <i class="fas fa-pause"></i> Вышли из ожидания инциденты
    </h3>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
    </div>
    <div class="card-body" style="padding:0px;" id="blink6">
    ';
    $id_shift = get_last_shift_id($link);
    $sql = mysqli_query($link, 'SELECT `ID`, `id_rec`, `id_shift`,`jira_num`, `content`,`action`, `id_user`,
  `destination`, `status`,`importance`,`type`,`keep`,`create_date`,`edit_date`,`delay_date`  FROM `list` WHERE  `status`=2 AND `id_shift`=' . $id_shift . ' AND `deleted`=0 AND NOW() > `delay_date`  ORDER BY create_date DESC');
    echo '<tbody>';
    while ($result = mysqli_fetch_array($sql)) {
        // while (1==2) {
        $count_wait_record++;
        $sql_user = mysqli_query($link, "SELECT `first_name`, `last_name` FROM `users` WHERE `ID`=" . $result['id_user'] . "");
        $result_user = mysqli_fetch_array($sql_user);
        $opacity = '';
        if ($result['status'] == 3 || $result['status'] == 4) {
            $opacity = 'div-opacity';
        }
        $content = mb_substr(strip_tags_smart($result['content']), 0, 500) . ' ...';
        $jira_num = strip_tags($result['jira_num']);
        ($jira_num != '') ?: $jira_num = 'б/н';
        $uploads = show_upload_files($link, $result['id_rec'], 3, 'index.php',1);
        $type = $result['type'];
        $note = '';
        if ($type == 2) {
            $note = '<span class="badge badge-info right">NOTE</span>';
        }
        $str .= '
<div id="blink7">
 <div class="alert ' . get_class_for_div($result['importance']) . ' ' . $opacity . '" style="margin-bottom:0px;" >
    <div class="ribbon-wrapper">
     <div class="ribbon bg-primary">
     <small>' . get_status_for_ribbons($result['status']) . '</small>
     </div>
  </div>
    <h5><i class="icon fas fa-info"></i> <a class="link-black" target="_blank" href="https://servicedesk:8443/browse/' . $jira_num . '">' . $jira_num . '</a></h5>
    <p style="margin-bottom:0px;">' . $note . ' ' . $content . ' </p>
    ' . $uploads . '
     <div style="display:inline;"><small><a href="one_page.php?ID=' . $result['ID'] . '"><i class="fas fa-share mr-1"></i>Перейти</a></small></div>
     <div style="text-align:right;display:inline;float:right;">
     <small>' . $result_user['first_name'] . ' ' . $result_user['last_name'] . ' в ' . $result['create_date'] . '</small>
     </div>
  </div>
</div>
 ';
    }
    $str .= '
</div>
<!-- /.card-body -->
<div class="card-footer">
  <small>Вышли из ожидания  ' . ($count_wait_record) . ' записей' . '</small>
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
';

if ($count_wait_record == 0){
    $str = '';
}

echo $str;
 /*else {
    echo '
    <div class="card">
    <div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-paperclip"></i> Вышли из ожидания
    </h3>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
    </div>
    <div class="card-body" >
    Нет инциндентов вышедших из ожидания
    </div>
<!-- /.card-body -->
<div class="card-footer">
  <small>Вышли из ожидания  ' . ($count_wait_record) . ' записей' . '</small>
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
    ';
}
*/