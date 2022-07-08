<?php
session_start();
include_once 'config.php';
$getcardid = $_GET['cardid'];
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
} else {
$getusername = $_SESSION['username'];
$getaccid = $_SESSION['accid'];
$query = mysqli_query($conn,"SELECT * FROM users WHERE baccid = '$getaccid'");
$result = $query->fetch_assoc();
$cardid = $result['cardid'];

$query1 = mysqli_query($conn, "SELECT * FROM cards WHERE cardid = '$getcardid'");
$result1 = $query1->fetch_assoc();
$owner = $result1['owner'];
$dbcardid = $result1['id'];
if($owner != $getusername) {
    header("Location: panel.php");
} else {
    if(strstr($cardid, ",$getcardid")) {
        $newcardsid = str_replace(",$getcardid", "", $cardid);
    } else {
        $newcardsid = str_replace("$getcardid", "", $cardid);
    }
    $cardsarray = explode(",", $cardid);
    
    $sql2 = "DELETE FROM `cards` WHERE `cards`.`id` = $dbcardid";
    $query2 = mysqli_query($conn, $sql2);
    
    $sql3 = "UPDATE users SET cardid = '$newcardsid' WHERE baccid = '$getaccid'";
    $query3 = mysqli_query($conn, $sql3);
    
    if($query2 && $query3) {
        header("Location: panel.php");
    } else {
        echo "Bir hata oluştu!";
    }
}
}
?>
