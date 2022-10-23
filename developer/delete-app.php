<?php
session_start();
include_once '../config.php';
include '../api/SessionHandler.php';
$getsessioncookie = $_COOKIE['sess_id'];
$getclientid = $_GET['clientid'];
if(sess_verify($getsessioncookie) == 1) {
$get_user_unique_id = get_sess_user($getsessioncookie);

$query = $db->query("SELECT * FROM users WHERE user_id = '{$get_user_unique_id}'",PDO::FETCH_ASSOC);
$dataquery = $query->fetch(PDO::FETCH_ASSOC);
$getusername = $dataquery['username'];
$getuserrole = $dataquery['role'];
$getusermoney = $dataquery['money'];
$getuserdolar = $dataquery['dolar'];
  
$app_query = $db->query("SELECT * FROM payment_apps WHERE client_id = '{$getclientid}'",PDO::FETCH_ASSOC);
$app_dataquery = $app_query->fetch(PDO::FETCH_ASSOC);
$owner = $app_dataquery['owner'];
$id = $app_dataquery['id'];
  
if($owner != $get_user_unique_id) {
    header("Location: apps");
} else {
$query = $db->prepare("DELETE FROM payment_apps WHERE id = :id");
$delete = $query->execute(array(
   'id' => $id
));
if($delete) {
    header("Location: apps");
} else {
    echo "Bir hata oluştu!";
}}
}
?>
