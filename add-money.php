<?php
session_start();
include_once 'config.php';
$getcardid = $_GET['cardid'];
$getusername = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
} else {
$getaccid = $_SESSION['accid'];
$query = mysqli_query($conn,"SELECT * FROM users WHERE baccid = '$getaccid'");
$result = $query->fetch_assoc();
$money = $result['money'];
$cardid = $result['cardid'];
$query2 = mysqli_query($conn,"SELECT * FROM cards WHERE cardid = '$getcardid'");
$result2 = $query2->fetch_assoc(); 
$cardmoney = $result2['money'];
$cardowner = $result2['owner'];

if($getusername != $cardowner) {
    header("Location: panel.php");
}

if (isset($_POST['submit'])) {
$yatirilcakmiktar = $_POST['miktar'];
if($money < $yatirilcakmiktar) {
    echo "Cüzdanınızda bu kadar para bulunmuyor.";
} else {
    if($getusername == $cardowner) {
    $yatirilcakmiktar = $_POST['miktar'];
    $newbankmiktar = $cardmoney+$yatirilcakmiktar;
    $yatirilcakmiktarnew = $yatirilcakmiktar+1;
    $newmoney = $money - $yatirilcakmiktarnew;
    $sql7 = "UPDATE users SET money = '$newmoney' WHERE baccid = '$getaccid'";
    $run_query = mysqli_query($conn, $sql7);
	$sql8 = "UPDATE cards SET money = '$newbankmiktar' WHERE cardid = '$getcardid'";
    $run_query8 = mysqli_query($conn, $sql8);
    if($run_query && $run_query8){
        echo "Başarıyla ₺$yatirilcakmiktar tutarında para yatırdınız.";
        header("Location: panel.php");
    } else {
       echo "Bir hata oluştu!";
    }
    }
}
}
};
?>

<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>NOMEE6 BANK</title>
    <!-- CSS files -->
    <link href="https://devlet.nomee6.xyz/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/demo.min.css" rel="stylesheet"/>
	<?php 
	$username = $_SESSION['username'];
	echo("
	<!-- Matomo -->
	  <script>
		var _paq = window._paq = window._paq || [];
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		_paq.push(['setUserId', '$username']);
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
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo($_SESSION['username']) ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="logout.php" class="dropdown-item">Çıkış Yap</a>
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
                  Para Yükle
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
                    <div class="h1 mb-3">₺<?php echo $money; ?></div>
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
                                        <div class="form-label">Ödeme Yöntemi</div>
                                        <select class="form-select" >
                                            <option value="wallet">Cüzdan</option>
                                        </select>
                                    </div>
									<div class="mb-3">
                            		<div class="form-label">Karta Yatırılacak miktar</div>
										<input type="number" name="miktar" id="miktar" class="form-control" required>
									</div>
									<div class="input-group">
										<button name="submit" class="btn">Yatır</button>
									</div>
								</div>
							</div>
						</div>
                        <small class="form-hint">
				            Not: Her işlem için ₺1 işlem ücreti kesilmektedir.
				        </small>
					</div>
				</div>
				</form>
        </div>
    </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  </li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="https://devlet.nomee6.xyz/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
