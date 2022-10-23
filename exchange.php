<?php
session_start();
include_once 'config.php';
include 'api/SessionHandler.php';
$getsessioncookie = $_COOKIE['sess_id'];
if(sess_verify($getsessioncookie) == 1) {
$get_user_unique_id = get_sess_user($getsessioncookie);

$query = $db->query("SELECT * FROM users WHERE user_id = '{$get_user_unique_id}'",PDO::FETCH_ASSOC);
$dataquery = $query->fetch(PDO::FETCH_ASSOC);
$getusername = $dataquery['username'];
$getuserrole = $dataquery['role'];
$getusermoney = $dataquery['money'];
$getuserdolar = $dataquery['dolar'];

$sys_Q = $db->query("SELECT * FROM sys WHERE name = 'dolar'",PDO::FETCH_ASSOC);
$sys_Q_query = $sys_Q->fetch(PDO::FETCH_ASSOC);
$get_dolar_current_price = $sys_Q_query['value'];
  
if (isset($_POST['dolaral'])) {
$dolarmiktar = $_POST['dolarmiktar'];
$totaldolartutar = $get_dolar_current_price*$dolarmiktar;
$newdolarmiktar = $getuserdolar+$dolarmiktar;
$dolarmiktar_is_numeric = is_numeric($dolarmiktar);
if($dolarmiktar_is_numeric) {

if($dolarmiktar < 1) {
    echo "Girdiğiniz tutar geçerli değildir.";
} else {
if($getusermoney < $totaldolartutar) {
    echo "Paranız bu işlem için yeterli değildir.";
} else {
    $newmoney = $getusermoney - $totaldolartutar;
  
  	$update_user_m_d = $db->prepare("UPDATE users SET
			money = :new_money,
            dolar = :new_dolar
			WHERE user_id = :userid");
	$update_user_m_d_query = $update_user_m_d->execute(array(
     		"new_money" => "$newmoney",
      		"new_dolar" => "$newdolarmiktar",
     		"userid" => "$get_user_unique_id"
	));
    if($update_user_m_d_query){
        echo "Başarıyla $dolarmiktar tutarında dolar satın aldınız.";
        header('Refresh:0');
    } else {
       echo "Bir hata oluştu!";
    }
}}
} else {
	echo "Girdiğiniz veri bir sayı değil.";
}
};
  
if (isset($_POST['dolarsat'])) {
$satdolarmiktar = $_POST['satdolarmiktar'];
$sattotaldolartutar = $get_dolar_current_price*$satdolarmiktar;
$satnewdolarmiktar = $getuserdolar-$satdolarmiktar;
$s_dolarmiktar_is_numeric = is_numeric($satdolarmiktar);
if($s_dolarmiktar_is_numeric) {
if($satdolarmiktar < 1) {
    echo "Girdiğiniz tutar geçerli değildir.";
} else {
if($getuserdolar < $satdolarmiktar) {
    echo "Paranız bu işlem için yeterli değildir.";
} else {
    $satnewmoney = $getusermoney + $sattotaldolartutar;
  	$s_update_user_m_d = $db->prepare("UPDATE users SET
			money = :new_money,
            dolar = :new_dolar
			WHERE user_id = :userid");
	$s_update_user_m_d_query = $s_update_user_m_d->execute(array(
     		"new_money" => "$satnewmoney",
      		"new_dolar" => "$satnewdolarmiktar",
     		"userid" => "$get_user_unique_id"
	));
    if($s_update_user_m_d_query){
        echo "Başarıyla $dolarmiktar tutarında dolar sattınız.";
        header('Refresh:0');
    } else {
       echo "Bir hata oluştu!";
    }
}}
} else {
	echo "Girdiğiniz veri bir sayı değil.";
}
};
  
} else {
    header("Location: login");
}
?>

<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Döviz | Nomee6 Bank</title>
    <!-- CSS files -->
    <link href="https://devlet.nomee6.xyz/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/demo.min.css" rel="stylesheet"/>
    <meta property="og:title" content="NOMEE6 BANK" />
    <meta property="og:url" content="https://bank.nomee6.xyz" />
    <meta property="og:image" content="https://nomee6.xyz/assets/A.png" />
    <meta property="og:description" content="E-Devlette ki eski klasik banka sistemi yeni modern ve gelişmiş bir sisteme taşındı." />
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
		  _paq.push(['setSiteId', '16']);
		  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		  g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
		})();
	  </script>
	  <!-- End Matomo Code -->
	");
	?>
  </head>
  <body>
    <div class="wrapper">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
              <img src="https://devlet.nomee6.xyz/static/logo.svg" width="150" height="35" alt="banka" class="navbar-brand-image">
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
              </div>
            </div>
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Koyu Temayı Etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Açık Temayı Etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
            </a>
            <?php
            if(strstr($_SERVER['HTTP_USER_AGENT'], "Nomee6 Bank Android Client")) { 
	    		echo '
             <div class="nav-item">
              <a href="notifications" class="nav-link" tabindex="-1" aria-label="Bildirimleri Göster">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
              </a>
            </div>';
    		};
            ?>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo($getusername) ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="logout" class="dropdown-item">Çıkış Yap</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="panel" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Kartlarım
                    </span>
                  </a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="exchange" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2"></path>
                        <path d="M12 3v3m0 12v3"></path>
                      </svg>
                    </span>
                    <span class="nav-link-title">
                      Döviz
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="transfer_iban" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transfer-in" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 18v3h16v-14l-8 -4l-8 4v3"></path>
                        <path d="M4 14h9"></path>
                        <path d="M10 11l3 3l-3 3"></path>
                      </svg>
                    </span>
                    <span class="nav-link-title">
                      IBAN Para Transferi
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="page-wrapper">
        <div class="container-xl">
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Döviz
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Toplam Nomee6 Lirası</div>
                      <div class="ms-auto lh-1">
                      </div>
                    </div>
                    <div class="h1 mb-3"><?php echo $getusermoney; ?>₺</div>
                  </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Toplam DOLLAR</div>
                      <div class="ms-auto lh-1">
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-0 me-2"><?php
                        if($getuserdolar == "") {
                            $getuserdolar = "0";
                        }
                        echo $getuserdolar;
                        ?>$</div>
                      <div class="me-auto">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Dolar Satış Fiyatı</div>
                      <div class="ms-auto lh-1">
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-0 me-2"><?php
                        echo $get_dolar_current_price;
                        ?>₺</div>
                      <div class="me-auto">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="col-12">
                    <div class="card-tabs ">
                      <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#dolarbuy" class="nav-link active" data-bs-toggle="tab">Dolar Satın Al</a></li>
                        <li class="nav-item"><a href="#dolarsat" class="nav-link" data-bs-toggle="tab">Dolar Bozdur</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="dolarbuy" class="card tab-pane active show">
                          <div class="card-body">
                            <div class="card-title">Dolar Satın Al</div>
                            <form enctype="multipart/form-data" action="" method="POST">
								<input type="number" placeholder="Alınacak Dolar Miktarı" name="dolarmiktar" id="dolarmiktar" class="form-control" required>
								<h4></h4>
								<button name="dolaral" class="btn">Dolar Satın Al</button>
							</form>
							<small class="form-hint">
							    Sadece cüzdanınızda ki para ile alabilirsiniz.
							</small>
                          </div>
                        </div>
                        <div id="dolarsat" class="card tab-pane">
                          <div class="card-body">
                            <div class="card-title">Dolar Bozdur</div>
							<form enctype="multipart/form-data" action="" method="POST">
								<input type="number" placeholder="Satılacak Dolar Miktarı" name="satdolarmiktar" id="satdolarmiktar" class="form-control" required>
								<h4></h4>
								<button name="dolarsat" class="btn">Dolar Sat</button>
							</form>
							<small class="form-hint">
							    Dolar bozdurduğunuzda para cüzdanınıza ₺ biçiminde aktarılacaktır.
							</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
