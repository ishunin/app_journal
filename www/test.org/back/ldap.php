<?php
#Функция авторизует в ldap под учетными данными. Возвращает массив с полями в случае успеха, иначе 0
function ldap_auth($login,$pass) {
$_SERVER['LOGON_USER']=$login;
$ldap_username = $login;
$ldap_password = $pass;

$ldap_connection = ldap_connect("ldap://dpc.tax.nalog.ru/");

if ($ldap_connection === false){
   echo 'Unable to connect to the ldap server';
} else {
	@ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
	@ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);
	@ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
	if ( @ldap_bind($ldap_connection, $ldap_username, $ldap_password) === true && !empty($ldap_password)){
		$ldap_base_dn = 'DC=dpc,DC=tax,DC=nalog,DC=ru';
		$domains = array('DPC\\','@dpc','@dpc.tax.nalog.ru','Regions\\','@regions.tax.nalog.ru');
		$matches = array();
		$masks = array('/n\d{4}-\d{2}-\d{3}/','/n\d{4}-\d{5}/','/n\d{4}_svc_\w+/');
		foreach ($masks as $mask) {
			preg_match($mask, strtolower($_SERVER['LOGON_USER']), $matches);
			if (count($matches) > 0) {
				$account = $matches[0];
				break;
			}
		}
		@$search_filter = '(&(objectCategory=person)(samaccountname='.$account.'))';
		$needarray=array('samaccountname','givenname','sn','company','department','title','telephonenumber','mail','thumbnailphoto','whenchanged', 'memberof');
		$usr=array();
		$result = @ldap_search($ldap_connection, $ldap_base_dn, $search_filter, $needarray);
		
		$res = 0;
		if ($result !== false){
			$user = array();
			$entries = @ldap_get_entries($ldap_connection, $result);
			if ($entries['count'] > 0) {
				$res = 1;
				foreach ($needarray as $val) {
					if (isset($entries[0][$val]['count'])) {
						if ($entries[0][$val]['count'] > 1) {
							if (isset($entries[0][$val])) {$usr[$val] = $entries[0][$val];}
						} else {
							if (isset($entries[0][$val][0])) {$usr[$val] = $entries[0][$val][0];}
						}
					}
				}
			}
		}
		@$user['FIO'] = $usr['sn'].' '.$usr['givenname'];
		@$user['Phone'] = $usr['telephonenumber'];
		@$user['EMail'] = $usr['mail'];
		@$user['JobTitle'] = $usr['title'];
		@$user['Department'] = $usr['department'];
		@$user['Company'] = $usr['company'];
		if (isset($usr['thumbnailphoto'])) {
			$user['base64Photo'] = base64_encode($usr['thumbnailphoto']);
		} else {
			$defPhoto = 'S:/Users/defaultUser.jpg';
			#$imagedata = file_get_contents($defPhoto);
			#$user['base64Photo'] = base64_encode($imagedata);	
		}
		@$time = explode('.',$usr['whenchanged']);
		$user['LastADUpdate'] = date('Y-m-d H:i:s', strtotime($time[0]));
		@ldap_unbind($ldap_connection); 
	}
}

#print_r ($user);
	if (isset($user)) {
		return $user;
	}
	else {
		return 0;
	}
}
/*

$res = ldap_auth('n7701-00-421@dpc.tax.nalog.ru','Ja83aa3710');

if ($res !=0 ) {
	print_r ($res);
} 
else {
	echo 'Нет такого пользователя в Ldap, неверный пароль или УЗ заблокирована';
}
*/
?>