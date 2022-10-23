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
$card__dataquery = $card_query->fetch(PDO::FETCH_ASSOC);
$cardmoney = $card__dataquery['money'];
$cardowner = $card__dataquery['owner'];
  
if($getusername != $cardowner) {
    header("Location: panel");
} else {

if (isset($_POST['submit'])) {
$cekilcekmiktar = $_POST['miktar'];
if($cardmoney < $cekilcekmiktar) {
    echo "Kartınızda bu kadar para bulunmuyor.";
} else {
    if($getusername == $cardowner) {
        $newbankmiktar = $cardmoney-$cekilcekmiktar;
        $newmoney = $getusermoney + $cekilcekmiktar - 1;
      	
      	$update_card_money = $db->prepare("UPDATE cards SET
			money = :new_money
			WHERE cardid = :cardid");
	 	$update_card_money_query = $update_card_money->execute(array(
     		"new_money" => "$newbankmiktar",
     		"cardid" => "$getcardid"
		));
      
      	$update_user_money = $db->prepare("UPDATE users SET
			money = :new_money
			WHERE user_id = :userid");
	 	$update_user_money_query = $update_user_money->execute(array(
     		"new_money" => "$newmoney",
     		"userid" => "$get_user_unique_id"
		));
        if($update_card_money_query && $update_user_money_query){
            echo "<script>alert(\"Başarıyla ₺$cekilcekmiktar tutarında para çektiniz.\")</script>";
            header("Location: panel");
        } else {
           echo "Bir hata oluştu!";
        }
    }
}
}
  
}
  
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
    <title>Cüzdana Para Çek | Nomee6 Bank</title>
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
      <div class="page-wrapper">
        <div class="container-xl">
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Para Çek
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
                      <div class="subheader">Toplam Cüzdanda ki Para</div>
                      <div class="ms-auto lh-1">
                      </div>
                    </div>
                    <div class="h1 mb-3">₺<?php echo $getusermoney; ?></div>
                  </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Toplam kartta ki Para</div>
                      <div class="ms-auto lh-1">
                      </div>
                    </div>
                    <div class="h1 mb-3">
                        ₺<?php
                        if($cardmoney == "") {
                            $cardmoney = "0";
                        };
                         echo $cardmoney; 
                         ?></div>
                  </div>
                </div>
            </div>
            <form enctype="multipart/form-data" action="" method="POST">
					<div class="card-body">
				        <div class="row">
							<div class="col-xl-4">
				            	<div class="row">
				            	    <div class="mb-3">
                                        <div class="form-label">Paranın Çekileceği Konum</div>
                                        <select class="form-select" >
                                            <option value="wallet">Cüzdan</option>
                                        </select>
                                    </div>
									<div class="mb-3">
                            		<div class="form-label">Çekilecek Miktar</div>
										<input type="number" name="miktar" id="miktar" class="form-control" required>
									</div>
									<div class="input-group">
										<button name="submit" class="btn">Çek</button>
									</div>
								</div>
							</div>
						</div>
                        <small class="form-hint">
				            Not: Her işlem için ₺1 işlem ücreti kesilmektedir.
				        </small>
					</div>
				</form>
        </div>
    </div>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
