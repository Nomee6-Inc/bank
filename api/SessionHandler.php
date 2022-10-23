<?php
include_once '../config.php';
date_default_timezone_set('Europe/Istanbul');

try {
     $db = new PDO("mysql:host=localhost;dbname=database", "root", "123");
} catch ( PDOException $e ){
     print $e->getMessage();
}

function sess_verify($session_id) {
global $db;
  	$query = $db->query("SELECT * FROM sessions WHERE sess_token = '{$session_id}'",PDO::FETCH_ASSOC);
  	$dataquery = $query->fetch(PDO::FETCH_ASSOC);
    $sess_expiredate = new DateTime($dataquery['expire_date']);
	$nowdate = new DateTime();
    if($dataquery['logged_in'] == 1 && $sess_expiredate > $nowdate) {
    	return $getsessionstatus = 1;
    } else {
    	return $getsessionstatus = 0;
    }
}

function get_sess_user($session_id) {
global $db;
  	$query = $db->query("SELECT * FROM sessions WHERE sess_token = '{$session_id}'",PDO::FETCH_ASSOC);
  	$dataquery = $query->fetch(PDO::FETCH_ASSOC);
  	return $user_unique_id = $dataquery['acc_unique_id'];
}
?>
