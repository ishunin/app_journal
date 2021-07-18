<?php
error_reporting(~E_ALL);
include_once('simple_html_dom.php');
$username = "erp";
$password = "P@ssw0rd";
$baseurl = "https://servicedesk:8443";
//Функция запроса фильтра по ID
function get_filter_name($id,$url){
	global $username;
	global $password;
	global $baseurl;
	if ($url == '1') {$curl = $baseurl;}
	else {$curl = $baseurl_archive;}
	$url = "$curl/rest/api/2/filter/$id";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	$curlinfo = curl_getinfo($curl);
	$httpcode = $curlinfo["http_code"];
	if(curl_exec($curl) === false) {
		$filter['Error'] = curl_error($curl);
	} else {
		$filter_json = curl_exec($curl);
		if ($filter_json == '') {
			curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_HEADER, 1);
			$curlinfo = curl_getinfo($curl);
			if ($curlinfo['http_code'] == '503') {
				$filter['Error'] = 'Jira еще пытается запуститься';
				return $filter;
			}
			$filter_json = curl_exec($curl);
			var_dump($filter_json);
			if (strpos($filter_json,'HTTP/1.1 503')) {
				$filter['Error'] = curl_error($curl);
				return $filter;
			}
		}
		$filter = json_decode($filter_json,true);
	}
	curl_close($curl);
	return $filter;
}

function millsToPrintTime($val, $type) {
	global $issue;
	switch ($type) {
		case 'Jira': {
			$val = $issue['fields'][$val]['ongoingCycle']['remainingTime']['millis'];
			break;
		}
		default: {
			break;
		}
	}
	$hours = floor($val/3600000);
	$mins = round(($val - $hours * 3600000)/60000);
	$Time['print'] = $hours.":".str_pad($mins,2,"0",STR_PAD_LEFT);
	$Time['status'] = null;
	if ($val > 0) {
		if ($val < 60000) { //1 min
			$Time['status'] = '1';
		} elseif ($val < 120000) { //2 min
			$Time['status'] = '2';
		} elseif ($val < 180000) { //3 min
			$Time['status'] = '3';
		} elseif ($val < 300000) { //5 min
			$Time['status'] = '5';
		} elseif ($val < 420000) { //7 min
			$Time['status'] = '7';
		} elseif ($val < 600000) { //10 min
			$Time['status'] = '10';
		}
	}
	$Time['status'] = '2';
	return $Time;
}

//Функция запроса заявок по фильтру
function get_filter_issues($filter){
	global $username;
	global $password;
	global $baseurl;
	$url = $filter['searchUrl'];
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	$issues_json = (curl_exec($curl));
	$issues = json_decode($issues_json,true);
	curl_close($curl);
	return $issues['issues'];
}

