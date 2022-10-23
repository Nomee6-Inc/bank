<?php
session_start();
include_once '../config.php';
include '../api/SessionHandler.php';
$getsessioncookie = $_COOKIE['sess_id'];
if(sess_verify($getsessioncookie) == 1) {
$get_user_unique_id = get_sess_user($getsessioncookie);

$query = $db->query("SELECT * FROM users WHERE user_id = '{$get_user_unique_id}'",PDO::FETCH_ASSOC);
$dataquery = $query->fetch(PDO::FETCH_ASSOC);
$getusername = $dataquery['username'];
$getuserrole = $dataquery['role'];
$getusermoney = $dataquery['money'];
$getuserdolar = $dataquery['dolar'];
  
if (isset($_POST['submit'])) {
  	$createappclientid = sha1(rand().rand().rand().rand());
  	$createappsecret = openssl_random_pseudo_bytes(30);
	$createappsecret = bin2hex($createappsecret);
    $getappname = htmlentities($_POST['appname']);
  	$getappiban = $_POST['moneywithdrawiban'];
    $getappcallback = $_POST['appcallback'];
  	$iban__query = $db->query("SELECT * FROM cards WHERE iban = '{$getappiban}'",PDO::FETCH_ASSOC);
	$iban__dataquery = $iban__query->fetch(PDO::FETCH_ASSOC);
  	if($iban__query->rowCount() > 0) {
    if(filter_var($getappcallback, FILTER_VALIDATE_URL) && $getappname) {
    $save_app = $db->prepare("INSERT INTO payment_apps SET
		name = ?,
		client_id = ?,
        secret = ?,
        owner = ?,
        money_withdraw_iban = ?,
        money = ?,
        callback = ?");
	$save_app_insert = $save_app->execute(array(
	     $getappname, $createappclientid, $createappsecret, $get_user_unique_id, $getappiban, "", $getappcallback
	));
    if($save_app_insert) {
        header("Location: apps");
    } else {
        echo "<script>alert(\"Bir hata oluştu!\")</script>";
    }  
      
    } else {
    	echo "<script>alert(\"Girdiğiniz veriler geçerli değil.\")</script>";
    }
    } else {
    	echo "<script>alert(\"IBAN geçerli değil.\")</script>";
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
    <title>Uygulama Oluştur | NOMEE6 Bank</title>
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
                  Uygulama Oluştur
                </h2>
              </div>
              <form enctype="multipart/form-data" action="" method="POST">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                            <div class="card">
                              <div class="card-body">
                                <div class="mb-3">
                                  <div class="form-label">Uygulama İsmi</div>
                                  <input type="text" name="appname" class="form-control" autocomplete="off" required/>
                                </div>
                                <div class="mb-3">
                                  <div class="form-label">Uygulama Callback adresi</div>
                                  <input type="text" name="appcallback" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                  <div class="form-label">Paranın çekileceği IBAN</div>
                                  <input type="text" name="moneywithdrawiban" class="form-control" required>
                                </div>
                    <div class="mt-2">
                        <button type="submit" name="submit" class="btn btn-primary w-100">Oluştur</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        </form>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
