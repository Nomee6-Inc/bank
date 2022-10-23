<?php
include "../../config.php";
$get_pay_code = $_POST['pay_code'];
$get_client_id = $_POST['client_id'];
$get_secret = $_POST['secret'];

$pay_app_query = $db->query("SELECT * FROM payment_apps WHERE client_id = '{$get_client_id}' AND secret = '{$get_secret}'",PDO::FETCH_ASSOC);
$pay_app_data_query = $pay_app_query->fetch(PDO::FETCH_ASSOC);
$pay_app_count = $pay_app_query -> rowCount();
$_get_pay_app_client_id = $pay_app_data_query['client_id'];
if($pay_app_count > 0) {
$pay_code_query = $db->query("SELECT * FROM payments WHERE code = '{$get_pay_code}'",PDO::FETCH_ASSOC);
$pay_code_data_query = $pay_code_query->fetch(PDO::FETCH_ASSOC);
$get_pay_code_app_client_id = $pay_code_data_query['application'];
$get_pay_code_payment_Id = $pay_code_data_query['payment_id'];
$get_pay_code_status = $pay_code_data_query['status'];
if($_get_pay_app_client_id == $get_pay_code_app_client_id) {
if($get_pay_code_status == "Kullanldı") {
	header("Content-Type:application/json");
  	$response['status'] = 409;
	$response['status_message'] = "Code already used.";
	$response['data'] = NULL;
	$response['data']['paymentId'] = "$get_pay_code_payment_Id";
	
	$json_response = json_encode($response);
	echo $json_response;
} else if($get_pay_code_status == "Onaylandı") {
  	$update_paymnt_status = $db->prepare("UPDATE payments SET status = :new_status WHERE code = :code");
	$update_paymnt_status_query = $update_paymnt_status->execute(array(
     		"new_status" => "Kullanıldı",
     		"code" => "$get_pay_code"
	));
	header("Content-Type:application/json");
  	$response['status'] = 200;
	$response['status_message'] = "success";
	$response['data']['status'] = "1";
	$response['data']['paymentId'] = "$get_pay_code_payment_Id";
  	
	$json_response = json_encode($response);
	echo $json_response;
} else {
	header("Content-Type:application/json");
  	$response['status'] = 500;
	$response['status_message'] = "Error: API Error";
	$response['data'] = NULL;
	
	$json_response = json_encode($response);
	echo $json_response;
}

} else {
	header("Content-Type:application/json");
  	$response['status'] = 403;
	$response['status_message'] = "Forbidden";
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
