<?php
session_start();
include_once 'config.php';
include 'api/SessionHandler.php';
$getcardid = $_GET['cardid'];
$getsessioncookie = $_COOKIE['sess_id'];
if(sess_verify($getsessioncookie) == 1) {
$get_user_unique_id = get_sess_user($getsessioncookie);

$query = $db->query("SELECT * FROM users WHERE user_id = '{$get_user_unique_id}'",PDO::FETCH_ASSOC);
$dataquery = $query->fetch(PDO::FETCH_ASSOC);
$getusername = $dataquery['username'];
$getuserrole = $dataquery['role'];
$getusermoney = $dataquery['money'];
$getuserdolar = $dataquery['dolar'];
  
$card_query = $db->query("SELECT * FROM cards WHERE cardid = '{$getcardid}'",PDO::FETCH_ASSOC);
$card_data_query = $card_query->fetch(PDO::FETCH_ASSOC);
$owner = $card_data_query['owner'];
$dbcardid = $card_data_query['id'];
  
if($owner != $getusername) {
	header("Location: panel");
} else {
$query = $db->prepare("DELETE FROM cards WHERE id = :id");
$delete = $query->execute(array(
   'id' => $dbcardid
));
if($delete) {
    header("Location: panel");
} else {
    echo "Bir hata oluştu!";
}
}
} else {
    header("Location: login");
}
?>
