<?php
include 'config.php';
error_reporting(0);

$getsesscookie = $_COOKIE['sess_id'];

$query = $db->prepare("UPDATE sessions SET
logged_in = :new_logged_in,
fcm_id = :new_fcm_id
WHERE sess_token = :sesstoken");
$logoutquery = $query->execute(array(
     "new_logged_in" => "0",
     "new_fcm_id" => "",
     "sesstoken" => "$getsesscookie"
));
if ( $logoutquery ){
}

setcookie("sess_id", "", time() - 3600, "/");
header("Refresh:1 url=index");
?>
