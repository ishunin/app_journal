<?php
date_default_timezone_set("Europe/Moscow");
require 'jira/vendor/autoload.php';
use JiraRestApi\Field\Field;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;

$id_shift =  get_last_shift_id($link);
$data2 = mysqli_fetch_assoc(mysqli_query($link, "SELECT *  FROM `shift` WHERE `ID`=$id_shift"));
if ($data2) {
  $id_user =   $data2['id_user'];
  $report_user_login = get_user_login_by_id($id_user,$link);
  $report_create_shift = $data2['create_date'];
  $report_end_shift =  date("Y-m-d H:i:s"); 
  $report_create_shift = date_create_from_format('Y-m-d H:i:s', $report_create_shift);
$report_create_shift_jira_fromat =  date_format($report_create_shift, 'Y-m-d H:i');
$report_end_shift = date_create_from_format('Y-m-d H:i:s', $report_end_shift);
$report_end_shift_jira_fromat =  date_format($report_end_shift, 'Y-m-d H:i');
/*
echo 'Юзер id'.$report_user_login.'<br>';
echo 'Юзер'.$report_user_id.'<br>';
echo $report_create_shift_jira_fromat.'<br>';
echo $report_end_shift_jira_fromat.'<br>';

exit();
*/
# report_all_incidents###########################################################################
$id_group = 1;
$jql = 'project = INM AND issuetype = Incident AND status in (Зарегистрировано, Ожидание, "В работе", Уточнение, "На исполнение", "Внешняя линия", "Передать на внешнюю линию", "На согласовании с ОБ", "Закрыть на внешней линии") AND INM-ERROR = "Систем мониторинга" AND reporter in (duty_it, currentUser(), membersOf("Администраторы серверного оборудования"), pserver_admins)';
try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
		foreach ($ret->issues as $issue) {
            (isset($issue->fields->priority->id) && !empty($issue->fields->priority->id)) ?  $priority = $issue->fields->priority->id : $priority = 0;
            (isset($issue->key) && !empty($issue->key)) ?  $jira_num = $issue->key : $jira_num = '-';
            (isset($issue->fields->summary) && !empty($issue->fields->summary)) ?  $topic = $issue->fields->summary : $topic = '-';
            
            #Добавление информации в БД отчетов
            $sql1 = mysqli_query($link, "INSERT INTO `report_shift` (`id_shift`,`jira_num`,`topic`,`priority`,`id_group`,`id_user`) VALUES ($id_shift,'$jira_num','$topic',$priority,$id_group,$id_user)");
            if (!$sql1) {
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                exit(); 
            }
		}
} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
    echo "Ошибка. Возможно Jira лежит?";
    exit();
}
#КОНЕЦ report_all_incidents###########################################################################

# report_complete################################################################################
$id_group = 2;
$jql = "(status changed from 'В работе' to 'Выполнено' AND resolved >=  '$report_create_shift_jira_fromat' AND resolved <= '$report_end_shift_jira_fromat') AND assignee in ($report_user_login) AND issuetype != '10311' ORDER BY created DESC";
try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
		foreach ($ret->issues as $issue) {
            (isset($issue->fields->priority->id) && !empty($issue->fields->priority->id)) ?  $priority = $issue->fields->priority->id : $priority = 0;
            (isset($issue->key) && !empty($issue->key)) ?  $jira_num = $issue->key : $jira_num = '-';
            (isset($issue->fields->summary) && !empty($issue->fields->summary)) ?  $topic = $issue->fields->summary : $topic = '-';
            
            $sql1 = mysqli_query($link, "INSERT INTO `report_shift` (`id_shift`,`jira_num`,`topic`,`priority`,`id_group`,`id_user`) VALUES ($id_shift,'$jira_num','$topic',$priority,$id_group,$id_user)");
            if (!$sql1) {
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                exit(); 
            }
		}
} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
    echo "Ошибка. Возможно Jira лежит?";
    exit();
}
#КОНЕЦ report_all_incidents###########################################################################

# report_create################################################################################
$id_group = 3;
$jql = "created >=  '$report_create_shift_jira_fromat' AND created <= '$report_end_shift_jira_fromat' AND reporter in ($report_user_login) AND issuetype != '10311' ORDER BY created DESC";
try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
		foreach ($ret->issues as $issue) {
            (isset($issue->fields->priority->id) && !empty($issue->fields->priority->id)) ?  $priority = $issue->fields->priority->id : $priority = 0;
            (isset($issue->key) && !empty($issue->key)) ?  $jira_num = $issue->key : $jira_num = '-';
            (isset($issue->fields->summary) && !empty($issue->fields->summary)) ?  $topic = $issue->fields->summary : $topic = '-';
            
            $sql1 = mysqli_query($link, "INSERT INTO `report_shift` (`id_shift`,`jira_num`,`topic`,`priority`,`id_group`,`id_user`) VALUES ($id_shift,'$jira_num','$topic',$priority,$id_group,$id_user)");
            if (!$sql1) {
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                exit(); 
            }
		}
} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
    echo "Ошибка. Возможно Jira лежит?";
    exit();
}
#КОНЕЦ report_all_incidents###########################################################################

