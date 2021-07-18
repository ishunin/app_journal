<?php
require 'vendor/autoload.php';

use JiraRestApi\Field\Field;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;

//$jql = 'project = INM AND issuetype = Incident AND status in (Зарегистрировано, Ожидание, "В работе", Уточнение, "На исполнение", "Внешняя линия", "Передать на внешнюю линию", "Ожидает уточнения", "На согласовании с ОБ", "Закрыть на внешней линии", "Уточнение на СТП", "Закрыть на СТП") AND text ~ Teradata AND INM-ERROR = Аппаратно-программные AND INM-ERROR-APP_PROVISION = Аппаратное ';
$jql = 'project = INM AND issuetype = Incident AND status in (Зарегистрировано, Ожидание, "В работе", Уточнение, "На исполнение", "Внешняя линия", "Передать на внешнюю линию", "На согласовании с ОБ", "Закрыть на внешней линии") AND INM-ERROR = "Систем мониторинга" AND reporter in (duty_it, currentUser(), membersOf("Администраторы серверного оборудования"), pserver_admins)';


try {
    $issueService = new IssueService();

    $ret = $issueService->search($jql);
    //var_dump($ret);
    // do something with fetched data

   // var_dump($ret);

    foreach ($ret->issues as $issue) {
        var_dump($issue);
        //print (sprintf("%s %s \n", $issue->key,  $issue->fields->summary, $issue->id->displ));
        //exit();
        print (sprintf("%s %s \n", $issue->key, $issue->fields->summary));
        echo '<br>';
    }

} catch (JiraRestApi\JiraException $e) {
    $this->assertTrue(false, 'testSearch Failed : '.$e->getMessage());
    
}


?>