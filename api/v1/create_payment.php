<?php
include "../../config.php";
$getclientid = $_POST['client_id'];
$getsecret = $_POST['secret'];
$getcardnumber = $_POST['card_number'];
$getcardexpire = $_POST['card_expire'];
$getcardcvv = $_POST['card_cvv'];
$getamount = $_POST['amount'];

$pay_app_query = $db->query("SELECT * FROM payment_apps WHERE client_id = '{$getclientid}' AND secret = '{$getsecret}'",PDO::FETCH_ASSOC);
$pay_app_data_query = $pay_app_query->fetch(PDO::FETCH_ASSOC);
$pay_app_count = $pay_app_query -> rowCount();
if($pay_app_count > 0) {
	$pay_card_query = $db->query("SELECT * FROM cards WHERE cardnumber = '{$getcardnumber}' AND cvv = '{$getcardcvv}' AND end = '$getcardexpire'",PDO::FETCH_ASSOC);
	$pay_card_data_query = $pay_card_query->fetch(PDO::FETCH_ASSOC);
  	$_pay__card_money = $pay_card_data_query['money'];
  	$_pay__card_card_id = $pay_card_data_query['cardid'];
  	$_pay__card_user = $pay_card_data_query['user'];
  	$_pay_card_count = $pay_card_query -> rowCount();
  	if($_pay_card_count > 0) {
    	if($_pay__card_money < $getamount) {
    		header("Content-Type:application/json");
  			$response['status'] = 403;
			$response['status_message'] = "Error: User money not enough.";
			$response['data'] = NULL;
			
			$json_response = json_encode($response);
			echo $json_response;
    	} else {
    		$getamount_is_numeric = is_numeric($getamount);
          	if($getamount_is_numeric) {
              	$_generate_new__payment_id = openssl_random_pseudo_bytes(8);
				$_generate_new__payment_id = bin2hex($_generate_new__payment_id);
              	
              	$generate__3d__secure_code = rand(100000, 999999);
              
            	$_generate_new__payment_code = openssl_random_pseudo_bytes(25);
				$_generate_new__payment_code = bin2hex($_generate_new__payment_code);
              	$create_payment = $db->prepare("INSERT INTO payments SET
					payment_id = ?,
					cardid = ?,
					amount = ?,
					application = ?,
                    user = ?,
                    status = ?,
                    code = ?,
                    3d = ?");
				$create_payment_query = $create_payment->execute(array(
				     $_generate_new__payment_id, $_pay__card_card_id, $getamount, $getclientid, $_pay__card_user, "Kullanıcı Onayı Bekliyor", $_generate_new__payment_code, $generate__3d__secure_code
				));
              if($create_payment_query) {
              	header("Content-Type:application/json");
  				$response['status'] = 200;
				$response['status_message'] = "success";
				$response['data'] = "$_generate_new__payment_code";
				
				$json_response = json_encode($response);
				echo $json_response;
              } else {
              	header("Content-Type:application/json");
  				$response['status'] = 500;
				$response['status_message'] = "Error: Database Error";
				$response['data'] = NULL;
				
				$json_response = json_encode($response);
				echo $json_response;
              }
            } else {
            	header("Content-Type:application/json");
  				$response['status'] = 403;
				$response['status_message'] = "Invalid Request: Amount not valid.";
				$response['data'] = NULL;
				
				$json_response = json_encode($response);
				echo $json_response;
            }
    	}
    } else {
    	    header("Content-Type:application/json");
  			$response['status'] = 404;
			$response['status_message'] = "Error: User card not found.";
			$response['data'] = NULL;
			
			$json_response = json_encode($response);
			echo $json_response;
    }
} else {
	header("Content-Type:application/json");
  	$response['status'] = 404;
	$response['status_message'] = "Invalid Request: Application credentials incorrect.";
	$response['data'] = NULL;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>