function get_issue($issue, $inwork) {
	global $baseurl;
	$iss['Key'] = $issue['key'];
	$iss['Assignee'] = $issue['fields']['assignee']['displayName'];
	$iss['Reporter'] = $issue['fields']['reporter']['displayName'];
	$iss['Status'] = $issue['fields']['status']['name'];
	$iss['StatusID'] = intval($issue['fields']['status']['id']);
	$iss['Reporter'] = $issue['fields']['reporter']['displayName'];
	$iss['Priority'] = intval($issue['fields']['priority']['id']);
	$iss['Theme'] = $issue['fields']['summary'];
	if ($inwork > 0) {
		switch ($iss['Status']) {
			case 'На согласовании':
			case 'Согласование реализации': {
				$iss['SLA'] = millsToPrintTime("customfield_11204", "Jira");
				break;
			}
			case 'Уточнение': {
				$iss['SLA'] = millsToPrintTime("customfield_11200", "Jira");
				break;
			}
			case 'Анализ': {
				$iss['SLA'] = millsToPrintTime("customfield_11205", "Jira");
				break;
			}
			case 'На исполнение': {
				$iss['SLA'] = millsToPrintTime("customfield_10334", "Jira");
				break;
			}
			case 'Зарегистрировано':
			case 'Принятие в работу': {
				$iss['SLA'] = millsToPrintTime("customfield_10802", "Jira");
				break;
			}
			default: {
				$iss['SLA'] = millsToPrintTime("customfield_11202", "Jira");
				break;
			}
		}
	} else {
		switch ($iss['Status']) {
			case 'Зарегистрировано':
			case 'Принятие в работу': {
				$iss['SLA'] = millsToPrintTime("customfield_10802", "Jira");
				break;
			}
			case 'Уточнение': {
				$iss['SLA'] = millsToPrintTime("customfield_11200", "Jira");
				break;
			}
			case 'На исполнение': {
				if (($issue['fields']["customfield_10334"]['ongoingCycle']['remainingTime']['millis'] == 0) and ($issue['fields']["customfield_11202"]['ongoingCycle']['remainingTime']['millis'] !=0)) {
					$iss['SLA'] = millsToPrintTime("customfield_11202", "Jira");
				} else {
					$iss['SLA'] = millsToPrintTime("customfield_10334", "Jira");
				}
				break;
			}
			case 'На согласовании':
			case 'Согласование реализации': {
				$iss['SLA'] = millsToPrintTime("customfield_11204", "Jira");
				break;
			}
			case 'Анализ': {
				$iss['SLA'] = millsToPrintTime("customfield_11205", "Jira");
				break;
			}
			default: {
				$iss['SLA'] = millsToPrintTime("customfield_11202", "Jira");
				break;
			}
		}
	
	}
	switch ($iss['Priority']) {
		case 1: {
			$iss['Style'] = 'highlight_sla_r';
			$iss['Prio'] = 'red';
			break;
		};
		case 2: {
			$iss['Style'] = 'highlight_sla_r';
			$iss['Prio'] = 'red';
			break;
		};
		case 3: {
			$iss['Style'] = 'highlight_sla_y';
			$iss['Prio'] = 'yellow';
			break;
		};
		case 4: {
			$iss['Style'] = 'highlight_sla_y';
			$iss['Prio'] = 'yellow';
			break;
		};
		case 10001: {
			$iss['Style'] = 'highlight_sla_g';
			$iss['Prio'] = 'green';
			break;
		};
		default: {
			$iss['Style'] = 'highlight_sla_g';
			$iss['Prio'] = 'green';
			break;
		}
	}
	$iss['href'] = $baseurl.'/browse/'.$iss['Key'];
	return $iss;
}
	
	$htable=array();
	$hbody=array();
	if (($handle = fopen("config.csv", "r")) !== FALSE) {
		$filters = array();
		$i = 0;
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$filters['ID'][$i] = $data[0];
			$filters['filterID'][$i] = $data[2];
			$i++;
		}
		fclose($handle);
	}
	$key = array_search($_REQUEST['load'], $filters['ID']);
	$filter = get_filter_name($filters['filterID'][$key],'1');
	
if (isset($filter['Error'])) {
	$card = '
		<div class="card highlight_sla_r" id="jira_nah'.$_REQUEST['load'].'">
			<div class="code"><img src="images/jira_oops.png" style="height:150px; margin: 0 auto;"></div>
				<div class="main"><img src="images/jira_oops.png" style="height:150px; display:inline;">Jira Ooops!!!! --*-- '.$filter['Error'].' --*-- </div>
				<div class="assignee">Кому: --*--</div>
				<div class="author">От: --*--</div>
				<div class="status">--*--</div>
				<div class="sla">--*--</div>
			</div>';
	$data['ID'][0]['ID'] = 'jira_nah'.$_REQUEST['load'];
	$data['Card']['jira_nah'.$_REQUEST['load']] = $card;
	$data['Priority']['jira_nah'.$_REQUEST['load']] = 'red';
} else {
	$issues = get_filter_issues($filter);
	$i = 0;
	foreach ($issues as $issue) {
		$iss = get_issue($issue,0);
		$card = '
		<div class="card  '.$iss['Style'];
		if (!is_null($iss['SLA']['status'])) {
			$card .= ' pulse';
		}
		$card .= '" id="'.$iss['Key'].'">
			<div class="code">'.$iss['Key'].'</div>';
		if (strpos($_SESSION['username'],'_') === false) {
			$card .= '<a href="'.$iss['href'].'" target="_blank" title="Просмотреть в СОО" class="main">';
		} else {
			$card .= '<div class="main">';
		}
		$card .= $iss['Theme'];
		if (strpos($_SESSION['username'],'_') === false) {
			$card .= '</a>';
		} else {
			$card .= '</div>';
		}
		$card .= '
			<div class="assignee">Кому: '.$iss['Assignee'].'</div>
			<div class="author">От: '.$iss['Reporter'].'</div>
			<div class="status">'.$iss['Status'].'</div>
			<div class="sla">'.$iss['SLA']['print'].'</div>';
		$card .= '</div>';
		$data['ID'][$i]['ID'] = $iss['Key'];
		$data['Card'][$iss['Key']] = $card;
		$data['Priority'][$iss['Key']] = $iss['Prio'];
		$data['SLAcheck'][$iss['Key']] = $iss['SLA']['status'];
		$i++;
	}
}
$out = json_encode(array('count' => count($data['ID']), 'result' => $data['ID'], 'cards' => $data['Card'], 'priority' => $data['Priority'], 'SLAcheck' => min($data['SLAcheck'])));
header('HTTP/1.0 200 OK');
echo $out;
return;	
//$issues = $html->find('issuetable-web-component')->plaintext;
	//print_r($html);
?>