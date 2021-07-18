<?php
require 'jira/vendor/autoload.php';

use JiraRestApi\Field\Field;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;

//$jql = 'project = INM AND issuetype = Incident AND status in (Зарегистрировано, Ожидание, "В работе", Уточнение, "На исполнение", "Внешняя линия", "Передать на внешнюю линию", "Ожидает уточнения", "На согласовании с ОБ", "Закрыть на внешней линии", "Уточнение на СТП", "Закрыть на СТП") AND text ~ Teradata AND INM-ERROR = Аппаратно-программные AND INM-ERROR-APP_PROVISION = Аппаратное ';
$jql = 'project = INM AND issuetype = Incident AND status in (Зарегистрировано, Ожидание, "В работе", Уточнение, "На исполнение", "Внешняя линия", "Передать на внешнюю линию", "На согласовании с ОБ", "Закрыть на внешней линии") AND INM-ERROR = "Систем мониторинга" AND reporter in (duty_it, currentUser(), membersOf("Администраторы серверного оборудования"), pserver_admins)';

try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql);
    // do something with fetched data
	$i=0;
	echo '
	<table class="table table-bordered table-striped table_inc_class dataTable dtr-inline collapsed">
		<tbody>';
		foreach ($ret->issues as $issue) {
			//var_dump($issue);
			// print (sprintf("%s %s \n", $issue->key, $issue->fields->summary));
			echo '
			<tr>
				<td><a href="https://servicedesk:8443/browse/'.$issue->key.'" target="_blank"> '.sprintf("%s \n",$issue->key).'</a></td>
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
	$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
}




?>


                   