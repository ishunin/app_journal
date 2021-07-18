<?php
require 'jira/vendor/autoload.php';

use JiraRestApi\Field\Field;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;
$report_user_id = $shif_info['id_user'];
$report_user_login = @get_user_login_by_id($report_user_id,$link);
$report_create_shift =  $shif_info['create_date'];
$report_end_shift =  $shif_info['end_date'];

$report_create_shift = date_create_from_format('Y-m-d H:i:s', $report_create_shift);
$report_create_shift_jira_fromat =  date_format($report_create_shift, 'Y-m-d H:i');

$report_end_shift = date_create_from_format('Y-m-d H:i:s', $report_end_shift);
$report_end_shift_jira_fromat =  date_format($report_end_shift, 'Y-m-d H:i');

$jql = "created >=  '$report_create_shift_jira_fromat' AND created <= '$report_end_shift_jira_fromat' AND reporter in ($report_user_login) AND issuetype != '10311' ORDER BY created DESC";
//$jql = "created >=  '$report_create_shift_jira_fromat' AND created <= '$report_end_shift_jira_fromat' AND reporter in ($report_user_login) AND issuetype != '10311' ORDER BY created DESC";


try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
    // do something with fetched data
  $i=0;
//echo $report_create_shift_jira_fromat;
//echo $report_end_shift_jira_fromat;
//key = INM-48578 AND created > '2020/12/05 11:00' AND  created <  '2020/12/05 10:00'
	echo '
	<table class="table table-bordered table-striped table_inc_class dataTable dtr-inline collapsed">
		<tbody>';
		foreach ($ret->issues as $issue) {
      //var_dump($issue);
      $priority = $issue->fields->priority->id;
			// print (sprintf("%s %s \n", $issue->key, $issue->fields->summary));
			echo '
			<tr class="'.get_jira_issue_class_priority($priority).'">
				<td><a class="link-black" style="color:white;" href="https://servicedesk:8443/browse/'.$issue->key.'" target="_blank" > '.sprintf("%s \n",$issue->key).'</a></td>
        <td>'.$issue->fields->summary.'</td>
			</tr>
			';
			$i++;	
		}
		if ($i==0) {
			echo '
			<tr>
			<td colspan="2" style="text-align:center;">Нет записей для отображения</td>
			</tr>';
		}
		echo '
		</tbody>
	</table>';

} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
	echo "Ошибка. Возможно Jira недоступна?";
}




?>


                   