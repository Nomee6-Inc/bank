<?php
session_start();
include_once '../config.php';
include '../api/SessionHandler.php';
$getclientid = htmlentities($_GET['clientid']);
$getsessioncookie = $_COOKIE['sess_id'];
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
$appname = $app_dataquery['name'];
$callback = $app_dataquery['callback'];
$secret = $app_dataquery['secret'];
$appmoney = $app_dataquery['money'];
$money_withdraw_iban = $app_dataquery['money_withdraw_iban'];
  
if($owner != $get_user_unique_id) {
    header("Location: apps");
} else {
  
if(isset($_POST['money_withdraw_to_iban'])) {
if(!$appmoney || $appmoney == 0) {
	echo "<script>alert(\"Çekebileceğiniz bir bakiyeniz bulunmamaktadır.\")</script>";
} else {
$iban_card_data_query = $db->query("SELECT * FROM cards WHERE iban = '{$money_withdraw_iban}'",PDO::FETCH_ASSOC);
$iban_card_data_query_q = $iban_card_data_query->fetch(PDO::FETCH_ASSOC);
$get_user_iban__money = $iban_card_data_query_q['money'];
$__new_user_iban_money = $get_user_iban__money+$appmoney;
$sql2 = $db->prepare("UPDATE cards SET money = :new_money WHERE iban = :iban");
$query2 = $sql2->execute(array(
	     "new_money" => "$__new_user_iban_money",
	     "iban" => "$money_withdraw_iban"
));
if($query2) {
	echo "<script>alert(\"Bakiyeniz başarıyla banka hesabınıza aktarıldı.\")</script>";
  	$sql4 = $db->prepare("UPDATE payment_apps SET money = :new_money WHERE client_id = :client_id");
	$query4 = $sql4->execute(array(
	     "new_money" => "0",
	     "client_id" => "$getclientid"
	));
  	if($query4) {
    	header("Refresh:0");
    }
} else {
	echo "<script>alert(\"Bir API hatası meydana geldi.\")";
}
}
}
  
}
  
} else {
    header("Location: ../login");
}
?>

<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Ödemeler | NOMEE6 Bank</title>
    <!-- CSS files -->
    <link href="https://devlet.nomee6.xyz/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/demo.min.css" rel="stylesheet"/>
	<?php
	echo("
	<!-- Matomo -->
	  <script>
		var _paq = window._paq = window._paq || [];
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		_paq.push(['setUserId', '$getusername']);
		_paq.push(['enableHeartBeatTimer']);
		(function() {
			var u=\"https://matomo.aliyasin.org/\";
		  _paq.push(['setTrackerUrl', u+'matomo.php']);
		  _paq.push(['setSiteId', '13']);
		  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		  g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
		})();
	  </script>
	  <!-- End Matomo Code -->
	");
	?>
  </head>
  <body>
    <div class="page">
      <aside class="navbar navbar-vertical navbar-expand-lg navbar-transparent">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark">
            <a href=".">
              <img src="https://devlet.nomee6.xyz/static/logo.svg" width="110" height="32" alt="E-DEVLET" class="navbar-brand-image">
            </a>
          </h1>
          <div class="navbar-nav flex-row d-lg-none">
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Koyu Temayı Etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Açık Temayı Etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
            </a>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Kullanıcı menüsünü aç">
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo($getusername) ?></div>
                  <div class="mt-1 small text-muted"><?php echo $getuserrole; ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
               <a href="../logout" class="dropdown-item">Çıkış Yap</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
              <li class="nav-item">
                <a class="nav-link" href="./panel" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Ana Sayfa
                  </span>
                </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="./apps" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
	                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><rect x="4" y="14" width="6" height="6" rx="1" /><rect x="14" y="14" width="6" height="6" rx="1" /><line x1="14" y1="7" x2="20" y2="7" /><line x1="17" y1="4" x2="17" y2="10" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Uygulamalar
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./docs/" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="9" y1="9" x2="10" y2="9" /><line x1="9" y1="13" x2="15" y2="13" /><line x1="9" y1="17" x2="15" y2="17" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Documentation
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </aside>
      <div class="page-wrapper">
        <div class="container-xl">
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Ödemeler
                </h2>
              </div>
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="status-indicator status-green status-indicator-animated">
                  <span class="status-indicator-circle"></span>
                  <span class="status-indicator-circle"></span>
                  <span class="status-indicator-circle"></span>
                </span>
              </div>
              <div class="col">
                <h2 class="page-title">
                  <?php echo $appname; ?>
                </h2>
                <div class="text-muted">
                  <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><span class="text-green">Ödemeler Alınıyor</span></li>
                  </ul>
                </div>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="manage-app?clientid=<?php echo $getclientid; ?>" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>
                    Uygulamayı Yönet
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-4">
                <div class="card">
                  <div class="card-body">
                    <div class="subheader">Bakiye</div>
                    <div class="h3 m-0"><?php
                      if($appmoney) {
                      	echo $appmoney;
                      } else {
                      	echo "0";
                      }
                      ?>₺</div>
                  </div>
                </div>
              </div>
              <form method="POST" action="">
              	<button type="submit" name="money_withdraw_to_iban" class="btn btn-blue">
              	  Tüm Parayı Kayıtlı IBAN'a Çek
              	</button>
              </form>
              <div class="col-12">
                <div class="card">
                  <div class="card-table table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Ödeme ID</th>
                          <th>Tutar</th>
                          <th>Durum</th>
                          <th>Kullanıcı Email</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php
             				$sql = "SELECT * FROM payments WHERE application = '$getclientid'";
             				$result = mysqli_query($conn, $sql);
             				while($row = mysqli_fetch_array($result)){
             				  $get__payment_id = $row['payment_id'];
                              $get__amount = $row['amount'];
                              $get__status = $row['status'];
                              
                              $get__user = $row['user'];
                              
                              $pay_user__query = $db->query("SELECT * FROM users WHERE user_id = '{$get__user}'",PDO::FETCH_ASSOC);
							  $pay_user__data_query = $pay_user__query->fetch(PDO::FETCH_ASSOC);
                              $get_pay_user__uname = $pay_user__data_query["email"];
                              echo "<tr>
                          <td>$get__payment_id</td>
                          <td>$get__amount</td>
                          <td>$get__status</td>
                          <td>$get_pay_user__uname</td>
                        </tr>";
             				};
              			?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <small class="form-hint">Not: Ödeme durumu "Kullanıldı" olduğu zaman bu ödeme işlemi başarıyla gerçekleşmiş ve Uygulamanız tarafından sorgulanmış demektir.</small>
              </div>
            </div>
          </div>
        </div>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
