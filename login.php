<?php
if(strstr($_SERVER['HTTP_USER_AGENT'], "Nomee6 Bank Android Client")) { 
	header("Location: panel");
}
include 'config.php';
include 'api/SessionHandler.php';
include 'api/getuseros.php';
error_reporting(0);
$getsessioncookie = $_COOKIE['sess_id'];
if (sess_verify($getsessioncookie) == 1) {
    header("Location: panel");
} else {

if (isset($_POST['submit'])) {
$generate_new_login_code = openssl_random_pseudo_bytes(30);
$generate_new_login_code = bin2hex($generate_new_login_code);
$save_logincode = $db->prepare("INSERT INTO blogincodes SET
		code = ?,
		user = ?");
$save_logincode_query = $save_logincode->execute(array(
     $generate_new_login_code, ""
));
if($save_logincode_query) {
    header("Refresh:1 url=https://devlet.nomee6.xyz/api/v2/bank/sso-login.php?login_code=$generate_new_login_code");
    echo "Yönlendiriliyorsunuz...";
} else {
    echo "E-Devlet API Hizmetine bağlanılırken bir hata oluştu! Lütfen daha sonra tekrar deneyiniz.";
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
    <title>Giriş Yap | Nomee6 Bank</title>
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
  <body class=" border-top-wide border-primary d-flex flex-column">
  <form enctype="multipart/form-data" action="" method="POST">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="text-center mb-4">
          <a href="https://bank.nomee6.xyz" class="navbar-brand navbar-brand-autodark"><img src="https://devlet.nomee6.xyz/static/logo.svg" height="36" alt=""></a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Nomee6 Bank Hesabına Giriş Yap</h2>
            <div class="form-footer">
              <button name="submit" class="btn btn-primary w-100">E-Devlet Hesabın ile giriş yap</button>
            </div>
          </div>
      </div>
    </div>
</form>
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
