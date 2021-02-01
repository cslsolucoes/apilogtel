<?php

// Function to log in with Active Directory
function ldapLogin($user, $pass) {
	$adServer = "ldap://10.254.1.3";
	//$adServer = "ldap://201.87.240.30";
  $ldaptree    = "OU=Empresa,DC=logtel,DC=net,DC=br";
  $filter = "(&(sAMAccountName=edie.matos))";
  $ldapconn = ldap_connect($adServer);
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
	$bind = @ldap_bind($ldapconn, $user, $pass);

	if($bind && $ldapconn && $ldaptree && $filter) {
    $result = @ldap_search($ldapconn, $ldaptree, $filter);
    $data = @ldap_get_entries($ldapconn, $result);
    $grupo = @explode(",", $data[0]['memberof'][0]);
    $grupo = @substr($grupo[0], 3);
		return true;
	} else {
		return false;
	}
}

function getUserId($username) {
  $pdo = new PDO('pgsql:host=201.87.240.202;port=5432;dbname=dbsgp;user=postgres;password=postmy');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $sql = "Select id from auth_user where username = '$username'";
  $res = $pdo->query($sql);
  $res = $res->fetchAll();
  if(isset($res[0]['id'])) {
    return $res[0]['id'];
  }
  return false;
}

function isAdmin($user) {
  if(!$user || ($user != "ludmila.bernardes@logtel.net.br" && $user != "claiton.linhares@logtel.net.br")) return false;
  return true;
}

// Function to check if user is logged in or not
function not_logged_in() {
  if(isset($_SESSION['user'])) {
    return false;
  }
  return true;
}

function formatBytes($bytes, $precision = 0) { 
  $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

  $bytes = max($bytes, 0); 
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
  $pow = min($pow, count($units) - 1); 

  // $bytes /= pow(1024, $pow);
  $bytes /= (1 << (10 * $pow)); 

  return round($bytes, $precision) . $units[$pow]; 
}

function brazilianNumberFormat($number) {
  return number_format($number, 2, ',', '.');
}