# report_equipment_closed################################################################################
$id_group = 4;
$jql = "project = INM AND issuetype = Incident AND status changed from 'Выполнено' to 'Закрыто'  AND updated >=  '$report_create_shift_jira_fromat' AND updated <= '$report_end_shift_jira_fromat' AND assignee in ($report_user_login) AND INM-ERROR = Аппаратно-программные AND SELECT-REGION-MULTI = Москва";
try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
		foreach ($ret->issues as $issue) {
            (isset($issue->fields->priority->id) && !empty($issue->fields->priority->id)) ?  $priority = $issue->fields->priority->id : $priority = 0;
            (isset($issue->key) && !empty($issue->key)) ?  $jira_num = $issue->key : $jira_num = '-';
            (isset($issue->fields->summary) && !empty($issue->fields->summary)) ?  $topic = $issue->fields->summary : $topic = '-';
            
            $sql1 = mysqli_query($link, "INSERT INTO `report_shift` (`id_shift`,`jira_num`,`topic`,`priority`,`id_group`,`id_user`) VALUES ($id_shift,'$jira_num','$topic',$priority,$id_group,$id_user)");
            if (!$sql1) {
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                exit(); 
            }
		}
} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
    echo "Ошибка. Возможно Jira лежит?";
    exit();
}
#КОНЕЦ report_all_incidents###########################################################################

# report_equipment_to################################################################################
$id_group = 5;
$jql = 'project = INM AND issuetype = Incident AND status = "Внешняя линия" AND INM-ERROR = Аппаратно-программные AND SELECT-REGION-MULTI = Москва AND assignee in (duty_it, currentUser())';
try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
		foreach ($ret->issues as $issue) {
            (isset($issue->fields->priority->id) && !empty($issue->fields->priority->id)) ?  $priority = $issue->fields->priority->id : $priority = 0;
            (isset($issue->key) && !empty($issue->key)) ?  $jira_num = $issue->key : $jira_num = '-';
            (isset($issue->fields->summary) && !empty($issue->fields->summary)) ?  $topic = $issue->fields->summary : $topic = '-';
            
            $sql1 = mysqli_query($link, "INSERT INTO `report_shift` (`id_shift`,`jira_num`,`topic`,`priority`,`id_group`,`id_user`) VALUES ($id_shift,'$jira_num','$topic',$priority,$id_group,$id_user)");
            if (!$sql1) {
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                exit(); 
            }
		}
} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
    echo "Ошибка. Возможно Jira лежит?";
    exit();
}
#КОНЕЦ report_equipment_to###########################################################################

# report_equipment################################################################################
$id_group = 6;
$jql = 'project = INM AND issuetype = Incident AND status in (Зарегистрировано, Ожидание, "В работе", Уточнение, "На исполнение", Отклонено, "Внешняя линия", "Передать на внешнюю линию", "Ожидает уточнения", "На согласовании с ОБ", "Уточнение на СТП") AND INM-ERROR = Аппаратно-программные AND SELECT-REGION-MULTI = Москва AND assignee in (duty_it, currentUser())';
try {
    $issueService = new IssueService();
    $ret = $issueService->search($jql,0,100);
		foreach ($ret->issues as $issue) {
            (isset($issue->fields->priority->id) && !empty($issue->fields->priority->id)) ?  $priority = $issue->fields->priority->id : $priority = 0;
            (isset($issue->key) && !empty($issue->key)) ?  $jira_num = $issue->key : $jira_num = '-';
            (isset($issue->fields->summary) && !empty($issue->fields->summary)) ?  $topic = $issue->fields->summary : $topic = '-';
            
            $sql1 = mysqli_query($link, "INSERT INTO `report_shift` (`id_shift`,`jira_num`,`topic`,`priority`,`id_group`,`id_user`) VALUES ($id_shift,'$jira_num','$topic',$priority,$id_group,$id_user)");
            if (!$sql1) {
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                exit(); 
            }
		}
} catch (JiraRestApi\JiraException $e) {
	//$this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());    
    echo "Ошибка. Возможно Jira лежит?";
    exit();
}
#КОНЕЦ report_equipment###########################################################################


} 




  ?>